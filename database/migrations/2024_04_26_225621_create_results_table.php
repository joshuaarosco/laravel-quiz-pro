<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('quiz_id')->constrained();
            $table->unsignedBigInteger('user_id')->constrained();

            $table->string('status')->default('pending')->nullable();
            $table->integer('score')->default(0)->nullable();
            $table->integer('minute')->default(0)->nullable();
            $table->integer('seconds')->default(0)->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('quiz_id')->references('id')->on('quizzes');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('results');
    }
}
