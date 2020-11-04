<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryContract;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryContract $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        //Todo make user search
        return UserResource::collection($this->userRepository->all());
    }

    public function store(UserRequest $userRequest)
    {
        $this->userRepository->create($userRequest->validated());

        return response()->json(['message' => 'User have been successfully created!'], 201);
    }

    public function show($id)
    {
        return new UserResource($this->userRepository->findById($id));
    }

    public function update(UserRequest $userRequest, $id)
    {
        $this->userRepository->update($id, $userRequest->validated());

        return response()->json(['message' => 'User have been successfully updated!'], 200);
    }

    public function destroy(int $id)
    {
        $this->userRepository->delete($id);

        return response()->json(['message' => 'User was deleted!'], 200);
    }
}
