<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::dropIfExists('feedbacks');
		   
        Schema::create('feedbacks', function (Blueprint $table) {
			$table->increments('id');
			$table->text('feedback')->nullable();
			$table->integer('grade')->nullable();
			$table->dateTime('timestamp_received_date');
			$table->string('class_code');
			$table->string('course');
            $table->string('period');

            $table->foreign('course')->references('course_code')->on('courses')->onDelete('cascade');
			
			$table->string('location');
			$table->foreign('location')->references('location_code')->on('locations')->onDelete('cascade');
			
			$table->integer('import')->unsigned();
			$table->foreign('import')->references('id')->on('imports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feedbacks');
    }
}
