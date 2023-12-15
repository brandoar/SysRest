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
        Schema::create('empresa', function (Blueprint $table) {
            $table->string('n_ruc',11)->unique();
            $table->string('l_empr', 100)->unique();
            $table->string('l_dire',150)->default('');
            $table->string('n_celu',15)->default('');
            $table->longText('l_logo')->default('');
            $table->string('c_usua',20)->default('');
            $table->string('c_usum',20)->default('');
            $table->dateTime('f_digi')->nullable();
            $table->dateTime('f_modi')->nullable(); 
        });

        \DB::table('empresa')->insert([
            'n_ruc' => '10714759570', 
            'l_empr' => 'SYSREST',
            'c_usua' => 'ADMIN',
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
        Schema::dropIfExists('empresa');
    }
};
