<?php

use App\Models\Location;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('meter_readers', function (Blueprint $table) {
            $table->id();
            $table->string('meter_number');
            $table->text('description')->nullable();
            $table->foreignId('location_id')->constrained();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meter_readers');
    }
};
