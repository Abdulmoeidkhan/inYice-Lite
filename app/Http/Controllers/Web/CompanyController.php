<?php

namespace App\Http\Controllers\Web;

use App\Models\Company;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req) {}

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $req)
    {
        $userArray = [];
        $users = User::where('company_uuid', $req->user()->company_uuid)
            ->whereHas('roles', function ($query) {
                $query->where('id', 2);
            })->get(['uuid', 'name']);
        foreach ($users as $user) {
            $userArray[$user->uid] = $user->name;
        }
        return view('pages.company', ['company' => $req->user()->company, 'users' => $userArray]);
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
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        //
    }
}
