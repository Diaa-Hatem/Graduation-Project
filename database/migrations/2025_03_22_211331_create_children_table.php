<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('children', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('birth_date');
            $table->string('image')->nullable();
            $table->enum('gender',['انثي' , 'ذكر']);
            $table->string('report')->nullable();
            $table->integer('total_questions_score')->nullable();
            $table->decimal('ml_result',4,1)->nullable();
            $table->string('final_diagnosis')->nullable();
            $table->double('final_diagnosis_score')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('children');
    }
};
