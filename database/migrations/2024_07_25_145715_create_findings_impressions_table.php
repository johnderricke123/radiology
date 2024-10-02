<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFindingsImpressionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('findings_impressions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('result_id')->default(0);
            $table->string('test')->nullable();
            $table->foreign('result_id')->references('id')->on('results')->onDelete('cascade');
            $table->string('findings')->nullable();
            $table->string('impressions')->nullable();
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
        Schema::dropIfExists('findings_impressions');
    }
}
