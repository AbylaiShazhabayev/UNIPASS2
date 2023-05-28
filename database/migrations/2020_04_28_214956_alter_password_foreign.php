<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPasswordForeign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('passwords', function (Blueprint $table) {
            $table->dropForeign('passwords_created_by_foreign');

            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::table('passwords_shareds', function (Blueprint $table) {
            $table->dropForeign('passwords_shareds_user_id_foreign');
            $table->dropForeign('passwords_shareds_tenant_id_group_id_foreign');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign(['tenant_id', 'group_id'])
                ->references(['tenant_id', 'id'])
                ->on('groups')
                ->onDelete('cascade');
        });
    }
}
