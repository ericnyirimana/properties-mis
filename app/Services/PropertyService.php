<?php


namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class PropertyService{


    public function __construct(){

    }



    public function getPropertiesPerPage(int $pageNumber, int $pageSize){


        $fetchPropertiesUrl = env('PROPERTY_API').'/properties';
        try{
            $response = Http::get($fetchPropertiesUrl, [
                'api_key' => env('PROPERTY_API_KEY'),
                'page[number]' => $pageNumber,
                'page[size]' => $pageSize,
            ]);
        } catch(\Throwable $e){
            response()->json(['error' => 'Oops, something went wrong'], 400);
            Log::error('An error has occurred when getting properties per page : {' . $e->getMessage() . '})');
        }
        return $response;
    }

}
