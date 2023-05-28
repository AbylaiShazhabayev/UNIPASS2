<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPasswordSharedForeign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('passwords_shareds', function (Blueprint $table) {
            $table->dropForeign('passwords_shareds_tenant_id_password_id_foreign');

            $table->foreign(['tenant_id', 'password_id'])
                ->references(['tenant_id', 'id'])
                ->on('passwords')
                ->onDelete('cascade');
        });
    }
}
