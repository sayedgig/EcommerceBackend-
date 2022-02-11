<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class FrontendController extends Controller
{
    
    function category(){
        $category = Category::where('status','0')->get();
      
        return response()->json([
            'status'=>200,
            'category'=>$category,
        ]);
    }

    function product($slug){
        $category = Category::where('status','0')->where('slug',$slug)->first();
        if($category){

            $products = Product::where('status','0')->where('category_id',$category->id)->get();
            if($products){
                return response()->json([
                    'status'=>200,
                    'product_data'=> [
                        'category' => $category,
                        'product' => $products
                    ],
                ]);

            }else {
                return response()->json([
                    'status'=>400,
                    'message'=>'no product availlable',
                ]);

            }
          

        }else{
            return response()->json([
                'status'=>404,
                'message'=>'no categor found',
            ]);

        }
        
    }

    
    function viewProduct($category_slug ,$product_slug ){
        $category = Category::where('status','0')->where('slug',$category_slug )->first();
        if($category){

            $product = Product::where('status','0')->where('slug',$product_slug)->where('category_id',$category->id)->first();
            if($product){
                return response()->json([
                    'status'=>200,
                    'product'=> $product
                ]);

            }else {
                return response()->json([
                    'status'=>400,
                    'message'=>'no product availlable',
                ]);

            }
          

        }else{
            return response()->json([
                'status'=>404,
                'message'=>'no categor found',
            ]);

        }
        
    }



}
