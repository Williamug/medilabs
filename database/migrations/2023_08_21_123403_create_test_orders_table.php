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
        Schema::create('test_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('patient_id')->nullable();
            $table->foreignId('visit_id')->nullable();
            // $table->json('lab_service_id')->nullable();
            $table->text('spacemen_id')->nullable();
            $table->foreignId('result_option_id')->nullable();
            $table->string('test_identity')->nullable();
            $table->string('result_status')->nullable();
            $table->text('comment')->nullable();
            $table->date('visit_date')->nullable();
            $table->integer('patient_age')->nullable();
            $table->integer('temperature')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('height')->nullable();
            $table->string('next_of_kin_name')->nullable();
            $table->string('next_of_kin_gender')->nullable();
            $table->string('relation_to_patient')->nullable();
            $table->string('next_of_kin_phone_number')->nullable();
            $table->string('next_of_kin_residence')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_orders');
    }
};
