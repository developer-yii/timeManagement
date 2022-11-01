<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsCompletedToStudentTimeLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_time_log', function (Blueprint $table) {
            $table->tinyInteger('is_completed')->default('0')->after('is_attendance');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_time_log', function (Blueprint $table) {
            $table->dropColumn('is_completed');
        });
    }
}
