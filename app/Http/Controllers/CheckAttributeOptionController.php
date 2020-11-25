<?php

namespace App\Http\Controllers;

use App\Forms\CheckAttributeOptionForm;
use App\Http\Requests\CheckAttributeOptionRequest;
use App\Http\Resources\CheckAttributeOptionResource;
use App\Repositories\CheckAttributeOptionRepository;

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

    public function index()
    {
        return CheckAttributeOptionResource::collection($this->option->with(['attribute']));
    }

    public function create(CheckAttributeOptionForm $form)
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
