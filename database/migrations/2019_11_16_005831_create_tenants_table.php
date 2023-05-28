<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 64);
            $table->string('plan', 64);
            $table->integer('number_users')->nullable();
            $table->decimal('value_by_user', 15, 2)->nullable();
            $table->decimal('value', 15, 2)->nullable();
            $table->string('recurrent_payment_id')->nullable();
            $table->tinyInteger('active')->default(0);
            $table->timestamps();
        });

        DB::statement('GRANT ALL PRIVILEGES ON tenants TO "user"@"%"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenants');
    }
}
