<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;


class CheckoutController extends Controller
{
    public function placeorder(Request $request){
        if(auth('sanctum')->check()){

            $validator = Validator::make($request->all(),[
                'firstname' => 'required',
                'lastname' => 'required',
                'phone' => 'required',
                'email' => 'required',
                'address' => 'required',
                'city' => 'required',
                'state' => 'required',
                'zipcode' => 'required',
                
            ]);

            if ($validator->fails()){
                return response()->json([
                    'status'=>422,
                    'errors'=>$validator->messages(),
                ]);
            }else {

                $order = new Order;
                $user_id =  1;//auth('sanctum')->user()->id;

                $order->user_id =$user_id ;
                $order->firstname=$request->firstname;
                $order->lastname=$request->lastname;
                $order->phone=$request->phone;
                $order->email=$request->email;
                $order->address=$request->address;
                $order->city=$request->city;
                $order->state=$request->state;
                $order->zipcode=$request->zipcode;
                $order->save();
                
                $cart = Cart::where('user_id',$user_id )->get();

                $orderItems =[];
                foreach($cart as $item){
                    $orderItems[] = [
                        
                        'product_id' => $item->product_id,
                        'qty' => $item->product_qty,
                        'price' => $item->product->selling_price,
                        
                    ];

            

                     $item->product->update([
                         'quantity' =>$item->product->quantity - $item->product_qty
                     ]);
                    $order->orderitem()->createMany($orderItems);
                    Cart::destroy($cart);
                };


            }
            return response()->json([
                'status'=>200,
                'message'=>'order placed successfully',
'orderItems'=>$orderItems
            ]);   
   
} else{
    return response()->json([
        'status'=>401,
        'message'=>'login add to checkout'
    ]);   
}


}

}
