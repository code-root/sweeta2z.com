<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{

    public function index(){
        return view('dashboard.country.index')->with('country',Country::get());
    }


    public function edit($id){
        // return Category::with(['image'])->get();
        return view('dashboard.country.edit')->with('country',Country::where('id',$id)->first());
    }

    public function create(){
        return view('dashboard.country.create');
    }

    public function show($id)
    {
        $country = Country::find($id);
        return response()->json($country);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string',
        ]);
        if (!Country::where('name' , $request->input('name'))->exists()) {
            $country = new Country($request->all());
            $country->save();
            $token =  $country->id;
        }else {
            $token = Country::select('id')->where('name' , $request->input('name'))->first()['id'];
        }
        return $token;
    }

    public function update(Request $request, $id)
    {
        $country = Country::find($id);
        $country->update($request->all());
        return response()->json($country, 200);
    }

    public function destroy($id)
    {
        $country = Country::find($id);
        $country->delete();
        return response()->json(null, 204);
    }
}
