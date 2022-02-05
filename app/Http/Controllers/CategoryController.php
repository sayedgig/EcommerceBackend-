<?php

namespace App\Http\Controllers;


use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    function destroy($id){
        $category = Category::find($id);
        if($category){
            $category->delete();
            return response()->json([
                'status'=>200,
                'message'=>'category deleted sucessfully'
            ]);
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'no category is found'
                ]);   
            }

    }

    function update(Request $request , $id){

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required',
            'meta_title' => 'required',
        ]);
    
        if ($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages(),
            ]);
        }
        else{
            $category                    =  Category::find($id);
            if($category ){
            $category->slug              = $request->input('slug');
            $category->name              = $request->input('name');
            $category->description        = $request->input('description');
            $category->status            = $request->input('status');
            $category->meta_title        = $request->input('meta_title');
            $category->meta_description  = $request->input('meta_description');
            $category->meta_keyword      = $request->input('meta_keyword');
            $category->save();
            return response()->json([
                'status'=>200,
                'message'=>'category added sucessfully'
            ]);
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'no category is found'
                ]);   
            }
        }
    }


    function edit($id){
        $category = Category::find($id);

        if($category) {
            return response()->json([
                'status'=>200,
                'category'=>$category,
            ]);
        }else{
            return response()->json([
                'status'=>400,
                'message'=>'category id is not been found',
            ]);

        }
    }
        


    


    function index(){
        $category = Category::all();
      
        return response()->json([
            'status'=>200,
            'category'=>$category,
        ]);


    }
    

    function store(Request $request){

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required',
            'meta_title' => 'required',
        ]);
    
        if ($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }
        else{
            $category                    = new Category;
            $category->slug              = $request->input('slug');
            $category->name              = $request->input('name');
            $category->description        = $request->input('description');
            $category->status            = $request->input('status');
            $category->meta_title        = $request->input('meta_title');
            $category->meta_description  = $request->input('meta_description');
            $category->meta_keyword      = $request->input('meta_keyword');
            $category->save();
            return response()->json([
                'status'=>200,
                'message'=>'category added sucessfully'
            ]);
        }

        


    }

    
    
}
