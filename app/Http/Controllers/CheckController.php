<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckRequest;
use App\Models\Check;
use Illuminate\Http\Request;

class CheckController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth:api', ['except' => ['index', 'show']]);
        //$this->middleware('admin', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CheckRequest $checkRequest
     * @return void
     */
    public function store(CheckRequest $checkRequest)
    {
        dd($checkRequest->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
