<?php

namespace App\Models;

use App\Jobs\SendMail;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'vw_users';

    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'admin',
        'active',
        'created_by',
        'updated_by',
    ];

    protected $hidden = ['tenant_id', 'password', 'remember_token'];

    public static function rules($id = '')
    {
        return [
            'name' => 'required|max:64',
            'email' => 'email|sometimes|required|max:64|unique:users,email,' . $id . ',id',
            'password' => 'max:64',
        ];
    }

    public static function names()
    {
        return [
            'name' => 'Nome',
            'email' => 'E-mail',
            'password' => 'Password',
        ];
    }

    public static function sendMailNewUser($userView)
    {
        DB::table('password_creates')->where('email', $userView->email)->delete();

        $token = sha1(Carbon::now()->toDateTimeString());
        DB::table('password_creates')->insert(
            [
                'email' => $userView->email,
                'token' => $token,
                'created_at' => Carbon::now()->toDateTimeString()
            ]
        );

        SendMail::dispatch([
            'template' => 'emails.convite_sistema',
            'to_name' => $userView->name,
            'to_mail' => $userView->email,
            'title' => 'Convite para utilização do ' . config('app.name'),
            'convidado' => $userView->name,
            'name' => Auth::user()->name,
            'token' => $token
        ]);
    }
}
