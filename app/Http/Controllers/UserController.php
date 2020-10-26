<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        //Todo make user search
        return UserResource::collection(User::with(['pharmacy', 'meta'])->paginate(25));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $userRequest
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $userRequest, User $user)
    {
        // Todo make saving user meta info to a different table
        $user->create($userRequest->validated());
        return response()->json(['message' => 'User have been successfully created!'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return UserResource
     */
    public function show(User $user)
    {
        return new UserResource($user->load(['pharmacy', 'meta']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $userRequest
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $userRequest, User $user)
    {
        // Todo make saving user meta info to a different table
        $user->update($userRequest->validated());
        return response()->json(['message' => 'User have been successfully updated!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
        } catch (\Exception $e) {
            return response()
                ->json(
                    ['message' => 'There was an error while deleting the user, please try later'],
                    503);
        }

        return response()->json(['message' => 'User was deleted!'], 200);
    }
}
