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
        Schema::create('ventas', function (Blueprint $table) {
            $table->string('c_comp',2);
            $table->string('n_seri',4);
            $table->string('n_comp',10);
            $table->date('f_comp');
            $table->integer('d_anul')->default(0);
            $table->integer('k_mone')->default(0);
            $table->decimal('s_tipc',7,3)->default(1);
            $table->integer('k_pago');
            $table->decimal('p_igv',3,2);
            $table->decimal('s_exon',12,7);
            $table->decimal('s_bimp',12,7);
            $table->decimal('s_igv',12,7);
            $table->decimal('s_tota',12,7);
            $table->string('n_serip',4)->index();
            $table->string('n_compp',10)->index();
            $table->string('n_docu',11)->index();
            $table->unsignedInteger('c_usua')->index();
            $table->dateTime('f_digi')->nullable();
            $table->integer('c_sucu')->default(0);

            $table->primary(['c_comp', 'n_seri', 'n_comp']);
            $table->foreign(['n_serip', 'n_compp'],'FK__ventas__n_serip__n_compp')->references(['n_seri', 'n_comp'])->on('pedidos');
            $table->foreign(['c_usua'],'FK__ventas__c_usua')->references(['c_usua'])->on('usuarios');
            $table->foreign(['n_docu'],'FK__ventas__n_docu')->references(['n_docu'])->on('agentes');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
};
