<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentIconModel extends Model
{
    use HasFactory;

    protected $table = 'payment_icons';

    public function getImage()
    {
        if (!empty($this->image_name) && file_exists(public_path('upload/payment_icons/' . $this->image_name))) {
            $path = public_path('upload/payment_icons/' . $this->image_name);
            $timestamp = filemtime($path);
            return url('upload/payment_icons/' . $this->image_name . '?v=' . $timestamp);
        }

        return '';
    }
}
