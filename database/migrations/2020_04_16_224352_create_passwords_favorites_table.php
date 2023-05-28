<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswordsFavoritesTable extends Migration
{
    private $set_schema_table = 'passwords_favorites';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->unsignedInteger('tenant_id');
            $table->unsignedInteger('id');
            $table->unsignedInteger('password_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->primary(['tenant_id', 'id']);
            $table->index(['tenant_id']);

            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign(['tenant_id', 'password_id'])->references(['tenant_id', 'id'])->on('passwords')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });

        DB::statement('CREATE VIEW vw_' . $this->set_schema_table . ' AS SELECT * FROM ' . $this->set_schema_table . ' WHERE tenant_id = getTenant()');

        DB::unprepared('CREATE TRIGGER trix_' . $this->set_schema_table . ' BEFORE INSERT ON ' . $this->set_schema_table . '
            FOR EACH ROW
            BEGIN
                SET NEW.tenant_id=(SELECT getTenant());
                SET NEW.id=(select IFNULL(max(id)+1,1) from ' . $this->set_schema_table . ' where tenant_id=NEW.tenant_id);
                SET @lastInsertId_' . $this->set_schema_table . '=NEW.id;
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
