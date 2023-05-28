<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFolderFieldInPasswordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('passwords', function (Blueprint $table) {
            $table->unsignedInteger('folder_id')->nullable()->after('name');
        });

        DB::statement('DROP VIEW vw_passwords');
        DB::statement('CREATE VIEW vw_passwords AS SELECT * FROM passwords WHERE tenant_id = getTenant()');
    }
}
