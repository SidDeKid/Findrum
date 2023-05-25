<?php

namespace App\Http\Controllers;

use App\Models\Band;
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

        return Band::all();
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
        return $band;
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
    public function removeDrummer(Drummer $drummer, Band $band)
    {
        return $band->drummers()->dissociate($drummer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Band $band)
    {
        $band->update($request->validate([
            'name' => 'required|max:100',
        ]));
        return $band;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Band $band)
    {
        return $band->delete();
    }
}
