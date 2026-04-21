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
        Schema::create('rendez_vouses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('medecin_id')->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->dateTime('date_heure');
            $table->enum('statut', ['en_attente', 'confirme', 'annule'])->default('en_attente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rendez_vouses');
    }
};
