<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product', function (Blueprint $table) {
            $table->string('cost_price', 25)->nullable()->after('price');
            $table->integer('bought_at')->nullable()->after('cost_price');
            $table->integer('sold_at')->nullable()->after('bought_at');
        });
    }

    public function down(): void
    {
        Schema::table('product', function (Blueprint $table) {
            $table->dropColumn(['cost_price', 'bought_at', 'sold_at']);
        });
    }
};
