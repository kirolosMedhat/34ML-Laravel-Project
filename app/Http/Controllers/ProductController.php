<?php

namespace App\Http\Controllers;

use App\Events\ProductOutOfStock;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('variants.options');
        // -----------------------------------------------
        // Filter by average rating 
        if ($request->has('filter.average_rating')) {
            $query->where('average_rating', $request->input('filter.average_rating'));
        }
        // -----------------------------------------------
        // Filter by options
        // Parse filter options from the URL
        if ($request->filled('filter.options')) {
            $options = explode(',', $request->input('filter.options'));
            $color = null;
            $size = null;

            // Extract color and size from filter options
            foreach ($options as $option) {
                list($key, $value) = explode(':', $option);
                if ($key === 'color') {
                    $color = $value;
                } elseif ($key === 'size') {
                    $size = $value;
                }
            }

            // Query products based on color and size filters
            $query = Product::query();
            if ($color) {
                $query->whereHas('variants.options', function ($query) use ($color) {
                    $query->where('name', 'color')->whereJsonContains('values', [$color]);
                });
            }
            if ($size) {
                $query->whereHas('variants.options', function ($query) use ($size) {
                    $query->where('name', 'size')->whereJsonContains('values', [$size]);
                });
            }

            // Get the filtered products
            $products = $query->get();

            return response()->json($products);
        }


        // -----------------------------------------------
        // Filter by max price
        if ($request->has('filter.max_price')) {
            $maxPrice = (float) $request->input('filter.max_price');
            $query = $query->get();
            // dd($query);
            $query->each(function ($product) use ($maxPrice) {
                $product->load(['variants' => function ($query) use ($maxPrice) {
                    $query->where('price', '<=', $maxPrice);
                }]);
            });
            $products = $query;
            return response()->json($products);
        }
        // -----------------------------------------------
        // Check if there are any out-of-stock products
        $outOfStockProducts = $query->where('is_in_stock', 0)->get();
        if ($outOfStockProducts) {
            foreach ($outOfStockProducts as $product) {
                // dd($product);
                ProductOutOfStock::dispatch($product);
                // dd($product);
            }
        }
        $products = $query->get();
        return response()->json($products);
    }
}
