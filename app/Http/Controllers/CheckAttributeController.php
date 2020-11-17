<?php

namespace App\Http\Controllers;

use App\Forms\CheckAttributeForm;
use App\Http\Requests\CheckAttributeRequest;
use App\Http\Resources\CheckAttributeResource;
use App\Repositories\Contracts\CheckAttributeRepositoryContract;

class CheckAttributeController extends Controller
{
    private $checkAttributeRepository;

    public function __construct(CheckAttributeRepositoryContract $checkAttributeRepository)
    {
        $this->checkAttributeRepository = $checkAttributeRepository;
    }

    public function create(CheckAttributeForm $form)
    {
        return response()->json(['form' => $form->get()]);
    }

    public function index()
    {
        // Todo make search by attribute
        return new CheckAttributeResource($this->checkAttributeRepository->all());
    }

    public function store(CheckAttributeRequest $checkAttributeRequest)
    {
        $this->checkAttributeRepository->create($checkAttributeRequest->validated());

        return response()->json(['message' => __('crud.attribute_created')], 201);
    }

    public function edit(CheckAttributeForm $form, $id)
    {
        $attr = $this->checkAttributeRepository->findById($id);

        return response()->json(['form' => $form->fill($attr)->get()]);
    }

    public function show(int $id)
    {
        return new CheckAttributeResource($this->checkAttributeRepository->findById($id));
    }

    public function update(CheckAttributeRequest $checkAttributeRequest, int $id)
    {
        $this->checkAttributeRepository->update($id, $checkAttributeRequest->validated());

        return response()->json(['message' => __('crud.attribute_updated')], 200);
    }

    public function destroy(int $id)
    {
        $this->checkAttributeRepository->delete($id);
        return response()->json(['message' => __('crud.attribute_deleted')], 200);
    }
}
