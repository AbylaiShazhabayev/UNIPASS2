<?php

namespace App\Http\Controllers\System;

use App\Constants;
use App\Http\Controllers\Controller;
use App\Tenant;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MyPlanController extends Controller
{
    public function update(Request $request)
    {
        $rules = [
            'active_users_limit' => 'required|integer|min:1|max:10000',
        ];
        $names = [
            'active_users_limit' => 'Number of users',
        ];
        $request->validate($rules, [], $names);

        $countUsers = DB::table('vw_users')->where('active', Constants::INTEGER_TRUE)->count();

        if ($countUsers > $request->active_users_limit) {
            throw ValidationException::withMessages(['message' => 'You already own ' . $countUsers . ' active users']);
        }

        $data = [
            'price' => Tenant::calculatePrice($request->active_users_limit),
            'active_users_limit' => $request->active_users_limit,
        ];

        $tenant = Tenant::find(Auth::user()->tenant_id);

        $tenant->update($data);

        return $tenant;
    }
}
