<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Requests\WhaterLoad;
use App\Http\Requests\CitySearch;
use App\Models\History;

class ApiController extends Controller
{
    public function listCitys(){

    }
    public function weatherLoad(WhaterLoad $request){ 
        // Apuntamos a la url de consuimo de la api consultando por ciudad
        $data = \Helper::curl('https://api.openweathermap.org/data/2.5/weather?id='.$request->cityid.'&appid='.env('OPENWEATHERMAP_APP_ID'));
        if(isset($data) && $data->cod=='404'){
            return response()->json(['message'=>$data->message], 404);
        } else{
            History::create([
                'city_id'=>$data->id,
                'city_name'=>$data->name,
                'json'=>$data
            ]);
            return response()->json($data, 200);
        }
    }

    public function searchCitys(CitySearch $request){
        $data = \Helper::searchCitys($request->search);
        // $data = \Helper::listCitys();
        return response()->json($data, 200);
    }
}
