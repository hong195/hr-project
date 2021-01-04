<?php

namespace App\Http\Controllers;

use App\Enums\Pagination;
use App\Forms\CheckAttributeOptionForm;
use App\Http\Requests\CheckAttributeOptionRequest;
use App\Http\Resources\CheckAttributeOptionResource;
use App\Models\CheckAttributeOption;
use App\Repositories\CheckAttributeOptionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CheckAttributeOptionController extends Controller
{
    /**
     * @var CheckAttributeOptionRepository
     */
    private $option;

    public function __construct(CheckAttributeOptionRepository $option)
    {
        $this->option = $option;
    }

    public function index(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $perPage = $request->get('perPage', Pagination::DEFAULT_PER_PAGE);
        $page = $request->get('page', Pagination::DEFAULT_PAGE);
        $result = CheckAttributeOption::with('attribute')->paginate($perPage, '*', 'page', $page);

        return CheckAttributeOptionResource::collection($result);
    }

    public function create(CheckAttributeOptionForm $form): JsonResponse
    {
        return response()->json(['form' => $form->get()]);
    }

    public function store(CheckAttributeOptionRequest $request)
    {
        $this->option->create($request->validated());

        return response()->json(['message' => __('crud.option_created')]);
    }

    public function edit(CheckAttributeOptionForm $form, $id)
    {
        $option = $this->option->findById($id);

        return response()->json(['form' => $form->fill($option)->get()]);
    }

    public function update(CheckAttributeOptionRequest $request,$id)
    {
        $this->option->update($id,$request->validated());

        return response()->json(['message' => __('crud.option_updated')]);
    }

    public function destroy($id)
    {
        $this->option->delete($id);

        return response()->json(['message' => __('crud.option_deleted')]);
    }
}
