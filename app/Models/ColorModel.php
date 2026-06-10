<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColorModel extends Model
{
    use HasFactory;

    protected $table = 'color';

    public static function getSingle($id)
    {
        return Self::find($id);
    }

    public static function getRecord()
    {
        return self::select('color.*', 'users.name as created_by_name')
                    ->join('users', 'users.id', '=', 'color.created_by')
                    ->where('color.is_delete', '=', 0)
                    ->orderBy('color.id', 'desc')
                    ->get();
    }

    public static function getRecordActive()
    {
        return self::select('color.*')
                    ->join('users', 'users.id', '=', 'color.created_by')
                    ->where('color.is_delete', '=', 0)
                    ->where('color.status', '=', 0)
                    ->orderBy('color.name', 'asc')
                    ->get();
    }

    public static function getAvailableForProducts($category_id = null, $subcategory_id = null, $search = '')
    {
        $query = self::select('color.*')
                    ->join('product_color', 'product_color.color_id', '=', 'color.id')
                    ->join('product', 'product.id', '=', 'product_color.product_id')
                    ->where('color.is_delete', '=', 0)
                    ->where('color.status', '=', 0)
                    ->where('product.is_delete', '=', 0)
                    ->where('product.status', '=', 0);

        if (!empty($category_id)) {
            $query->where('product.category_id', $category_id);
        }

        if (!empty($subcategory_id)) {
            $query->where('product.sub_category_id', $subcategory_id);
        }

        if (!empty($search)) {
            $query->where('product.title', 'like', '%'.$search.'%');
        }

        return $query->groupBy('color.id')->orderBy('color.name', 'asc')->get();
    }
}
