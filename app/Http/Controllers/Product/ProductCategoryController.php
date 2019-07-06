<?php

namespace App\Http\Controllers\Product;

use App\Category;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        return $product->categories;
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product,Category $category)
    {
        $product->categories()->syncWithoutDetaching([$category->id]);

        return response()->json([
            'data'=>$product->categories
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product,Category $category)
    {
        if (!$product->categories()->find($category->id)){
            throw new \HttpException('category not found ',422);
        }
        $product->categories()->detach([$category->id]);

        return response()->json([
            'data'=>$product->categories
        ]);
    }
}
