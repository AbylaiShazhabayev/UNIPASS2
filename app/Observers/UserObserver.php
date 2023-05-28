<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class UserObserver
{
    public function creating(User $user)
    {
        $activeUsersLimit = DB::table('tenants')->where('id', Auth::user()->tenant_id)->first()->active_users_limit;
        $count = DB::table('vw_users')->count();

        // rule 1
        if ($count >= $activeUsersLimit) {
            throw ValidationException::withMessages(['message' => 'Plan user limit reached']);
        }

        // rule 2
        if (!Auth::user()->admin && $user->admin == 1) {
            throw ValidationException::withMessages(['message' => 'You do not have permission to register admin users']);
        }
    }

    public function created(User $user)
    {
        User::sendMailNewUser($user);
    }

    /**
     * rules:
     * 1 - Só administradores podem alterar outros usuários administradores
     * 2 - Caso seja administrador não pode remover a flag admin
     */
    public function updating(User $user)
    {
        // rule 1
        if (!Auth::user()->admin && $user->admin == 1) {
            throw ValidationException::withMessages(['message' => 'You do not have permission to register admin users']);
        }

        // rule 2
        if (Auth::user()->admin && Auth::user()->id == $user->id) {
            unset($user['admin']);
        }

        $user['updated_by'] = Auth::user()->id;
    }

    public function deleting(User $user)
    {
        if (Auth::user()->id == $user->id) {
            throw ValidationException::withMessages(['message' => 'It is not allowed to delete the user himself']);
        }
    }

}
