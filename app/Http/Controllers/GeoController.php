<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\GeoService;

class GeoController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new GeoService;
    }
    
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        if (!$request->has('file')){
            return [
                'success' => false,
                'error' => 'the file field is required.'
            ];
        }

        $request->file('file')->move(storage_path('states'), $request->file('file')->getClientOriginalName());
        $file = 'states/' . $request->file('file')->getClientOriginalName();

      

        // $file = Storage::putFileAs(
        //     'states', 
        //     $request->file('file'), 
        //     uniqid() . '_' . $request->file('file')->getClientOriginalName()
        // );

        //Storage::disk('local')->put('states', $request->file('file'));

        return $this->service->createCityAndZip(storage_path() . "/$file");

    }
    public function validateGeo(Request $request)
    {
        
        if (!$request->has('city')){
            return [
                'success' => false,
                'error' => 'the city field is required.'
            ];
        }
        if (!$request->has('state')){
            return [
                'success' => false,
                'error' => 'the state field is required.'
            ];
        }

        if (!$request->has('zip')){
            return [
                'success' => false,
                'error' => 'the zip field is required.'
            ];
        }

        if (strlen($request->state) > 2 || strlen($request->state) === 1){
            return [
                'success' => false,
                'error' => 'Please provide the 2 letter state code.'
            ];
        }

        return $this->service->validateGeoData($request->all());

    }
}
