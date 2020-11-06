<?php

namespace App\Http\Controllers;
use App\Http\Resources\RoleResource;
use Spatie\Permission\Models\Role;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return RoleResource::collection(Role::all());
    }
}
