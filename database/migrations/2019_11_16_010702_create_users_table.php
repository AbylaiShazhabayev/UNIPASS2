<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    private $set_schema_table = 'users';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->unsignedInteger('tenant_id');
            $table->increments('id');
            $table->string('name', 64);
            $table->string('email', 64);
            $table->string('password', 64);
            $table->tinyInteger('admin')->default('0');
            $table->tinyInteger('active')->default('0');
            $table->rememberToken();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();

            $table->index(["tenant_id"]);
            $table->unique(["email"]);
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });

        DB::statement('GRANT ALL PRIVILEGES ON ' . $this->set_schema_table . ' TO "user"@"%"');

        DB::statement('CREATE VIEW vw_' . $this->set_schema_table . ' AS SELECT * FROM ' . $this->set_schema_table . ' WHERE tenant_id = getTenant()');

        DB::unprepared('CREATE TRIGGER trix_' . $this->set_schema_table . ' BEFORE INSERT ON ' . $this->set_schema_table . '
            FOR EACH ROW
            BEGIN
                SET NEW.tenant_id=(SELECT getTenant());
            END');

        DB::statement('GRANT ALL PRIVILEGES ON vw_' . $this->set_schema_table . ' TO "user"@"%"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->set_schema_table);
        DB::statement('DROP VIEW vw_' . $this->set_schema_table);
    }
}
