<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::select('id', 'name', 'price', 'category', 'image', 'view', 'quantity')
            ->get();
        return response()->json([
            "success" => true,
            "message" => "Product List",
            "data" => $products
        ]);
    }
    public function myProduct()
    {
        $user = Auth::user();
        $products = Product::select('id', 'name', 'price', 'category', 'image', 'view', 'quantity')->where('user_id', '=',  $user->id)
            ->get();
        return response()->json([
            "success" => true,
            "message" => "Product List",
            "data" => $products
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'descirption' => 'required',
            'location' => 'required',
            'category' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $product = new Product();
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('public/Image'), $filename);
            $product['image'] = $filename;
        }
        $product->user_id = $user->id;
        $product->name = $request->name;
        $product->descirption = $request->descirption;
        $product->location = $request->location;
        $product->category = $request->category;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->save();
        return response()->json([
            "success" => true,
            "message" => "Product created successfully.",
            "data" => $product
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => "chake the id.",
                "item" => []
            ]);
        }
        $product = Product::find($request->id);
        if (is_null($product)) {
            return response()->json([
                "success" => false,
                "message" => "Product Not Find.",
                "item" => []
            ]);
        }
        $user = Auth::user();

            $product->view = $product->view + 1;
            $product->save();

        return response()->json([
            "success" => true,
            "message" => "Product retrieved successfully.",
            "item" => $product
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'id' => 'required|numeric',
            'descirption' => 'required',
            'location' => 'required',
            'category' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => "chake the fildes.",
                "data" => []
            ]);
        }

        $product = Product::where('id', '=', $request->id)->first();
        $user = Auth::user();
        if( $product->user_id==$user->id){
            $product->descirption = $input['descirption'];
            $product->location = $input['location'];
            $product->category = $input['category'];
            $product->price = $input['price'];
            $product->quantity = $input['quantity'];
            $product->save();
        }else{
            return response()->json([
                "success" => false,
                "message" => "you don't have permission.",
                "data" => []
            ]);
        }

        return response()->json([
            "success" => true,
            "message" => "Product updated successfully.",
            "data" => $product
        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        DB::beginTransaction();
        $product = Product::find($request->id);
        // $image_path = "C:\Users\hornet\github\Product_app_backend\public\public\Image\\" + $product->image;
        // if (File::exists($image_path)) {
        //     File::delete($image_path);
        // }
        unlink("public/Image/" . $product->image);
        $product->delete();
        DB::commit();
        return response()->json([
            "success" => true,
            "message" => "Product deleted successfully.",
            "data" => []
        ]);
    }
}
