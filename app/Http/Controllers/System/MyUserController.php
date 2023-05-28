<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use DataTables;
use DB;
use Illuminate\Http\Request;

class MyUserController extends Controller
{
    public function update(Request $request)
    {
        $rules = User::rules(Auth::user()->id);
        $names = User::names();

        $data = [
            'name' => $request->name,
            'password' => bcrypt($request->password)
        ];

        if (!$request->password) {
            unset($rules['password'], $data['password']);
        }

        $request->validate($rules, [], $names);

        $userUpdate = Auth::user();

        $userUpdate->update($data);

        return $userUpdate;
    }

}
