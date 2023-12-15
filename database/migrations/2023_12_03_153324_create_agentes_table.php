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
        Schema::create('agentes', function (Blueprint $table) {
            $table->string('n_docu',11)->unique();
            $table->string('l_agen',100);
            $table->string('l_dire',150)->default('');
            $table->string('n_celu',15)->default('');
            $table->string('l_mail',100)->default('');

            $table->string('c_usua',20)->default('');
            $table->string('c_usum',20)->default('');
            $table->dateTime('f_digi')->nullable();
            $table->dateTime('f_modi')->nullable(); 
        });

        \DB::table('agentes')->insert([
            [
                'n_docu' => '100',
                'l_agen' => 'VENTAS VARIAS',
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
        Schema::dropIfExists('agentes');
    }
};
