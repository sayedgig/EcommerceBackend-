<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class ProductController extends Controller
{

    
    function index(){
        $item = Product::all();
      
        return response()->json([
            'status'=>200,
            'products'=>$item,
        ]);


    }
    

    function store(Request $request){

        $validator = Validator::make($request->all(),[
            'category_id' => 'required',
            'name' => 'required',
            'slug' => 'required',

            'meta_title' => 'required',

            'selling_price' => 'required',
            'original_price' => 'required',
            'quantity' => 'required',
            'brand' => 'required',

        ]);
    
        if ($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages(),
            ]);
        }
        else{
            $product                    = new Product;
            $product->name              = $request->input('name');
            $product->description        = $request->input('description');
            $product->status            = $request->input('status');
            $product->meta_title        = $request->input('meta_title');
            $product->meta_description  = $request->input('meta_description');
            $product->meta_keyword      = $request->input('meta_keyword');
            $product->slug              = $request->input('slug');
            
            $product->selling_price              = $request->input('selling_price');
            $product->original_price              = $request->input('original_price');
            $product->quantity        = $request->input('quantity');
            $product->brand            = $request->input('brand');
            $product->feature        = $request->input('feature');
            $product->popular  = $request->input('popular');
            $product->status      = $request->input('status');
            $product->category_id              = $request->input('category_id');

            if ($request->hasFile('image')){
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $fileName = time() . '.' . $extension;
                $file->move('upload/product',$fileName);
                $product->image = 'upload/product/' . $fileName;

            }

            $product->save();
            return response()->json([
                'status'=>200,
                'message'=>'product is added sucessfully'
            ]);
        }

    }
}
