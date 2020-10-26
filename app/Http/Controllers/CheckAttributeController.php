<?php

namespace App\Http\Controllers;

use App\Http\Resources\CheckAttributeResource;
use App\Models\CheckAttribute;
use Illuminate\Http\Request;

class CheckAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return CheckAttributeResource
     */
    public function index()
    {
        // Todo make search by attribute
        return new CheckAttributeResource(CheckAttribute::with('meta')->paginate(25));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param CheckAttribute $checkAttribute
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, CheckAttribute $checkAttribute)
    {
        $checkAttribute->create($request->only('name', 'meta'));

        return response()->json(['message' => 'Attribute was successfully created!'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param CheckAttribute $checkAttribute
     * @return CheckAttributeResource
     */
    public function show(CheckAttribute $checkAttribute)
    {
        return new CheckAttributeResource($checkAttribute->load('meta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param CheckAttribute $checkAttribute
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, CheckAttribute $checkAttribute)
    {
        $checkAttribute->update($request->only('name', 'meta'));

        return response()->json(['message' => 'Attribute was successfully updated!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CheckAttribute $checkAttribute
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(CheckAttribute $checkAttribute)
    {
        try {
            $checkAttribute->delete();
        } catch (\Exception $e) {
            return response()
                ->json(
                    ['message' => 'There was an error while deleting the check attribute, please try later'],
                    503);
        }

        return response()->json(['message' => 'Attribute was deleted!'], 200);
    }
}
