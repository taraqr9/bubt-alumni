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
        Schema::create('information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('reference');
            $table->tinyInteger('intake');
            $table->tinyInteger('shift');
            $table->dateTime('passing_year')->nullable();
            $table->string('university_id')->nullable();
            $table->string('current_job_designation')->nullable();
            $table->string('current_company')->nullable();
            $table->string('lives')->nullable();
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
        Schema::dropIfExists('informations');
    }
};
