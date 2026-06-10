<?php

namespace App\Support;

class Money
{
    public static function format($amount): string
    {
        return 'UGX '.number_format((float) $amount, 0);
    }
}
