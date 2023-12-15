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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->string('n_seri',4);
            $table->string('n_comp',10);
            $table->date('f_comp');
            $table->integer('k_mone')->default(0);
            $table->decimal('s_tipc',7,3)->default(1);
            $table->decimal('s_tota',12,7);
            $table->integer('d_anul')->default(0);
            $table->integer('q_pago')->default(0);
            $table->unsignedInteger('c_mozo')->index();
            $table->unsignedInteger('c_mesa')->index();
            $table->unsignedInteger('c_ubic')->index();
            $table->integer('c_sucu')->default(0);
            $table->dateTime('f_digi')->nullable();

            $table->primary(['n_seri', 'n_comp']);
            $table->foreign(['c_mozo'],'FK__pedidos__c_mozo')->references(['c_mozo'])->on('mozos');
            $table->foreign(['c_mesa'],'FK__pedidos__c_mesa')->references(['c_mesa'])->on('mesas');
            $table->foreign(['c_ubic'],'FK__pedidos__c_ubic')->references(['c_ubic'])->on('ubicacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
};
