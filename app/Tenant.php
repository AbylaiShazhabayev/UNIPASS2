<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Tenant extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'tenants';

    protected $fillable = [
        'name',
        'price',
        'invoice_period',
        'invoice_interval',
        'trial_ends_at',
        'starts_at',
        'ends_at',
        'cancels_at',
        'canceled_at',
        'active_users_limit',
        'recurrent_payment_id',
        'active'
    ];

    protected $hidden = ['password'];

    public static function calculatePrice($activeUsersLimit)
    {
        if ($activeUsersLimit <= 10) {
            return $activeUsersLimit * 3;
        }

        if ($activeUsersLimit <= 25) {
            return $activeUsersLimit * 2.50;
        }

        if ($activeUsersLimit <= 50) {
            return $activeUsersLimit * 2.30;
        }

        return $activeUsersLimit * 1.80;
    }

}
