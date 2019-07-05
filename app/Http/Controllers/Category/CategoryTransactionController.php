<?php

namespace App\Http\Controllers\Category;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        //
        return $transactions=$category->products()->with('transactions')
            ->whereHas('transactions')
            ->get()
            ->pluck('transactions')
            ->collapse();
    }
}
