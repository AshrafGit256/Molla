<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private int $rate = 3800;

    public function up(): void
    {
        $this->convertTableColumns('product', ['price', 'old_price']);
        $this->convertTableColumns('product_size', ['price']);
        $this->convertTableColumns('shipping_charge', ['price']);
        $this->convertAmountDiscounts();
        $this->convertTableColumns('orders', ['discount_amount', 'shipping_amount', 'total_amount']);
        $this->convertTableColumns('orders_item', ['price', 'size_amount', 'total_price']);
    }

    public function down(): void
    {
        $this->convertTableColumns('product', ['price', 'old_price'], true);
        $this->convertTableColumns('product_size', ['price'], true);
        $this->convertTableColumns('shipping_charge', ['price'], true);
        $this->convertAmountDiscounts(true);
        $this->convertTableColumns('orders', ['discount_amount', 'shipping_amount', 'total_amount'], true);
        $this->convertTableColumns('orders_item', ['price', 'size_amount', 'total_price'], true);
    }

    private function convertTableColumns(string $table, array $columns, bool $reverse = false): void
    {
        if (!Schema::hasTable($table)) {
            return;
        }

        foreach ($columns as $column) {
            if (!Schema::hasColumn($table, $column)) {
                continue;
            }

            $max = (float) DB::table($table)->max($column);

            if (!$reverse && $max >= 10000) {
                continue;
            }

            DB::table($table)
                ->whereNotNull($column)
                ->orderBy('id')
                ->chunkById(100, function ($rows) use ($table, $column, $reverse) {
                    foreach ($rows as $row) {
                        $amount = (float) $row->{$column};
                        $converted = $reverse ? $amount / $this->rate : $this->roundUgx($amount * $this->rate);
                        DB::table($table)->where('id', $row->id)->update([$column => $converted]);
                    }
                });
        }
    }

    private function convertAmountDiscounts(bool $reverse = false): void
    {
        if (!Schema::hasTable('discount_code') || !Schema::hasColumn('discount_code', 'percent_amount')) {
            return;
        }

        DB::table('discount_code')
            ->where('type', 'Amount')
            ->orderBy('id')
            ->chunkById(100, function ($rows) use ($reverse) {
                foreach ($rows as $row) {
                    $amount = (float) $row->percent_amount;

                    if (!$reverse && $amount >= 10000) {
                        continue;
                    }

                    $converted = $reverse ? $amount / $this->rate : $this->roundUgx($amount * $this->rate);
                    DB::table('discount_code')->where('id', $row->id)->update(['percent_amount' => $converted]);
                }
            });
    }

    private function roundUgx(float $amount): int
    {
        return (int) round($amount / 100) * 100;
    }
};
