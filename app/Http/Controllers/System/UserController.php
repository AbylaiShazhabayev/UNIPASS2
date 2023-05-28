<?php

namespace App\Http\Controllers\System;

use App\Constants;
use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use DataTables;
use DB;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:user-view', ['only' => ['view', 'index', 'show']]);
        $this->middleware('permission:user-create', ['only' => ['store']]);
        $this->middleware('permission:user-edit', ['only' => ['update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    public function view()
    {
        return response()->view('system.users.users');
    }

    public function index(Request $request)
    {
        $query = User::query();

        if (filter_var($request->is_data_table, FILTER_VALIDATE_BOOLEAN)) {
            return DataTables::eloquent($query)->toJson();
        }

        return $query->paginate(Constants::PAGINATION_LIMIT);
    }

    public function show(User $user)
    {
        $keys = ["folder-view", "folder-create", "folder-edit", "folder-delete", "user-view", "user-create", "user-edit", "user-delete", "group-view", "group-create", "group-edit", "group-delete"];
        $userCore = \App\User::find($user->id);

        foreach ($keys as $key) {
            $user->{$key} = $userCore->can($key) ? 1 : 0;
        }

        return $user;
    }

    public function store(Request $request)
    {
        $rules = User::rules();
        $names = User::names();

        $request->validate($rules, [], $names);

        $user = User::create($request->all());

        $this->setPermissions($request, $user);

        return $user;
    }

    /**
     * rules
     * 1 - Não pode alterar as permissões do próprio usuário
     */
    public function update(Request $request, User $user)
    {
        $rules = User::rules($user->id);
        $names = User::names();

        $request->validate($rules, [], $names);

        $user->update($request->only(['name', 'admin']));

        if (Auth::user()->id != $user->id) {
            $this->setPermissions($request, $user);
        }

        return $user;
    }

    private function setPermissions($request, $user)
    {
        $keys = ["folder-view", "folder-create", "folder-edit", "folder-delete", "user-view", "user-create", "user-edit", "user-delete", "group-view", "group-create", "group-edit", "group-delete"];
        $permissions = [];

        $userCore = \App\User::find($user->id);

        foreach ($keys as $key) {
            if ($request->{$key}) {
                array_push($permissions, $key);
            }
        }

        $userCore->syncPermissions($permissions);
    }

    public function destroy(User $user)
    {
        $user->delete();
    }

}
