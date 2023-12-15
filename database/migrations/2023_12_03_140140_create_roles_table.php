<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('c_role');
            $table->string('l_role',20);

            //$table->primary(['c_role']);
        });

        \DB::table('roles')->insert([
            ['l_role' => 'ADMIN'],
            ['l_role' => 'CAJERO'],
            ['l_role' => 'MEZERO'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
};
