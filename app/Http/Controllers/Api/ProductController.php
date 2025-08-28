<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

use App\Models\Product;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Cache::remember('products_all', 300, function () {
            return Product::all();
        });

        return response()->json($products);
    }

    public function show($id)
    {
        $product = Cache::remember("product_{$id}", 300, function () use ($id) {
            return Product::findOrFail($id);
        });

        return response()->json($product);
    }

    public function store(Request $request)
    {
        $product = Product::create($request->only([
            'name','description','price'
        ]));
        Cache::forget('products_all');

        return response()->json($product, 201);
    }
}
