<?php

namespace App\Http\Controllers;

use App\Models\Band;
use App\Models\Drummer;
use Illuminate\Http\Request;

class BandController extends Controller
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
                    return Band::all();
                case 1:
                    return Band::where('name', 'like', "%". $arrName[0]. "%")
                        ->orWhere('name', $arrName[0])->get();
                default:
                    return Band::where('name', 'like', "%". $arrName[0]. "%")
                        ->orWhere('name', $arrName[0])
                        ->orWhere('name', $arrName[1])->get();
            }
        }

        return Band::all()->load('drummers');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return Band::create($request->validate([
            'name' => 'required|max:100',
        ]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Band $band)
    {
        return $band->load('drummers');
    }

    /**
     * Display the drummers related to the specified resource.
     */
    public function drummers(Band $band)
    {
        return $band->drummers;
    }

    /**
     * remove an existing drummer from an existing band.
     */
    public function addDrummer(Band $band, Drummer $drummer)
    {
        return $band->drummers()->attach($drummer);
    }

    /**
     * remove an existing drummer from an existing band.
     */
    public function removeDrummer(Band $band, Drummer $drummer)
    {
        return $band->drummers()->detach($drummer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Band $band)
    {
        $band->update($request->validate([
            'name' => 'required|max:100',
        ]));
        return $band->load('drummers');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Band $band)
    {
        return $band->delete();
    }
}
