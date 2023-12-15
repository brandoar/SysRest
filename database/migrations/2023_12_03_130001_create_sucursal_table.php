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
        Schema::create('sucursal', function (Blueprint $table) {
            $table->increments('c_sucu');
            $table->string('l_sucu',100);
            $table->string('c_usua',20)->default('');
            $table->string('c_usum',20)->default('');
            $table->dateTime('f_digi')->nullable();
            $table->dateTime('f_modi')->nullable(); 

            //$table->primary(['c_sucu']);
        });

        \DB::table('sucursal')->insert([
            'l_sucu' => 'SUCURSAL PRINCIPAL',
            'c_usua' => 'ADMIN',
            'c_usum' => 'ADMIN',
            'f_digi' => date('Y-m-d\TH:i:s'),
            'f_modi' => date('Y-m-d\TH:i:s'),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sucursal');
    }
};
