<?php

// namespace App\Http\Controllers;

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\LikeController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Author;

use Illuminate\support\Facades\Auth;
use PhpParser\Node\Stmt\Foreach_;

class ProductController extends Controller
{
    // public function like($id)
    // {
    //     $post_id = $id;
    //     $author_id = Auth::user()->id;
    //     // $like= new like();
    //     $author = new Author();
    //     $author->post_id=$post_id;
    //     $author->user_id=$author_id;
    //     $author->like=1;
    //     $author->save();
    //     return

    // }
    public function search(Request $request)
    {
        $name =  $request->name;
        $search =  $request->search;
        if ($name == null) {
            return;
        }
        if ($search == "name" or $search == null) {
            $products = Product::where('name', 'like', '%' . $name . '%')->get();
            return  $products;
        }
        if ($search == "price") {
            $products = Product::where('price', $name)->get();
            return $products;
        }
        if ($search == "cateogry") {
            $products = Product::where('cateogry', $name)->get();
            return $products;
        }
        if ($search == "exp_date") {
            $products = Product::where('exp_date', $name)->get();
            return $products;
        }
    }
    // public function sorting(Request $request)
    // {
    //     $name =  $request->name;
    //     $sort =  $request->sort;
    //     if ($name == null) {
    //         return;
    //     }
    //     if ($sort == "name" or $sort == null) {
    //         $products = Product::orderBy(column: 'price')->get();
    //         return  $products;
    //     }
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::withCount('likes')->get();
        foreach ($products as $product) {
            $product["meLike"] = LikeController::meLike($product['id']);
        }
        return $products;
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
        //validation
        $request->validate([

            "name" => "required|max:50|min:3",
            "price" => "required",
            "image" => "required|url",
            "quantity" => "required|max:250",
            "exp_date" => "required|nullable|date",
            "phone_number" => "required",
            'common_info' => 'required|url',
            'category_id'              => 'required|numeric|exists:categories,id',
            //'authors_id'              => 'required|numeric|exists:authors,id'

        ]);
        // $file_extension = $request->image;
        // $file_name = time(). '.' .$file_extension;
        // $path='images';
        // $request->image->move($path,$file_name);
        //Create product data
        // $image = $request->file('image');
        // if ($request->hasFile('image')) {
        //     $new_name = time() . '.' . $image->getClientOriginalExtension();
        //     $image->move(public_path('/images'), $new_name);
        // }
        $product = new Product();

        $product->author_id = auth()->user()->id;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->common_info = $request->common_info;
        $product->dis_one = $request->dis_one;
        $product->dis_two = $request->dis_two;
        $product->dis_three = $request->dis_three;
        $product->quantity = $request->quantity;
        $product->exp_date = $request->exp_date;
        $product->date_one = $request->date_one;
        $product->date_two = $request->date_two;
        $product->date_three = $request->date_three;
        $product->phone_number = $request->phone_number;
        $product->image =  $request->image;
        if (Carbon::createFromFormat('Y-m-d', $request->exp_date)->subDays($request->date_one) >= Carbon::now()) {
            $price1 = $request->price - ($request->price *  $request->dis_one / 100);
        } elseif (Carbon::createFromFormat('Y-m-d', $request->exp_date)->subDays($request->date_one)  >= Carbon::now()) {
            $price1 = $request->price - ($request->price * $request->dis_two / 100);
        } else  $price1 = $request->price - ($request->price * $request->dis_three / 100);

        $product->category_id = $request->category_id;

        //save
        $product->save();
        //send response
        return $product;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($product_id)
    {
        $author_id = auth()->user()->id;

        if (Product::where([
            "author_id" => $author_id,
            "id" => $product_id
        ])->exists()) {

            $product = Product::where(
                "id",
                $product_id
            )->withCount('likes')->first();
            $product['meLike'] = LikeController::meLike($product_id);

            return $product;
        } else {
            return response()->json([
                "message" => "Author Product doesn't exists"
            ]);
        }
    }
    public function authorProduct()
    {
        $author_id = auth()->user()->id;
        $products = Author::find($author_id)->products;

        return $products;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $product_id)
    {
        //     $request ->validate([

        //     // "name" =>"required|max:50|min:3",
        //     //     "price"=>"required",
        //     //    // "image"=>"required|url",
        //     //     "quantity"=>"required|max:250",
        //     //     "exp_date"=>"required|nullable|date",
        //     //     "phone_number"=>"required",
        //     //     //'categories_id'              => 'required|numeric|exists:categories,id',
        //     //    // 'authors_id'              => 'required|numeric|exists:authors,id'
        //     ]);


        //     $product->name= $request->name;
        //     $product->price= $request->price;
        //     $product->quantity= $request->quantity;
        //     $product->exp_date= $request->exp_date;
        //    // $product->image= $request->image;
        //     $product->phone_number= $request->phone_number;
        //    // $product->category_id = $request->category_id;
        //    $product->save();
        //     return $product;

        $author_id = auth()->user()->id;

        if (Product::where([
            "author_id" => $author_id,
            "id" => $product_id
        ])->exists()) {

            $product = Product::find($product_id);

            //print_r($request->all());die;

            $product->name = isset($request->name) ? $request->name : $product->name;
            $product->price = isset($request->price) ? $request->price : $product->price;
            $product->quantity = isset($request->quantity) ? $request->quantity : $product->quantity;
            $product->exp_date = isset($request->exp_date) ? $request->exp_date : $product->exp_date;
            $product->phone_number = isset($request->phone_number) ? $request->phone_number : $product->phone_number;
            $product->save();

            return $product;
        } else {
            return response()->json([
                "message" => "Author Product doesn't exists"
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($product_id)
    {
        $author_id = auth()->user()->id;

        if (Product::where([
            "author_id" => $author_id,
            "id" => $product_id
        ])->exists()) {

            $product = Product::find($product_id);

            $product->delete();

            return "the product has been deleted";
        } else {
            return response()->json([
                "message" => "Author Product doesn't exists"
            ]);
        }
    }
}
