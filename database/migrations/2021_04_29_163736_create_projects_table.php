<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            //$table->timestamps();
            //relationship 1:N with students
            $table->unsignedbigInteger('student');
            $table->foreign('student')
                ->references('registration_number_s')
                ->on('students')
                ->onDelete('cascade');
            //relationship 1:N with courses
            $table->unsignedbigInteger('course');
            $table->foreign('course')
                ->references('id')
                ->on('courses')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
