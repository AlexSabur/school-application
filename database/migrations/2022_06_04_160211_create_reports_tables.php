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
        Schema::create('violations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->timestamp('closed_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('records', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('message')->nullable();
            $table->foreignUuid('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignUuid('classroom_id')->constrained('classrooms')->cascadeOnDelete();
            $table->foreignUuid('violation_id')->constrained('violations')->cascadeOnDelete();
            $table->foreignUuid('report_id')->constrained('reports')->cascadeOnDelete();
            $table->softDeletes();
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
        Schema::dropIfExists('records');
        Schema::dropIfExists('reports');
        Schema::dropIfExists('violations');
    }
};
