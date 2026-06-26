<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSettingModel extends Model
{
    use HasFactory;

    protected $table = 'system_setting';

    public static function getSingle()
    {
        return self::find(1);
    }

    public function getLogo()
    {
        if(!empty($this->logo) && file_exists(public_path('upload/setting/' .$this->logo)))
        {
            $path = public_path('upload/setting/' .$this->logo);
            $timestamp = filemtime($path);
            return url('upload/setting/' .$this->logo . '?v=' . $timestamp);
        }
        else
        {
            return "";
        }
    }

    public function getFavicon()
    {
        if(!empty($this->favicon) && file_exists(public_path('upload/setting/' .$this->favicon)))
        {
            $path = public_path('upload/setting/' .$this->favicon);
            $timestamp = filemtime($path);
            return url('upload/setting/' .$this->favicon . '?v=' . $timestamp);
        }
        else
        {
            return "";
        }
    }

    public function getFooterPaymentIcon()
    {
        if(!empty($this->footer_payment_icon) && file_exists(public_path('upload/setting/' .$this->footer_payment_icon)))
        {
            $path = public_path('upload/setting/' .$this->footer_payment_icon);
            $timestamp = filemtime($path);
            return url('upload/setting/' .$this->footer_payment_icon . '?v=' . $timestamp);
        }
        else
        {
            return "";
        }
    }
}
