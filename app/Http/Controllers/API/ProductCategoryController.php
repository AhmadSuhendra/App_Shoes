<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class ProductCategoryController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit');
        $name = $request->input('name');
        $show_product = $request->input('show_product');

        if ($id) {
            // modal product
            $category = ProductCategory::with(['product',])->find($id);
            if ($category) {
                return ResponseFormatter::success(
                    $category,
                    'Data Category Berhasil Diambil'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data Category Tidak Ada',
                    404
                );
            }
        }

        $category = ProductCategory::query();

        if ($category) {
            $category->where('name', 'like', '%' . $name . '%');
        }

        if ($show_product) {
            $category->with('products');
        }

        return ResponseFormatter::success(
            $category->paginate($limit),
            'Data List Category Berhasil Diambil'
        );
    }
}
