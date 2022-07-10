<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::orderBy('created_at', 'DESC')->get();
        return response()->json([
            "message" => "house List",
            "data" => $product, 200
        ]);
    }
    public function myProduct()
    {
        $user_id = Auth::guard('user')->user()->id;
        $product = Product::select("*")->where('user_id', $user_id)->get();;
        return response()->json([
            "message" => "house List",
            "data" => $product, 200
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' =>  'required',
            'location' =>  'required',
            'price' =>  'required',
            'category' =>  'required',
            'image' =>  'required',
            'description' =>  'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $user_id = Auth::guard('user')->user()->id;
        $product = Product::create([
            'officesOwner' =>    $user_id,
            'name' =>  $request->name,
            'location' =>  $request->location,
            'price' =>  $request->price,
            'category' => $request->category,
            'image' => $request->image,
            'description' => $request->description,
        ]);
        return response()->json([
            "message" => "product created successfully.", 200
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Product $product)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' =>  'required',
            'location' =>  'required',
            'price' =>  'required',
            'category' =>  'required',
            'image' =>  'required',
            'description' =>  'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $product->name = $input['name'];
        $product->location = $input['location'];
        $product->price = $input['price'];
        $product->category = $input['category'];
        $product->image = $input['image'];
        $product->description = $input['description'];
        $product->save();
        return response()->json([
            "message" => "product updated successfully.",
            "data" => $product,
            200
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $Product = Product::find($id);
        if (is_null($Product)) {
            return $this->sendError('Product not found.');
        }
        $Product->delete();
        return response()->json([
            "success" => true,
            "message" => "Product deleted successfully.",
            "data" => $Product
        ]);
    }
}
