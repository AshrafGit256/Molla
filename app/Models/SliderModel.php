<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SliderModel extends Model
{
    use HasFactory;

    protected $table = 'slider';

    public static function getSingle($id)
    {
        return Self::find($id);
    }

    public static function getRecord()
    {
        return self::select('slider.*')
                    ->where('slider.is_delete', '=', 0)
                    ->orderBy('slider.id', 'desc')
                    ->paginate(10);
    }

    public static function getRecordActive()
    {
        return self::select('slider.*')
                    ->where('slider.is_delete', '=', 0)
                    ->where('slider.status', '=', 0)
                    ->orderBy('slider.id', 'asc')
                    ->get();
    }

    public function getImage()
    {
        if(!empty($this->image_name) && file_exists(public_path('upload/slider/' .$this->image_name)))
        {
            $path = public_path('upload/slider/' .$this->image_name);
            $timestamp = filemtime($path);
            return url('upload/slider/' .$this->image_name . '?v=' . $timestamp);
        }
        else
        {
            return "";
        }
    }
    
}
