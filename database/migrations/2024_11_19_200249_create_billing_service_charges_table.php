<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingServiceChargesTable extends Migration
{
    public function up(): void
    {
        Schema::create('billing_service_charges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('billing_id')->constrained();
            $table->foreignId('service_charges_id')->constrained();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('billing_service_charges');
    }
}
