<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('result_id')->constrained();
            $table->unsignedBigInteger('question_id')->constrained();

            $table->string('answer')->nullable();
            $table->boolean('is_correct')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('result_id')->references('id')->on('results');
            $table->foreign('question_id')->references('id')->on('questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
}
