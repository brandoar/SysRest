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
        Schema::create('ubicacion', function (Blueprint $table) {
            $table->increments('c_ubic');
            $table->string('l_ubic',20);
            $table->unsignedInteger('c_sucu')->index();
            $table->string('c_usua',20)->default('');
            $table->string('c_usum',20)->default('');
            $table->dateTime('f_digi')->nullable();
            $table->dateTime('f_modi')->nullable(); 

            $table->foreign(['c_sucu'],'FK__ubicacion__c_sucu')->references(['c_sucu'])->on('sucursal');
        });

        \DB::table('ubicacion')->insert([
            [
                'l_ubic' => 'SALA PRINCIPAL',
                'c_sucu' => 1,
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
        Schema::dropIfExists('ubicacion');
    }
};
