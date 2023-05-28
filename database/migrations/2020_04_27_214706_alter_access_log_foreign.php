<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAccessLogForeign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('access_log', function (Blueprint $table) {
            $table->dropForeign('access_log_usuario_id_foreign');

            $table->foreign('usuario_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }
}
