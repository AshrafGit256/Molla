<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('delivery_address')->nullable()->after('shipping_amount');
            $table->decimal('delivery_latitude', 10, 7)->nullable()->after('delivery_address');
            $table->decimal('delivery_longitude', 10, 7)->nullable()->after('delivery_latitude');
            $table->decimal('delivery_distance_km', 8, 2)->nullable()->after('delivery_longitude');
            $table->integer('delivery_duration_minutes')->nullable()->after('delivery_distance_km');
            $table->timestamp('inventory_deducted_at')->nullable()->after('payment_data');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'delivery_address',
                'delivery_latitude',
                'delivery_longitude',
                'delivery_distance_km',
                'delivery_duration_minutes',
                'inventory_deducted_at',
            ]);
        });
    }
};
