<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Password;
use App\Models\PasswordShared;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PasswordSharedController extends Controller
{
    public function __construct()
    {
        $this->model = new PasswordShared;
    }

    public function shareds($passwordId)
    {
        $result = DB::table('vw_passwords_shareds as sc')
            ->leftJoin('vw_users as u', 'u.id', '=', 'sc.user_id')
            ->leftJoin('vw_groups as g', 'g.id', '=', 'sc.group_id')
            ->select([
                'sc.id',
                'u.id as user_id',
                'u.name as user_name',
                'g.id as group_id',
                'g.name as group_name',
                'sc.can_view',
                'sc.can_edit',
                'sc.can_delete',
                'sc.can_share',
                'sc.created_at',
                'sc.updated_at'
            ])
            ->where('sc.password_id', $passwordId)
            ->get();

        return Datatables::of($result)->make(true);
    }

    public function groupsAvailable($passwordId)
    {
        $result = DB::table('vw_groups as g')
            ->select(['g.id', 'g.name', 'g.created_at'])
            ->leftJoin('vw_passwords_shareds as sc', function ($leftJoin) use ($passwordId) {
                $leftJoin
                    ->on('sc.group_id', '=', 'g.id')
                    ->where('sc.password_id', '=', $passwordId);
            })
            ->whereNull('sc.id')
            ->get();

        return DataTables::of($result)->make(true);
    }

    public function usersAvailable($passwordId)
    {
        $result = DB::table('vw_users as u')
            ->select(['u.id', 'u.name', 'u.email'])
            ->leftJoin('vw_passwords_shareds as sc', function ($leftJoin) use ($passwordId) {
                $leftJoin
                    ->on('sc.user_id', '=', 'u.id')
                    ->where('sc.password_id', '=', $passwordId);
            })
            ->whereNotIn('u.id', function ($query) use ($passwordId) {
                $query->select('s.created_by')
                    ->from('vw_passwords as s')
                    ->where('s.id', $passwordId);
            })
            ->where('u.active', 1)
            ->whereNull('sc.id')
            ->get();

        return DataTables::of($result)->make(true);
    }

    public function add(Request $request, $passwordId)
    {
        $password = Password::find($passwordId);

        Password::hasPermissionPassword($password, 'can_share');

        $data = json_decode($request->shareds, true);
        $response = [];

        foreach ($data as $item) {
            $item['password_id'] = $password->id;
            $response[] = PasswordShared::create($item);
        }

        return response()->json($response);
    }

    public function delete($passwordSharedId)
    {
        $passwordShared = PasswordShared::find($passwordSharedId);
        $password = Password::find($passwordShared->password_id);

        Password::hasPermissionPassword($password, 'can_share');

        $passwordShared->delete();

        return response()->json();
    }
}
