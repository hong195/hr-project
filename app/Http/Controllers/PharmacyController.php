<?php

namespace App\Http\Controllers;

use App\Http\Requests\PharmacyRequest;
use App\Http\Resources\PharmacyResource;
use App\Models\Pharmacy;
use App\Repositories\PharmacyRepository;

class PharmacyController extends Controller
{
    /**
     * @var PharmacyRepository
     */
    private $pharmacyRepository;

    public function __construct(PharmacyRepository $pharmacyRepository)
    {
        $this->pharmacyRepository = $pharmacyRepository;
    }

    public function index()
    {
        // Todo make search
        return PharmacyResource::collection($this->pharmacyRepository->all());
    }


    public function create()
    {
        // Todo Make pharmacy form
    }

    public function store(PharmacyRequest $pharmacyRequest)
    {
        $this->pharmacyRepository->create($pharmacyRequest->validated());

        return response()->json(['message' => 'Pharmacy was successfully created!'], 201);
    }


    public function show($id)
    {
        return new PharmacyResource($this->pharmacyRepository->findById($id));
    }


    public function edit(Pharmacy $pharmacy)
    {
        // Todo Make pharmacy form
    }

    public function update(PharmacyRequest $pharmacyRequest, $id)
    {
        $this->pharmacyRepository->update($id, $pharmacyRequest->validated());

        return response()->json(['message' => 'Pharmacy was successfully updated!']);
    }

    public function destroy($id)
    {
        $this->pharmacyRepository->delete($id);

        return response()->json(['message' => 'Pharmacy was deleted!'], 200);
    }
}
