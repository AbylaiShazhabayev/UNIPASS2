<?php

namespace App\Http\Controllers\System;

use App\Constants;
use App\Http\Controllers\Controller;
use App\Models\Password;
use App\Models\PasswordFavorite;
use App\Models\PasswordType;
use Auth;
use DataTables;
use DB;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    public function view()
    {
        return response()->view('system.passwords.passwords');
    }

    public function securityCenterIndex(Request $request){
        return response()->view('system.passwords.security-center');
    }

    public function index(Request $request)
    {
        $where = '';

        $sqlPasswords = $this->sqlPasswords();

        $sqlPasswordsSharedsUsers = $this->sqlPasswordsSharedsUsers();

        $passwordsSharedsGroups = $this->sqlPasswordsSharedsGroups();

        $from = "($sqlPasswords) UNION ($sqlPasswordsSharedsUsers) UNION ($passwordsSharedsGroups)";
        $params = [
            'user_id1' => Auth::user()->id,
            'user_id2' => Auth::user()->id,
            'user_id3' => Auth::user()->id,
            'user_id4' => Auth::user()->id,
            'user_id5' => Auth::user()->id,
            'user_id6' => Auth::user()->id,
        ];

        if ($request->has('filter_by')) {
            if ($request->filter_by == 'favorites') {
                $where .= ' AND t.favorite = TRUE ';
            }
            if ($request->filter_by == 'my_passwords') {
                $from = "$sqlPasswords";
                $params = [
                    'user_id1' => Auth::user()->id,
                ];
            }
            if ($request->filter_by == 'shareds_passwords') {
                $from = "($sqlPasswordsSharedsUsers) UNION ($passwordsSharedsGroups)";
                $params = [
                    'user_id2' => Auth::user()->id,
                    'user_id3' => Auth::user()->id,
                    'user_id4' => Auth::user()->id,
                    'user_id5' => Auth::user()->id,
                    'user_id6' => Auth::user()->id,
                ];
            }
        }

        if ($request->has('filter_by_folder')) {
            $where .= ' AND FIND_IN_SET(t.folder_id, :folders) ';
            $params['folders'] = implode($request->filter_by_folder, ',');
        }

        if ($request->has('filter_by_type')) {
            $where .= ' AND FIND_IN_SET(t.type, :types) ';
            $params['types'] = implode($request->filter_by_type, ',');
        }

        $query = DB::select("
                SELECT
                    *
                FROM ($from) AS t
                WHERE 1 = 1
                $where
            ",
            $params
        );

        if (filter_var($request->data_table, FILTER_VALIDATE_BOOLEAN)) {
            return DataTables::of($query)->toJson();
        }

        return $query->paginate(Constants::PAGINATION_LIMIT);
    }

    private function sqlPasswords()
    {
        return "
            SELECT
                p.id,
                p.name,
                p.password,
                p.type,
                p.folder_id,
                0 AS shared,
                1 AS can_view,
                1 AS can_edit,
                1 AS can_delete,
                1 AS can_share,
                p.created_at,
                p.updated_at,
                IF(pf.id IS NOT NULL, TRUE, FALSE) AS favorite
            FROM vw_passwords AS p
            LEFT JOIN vw_passwords_favorites AS pf ON (pf.password_id = p.id AND pf.user_id = p.created_by)
            WHERE p.created_by = :user_id1
        ";
    }

    private function sqlPasswordsSharedsUsers()
    {
        return "
            SELECT
                p.id,
                p.name,
                p.password,
                p.type,
                p.folder_id,
                1 AS shared,
                ps.can_view,
                ps.can_edit,
                ps.can_delete,
                ps.can_share,
                p.created_at,
                p.updated_at,
                IF(pf.id IS NOT NULL, TRUE, FALSE) AS favorite
            FROM vw_passwords_shareds AS ps
            INNER JOIN vw_passwords AS p ON (p.id = ps.password_id)
            LEFT JOIN vw_passwords_favorites AS pf ON (pf.password_id = p.id AND pf.user_id = ps.user_id)
            WHERE  ps.user_id = :user_id2
            AND p.created_by <> :user_id3
        ";
    }

    private function sqlPasswordsSharedsGroups()
    {
        return "
            SELECT
                p.id,
                p.name,
                p.password,
                p.type,
                p.folder_id,
                1 AS shared,
                ps.can_view,
                ps.can_edit,
                ps.can_delete,
                ps.can_share,
                p.created_at,
                p.updated_at,
                IF(pf.id IS NOT NULL, TRUE, FALSE) AS favorite
            FROM vw_passwords_shareds AS ps
            INNER JOIN vw_passwords AS p ON (p.id = ps.password_id)
            INNER JOIN vw_groups_users AS gu ON (gu.group_id = ps.group_id)
            LEFT JOIN vw_passwords_favorites AS pf ON (pf.password_id = p.id AND pf.user_id = gu.user_id)
            WHERE  gu.user_id = :user_id4
            AND p.created_by <> :user_id5
            AND NOT EXISTS (SELECT 1
                            FROM vw_passwords_shareds AS ps
                            WHERE ps.password_id = p.id
            AND ps.user_id = :user_id6)
        ";
    }

    public function show(Password $password)
    {
        Password::hasPermissionPassword($password, 'can_view');

        $password->type_name = PasswordType::getDescription($password->type);

        return $password->makeVisible('password');
    }

    public function store(Request $request)
    {
        $rules = Password::rules();
        $names = Password::names();

        $request->validate($rules, [], $names);

        return Password::create($request->all());
    }

    public function update(Request $request, Password $password)
    {
        Password::hasPermissionPassword($password, 'can_edit');

        $rules = Password::rules($password->id);
        $names = Password::names();

        $request->validate($rules, [], $names);

        $password->update($request->all());

        return $password;
    }

    public function destroy(Password $password)
    {
        Password::hasPermissionPassword($password, 'can_delete');

        $password->delete();
    }

    public function favorite($passwordId)
    {
        $password = Password::find($passwordId);

        Password::hasPermissionPassword($password, 'can_view');

        $passwordFavorite = PasswordFavorite::where('password_id', $password->id)
            ->where('user_id', auth()->user()->id)
            ->first();

        if ($passwordFavorite) {
            $response = $passwordFavorite->delete();
        } else {
            $response = PasswordFavorite::create([
                'password_id' => $password->id,
                'user_id' => auth()->user()->id
            ]);
        }

        return response()->json($response);
    }
}
