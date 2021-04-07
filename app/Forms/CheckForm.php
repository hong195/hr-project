<?php


namespace App\Forms;


use App\Models\Check;
use App\Models\User;
use App\Repositories\Contracts\CheckAttributeRepositoryContract;
use App\Repositories\Contracts\UserRepositoryContract;
use Carbon\Carbon;
use Saodat\FormBase\Contracts\FormBuilderInterface;

class CheckForm extends AbstractForm
{
    private $checkAttributes;

    protected $defaultFieldsAttributes = ['outlined' => true];
    /**
     * @var UserRepositoryContract
     */
    private $userRepository;


    public function __construct(FormBuilderInterface $formBuilder,
                                UserRepositoryContract $userRepository,
                                CheckAttributeRepositoryContract $checkAttributeRepository)
    {
        $this->userRepository = $userRepository;
        $formBuilder->setDefaultsFieldsAttributes($this->defaultFieldsAttributes);
        $this->checkAttributes = $checkAttributeRepository->all();
        parent::__construct($formBuilder);
    }

    protected function buildForm()
    {
        $this->formBuilder
            ->add('select', 'user_id', 'Сотрудник',
                [
                    'options' => $this->getUsers(),
                    'validationRule' => 'required',
                    'attributes' => [
                        'cols' => 6
                    ]
                ]);

        $this->formBuilder
            ->add('number', 'sum', 'Сумма чека',
                [
                    'validationRule' => 'required',
                    'attributes' => [
                        'cols' => 6
                    ]
                ]);

        $this->formBuilder->add('date', 'created_at', 'Дата чека',[
            'validationRule' => 'required',
            'attributes' => ['min' => '2020-01-01',
                'max'=> date("Y-m-d", strtotime("today")),
                'timepicker' => true
            ]
        ]);

        $this->checkAttributes->each(function($attribute) {
            if ($attribute->type === 'radio') {
                $this->formBuilder->add($attribute->type, "meta.$attribute->name", $attribute->label, [
                    'options' => $attribute->options->map(function($option) {
                        return [
                            'value' => $option->id,
                            'label' => $option->label,
                            'name' => $option->name
                        ];
                    }),
                ]);

                $this->formBuilder->add('textarea', "meta.notice.{$attribute->name}", 'Примечание');
            }

            if (!$attribute->use_in_rating && $attribute->type === 'textarea') {
                $this->formBuilder->add($attribute->type, "meta.$attribute->name", $attribute->label);
            }

        });
    }

    protected function getUsers()
    {
        $users = $this->userRepository->all();
        $users = $users->map(function ($user) {
            return ['id' => $user->id, 'name' => $user->first_name.' '.$user->last_name];
        })->toArray();

        return $users;
    }

    public function fill(Check $check)
    {

        foreach ($this->formBuilder->getFields() as $field) {
            $value = null;

            if ('name' === $field->getName()) {
                $value = $check->name;
            }

            if ('user_id' === $field->getName()) {
                $value = $check->user_id;
            }

            if ('sum' === $field->getName()) {
                $value = $check->sum;
            }

            if ('created_at' === $field->getName()) {
                $value = Carbon::parse($check->created_at)->format('Y-m-d H:i');
            }

            $field->setValue($value);
        }

        $criterias = $check->criteria;

        collect($this->formBuilder->getFields())->each(function($field) use ($criterias){
            collect($criterias)->each(function($criteria) use ($field){
                if ($field->getName() === "meta.$criteria->name") {
                    $value = null;
                    if ($criteria->options) {

                        foreach ($criteria->options as $option) {
                            if (!$option->selected) {
                                continue;
                            }

                            $value = $option->id;
                        }
                    }
                    if (property_exists($criteria, 'value')) {
                        $value = $criteria->value;
                    }

                    $field->setValue($value);
                }
            });
        });

        return $this;
    }
}
