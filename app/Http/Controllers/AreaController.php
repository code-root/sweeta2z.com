<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Country;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index() {
        // return 100;
        $areas = Area::with('country')->get();
        return view('dashboard.areas.index', compact('areas'));
    }

    public function create()
    {
        $countries = Country::all();
        return view('dashboard.areas.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'name_en' => 'required',
            'country_id' => 'required|exists:countries,id',
        ]);

        Area::create($data);

        return redirect()->route('areas.index')->with('success', 'تمت إضافة المنطقة بنجاح.');
    }

    public function show(Area $area)
    {
        return view('dashboard.areas.show', compact('area'));
    }

    public function edit(Area $area)
    {
        $countries = Country::all();
        return view('dashboard.areas.edit', compact('area', 'countries'));
    }

    public function update(Request $request, Area $area)
    {
        $data = $request->validate([
            'name' => 'required',
            'name_en' => 'required',
            'country_id' => 'required|exists:countries,id',
        ]);

        $area->update($data);

        return redirect()->route('areas.index')->with('success', 'تم تحديث المنطقة بنجاح.');
    }

    public function destroy(Area $area)
    {
        $area->delete();

        return redirect()->route('areas.index')->with('success', 'تم حذف المنطقة بنجاح.');
    }
}
