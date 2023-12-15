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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('c_usua');
            $table->string('l_usua',20)->unique();
            $table->unsignedInteger('c_role')->index();
            $table->string('l_pass',100);
            $table->string('n_docu',8);
            $table->string('l_nomb', 90);
            $table->string('l_mail', 80)->default('');
            $table->string('n_celu', 50)->default('');
            $table->longText('l_foto')->default('');
            $table->string('c_comp1', 2)->default('');
            $table->string('n_seri1', 4)->default('');
            $table->string('c_comp2', 2)->default('');
            $table->string('n_seri2', 4)->default('');
            $table->integer('c_sucu')->default(0);
            $table->dateTime('f_ingr')->nullable();
            $table->dateTime('f_digi')->nullable();
            $table->dateTime('f_modi')->nullable(); 

            $table->foreign(['c_role'],'FK__usuarios__c_role')->references(['c_role'])->on('roles');
        });

        \DB::table('usuarios')->insert([
            [
                'l_usua' => 'ADMIN',
                'c_role' => 1,
                'l_pass' => 'ADMIN',
                'n_docu' => '',
                'l_nomb' => '',
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
        Schema::dropIfExists('usuarios');
    }
};
