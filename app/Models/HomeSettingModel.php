<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSettingModel extends Model
{
    use HasFactory;

    protected $table = 'home_setting';

    public static function getSingle()
    {
        return self::find(1);
    }

    public function getPaymentImage()
    {
        if(!empty($this->payment_delivery_image) && file_exists(public_path('upload/setting/' .$this->payment_delivery_image)))
        {
            $path = public_path('upload/setting/' .$this->payment_delivery_image);
            $timestamp = filemtime($path);
            return url('upload/setting/' .$this->payment_delivery_image . '?v=' . $timestamp);
        }
        else
        {
            return "";
        }
    }

    public function getRefundImage()
    {
        if(!empty($this->refund_image) && file_exists(public_path('upload/setting/' .$this->refund_image)))
        {
            $path = public_path('upload/setting/' .$this->refund_image);
            $timestamp = filemtime($path);
            return url('upload/setting/' .$this->refund_image . '?v=' . $timestamp);
        }
        else
        {
            return "";
        }
    }

    public function getSupportImage()
    {
        if(!empty($this->support_image) && file_exists(public_path('upload/setting/' .$this->support_image)))
        {
            $path = public_path('upload/setting/' .$this->support_image);
            $timestamp = filemtime($path);
            return url('upload/setting/' .$this->support_image . '?v=' . $timestamp);
        }
        else
        {
            return "";
        }
    }

    public function getSignupImage()
    {
        if(!empty($this->signup_image) && file_exists(public_path('upload/setting/' .$this->signup_image)))
        {
            $path = public_path('upload/setting/' .$this->signup_image);
            $timestamp = filemtime($path);
            return url('upload/setting/' .$this->signup_image . '?v=' . $timestamp);
        }
        else
        {
            return "";
        }
    }
}
