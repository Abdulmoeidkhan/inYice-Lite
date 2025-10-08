<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Company, User};
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\{Role, Permission};

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $users = User::where('company_uuid', Auth::user()->company->uuid)->with(['roles', 'permissions'])->get();
        return view('pages.admin.users', ['company' => Auth::user()->company, 'users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $uuid)
    {
        $authUser = Auth::user();
        $user = User::where('uuid', $uuid)->with(['roles', 'permissions'])->first();
        $roles = Role::where('id', ">=", $authUser->roles[0]->id)->get();
        $rolesPermissions = Role::where('name', $user->roles[0]->name)->first()->permissions;
        $permissions = Permission::all();
        $filteredPermissions = $permissions->reject(function ($item) use ($rolesPermissions) {
            return $rolesPermissions->contains('id', $item->id);
        })->values();
        $superiorUser = $user->roles->contains(function ($role) use ($authUser) {
            return $role->id < $authUser->roles[0]->id;
        });
        // $filteredRoles = $roles->reject(function ($item) use ($user) {
        //     return $item->id > $user->roles[0]->id;
        // })->values();
        return view(
            'pages.admin.editUser',
            [
                'company' => $authUser->company,
                'user' => $user,
                'roles' => $roles,
                'permissions' => $permissions,
                'filteredPermissions' => $filteredPermissions,
                'rolesPermissions' => $rolesPermissions,
                'superiorUser' => $superiorUser,
                'selfUser' => $user->uuid == $authUser->uuid ? true : false,

            ]
        );
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
