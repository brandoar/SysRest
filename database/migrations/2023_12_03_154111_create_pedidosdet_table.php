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
        Schema::create('pedidosdet', function (Blueprint $table) {
            $table->string('n_seri',4);
            $table->string('n_comp',10);
            $table->string('n_item',2);
            $table->unsignedInteger('c_prod')->index();
            $table->decimal('s_vent',12,7);
            $table->decimal('s_cant',12,7);
            $table->string('c_indi',1)->default('');
            $table->integer('q_coci')->default(0);
            $table->integer('d_anul')->default(0);
            $table->string('l_obse', 150)->default('');
            $table->dateTime('f_digi')->nullable();

            $table->primary(['n_seri', 'n_comp', 'n_item']);
            $table->foreign(['n_seri', 'n_comp'],'FK__pedidos__n_seri__n_comp')->references(['n_seri', 'n_comp'])->on('pedidos');
            $table->foreign(['c_prod'],'FK__pedidos__c_prod')->references(['c_prod'])->on('productos');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidosdet');
    }
};
