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
        Schema::create('ventasdet', function (Blueprint $table) {

            $table->string('c_comp',2);
            $table->string('n_seri',4);
            $table->string('n_comp',10);
            $table->string('n_item',2);
            $table->unsignedInteger('c_prod')->index();
            $table->decimal('s_vent',12,7);
            $table->decimal('s_cant',12,7);
            $table->decimal('s_exon',12,7);
            $table->decimal('s_bimp',12,7);
            $table->decimal('s_igv',12,7);
            $table->string('c_indi',1)->default('');
            $table->dateTime('f_digi')->nullable();

            $table->primary(['c_comp', 'n_seri', 'n_comp', 'n_item']);
            $table->foreign(['c_comp', 'n_seri', 'n_comp'],'FK__ventasdet__c_comp__n_seri__n_comp')->references(['c_comp', 'n_seri', 'n_comp'])->on('ventas');
            $table->foreign(['c_prod'],'FK__ventas__c_prod')->references(['c_prod'])->on('productos');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventasdet');
    }
};
