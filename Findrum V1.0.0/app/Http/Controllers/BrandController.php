<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (isSet($_GET['name'])) {
            $arrName = (explode(" ", $_GET['name']));

            switch (sizeof($arrName)) {
                case 0:
                    return Brand::all();
                case 1:
                    return Brand::where('name', 'like', "%". $arrName[0]. "%")
                        ->orWhere('name', $arrName[0])->get();
                default:
                    return Brand::where('name', 'like', "%". $arrName[0]. "%")
                        ->orWhere('name', $arrName[0])
                        ->orWhere('name', $arrName[1])->get();
            }
        }

        return Brand::all()->load('components');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return Brand::create($request->validate([
            'name' => 'required|max:100',
        ]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        return $brand->load('components');
    }

    /**
     * Display the components related to the specified resource.
     */
    public function components(Brand $brand)
    {
        return $brand->components;
    }
    
    /**
     * Remove an existing components from an existing brand.
     */
    public function removeComponents(Component $component, Brand $brand)
    {
        return $brand->brand()->dissociate($brand);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $brand->update($request->validate([
            'name' => 'required|max:100',
        ]));
        return $brand->load('components');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        return $brand->delete();
    }
}
