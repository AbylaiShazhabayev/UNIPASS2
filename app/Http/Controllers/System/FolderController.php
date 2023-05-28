<?php

namespace App\Http\Controllers\System;

use App\Constants;
use App\Http\Controllers\Controller;
use App\Models\Folder;
use Auth;
use DataTables;
use DB;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:folder-view', ['only' => ['view', 'index', 'show', 'users', 'usersAvailable']]);
        $this->middleware('permission:folder-create', ['only' => ['store']]);
        $this->middleware('permission:folder-edit', ['only' => ['update', 'usersAdd', 'userDelete']]);
        $this->middleware('permission:folder-delete', ['only' => ['destroy']]);
    }

    public function view()
    {
        return response()->view('system.folders.folders');
    }

    public function index(Request $request)
    {
        $query = DB::select(
            'WITH RECURSIVE cte AS
            (
                SELECT
  	                d0.id,
  	                d0.name,
                    d0.folder_id,
                    CAST(d0.id AS CHAR(200)) AS path,
                    0 as depth
                FROM vw_folders d0
                WHERE d0.folder_id IS NULL
                UNION ALL
                SELECT
                    d1.id,
                    d1.name,
                    d1.folder_id,
                    CONCAT(cte.path, ",", d1.id),
                    cte.depth + 1
                FROM vw_folders d1
	            JOIN cte ON cte.id = d1.folder_id
            )
            SELECT * FROM cte ORDER BY path'
        );

        if (filter_var($request->is_data_table, FILTER_VALIDATE_BOOLEAN)) {
            return DataTables::of($query)->toJson();
        }

        return $query;
    }

    public function compact(Request $request)
    {
        $query = DB::select(
            'WITH RECURSIVE cte AS
            (
                SELECT
  	                d0.id,
  	                d0.name,
                    d0.folder_id,
                    CAST(d0.id AS CHAR(200)) AS path,
                    0 as depth
                FROM vw_folders d0
                WHERE d0.folder_id IS NULL
                UNION ALL
                SELECT
                    d1.id,
                    d1.name,
                    d1.folder_id,
                    CONCAT(cte.path, ",", d1.id),
                    cte.depth + 1
                FROM vw_folders d1
	            JOIN cte ON cte.id = d1.folder_id
            )
            SELECT * FROM cte ORDER BY path'
        );

        if (filter_var($request->is_data_table, FILTER_VALIDATE_BOOLEAN)) {
            return DataTables::of($query)->toJson();
        }

        return $query;
    }

    public function show(Folder $folder)
    {
        return $folder;
    }

    public function store(Request $request)
    {
        $rules = Folder::rules();
        $names = Folder::names();

        $request->validate($rules, [], $names);

        $folder = Folder::create($request->all());
        $folder->id = collect(DB::select('SELECT @lastInsertId_folders AS id'))->first()->id;

        return $folder;
    }

    public function update(Request $request, Folder $folder)
    {
        $rules = Folder::rules($folder->id);
        $names = Folder::names();

        $request->validate($rules, [], $names);

        $folder->update($request->all());

        return $folder;
    }

    public function destroy(Folder $folder)
    {
        $folder->delete();
    }

}
