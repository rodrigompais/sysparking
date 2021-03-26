<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->datetime('acceso');
            $table->string('hours')->nullable();
            $table->datetime('departure')->nullable();

            $table->string('plate',25)->nullable();
            $table->string('model',12)->nullable();
            $table->string('color',15)->nullable();
            $table->string('brand',18)->nullable();
            $table->string('nota',18)->nullable();

            $table->enum('keys', ['Sim','Não'])->default('Não');
            $table->decimal('total',10,2)->nullable();
            $table->decimal('money',10,2)->nullable();
            $table->decimal('change',10,2)->nullable();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('carrier_id')->nullable();
            $table->foreign('carrier_id')->references('id')->on('carriers');

            $table->unsignedBigInteger('tarifa_id')->nullable();
            $table->foreign('tarifa_id')->references('id')->on('tarifas');

            $table->unsignedBigInteger('vacancy_id')->nullable();
            $table->foreign('vacancy_id')->references('id')->on('vacancies');

            $table->string('bar_code',25)->nullable();
            $table->string('description',255)->nullable();
            $table->enum('status', ['Aberto','Fechado'])->default('Aberto');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
