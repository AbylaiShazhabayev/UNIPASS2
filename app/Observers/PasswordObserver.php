<?php

namespace App\Observers;

use App\Models\Password;
use Auth;

class PasswordObserver
{
    public function retrieved($password)
    {
        $password->password = decrypt($password->password);
    }

    public function creating(Password $password)
    {
        $password->password = encrypt($password->password);
        $password->created_by = Auth::user()->id;
    }

    public function updating(Password $password)
    {
        $password->password = encrypt($password->password);
        $password->updated_by = Auth::user()->id;
    }
}
