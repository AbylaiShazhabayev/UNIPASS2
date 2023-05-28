<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class GroupUser extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'vw_groups_users';

    protected $fillable = ['id', 'group_id', 'user_id'];

    public static function rules()
    {
        return [
            'group_id' => 'required',
            'user_id' => 'required',
        ];
    }

    public static function names()
    {
        return [
            'group_id' => 'Grupo',
            'user_id' => 'Usuário',
        ];
    }
}
