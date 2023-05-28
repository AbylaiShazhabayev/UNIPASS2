<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RefreshPasswordsViews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('DROP VIEW vw_passwords');
        DB::statement('CREATE VIEW vw_passwords AS SELECT * FROM passwords WHERE tenant_id = getTenant()');

        DB::statement('DROP VIEW vw_passwords_shareds');
        DB::statement('CREATE VIEW vw_passwords_shareds AS SELECT * FROM passwords_shareds WHERE tenant_id = getTenant()');
    }
}
