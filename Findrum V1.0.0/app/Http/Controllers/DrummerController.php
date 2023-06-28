<?php

namespace App\Http\Controllers;

use App\Models\Drummer;
use App\Models\Band;
use App\Models\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class DrummerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('sort')) {
            try {
                return Drummer::orderBy($request->sort)->orderby('last_name')->get()->load('bands')->load('components');
            } catch (\Throwable $th) {
                Log::error("While reading all drummers: ". $th);
            }
        } 
        return Drummer::orderBy('last_name')->get()->load('bands')->load('components');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:75',
            'last_name' => 'required|max:75',
        ]);
        if ($validator->fails()) {
            Log::error("New drummer not created, because of validator, request:". $request);
            return response('{ "Errormessage": "Data not correct" }', 400)->header('Content-Type', 'application/json');
        }

        $request->user()->currentAccessToken()->delete();
        $response = [
            'data'          => Drummer::create($request->all()),
            'access_token'  => auth()->user()->createToken('API Token')->plainTextToken,
            'token_type'    => 'Bearer'
        ];
        return response()->json($response, 201);
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
    public function addBand(Request $request, Drummer $drummer, Band $band)
    {
        $request->user()->currentAccessToken()->delete();
        $response = [
            'data'          => $band->drummers()->attach($drummer),
            'access_token'  => auth()->user()->createToken('API Token')->plainTextToken,
            'token_type'    => 'Bearer'
        ];
        return response()->json($response, 201);
    }

    /**
     * remove an existing drummer from an existing band.
     */
    public function removeBand(Request $request, Drummer $drummer, Band $band)
    {
        $request->user()->currentAccessToken()->delete();
        $response = [
            'data'          => $band->drummers()->detach($drummer),
            'access_token'  => auth()->user()->createToken('API Token')->plainTextToken,
            'token_type'    => 'Bearer'
        ];
        return response()->json($response, 200);
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
    public function addComponent(Request $request, Drummer $drummer, Component $component)
    {
        $request->user()->currentAccessToken()->delete();
        $response = [
            'data'          => $drummer->components()->attach($component),
            'access_token'  => auth()->user()->createToken('API Token')->plainTextToken,
            'token_type'    => 'Bearer'
        ];
        return response()->json($response, 201);
    }

    /**
     * Remove an existing component from an existing drummer.
     */
    public function removeComponent(Request $request, Drummer $drummer, Component $component)
    {
        $request->user()->currentAccessToken()->delete();
        $response = [
            'data'          => $drummer->components()->detach($component),
            'access_token'  => auth()->user()->createToken('API Token')->plainTextToken,
            'token_type'    => 'Bearer'
        ];
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Drummer $drummer)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:75',
            'last_name' => 'required|max:75',
        ]);
        if ($validator->fails()) {
            Log::error("New drummer not created, because of validator, request:". $request);
            return response('{ "Errormessage": "Data not correct" }', 400)->header('Content-Type', 'application/json');
        }

        $request->user()->currentAccessToken()->delete();
        $response = [
            'data'          => $drummer->update($request->all()),
            'access_token'  => auth()->user()->createToken('API Token')->plainTextToken,
            'token_type'    => 'Bearer'
        ];
        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Drummer $drummer)
    {
        $request->user()->currentAccessToken()->delete();
        $response = [
            'data'          => $drummer->delete(),
            'access_token'  => auth()->user()->createToken('API Token')->plainTextToken,
            'token_type'    => 'Bearer'
        ];
        return response()->json($response, 200);
    }
}
