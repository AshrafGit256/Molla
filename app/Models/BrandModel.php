<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandModel extends Model
{
    use HasFactory;

    protected $table = 'brand';

    public static function getSingle($id)
    {
        return Self::find($id);
    }

    public static function getRecord()
    {
        return self::select('brand.*', 'users.name as created_by_name')
                    ->join('users', 'users.id', '=', 'brand.created_by')
                    ->where('brand.is_delete', '=', 0)
                    ->orderBy('brand.id', 'desc')
                    ->get();
    }

    public static function getRecordActive()
    {
        return self::select('brand.*')
                    ->join('users', 'users.id', '=', 'brand.created_by')
                    ->where('brand.is_delete', '=', 0)
                    ->where('brand.status', '=', 0)
                    ->orderBy('brand.name', 'asc')
                    ->get();
    }

    public static function getAvailableForProducts($category_id = null, $subcategory_id = null, $search = '')
    {
        $query = self::select('brand.*')
                    ->join('product', 'product.brand_id', '=', 'brand.id')
                    ->where('brand.is_delete', '=', 0)
                    ->where('brand.status', '=', 0)
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

        return $query->groupBy('brand.id')->orderBy('brand.name', 'asc')->get();
    }
    
}
