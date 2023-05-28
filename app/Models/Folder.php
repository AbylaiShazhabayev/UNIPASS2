<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Folder extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'vw_folders';

    protected $fillable = [
        'id',
        'name',
        'folder_id',
        'created_by',
        'updated_by',
    ];

    public static function rules($id = '')
    {
        return [
            'name' => 'required|max:64|unique:vw_folders,name,' . $id . ',id',
        ];
    }

    public static function names()
    {
        return [
            'name' => 'Nome',
        ];
    }
}
