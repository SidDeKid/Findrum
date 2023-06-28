<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Component;
use App\Models\Drummer;
use Illuminate\Http\Request;

class ComponentController extends Controller
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
                    return Component::all();
                case 1:
                    return Component::where('name', 'like', "%". $arrName[0]. "%")
                        ->orWhere('name', $arrName[0])->get();
                default:
                    return Component::where('name', 'like', "%". $arrName[0]. "%")
                        ->orWhere('name', $arrName[0])
                        ->orWhere('name', $arrName[1])->get();
            }
        }

        return Component::all()->load('brand')->load('drummers');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return Component::create($request->validate([
            'brand_id' => 'required|int',
            'name' => 'required|max:100',
            'diameter' => 'required|numeric',
        ]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Component $component)
    {
        return $component->load('brand')->load('drummers');
    }
    
    /**
     * Display the brand related to the specified resource.
     */
    public function brand(Component $component)
    {
        return $component->brand;
    }
    
    /**
     * Attach an existing drummer to an existing brand.
     */
    public function addToBrand(Component $component, Brand $brand)
    {
        $component->brand()->dissociate($component->brand());
        return $component->brand()->associate($brand);
    }

    /**
     * Display the drummers related to the specified resource.
     */
    public function drummers(Component $component)
    {
        return $component->drummers->load('band');
    }
    
    /**
     * Attach an existing drummer to an existing component.
     */
    public function addDrummer(Component $component, Drummer $drummer)
    {
        return $component->drummers()->attach($drummer);
    }

    /**
     * Remove an existing drummer from an existing component.
     */
    public function removeDrummer(Component $component, Drummer $drummer)
    {
        return $component->drummers()->detach($drummer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Component $component)
    {
        return $component->update($request->validate([
            'brand_id' => 'required|int',
            'name' => 'required|max:100',
            'diameter' => 'required|int',
        ]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Component $component)
    {
        return $component->delete();
    }
}
