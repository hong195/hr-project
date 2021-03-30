<?php

namespace App\Http\Controllers;

use App\Enums\Pagination;
use App\Forms\UserForm;
use App\Http\Requests\UserRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Queries\UserQueryInterface;
use App\Repositories\Contracts\UserRepositoryContract;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryContract $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function byPharmacy(Request $request)
    {

        $users = User::where('pharmacy_id', $request->input('pharmacy_id'))->get();

        return EmployeeResource::collection($users);
    }

    public function index(Request $request, UserQueryInterface $userQuery)
    {
        $perPage = $request->get('perPage', Pagination::DEFAULT_PER_PAGE);
        $users = $userQuery->execute($perPage);

        return EmployeeResource::collection($users);
    }

    public function create(UserForm $form)
    {
        return response()->json(['form' => $form->get()]);
    }

    public function store(UserRequest $userRequest)
    {
        $this->userRepository->create($userRequest->validated());

        return response()->json(['message' => __('crud.user_created')], 201);
    }

    public function edit(UserForm $form, $id)
    {
        $user = $this->userRepository->findByid($id);

        return response()->json(['form' => $form->fill($user)->get()]);
    }

    public function show($id)
    {
        return new UserResource($this->userRepository->findById($id));
    }

    public function update(UserRequest $userRequest, $id)
    {
        $this->userRepository->update($id, $userRequest->validated());

        return response()->json(['message' => __('crud.user_updated')], 200);
    }

    public function destroy(int $id)
    {
        $this->userRepository->delete($id);

        return response()->json(['message' => __('crud.user_deleted')], 200);
    }
}
