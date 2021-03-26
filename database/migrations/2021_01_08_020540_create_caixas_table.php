<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaixasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashdesk', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->decimal('amount', 10,2)->default(0);
            $table->string('description',255)->nullable();
            $table->string('receipt',100)->nullable();
            $table->enum('type', ['Entrada','Saída'])->default('Entrada');
            
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            
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
        Schema::dropIfExists('cashdesk');
    }
}
