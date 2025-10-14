<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController as BaseApiController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\User;

class EmployeeApiController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $employees = User::where('company_uuid', Auth::user()->company->uuid)
                ->whereNot('uuid', Auth::user()->uuid)
                ->whereHas('roles', function ($query) {
                    $query->where('id', '>', 2)->where('id', '<', 7);
                })->with(['roles', 'permissions'])->get();
            return $employees;
            // return $this->sendResponse($employees, 'employees Retrieved successfully.');
        } catch (\Illuminate\Database\QueryException $ex) {
            return $this->sendError('Database Error.', $ex->getMessage());
        } catch (\Exception $e) {
            return $this->sendError('Database Error.', $e->getMessage());
        }
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
