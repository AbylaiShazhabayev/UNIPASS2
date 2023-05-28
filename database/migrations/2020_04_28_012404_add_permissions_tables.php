<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPermissionsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('GRANT ALL PRIVILEGES ON roles TO "user"@"%"');
        DB::statement('GRANT ALL PRIVILEGES ON permissions TO "user"@"%"');
        DB::statement('GRANT ALL PRIVILEGES ON model_has_permissions TO "user"@"%"');
        DB::statement('GRANT ALL PRIVILEGES ON model_has_roles TO "user"@"%"');
        DB::statement('GRANT ALL PRIVILEGES ON role_has_permissions TO "user"@"%"');
    }
}
