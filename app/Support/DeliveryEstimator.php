<?php

namespace App\Support;

class DeliveryEstimator
{
    public static function estimate(float $destinationLat, float $destinationLng): array
    {
        $storeLat = (float) env('STORE_LATITUDE', 0.3476);
        $storeLng = (float) env('STORE_LONGITUDE', 32.5825);
        $distanceKm = self::distanceKm($storeLat, $storeLng, $destinationLat, $destinationLng);
        $averageSpeedKmh = max((float) env('BODA_AVERAGE_SPEED_KMH', 28), 1);
        $durationMinutes = max(10, (int) ceil(($distanceKm / $averageSpeedKmh) * 60));
        $baseFare = (float) env('BODA_BASE_FARE_UGX', 2500);
        $perKm = (float) env('BODA_PER_KM_UGX', 900);
        $perMinute = (float) env('BODA_PER_MINUTE_UGX', 80);
        $surge = (float) env('BODA_SURGE_MULTIPLIER', 1);
        $fee = ($baseFare + ($distanceKm * $perKm) + ($durationMinutes * $perMinute)) * $surge;

        return [
            'distance_km' => round($distanceKm, 2),
            'duration_minutes' => $durationMinutes,
            'fee' => (int) ceil($fee / 100) * 100,
            'one_hour_delivery' => $durationMinutes <= 60,
        ];
    }

    private static function distanceKm(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $earthRadiusKm = 6371;
        $latDelta = deg2rad($lat2 - $lat1);
        $lngDelta = deg2rad($lng2 - $lng1);
        $a = sin($latDelta / 2) ** 2
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($lngDelta / 2) ** 2;

        return $earthRadiusKm * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }
}
