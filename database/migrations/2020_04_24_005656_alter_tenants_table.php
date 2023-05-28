<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AlterTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tenants', function ($table) {
            $table->dropColumn('plan');
            $table->dropColumn('number_users');
            $table->dropColumn('value_by_user');
            $table->dropColumn('value');

            $table->decimal('price', 15, 2)->nullable()->after('name');
            $table->smallInteger('invoice_period')->unsigned()->default(0)->after('price');
            $table->string('invoice_interval')->default('month')->after('invoice_period');
            $table->dateTime('trial_ends_at')->nullable()->after('invoice_interval');
            $table->dateTime('starts_at')->nullable()->after('trial_ends_at');
            $table->dateTime('ends_at')->nullable()->after('starts_at');
            $table->dateTime('cancels_at')->nullable()->after('ends_at');
            $table->dateTime('canceled_at')->nullable()->after('cancels_at');
            $table->integer('active_users_limit')->unsigned()->nullable()->after('canceled_at');
        });
    }
}
