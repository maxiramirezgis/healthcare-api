<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Lightit\Clinic\Domain\Models\Clinic;
use Lightit\Doctor\Domain\Models\Doctor;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clinic_doctor', function (Blueprint $table) {
            $table->foreignId('clinic_id')->constrained('clinics')->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained('doctors')->cascadeOnDelete();
            $table->primary(['clinic_id', 'doctor_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clinic_doctor');
    }
};
