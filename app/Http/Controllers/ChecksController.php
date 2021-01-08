<?php

namespace App\Http\Controllers;

use App\Enums\CheckLimit;
use App\Exceptions\CheckExpcetion;
use App\Forms\CheckForm;
use App\Http\Requests\CheckRequest;
use App\Http\Resources\CheckResource;
use App\Models\Check;
use App\Queries\CheckQueryInterface;
use App\Repositories\Contracts\CheckRepositoryContract;

class ChecksController extends Controller
{
    private $checkRepository;

    public function __construct(CheckRepositoryContract $checkRepository)
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
        $this->checkRepository = $checkRepository;
    }


    public function index(CheckQueryInterface $checkQuery): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $checks = $checkQuery->execute(CheckLimit::MINIMUM_FOR_CREATING_RATING);

        return CheckResource::collection($checks);
    }


    public function create(CheckForm $form)
    {
        return response()->json(['form' => $form->get()]);
    }

    public function store(CheckRequest $checkRequest)
    {
        try {
            $this->checkRepository->create($checkRequest->validated());
        } catch (CheckExpcetion $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
        return response()->json(['message' => __('crud.check_created')], 201);
    }

    public function show($id)
    {
        return new CheckResource($this->checkRepository->findById($id));
    }

    public function edit(CheckForm $form, $id)
    {
        $check = $this->checkRepository->findById($id);

        return response()->json(['form' => $form->fill($check)->get()]);
    }

    public function update(CheckRequest $checkRequest, $id)
    {
        try {
            $this->checkRepository->update($id, $checkRequest->validated());
        } catch (CheckExpcetion $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }

        return response()->json(['message' => __('crud.check_updated')], 200);
    }

    public function destroy(Check $check)
    {
        try {
            $check->delete();
        } catch (\Exception $e) {
            return response()
                ->json(['message' => __('crud.delete_error')], 503);
        }

        return response()->json(['message' => __('crud.check_deleted')], 200);
    }
}
