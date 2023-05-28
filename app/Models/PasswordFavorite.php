<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PasswordFavorite extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'vw_passwords_favorites';

    protected $fillable = [
        'id',
        'password_id',
        'user_id',
    ];

    protected $hidden = ['tenant_id'];

    public function rules()
    {
        return [
            'password_id' => 'required|int',
            'user_id' => 'sometimes|int',
        ];
    }

    public function names()
    {
        return [
            'password_id' => 'Senha',
            'user_id' => 'Usuário',
        ];
    }
}
