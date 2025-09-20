<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController as BaseApiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class UserApiController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('company_uuid', Auth::user()->company->uuid)->with(['roles','permissions'])->get();
        // return $this->sendResponse($users, 'Users retrieved successfully.');
        return response()->json($users->toArray()); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
