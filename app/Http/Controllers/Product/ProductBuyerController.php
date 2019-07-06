<?php

namespace App\Http\Controllers\Product;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductBuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        return $product->transactions()->whereHas('buyer')
            ->with('buyer')
            ->get()
            ->pluck('buyer')
            ->unique('id')
            ;
    }

}
