<?php

namespace App\Http\Controllers;

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

    /**
     * Display a listing of the resource.
     *
     * @return CheckAttributeResource
     */
    public function index()
    {
        // Todo make search by attribute
        return new CheckAttributeResource($this->checkAttributeRepository->all());
    }

    public function store(CheckAttributeRequest $checkAttributeRequest)
    {
        $this->checkAttributeRepository->create($checkAttributeRequest->validated());

        return response()->json(['message' => 'Attribute was successfully created!'], 201);
    }

    public function show(int $id)
    {
        return new CheckAttributeResource($this->checkAttributeRepository->findById($id));
    }

    public function update(CheckAttributeRequest $checkAttributeRequest, int $id)
    {
        $this->checkAttributeRepository->update($id, $checkAttributeRequest->validated());

        return response()->json(['message' => 'Attribute was successfully updated!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $this->checkAttributeRepository->delete($id);
        return response()->json(['message' => 'Attribute was deleted!'], 200);
    }
}
