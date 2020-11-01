<?php

namespace App\Http\Controllers;

use App\Exceptions\CheckExpcetion;
use App\Exceptions\UserRatingException;
use App\Http\Requests\CheckRequest;
use App\Http\Resources\CheckResource;
use App\Models\Check;
use App\Repositories\Contracts\CheckRepositoryContract;

class CheckController extends Controller
{
    /**
     * @var
     */
    private $checkRepository;

    public function __construct(CheckRepositoryContract $checkRepository)
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
        $this->checkRepository = $checkRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return CheckResource
     */
    public function index()
    {
        return new CheckResource(Check::with('meta')->paginate(25));
    }


    /**
     * @param CheckRequest $checkRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CheckRequest $checkRequest)
    {
        try {
            $this->checkRepository->create($checkRequest->validated());
        } catch (CheckExpcetion $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
        return response()->json(['message' => 'Check was successfully created'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return CheckResource
     */
    public function show($id)
    {
        return new CheckResource($this->checkRepository->findById($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CheckRequest $checkRequest
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CheckRequest $checkRequest, $id)
    {
        try {
            $this->checkRepository->update($id, $checkRequest->validated());
        }catch (CheckExpcetion $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }

        return response()->json(['message' => 'Check was successfully updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Check $check
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Check $check)
    {
        try {
            $check->delete();
        } catch (\Exception $e) {
            return response()
                ->json(['message' => 'There was an error while deleting the check, please try later'], 503);
        }
        return response()->json(['message' => 'Check was successfully deleted'], 200);
    }
}
