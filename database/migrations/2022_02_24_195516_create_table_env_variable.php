<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableEnvVariable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('env_variable', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->string('description', 5000);
            $table->string('type', 255);
            $table->string('default_value', 5000);
            $table->string('value', 5000);
            $table->boolean('updated')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('env_variable');
    }
}
