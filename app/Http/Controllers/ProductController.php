<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(){
        $data = Products::with(['category' , 'image'])->get();
        return view('dashboard.products.index', compact('data'));
    }

    public function edit($id) {

    $categories = Category::all();
    $products = Products::with('image')->where('id',$id)->first();
    $relationship =  Products::select('id' , 'name' ,'rel_id' )->get();
    return view('dashboard.products.edit', compact('products', 'categories' , 'relationship'));

  }

        public function update(Request $request, Products $products) {
            $data = $request->json()->all();
            $products = Products::where('id',$data['id'])->first();
            $products->update($data);
            if (isset($request->productsList)) {
                foreach ($request->productsList as $item) {
                    $c = Products::where('id',$item->id)->first();
                    $c->update(['rel_id'=>$data['id']]);
                }
            }
            return response()->json($products, 200);
        }

    public function create() {
        $fun = new Controller();
        $categories = Category::all();
        $products = Products::select('name','id')->get();
        return view('dashboard.products.create', compact('categories' ,'products'))
        ->with('token_image' , $fun->generateUniqueTokenImage());

    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string',
            'token' => 'required|string',
            'price' => 'required',
            'title' => 'required',
            'description' => 'required|string',
        ]);

        $dd = Products::create($validatedData);
    // Loop through each product
    if (isset($request->productsList)) {
        foreach ($request->productsList as $item) {
            $c = Products::where('id',$item->id)->first();
            $c->update(['rel_id'=>$dd->id]);

        }
    }

        return redirect()->route('products.index')->with('success', 'Products added successfully!');
    }

}
