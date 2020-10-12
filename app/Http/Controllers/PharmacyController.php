<?php

namespace App\Http\Controllers;

use App\Http\Requests\PharmacyRequest;
use App\Http\Resources\PharmacyResource;
use App\Models\Pharmacy;

class PharmacyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        // Todo make search
        return PharmacyResource::collection(Pharmacy::with('users')->paginate(25));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        // Todo Make pharmacy form
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PharmacyRequest $pharmacyRequest
     * @param Pharmacy $pharmacy
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PharmacyRequest $pharmacyRequest, Pharmacy $pharmacy)
    {
        $pharmacy->create($pharmacyRequest->validated());

        return response()->json([
            'message' => 'Pharmacy was successfully created!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Pharmacy $pharmacy
     * @return PharmacyResource
     */
    public function show(Pharmacy $pharmacy)
    {
        return new PharmacyResource($pharmacy->load('users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pharmacy  $pharmacy
     * @return \Illuminate\Http\Response
     */
    public function edit(Pharmacy $pharmacy)
    {
        // Todo Make pharmacy form
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PharmacyRequest $pharmacyRequest
     * @param \App\Models\Pharmacy $pharmacy
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PharmacyRequest $pharmacyRequest, Pharmacy $pharmacy)
    {
        $pharmacy->update($pharmacyRequest->validated());

        return response()->json([
            'message' => 'Pharmacy was successfully updated!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pharmacy  $pharmacy
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Pharmacy $pharmacy)
    {
        try {
            $pharmacy->delete();
        } catch (\Exception $e) {
            return response()
                ->json(
                    ['message' => 'There was an error while deleting the pharmacy, please try later'],
                    503);
        }

        return response()->json(['message' => 'Pharmacy was deleted!'], 200);
    }
}
