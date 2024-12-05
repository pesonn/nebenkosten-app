<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('meter_reader_service_charges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meter_reader_id')->constrained();
            $table->foreignId('service_charges_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meter_reader_service_charges');
    }
};
