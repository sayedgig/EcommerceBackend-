<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function updatequantity($cart_id,$scope){
        if(auth('sanctum')->check()){
            $user_id = auth('sanctum')->user()->id;
            $cart = Cart::where('user_id',$user_id )->where('id',$cart_id)->first();
            if($cart){
                if ($scope==="dec"){
                    $cart->product_qty -= 1;

                }else  if ($scope==="inc"){
                    $cart->product_qty +=1;

                }
                
                $cart->update();
                return response()->json([
                    'status'=>200,
                    'message'=>'qantity is updated' 
                ]);  
    

            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'cart id not found'
                ]);
            }
           
        }else{
            return response()->json([
                'status'=>401,
                'message'=>'login add to cart'
            ]);
        }
       

    }
    public function viewcart(){
        if(auth('sanctum')->check()){
            $user_id = auth('sanctum')->user()->id;
            $cart = Cart::where('user_id',$user_id )->get();

            return response()->json([
                'status'=>200,
                'cart'=>$cart 
            ]);  

        }else{
            return response()->json([
                'status'=>401,
                'message'=>'login add to cart'
            ]);
        }
       
    }
    public function addtocart(Request $request){

        if(auth('sanctum')->check()){

                    $user_id = auth('sanctum')->user()->id;
                    $product_id=$request->product_id;
                    $product_qty=$request->product_qty;

                    $productCheck = Product::where('id',$product_id)->first();
            
            if($productCheck) {
                 $cart = Cart::where('product_id',$product_id)->where('user_id',$user_id )->exists();
                if($cart){
                    return response()->json([
                        'status'=>409,
                        'message'=> $productCheck->name . ' Already added to cart '
                    ]);  

                }else{
                    $cartItem = new Cart;
                    $cartItem->user_id=$user_id;
                    $cartItem->product_id = $product_id;
                    $cartItem->product_qty = $product_qty;
                    $cartItem->save();
                    return response()->json([
                        'status'=>201,
                        'message'=>' added to cart '
                    ]);  

                }

               

            }else {
                return response()->json([
                    'status'=>404,
                    'message'=>'product not found'
                ]);  

            }
           
        } else{
            return response()->json([
                'status'=>401,
                'message'=>'login add to cart'
            ]);   
        }

        
    }
        
}
