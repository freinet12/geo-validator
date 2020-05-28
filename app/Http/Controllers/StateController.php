<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\State;
use Illuminate\Support\Facades\Storage;
use App\Services\GeoService;

class StateController extends Controller
{
    
    protected $service;

    public function __construct()
    {
        $this->service = new GeoService;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $states = State::get();
            return [
                'success' => true,
                'states' => $states
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (!$request->has('name') || strlen($request->name) === 0){
            return [
                'success' => false,
                'error' => 'the name field is required.'
            ];
        }

        if (strlen($request->name) > 2 || strlen($request->name) === 1){
            return [
                'success' => false,
                'error' => 'Please provide the 2 letter state code.'
            ];
        }

        if (gettype($request->name) !== "string"){
            return [
                'success' => false,
                'error' => 'name must be of type String.'
            ];
        }

        try {

            $existingState = State::where('name', strtoupper($request->name))->first();

            if(!$existingState){
                $state = new State;
                $state->name = strtoupper($request->name);
                $state->save();
                return [
                    'success' => true,
                    'state' => $state
                ];

            } else {
                return [
                    'success' => false,
                    "error' => 'A record for state: $request->name already exists."
                ];
            }
            
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
        
    }

    public function createAll()
    {
        return $this->service->createAllStates();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
