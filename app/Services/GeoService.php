<?php

namespace App\Services;

use App\State;
use App\City;
use App\Zip;
use Illuminate\Support\Facades\Storage;

class GeoService
{
  
    public function __construct()
    {
        //
    }

    public function createAllStates ()
    {
        $states = [
            'AL',
            'AK',
            'AZ',
            'AR',
            'CA',
            'CO',
            'CT',
            'DE',
            'FL',
            'GA',
            'HI',
            'ID',
            'IL',
            'IN',
            'IA',
            'KS',
            'KY',
            'LA',
            'ME',
            'MD',
            'MA',
            'MI',
            'MN',
            'MS',
            'MO',
            'MT',
            'NE',
            'NV',
            'NH',
            'NJ',
            'NM',
            'NY',
            'NC',
            'ND',
            'OH',
            'OK',
            'OR',
            'PA',
            'RI',
            'SC',
            'SD',
            'TN',
            'TX',
            'UT',
            'VT',
            'VA',
            'WA',
            'WV',
            'WI',
            'WY'
        ];

        $states_copy = [];

        foreach ($states as $state) {
            $existingState = State::where('name', $state)->first();
            if (!$existingState){
                
                $data = [
                   'name' => $state
                ];
                array_push($states_copy, $data);
            }
        }
        
        try {
            State::insert($states_copy);
            return 'All sates created successfully!';
           
        } catch (\Exception $e) {
            \Log::error($e);
            return $e->getMessage();
        }

        
    }

    public function createCityAndZip($file)
    {
        
        if ( pathinfo($file, PATHINFO_EXTENSION) === 'zip' ){
            $unzip = $this->unzip($file);
            if (!$unzip){
                return 'Unable to unzip file';
            }

            $dir =  pathinfo($file, PATHINFO_FILENAME);
            foreach (scandir( storage_path('states') . "/$dir" ) as $file) {
                $fileWithPath = storage_path('states') . "/$dir/$file";
                
                if ( pathinfo($fileWithPath, PATHINFO_EXTENSION) === 'csv' ||  pathinfo($fileWithPath, PATHINFO_EXTENSION) === 'txt'){
                    $this->createRecords($fileWithPath);
                }
            }

        } else {
            $this->createRecords($file);
        }

        return 'Done.';
    }

    private function unzip($file)
    {
        $zip = new \ZipArchive;
        if ($zip->open($file) === TRUE) {
            $zip->extractTo(storage_path('states'));
            $zip->close();
            return true;
        } else {
            return false;
        }
    }

    private function createRecords($file)
    {
        $handle = fopen($file, "r");
        while (($row = fgetcsv($handle)) !== FALSE) {
          
            try{
                $existingZip = Zip::where('zip_code', $row[0])->first();
                $state = State::where('name', $row[2])->first();
                
                if (!$existingZip){
                    $zip_data = [
                       'zip_code' => $row[0],
                       'state_id' => $state->id
                    ];
                    Zip::create($zip_data);
                }

                $zip = Zip::where('zip_code', $row[0])->first();
                $city_data = [
                    'name' => $row[1],
                    'state_id' => $state->id,
                    'zip_id' => $zip->id
                ];

                City::create($city_data);
                
            } catch (\Exception $e){
               \Log::error($e);
               return $e->getMessage();
            }  
            
        }
        fclose($handle);
        return 'success';
    }

    public function validateGeoData($data)
    {
        try {
            $city = City::where('name', $data['city'])->with(['zip', 'state'])->first();

            if ( 
                (strtolower($data['city']) == strtolower($city->name)) 
                && 
                (strtolower($data['state']) == strtolower($city->state->name)) 
                && 
                (strtolower($data['zip']) == strtolower($city->zip->zip_code))
                ){
                    return 'valid geo';
                } else {
                    return 'invalid geo';
                }

        } catch (\Exception $e){
            return 'unable to validate geo';
        }
       
    }

   
}
