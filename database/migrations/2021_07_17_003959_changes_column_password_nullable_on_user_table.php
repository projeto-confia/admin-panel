<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangesColumnPasswordNullableOnUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('password', 255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (User::whereNull('password')->exists()) {
                echo 'Não foi possível desfazer a migration ChangesColumnPasswordNullableOnUserTable pois existe usuários sem a coluna password preenchida';
                return;
            };
            $table->string('password')->nullable(false);
        });
    }
}
