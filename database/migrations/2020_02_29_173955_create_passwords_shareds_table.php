<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswordsSharedsTable extends Migration
{
    private $set_schema_table = 'passwords_shareds';

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
            $table->unsignedInteger('group_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->tinyInteger('favorite')->default(0);
            $table->tinyInteger('can_view');
            $table->tinyInteger('can_edit');
            $table->tinyInteger('can_delete');
            $table->tinyInteger('can_share');
            $table->timestamps();

            $table->primary(['tenant_id', 'id']);
            $table->index(['tenant_id']);

            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign(['tenant_id', 'password_id'])->references(['tenant_id', 'id'])->on('passwords');
            $table->foreign(['tenant_id', 'group_id'])->references(['tenant_id', 'id'])->on('groups');
            $table->foreign('user_id')->references('id')->on('users');
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
