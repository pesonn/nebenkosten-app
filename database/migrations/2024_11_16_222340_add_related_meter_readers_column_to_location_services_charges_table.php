<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelatedMeterReadersColumnToLocationServicesChargesTable extends Migration
{
    public function up(): void
    {
        Schema::table('location_service_charges', function (Blueprint $table) {
            $table->json('related_meter_readers')->after('service_charges_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('location_service_charges', function (Blueprint $table) {
            $table->dropColumn('related_meter_readers');
        });
    }
}
