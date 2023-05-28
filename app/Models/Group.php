<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Group extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'vw_groups';

    protected $fillable = [
        'id',
        'name',
        'created_by',
        'updated_by',
    ];

    public static function rules($id = '')
    {
        return [
            'name' => 'required|max:64|unique:vw_groups,name,' . $id . ',id',
        ];
    }

    public static function names()
    {
        return [
            'name' => 'Nome',
        ];
    }
}
