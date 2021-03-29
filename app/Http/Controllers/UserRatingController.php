<?php

namespace App\Http\Controllers;

use App\Enums\Pagination;
use App\Http\Requests\UserRatingRequest;
use App\Http\Resources\EmployeeResource;
use App\Queries\UserQueryInterface;

class UserRatingController extends Controller
{
    /**
     * @var UserQueryInterface
     */
    private $userQuery;

    public function __construct(UserQueryInterface $userQuery)
    {
        $this->userQuery = $userQuery;
    }

    public function index(UserRatingRequest $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $request = $request->validated();
        $perPage = $request['perPage'] ?? Pagination::DEFAULT_PER_PAGE;

        $userWithRatings = $this->userQuery->execute($perPage);

        return EmployeeResource::collection($userWithRatings);
    }
}
