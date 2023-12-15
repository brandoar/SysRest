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
        Schema::create('mesas', function (Blueprint $table) {
            $table->increments('c_mesa');
            $table->string('l_mesa',20);
            $table->integer('n_sill')->default(0);
            $table->boolean('q_ocup')->default(0);
            $table->unsignedInteger('c_ubic')->index();
            $table->string('c_usua',20)->default('');
            $table->string('c_usum',20)->default('');
            $table->dateTime('f_digi')->nullable();
            $table->dateTime('f_modi')->nullable(); 

            $table->foreign(['c_ubic'],'FK__mesas__c_ubic')->references(['c_ubic'])->on('ubicacion');
        });

        \DB::table('mesas')->insert(
            [
                'l_mesa' => 'MESA 1',
                'c_ubic' => 1,
                'c_usua' => 'ADMIN',
                'c_usum' => 'ADMIN',
                'f_digi' => date('Y-m-d\TH:i:s'),
                'f_modi' => date('Y-m-d\TH:i:s'),
            ],
            [
                'l_mesa' => 'MESA 2',
                'c_ubic' => 1,
                'c_usua' => 'ADMIN',
                'c_usum' => 'ADMIN',
                'f_digi' => date('Y-m-d\TH:i:s'),
                'f_modi' => date('Y-m-d\TH:i:s'),
            ],
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mesas');
    }
};
