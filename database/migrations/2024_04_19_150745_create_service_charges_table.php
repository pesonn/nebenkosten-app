<?php

use App\Models\Invoice;
use App\Models\MeterReader;
use App\Models\Provider;
use App\Models\ServiceType;
use App\Models\Tenant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('service_charges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_id')->constrained();
            $table->foreignId('service_type_id')->constrained();
            $table->dateTime('period_started_at');
            $table->dateTime('period_ended_at');
            $table->float('amount');
            $table->float('total_usage');
            $table->string('usage_unit');
            $table->string('file_path')->nullable();
            $table->dateTime('payed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_charges');
    }
};
