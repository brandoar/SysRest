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
        Schema::create('productos', function (Blueprint $table) {
            $table->increments('c_prod');
            $table->string('l_prod',50);
            $table->unsignedInteger('c_line')->index();
            $table->string('l_deta')->default('');
            $table->decimal('s_vent',12,7)->default(0);
            $table->longText('l_foto')->default('');
            $table->string('c_indi', 1)->default('');

            $table->string('c_usua',20)->default('');
            $table->string('c_usum',20)->default('');
            $table->dateTime('f_digi')->nullable();
            $table->dateTime('f_modi')->nullable(); 

            $table->foreign(['c_line'],'FK__productos__c_line')->references(['c_line'])->on('lineas');
        });

        \DB::table('productos')->insert([
            [
                'l_prod' => 'POLLO A LA BRASA 1/4',
                'c_line' => 1,
                's_vent' => 15.5,
                'c_usua' => 'ADMIN',
                'c_usum' => 'ADMIN',
                'f_digi' => date('Y-m-d\TH:i:s'),
                'f_modi' => date('Y-m-d\TH:i:s'),
            ],
            [
                'l_prod' => 'INKA KOLA 1L',
                'c_line' => 2,
                's_vent' => 7.5,
                'c_usua' => 'ADMIN',
                'c_usum' => 'ADMIN',
                'f_digi' => date('Y-m-d\TH:i:s'),
                'f_modi' => date('Y-m-d\TH:i:s'),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
};
