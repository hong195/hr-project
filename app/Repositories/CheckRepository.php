<?php


namespace App\Repositories;


use App\Exceptions\CheckExpcetion;
use App\Models\Check;
use App\Models\CheckData;
use App\Repositories\Contracts\CheckRepositoryContract;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Services\Contracts\CriteriaInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

class CheckRepository extends AbstractRepository implements CheckRepositoryContract
{

    /**
     * @var CriteriaInterface
     */
    private $criteriaService;
    /**
     * @var UserRepositoryContract
     */
    private $userRepository;
    /**
     * @var array
     */
    private $modelAttributes = [];


    public function __construct(Check $check,
                                CriteriaInterface $criteriaService,
                                UserRepositoryContract $userRepository)
    {
        parent::__construct($check);
        $this->criteriaService = $criteriaService;
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $checkRequest
     * @return mixed
     * @throws CheckExpcetion
     */
    public function create(array $checkRequest)
    {
        $checkRequest = collect($checkRequest);
        $user = $this->userRepository->findById($checkRequest->get('user_id'));

        if ($user->hasRating($checkRequest->get('created_at'))) {
            throw new CheckExpcetion(sprintf(
                'Failed to Pharmacy check, user has already have rating for given period - %s %s',
                Carbon::parse($checkRequest->get('created_at'))->format('F'),
                Carbon::parse($checkRequest->get('created_at'))->format('Y')
            ));
        }

        $this->setAttributes($checkRequest);
        $this->model = parent::create($this->modelAttributes);

        if ($checkRequest->has('meta')) {
            $this->saveMeta($checkRequest->get('meta'));
        }

        return $this->model;
    }

    public function setAttributes(SupportCollection $checkRequest)
    {
        $this->modelAttributes = $checkRequest->except('meta')->toArray();
        $this->modelAttributes['criteria'] = $this->criteriaService
            ->generate($checkRequest->get('meta'))->getCriteriaList();
    }

    /**
     * @param $id
     * @param array $checkRequest
     * @return bool
     * @throws CheckExpcetion
     */
    public function update($id, array $checkRequest)
    {
        $checkRequest = collect($checkRequest);
        $this->model = $this->findById($id);
        $user = $this->model->user;

        if ($user->hasRating($this->model->created_at)) {
            throw new CheckExpcetion(sprintf(
                'Failed to update check, user`s rating already generated for given period - %s %s',
                $this->model->created_at->format('F'),
                $this->model->created_at->format('Y')
            ));
        }

        if ($checkRequest->has('meta')) {
            $this->saveMeta($checkRequest->get('meta'));
        }

        $this->setAttributes($checkRequest);

        return $this->model->update($this->modelAttributes);
    }

    public function saveMeta(array $meta)
    {
        $meta = collect($meta);
        //Todo refactor deleting model
        $this->model->meta()->delete();


        $meta = $meta->map(function ($value, $key) {
            return ['value' => $value, 'name' => $key];
        })
            ->values()
            ->all();

        $this->model->meta()->createMany($meta);
    }

    public function findUsersChecksByYearAndMonth(int $user_id, int $year, int $month): Collection
    {
        return $this->model->whereUserId($user_id)
            ->whereMonth('created_at', $month)->whereYear('created_at', $year)->get();
    }
}
