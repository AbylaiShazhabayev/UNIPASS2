<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswordsTable extends Migration
{
    private $set_schema_table = 'passwords';

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
            $table->tinyInteger('type');
            $table->string('name', 64);
            $table->string('username', 64)->nullable();
            $table->text('password')->nullable();
            $table->string('url')->nullable();
            $table->string('email')->nullable();
            $table->tinyInteger('favorite')->default(0);

            $table->string('api_live_key')->nullable();
            $table->string('api_secret_key')->nullable();

            $table->string('database_server')->nullable();
            $table->string('database_port')->nullable();
            $table->string('database_name')->nullable();
            $table->string('database_alias')->nullable();

            $table->string('ftp_server')->nullable();
            $table->string('ftp_port')->nullable();
            $table->string('ftp_type')->nullable();

            $table->string('mail_type')->nullable();
            $table->string('mail_incoming_server')->nullable();
            $table->integer('mail_incoming_port')->nullable();
            $table->tinyInteger('mail_incoming_protocol')->nullable();
            $table->tinyInteger('mail_incoming_authentication')->nullable();
            $table->string('mail_outgoing_server')->nullable();
            $table->integer('mail_outgoing_port')->nullable();
            $table->tinyInteger('mail_outgoing_protocol')->nullable();
            $table->tinyInteger('mail_outgoing_authentication')->nullable();

            $table->string('license_version')->nullable();
            $table->string('license_key')->nullable();
            $table->string('license_to')->nullable();
            $table->string('license_company')->nullable();

            $table->text('notes')->nullable();
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();

            $table->primary(['tenant_id', 'id']);
            $table->index(['tenant_id']);

            $table->unique(['tenant_id', 'name']);

            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
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
