<?php

use App\Models\ServiceCharges;
use App\Models\Tenant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('location_service_charges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained();
            $table->foreignId('service_charges_id')->constrained();
            $table->integer('proportional')->nullable();
            $table->string('proportional_unit')->nullable();
            $table->integer('amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_service_charges');
    }
};
