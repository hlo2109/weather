<?php 
use Carbon\Carbon;

class helper
{
    
    public function __construct(){  
     
    } 
 
    public static function curl($url, $type="GET", $fields=null){
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      if($fields){
          curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
      }
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_TIMEOUT, 3);
      $result = \json_decode( curl_exec($ch) );
      return $result;
    }

    public static function listCitys(){      
      $data = file_get_contents(__DIR__.'/../../storage/app/current.city.list.json');
      $data = json_decode($data);
      $citys  = \collect($data); 
      return $citys;
    }
    public static function searchCitys($search){ 
      return self::listCitys()->filter(function($item) use($search){
        return stristr($item->name, $search);
      });
    }
    public static function searchCitysIn($ids){
      return self::listCitys()->whereIn('id', $search)->all();
    }

    public  static function dateLetter($date, $hour=false){
      Carbon::setLocale('es');
      $date = Carbon::parse($date);
      $mes = $date->formatLocalized("%B");
      $hora = ($hour) ? "a las ".$date->format("H").':'.$date->format("m") : '';
      return  $date->format("d")." de ".$mes." del ".$date->format("Y")." ".$hora;
  }   
   
}


?>