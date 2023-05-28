<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswordFavoritesUnique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('passwords_favorites', function (Blueprint $table) {
            $table->unique(['tenant_id', 'password_id', 'user_id']);
        });
    }
}
