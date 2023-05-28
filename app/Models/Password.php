<?php

namespace App\Models;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use OwenIt\Auditing\Contracts\Auditable;

class Password extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'vw_passwords';

    protected $fillable = [
        'id',
        'name',
        'type',
        'folder_id',
        'username',
        'password',
        'url',
        'email',
        'api_live_key',
        'api_secret_key',
        'database_server',
        'database_port',
        'database_name',
        'database_alias',
        'database_sid',
        'database_options',
        'ftp_server',
        'ftp_port',
        'ftp_type',
        'mail_type',
        'mail_incoming_server',
        'mail_incoming_port',
        'mail_incoming_protocol',
        'mail_incoming_authentication',
        'mail_outgoing_server',
        'mail_outgoing_port',
        'mail_outgoing_protocol',
        'mail_outgoing_authentication',
        'license_version',
        'license_key',
        'license_to',
        'license_company',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected $hidden = ['tenant_id'];

    public static function rules($id = '')
    {
        return [
            'name' => 'required|max:64|unique:vw_passwords,name,' . $id . ',id',
            'type' => 'required',
            'username' => 'max:64',
            'password' => 'max:160',
            'url' => 'max:255',
            'email' => 'max:255',
            'api_live_key' => 'max:255',
            'api_secret_key' => 'max:255',
            'database_server' => 'max:255',
            'database_port' => 'max:255',
            'database_name' => 'max:255',
            'database_alias' => 'max:255',
            'database_sid' => 'max:255',
            'database_options' => 'max:255',
            'ftp_server' => 'max:255',
            'ftp_port' => 'max:255',
            'ftp_type' => 'max:255',
            'mail_type' => 'max:255',
            'mail_incoming_server' => 'max:255',
            'mail_outgoing_server' => 'max:255',
            'license_version' => 'max:255',
            'license_key' => 'max:255',
            'license_to' => 'max:255',
            'license_company' => 'max:255',
            'notes' => 'max:10000',
        ];
    }

    public static function names()
    {
        return [
            'name' => __('fields.name'),
            'type' => __('fields.type'),
            'folder_id' => __('fields.folder'),
            'username' => __('fields.username'),
            'password' => __('fields.password'),
            'url' => __('fields.url'),
            'email' => __('fields.email'),
            'api_live_key' => __('fields.api_key'),
            'api_secret_key' => __('fields.secret_key'),
            'database_server' => __('fields.server'),
            'database_port' => __('fields.port'),
            'database_name' => __('fields.database_name'),
            'database_alias' => __('fields.alias'),
            'database_options' => __('fields.options'),
            'ftp_server' => __('fields.server'),
            'ftp_port' => __('fields.port'),
            'ftp_type' => __('fields.ftp_type'),
            'mail_type' => __('fields.mail_type'),
            'mail_incoming_server' => __('fields.incoming_server'),
            'mail_incoming_port' => __('fields.port'),
            'mail_outgoing_server' => __('fields.outgoing_server'),
            'mail_outgoing_port' => __('fields.port'),
            'license_version' => __('fields.license_version'),
            'license_key' => __('fields.license_key'),
            'license_to' => __('fields.license_to'),
            'license_company' => __('fields.company'),
            'notes' => __('notes'),
        ];
    }

    public static function hasPermissionPassword($password, $operation)
    {
        if ($password->created_by == Auth::user()->id) {
            return true;
        }

        $passwordSharedUser = DB::table('vw_passwords_shareds AS ps')
            ->select([
                'ps.can_view',
                'ps.can_edit',
                'ps.can_delete',
                'ps.can_share'
            ])
            ->where('ps.password_id', $password->id)
            ->where('ps.user_id', Auth::user()->id)
            ->first();

        if ($passwordSharedUser && $passwordSharedUser->{$operation}) {
            return true;
        }

        if (!$passwordSharedUser) {
            $passwordSharedGroup = DB::table('vw_passwords_shareds AS ps')
                ->join('vw_passwords AS p', 'p.id', '=', 'ps.password_id')
                ->join('vw_groups_users AS gu', 'gu.group_id', '=', 'ps.group_id')
                ->select([
                    'ps.can_view',
                    'ps.can_edit',
                    'ps.can_delete',
                    'ps.can_share'
                ])
                ->where('ps.password_id', $password->id)
                ->where('gu.user_id', Auth::user()->id)
                ->first();

            if ($passwordSharedGroup && $passwordSharedGroup->{$operation}) {
                return true;
            }
        }

        throw ValidationException::withMessages(['message' => 'Permission denied']);
    }
}
