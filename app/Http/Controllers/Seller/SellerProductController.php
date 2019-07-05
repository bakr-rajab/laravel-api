<?php

namespace App\Http\Controllers\Seller;

use App\Product;
use App\Seller;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SellerProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $products = $seller->products;

        return response()->json(
            [
                'data' => $products
            ]
        );

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $seller)
    {
        $roles = [
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer|min:1',
            'image' => 'required|image',
        ];
        $this->validate($request, $roles);

        $data = $request->all();
        $data['status'] = Product::UNAVAILABLE_PRODUCT;
        $data['image'] = '1.jpg';
        $data['seller_id'] = $seller->id;

        $product = Product::create($data);

        return response()->json([
            'data' => $product
        ]);


        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Seller $seller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seller $seller, Product $product)
    {

        $rules = [
            'quantity' => 'integer|min:1',
            'image' => 'image',
            'status' => 'in' . Product::UNAVAILABLE_PRODUCT . ',' . Product::AVAILABLE_PRODUCT,
        ];
        $this->validate($request, $rules);
        $this->checkSeller($seller, $product);

//        $product=$request->all();
        $product->name=$product->name;//???
        $product->description=$request->description;
        $product->quantity=$request->quantity;

        if ($request->has('status')){
            $product->status=$request->status;

            if($product->isAvailable() && $product->categories()->count() === 0){
                return 'error product must have a category';
            }
        }
        if($product->isClean()){
            return 'no change';
        }

        $product->save();
        return response()->json([
            'data' => $product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Seller $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller,Product $product)
    {
        $this->checkSeller($seller,$product);
        $product->delete();
        return response()->json([
           'data'=>$product
        ]);
        //
    }

    public function checkSeller(Seller $seller, Product $product)
    {
        if ($seller->id != $product->seller_id) {
            throw new HttpException(422, 'the specified seller is not actual seller of product ');
        }
    }
}
