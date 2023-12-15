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
        Schema::create('mozos', function (Blueprint $table) {
            $table->increments('c_mozo');
            $table->string('l_mozo',50);
            $table->string('l_clav',4)->unique();
            $table->string('c_usua',20)->default('');
            $table->string('c_usum',20)->default('');
            $table->dateTime('f_digi')->nullable();
            $table->dateTime('f_modi')->nullable(); 
        });

        \DB::table('mozos')->insert(
            [
                'l_mozo' => 'MOZO DE PRUEBA',
                'l_clav' => '12',
                'c_usua' => 'ADMIN',
                'c_usum' => 'ADMIN',
                'f_digi' => date('Y-m-d\TH:i:s'),
                'f_modi' => date('Y-m-d\TH:i:s'),
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mozos');
    }
};
