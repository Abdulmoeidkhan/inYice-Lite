<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SetupDashboardController extends Controller
{
    public function index()
    {
        // return Auth::user()->company;
        $company = Company::where('uuid', Auth::user()->company->uuid)->first();
        return view('pages.setupDashboard',$company ? ['company' => $company] : []);
    }
}
