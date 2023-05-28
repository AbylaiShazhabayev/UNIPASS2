<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PasswordShared extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'vw_passwords_shareds';

    protected $fillable = [
        'id',
        'password_id',
        'group_id',
        'user_id',
        'can_view',
        'can_edit',
        'can_delete',
        'can_share',
    ];

    protected $hidden = ['tenant_id'];

    public function rules()
    {
        return [
            'password_id' => 'required|int',
            'group_id' => 'sometimes|int',
            'user_id' => 'sometimes|int',
            'can_view' => 'required|in:0,1',
            'can_edit' => 'required|in:0,1',
            'can_delete' => 'required|in:0,1',
            'can_share' => 'required|in:0,1',
        ];
    }

    public function names()
    {
        return [
            'password_id' => 'Senha',
            'group_id' => 'Grupo',
            'user_id' => 'Usuário',
            'can_view' => 'Visualizar',
            'can_edit' => 'Editar',
            'can_delete' => 'Excluir',
            'can_share' => 'Compartilhar',
        ];
    }
}
