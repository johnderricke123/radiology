<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('test_id')->default(0);
            $table->foreign('test_id')->references('id')->on('tests')->onDelete('cascade');
            $table->text('content');
            $table->string('name');
            $table->string('input_type');
            $table->string('result');
            $table->string('unit');
            $table->string('range');
            $table->text('short_code');
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
        Schema::dropIfExists('exams');
    }
}
