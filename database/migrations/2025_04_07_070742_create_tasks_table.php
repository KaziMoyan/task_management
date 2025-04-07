<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('tasks', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('assign_by_id'); // Admin assigning the task
        $table->unsignedBigInteger('user_id');      // User receiving the task
        $table->string('name');
        $table->string('short_description')->nullable();
        $table->text('description')->nullable();
        $table->text('note')->nullable();
        $table->string('link')->nullable();
        $table->integer('minutes')->nullable();
        $table->date('date')->nullable();
        $table->time('time_start')->nullable();
        $table->time('time_end')->nullable();
        $table->timestamp('submit_at')->nullable();
        $table->string('status')->default('pending');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
