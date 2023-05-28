<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveFavoriteFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('passwords', function($table) {
            $table->dropColumn('favorite');
        });

        Schema::table('passwords_shareds', function($table) {
            $table->dropColumn('favorite');
        });
    }
}
