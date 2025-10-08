<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController as BaseApiController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class UserApiController extends BaseApiController
{


    public function updateProfilePassowrd(Request $request)
    {
        $requestingUser = Auth::user();

        $validator = Validator::make($request->all(), [
            'uuid' => 'required|exists:users,uuid',
            'userInputPassword' => 'required|string|min:8',
            'userInputPasswordConfirm' => 'required|string|min:8|same:userInputPassword',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $targetUser = User::where('uuid', $request->uuid)->first();
        if (!$targetUser) {
            return $this->sendError('User not found', ['error' => 'No user found with the provided UUID'], 404);
        }


        if ($requestingUser->uuid === $request->uuid) {
            $targetUser = User::where('uuid', $request->uuid)->update(['password' => bcrypt($request->userInputPassword)]);
            return $this->sendResponse($targetUser, 'User password updated successfully.');
        } else if ($requestingUser->hasanyrole('admin|owner|developer')) {
            $targetUser = User::where('uuid', $request->uuid)->update(['password' => bcrypt($request->userInputPassword)]);
            return $this->sendResponse($targetUser, 'User password updated successfully.');
        } else {
            return $this->sendError('Forbidden', ['error' => 'Insufficient permissions'], 403);
        }
    }

    public function attachRole(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return $this->sendError('Unauthorized', ['error' => 'User not authenticated'], 401);
        }

        if (!$user->hasanyrole('admin|owner|developer')) {
            return $this->sendError('Forbidden', ['error' => 'Insufficient permissions'], 403);
        }

        $request->validate([
            'uuid' => 'required|exists:users,uuid',
            'roles' => 'required|exists:roles,name',
        ]);

        $targetUser = User::where('uuid', $request->uuid)->first();
        if (!$targetUser) {
            return $this->sendError('User not found', ['error' => 'No user found with the provided UUID'], 404);
        }

        // Sync roles and permissions
        $targetUser->syncRoles($request->roles);

        return $this->sendResponse($targetUser->load('roles', 'permissions'), 'User roles updated successfully.');
    }

    public function attachPermission(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return $this->sendError('Unauthorized', ['error' => 'User not authenticated'], 401);
        }

        if (!$user->hasanyrole('admin|owner|developer')) {
            return $this->sendError('Forbidden', ['error' => 'Insufficient permissions'], 403);
        }

        $request->validate([
            'uuid' => 'required|exists:users,uuid',
            'permissions' => 'sometimes|array',
        ]);

        $targetUser = User::where('uuid', $request->uuid)->first();
        if (!$targetUser) {
            return $this->sendError('User not found', ['error' => 'No user found with the provided UUID'], 404);
        }

        // Sync roles and permissions
        if ($request->has('permissions')) {
            $targetUser->syncPermissions($request->permissions);
        }
        else{
            $targetUser->syncPermissions([]);
        }

        return $this->sendResponse($targetUser->load('roles', 'permissions'), 'User roles updated successfully.');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('company_uuid', Auth::user()->company->uuid)->whereNot('uuid', Auth::user()->uuid)->with(['roles', 'permissions'])->get();
        foreach ($users as $key => $user) {
            $roleNames = $user->roles->pluck('name')->toArray();
            if (!in_array('user', $roleNames)) {
                $imagePath = $user->uuid . '.png';
                $users[$key]->image = Storage::disk('staff')->url($imagePath);
            } else {
                $users[$key]->image = null;
            }
        }
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
