<?php

namespace App\Http\Controllers;

use App\Models\Drummer;
use App\Models\Band;
use App\Models\Component;
use Illuminate\Http\Request;

class DrummerController extends Controller
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
                    return Drummer::all();
                case 1:
                    return Drummer::where('first_name', 'like', "%". $arrName[0]. "%")
                        ->orWhere('last_name', $arrName[0])->get();
                default:
                    return Drummer::where('first_name', 'like', "%". $arrName[0]. "%")
                        ->orWhere('last_name', $arrName[0])
                        ->orWhere('last_name', $arrName[1])->get();
            }
        }

        // return Drummer::all()->load('bands')->load('components');
        return Drummer::all()->load('bands')->load('components');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return Drummer::create($request->validate([
            'first_name' => 'required|max:75',
            'last_name' => 'required|max:75',
        ]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Drummer $drummer)
    {
        return $drummer->load('bands')->load('components');
    }

    /**
     * Display the bands related to the specified resource.
     */
    public function bands(Drummer $drummer)
    {
        return $drummer->bands;
    }

    /**
     * Attach an existing drummer to an existing band.
     */
    public function addBand(Drummer $drummer, Band $band)
    {
        return $band->drummers()->attach($drummer);
    }

    /**
     * remove an existing drummer from an existing band.
     */
    public function removeBand(Drummer $drummer, Band $band)
    {
        return $band->drummers()->detach($drummer);
    }

    /**
     * Display the components related to the specified resource.
     */
    public function components(Drummer $drummer)
    {
        return $drummer->components->load('brand');
    }

    /**
     * Attach an existing component to an existing drummer.
     */
    public function addComponent(Drummer $drummer, Component $component)
    {
        return $drummer->components()->attach($component);
    }

    /**
     * Remove an existing component from an existing drummer.
     */
    public function removeComponent(Drummer $drummer, Component $component)
    {
        return $drummer->components()->detach($component);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Drummer $drummer)
    {
        return $drummer->update($request->validate([
            'first_name' => 'required|max:75',
            'last_name' => 'required|max:75',
        ]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Drummer $drummer)
    {
        return $drummer->delete();
    }
}
