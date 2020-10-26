<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckRequest;
use App\Http\Resources\CheckResource;
use App\Models\Check;
use App\Repositories\CheckRepository;

class CheckController extends Controller
{
    /**
     * @var
     */
    private $checkRepository;

    public function __construct(CheckRepository $checkRepository)
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
     * Store a newly created resource in storage.
     *
     * @param CheckRequest $checkRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CheckRequest $checkRequest)
    {
        $check = $this->checkRepository->create($checkRequest);
        return response()->json(['message' => 'Check was successfully created', 'check' => $check], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Check $check
     * @return CheckResource
     */
    public function show(Check $check)
    {
        return new CheckResource($check->with('meta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CheckRequest $checkRequest
     * @param Check $check
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CheckRequest $checkRequest, Check $check)
    {
        $check = $this->checkRepository->update($check, $checkRequest);
        return response()->json(['message' => 'Check was successfully updated', 'check' => $check], 200);
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
