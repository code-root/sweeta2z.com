<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    //our_work
    //blog
    //services
    public function index(Request $request){
        // return Category::with(['image'])->get();
        return view('dashboard.categories.index')->with('category',Category::with(['image'])->get());
    }


    public function edit($id){
        // return Category::with(['image'])->get();
        return view('dashboard.categories.edit')->with('category',Category::with(['image'])->where('id',$id)->first());
    }



    public function create(){
        $fun = new Controller();
        return view('dashboard.categories.create')
        ->with('token_image' , $fun->generateUniqueTokenImage());
    }

    public function show($id){
        $category = Category::find($id);
        return response()->json($category);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string',
            // 'cat' => 'required|string',
        ]);
        if (!Category::where('name' , $request->name)->exists()) {
            $category = Category::create([
            'name' => $request->input('name'),
            'title' => $request->input('title'),
            'token' => $request->input('token'),
            'type' => $request->input('type') ?? '',
        ]);
            $token =  $category->id;
        }else {
            $token = Category::select('id')->where('title' , $request->type)->first()['id'];
        }
        return $token;
    }

    public function update(Request $request) {
        $data = $request->json()->all();
      $category = Category::where('id',$data['id']);
      $category->update($data);
      return response()->json($category, 200);
  }

    public function destroy($id) {
        $category = Category::find($id);
        $category->delete();
        return response()->json(null, 204);
    }
}
