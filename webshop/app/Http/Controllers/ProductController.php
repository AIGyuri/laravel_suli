<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $webshop = Product::with('category')-> get();
        return response()->json($webshop, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
            request ()-> validate([
                
                'name' => 'required',
                'stock' => 'required',
                'price' => 'required',
                'categoryId' => 'required| exists:categories,id',
            ]);
            $product = Product::create($request->all());
            return response()->json($product, 201);
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //

        $product = Product::with('category')->find($id);
        return response()->json($product, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        request ()-> validate([
            'categoryId' => 'exists:categories,id',
        ]);

        $product = Product::find($id);
        if (!$product) {
            
            return response()->json(['message' => 'Product not found'], 404);
        }
        $product->update($request->all());
        return response()->json($product, 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
