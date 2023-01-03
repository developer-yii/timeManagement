<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('id_cards', function (Blueprint $table) {
            $table->id();
            $table->integer('id_number')->nullable();
            $table->smallInteger('card_type')->nullable()->comment('1=student; 2=teacher;');
            $table->smallInteger('card_color')->nullable()->comment('1=magenta; 2=blue;');
            $table->string('school_name')->nullable();
            $table->string('school_year')->nullable();
            $table->string('student_grade')->nullable();
            $table->string('student_name')->nullable();
            $table->string('teacher_name')->nullable();
            $table->string('dob')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('city')->nullable();
            $table->string('email')->nullable();
            $table->string('display_photo')->nullable();
            $table->smallInteger('print_free_card')->comment('1=yes; 0=no;')->default(0);
            $table->smallInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('id_cards');
    }
}
