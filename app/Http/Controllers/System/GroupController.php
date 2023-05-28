<?php

namespace App\Http\Controllers\System;

use App\Constants;
use App\GroupUser;
use App\Http\Controllers\Controller;
use App\Models\Group;
use Auth;
use DataTables;
use DB;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:group-view', ['only' => ['view', 'index', 'show', 'users', 'usersAvailable']]);
        $this->middleware('permission:group-create', ['only' => ['store']]);
        $this->middleware('permission:group-edit', ['only' => ['update', 'usersAdd', 'userDelete']]);
        $this->middleware('permission:group-delete', ['only' => ['destroy']]);
    }

    public function view()
    {
        return response()->view('system.groups.groups');
    }

    public function index(Request $request)
    {
        $query = Group::query();

        if (filter_var($request->is_data_table, FILTER_VALIDATE_BOOLEAN)) {
            return DataTables::eloquent($query)->toJson();
        }

        return $query->paginate(Constants::PAGINATION_LIMIT);
    }

    public function show(Group $group)
    {
        return $group;
    }

    public function store(Request $request)
    {
        $rules = Group::rules();
        $names = Group::names();

        $request->validate($rules, [], $names);

        $group = Group::create($request->all());
        $group->id = collect(DB::select('SELECT @lastInsertId_groups AS id'))->first()->id;

        return $group;
    }

    public function update(Request $request, Group $group)
    {
        $rules = Group::rules($group->id);
        $names = Group::names();

        $request->validate($rules, [], $names);

        $group->update($request->all());

        return $group;
    }

    public function destroy(Group $group)
    {
        $group->delete();
    }

    public function users(Request $request)
    {
        $objResult = DB::select(
            'SELECT
                su.id,
                su.name
            FROM vw_users su
            JOIN vw_groups_users sgsu ON (sgsu.user_id = su.id AND sgsu.group_id = :groupId)
            ORDER BY su.name',
            [
                'groupId' => $request->id
            ]
        );
        $objResult = collect($objResult);

        return Datatables::of($objResult)->make(true);
    }

    public function usersAvailable(Request $request)
    {
        $objResult = DB::select(
            'SELECT
                su.id,
                su.name
            FROM vw_users su
            LEFT JOIN vw_groups_users sgsu ON (sgsu.user_id = su.id AND sgsu.group_id = :groupId)
            WHERE sgsu.group_id IS NULL
            GROUP BY su.id
            ORDER BY su.name',
            [
                'groupId' => $request->id
            ]
        );
        $objResult = collect($objResult);

        return Datatables::of($objResult)->make(true);
    }

    public function usersAdd(Request $request, $grupoId)
    {
        $data = json_decode($request->users, true);
        $response = [];

        foreach ($data as $item) {
            $item['group_id'] = $grupoId;
            $response[] = GroupUser::create($item);
        }

        return response()->json($response);
    }

    public function userDelete(Request $request)
    {
        return DB::table('vw_groups_users')
            ->where('group_id', $request->id)
            ->where('user_id', $request->user_id)
            ->delete();
    }

}
