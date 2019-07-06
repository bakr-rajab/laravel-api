<?php

namespace App\Http\Controllers\Product;

use App\Product;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProductBuyerTransactionController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product, User $buyer, Transaction $transaction)
    {
        //
        $rules = [
            'quantity' => 'required|integer|min:1'
        ];
        $this->validate($request, $rules);

        if ($buyer->id == $product->seller_id) {
//            throw new HttpException('buyer is owner of this product', 422);
            dd($product->seller_id.'seller id = '.$product->seller_id);
        }
//        if (!$buyer->isVerified()) {
////            throw new HttpException('buyer not verified', 422);
//            dd($buyer->isVerified());
//        }
//        if (!$product->seller->isVerified()) {
////            throw new HttpException('product owner not verified', 422);
//                dd($product->seller->isVerified() .'seller not verified');
//        }
        if (!$product->isAvailable()) {
//            throw new \HttpException('product not available', 422);
            dd($product->isAvailable() .'product not available');
        }
        if ($product->quantity < $request->quantity){
            dd('product off');
        }
        return DB::transaction(function () use ($request, $product, $buyer) {
            $product->quantity -= $request->quantity;
            $product->save();
            $transaction = Transaction::create(
                [
                    'quantity' => $request->quantity,
                    'buyer_id' => $buyer->id,
                    'product_id'=>$product->id
                ]
            );
            return response()->json([
                'data'=>$transaction
            ]);
        });

    }

}
