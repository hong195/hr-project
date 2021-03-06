<?php

namespace App\Http\Controllers;

use App\Forms\UserForm;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
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
        return UserResource::collection($this->userRepository->all());
    }

    public function create(UserForm $form)
    {
        return response()->json($form->get());
    }

    public function store(UserRequest $userRequest)
    {
        $this->userRepository->create($userRequest->validated());

        return response()->json(['message' => 'User have been successfully created!'], 201);
    }

    public function edit(UserForm $form, $id)
    {
        $user = $this->userRepository->findByid($id);

        return $form->fill($user)->get();
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
