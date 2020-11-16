<?php

namespace App\Http\Controllers;

use App\Exceptions\CheckExpcetion;
use App\Exceptions\UserRatingException;
use App\Forms\CheckForm;
use App\Http\Requests\CheckRequest;
use App\Http\Resources\CheckResource;
use App\Models\Check;
use App\Repositories\Contracts\CheckRepositoryContract;
use Illuminate\Http\Request;

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


    public function index(Request $request)
    {
        if ($ratingId = $request->get('rating_id')) {
            $checks = Check::whereHas('ratings', function ($query) use ($ratingId) {
                return $query->where('ratings.id', $ratingId);
            })
                ->get();
        } else if ($request->get('with_user')) {
            $checks = Check::with('user')->get();
        } else if ($userId = $request->get('user_id')) {
            $year = $request->get('year') ? $request->get('year') : now()->year;
            $month = $request->get('month') ? $request->get('month') : now()->month;
            $checks = Check::where('user_id', $userId)
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->get();
        } else {
            $checks = Check::with('meta')->get();
        }

        return new CheckResource($checks);
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
        return response()->json(['message' => 'Check was successfully created'], 201);
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

        return response()->json(['message' => 'Check was successfully updated'], 200);
    }

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
