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
      $data = file_get_contents(base_path('storage/app/current.city.list.json'));
      $data = json_decode($data);
      $citys  = \collect($data); 
      return $citys;
    }
    public static function searchCitys($search){
      // return self::listCitys()->where('name', $search )->all();
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
  // Deprecable
    // private static function buildBaseString($baseURI, $method, $params) {
    //     $r = array();
    //     ksort($params);
    //     foreach($params as $key => $value) {
    //         $r[] = "$key=" . rawurlencode($value);
    //     }
    //     return $method . "&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
    // }

    // private static function buildAuthorizationHeader($oauth) {
    //     $r = 'Authorization: OAuth ';
    //     $values = array();
    //     foreach($oauth as $key=>$value) {
    //         $values[] = "$key=\"" . rawurlencode($value) . "\"";
    //     }
    //     $r .= implode(', ', $values);
    //     return $r;
    // }

    // public static function YahooWeather($url){    
    //     $app_id = env('APP_YAHOO_APP_ID');
    //     $consumer_key = env('APP_YAHOO_CONSUMER_KEY');
    //     $consumer_secret = env('APP_YAHOO_CONSUMER_SECRET');

    //     $query = array(
    //         'location' => 'sunnyvale,ca',
    //         'format' => 'json',
    //     );

    //     $oauth = array(
    //         'oauth_consumer_key' => $consumer_key,
    //         'oauth_nonce' => uniqid(mt_rand(1, 1000)),
    //         'oauth_signature_method' => 'HMAC-SHA1',
    //         'oauth_timestamp' => time(),
    //         'oauth_version' => '1.0'
    //     );

    //     $base_info = self::buildBaseString($url, 'GET', array_merge($query, $oauth));
    //     $composite_key = rawurlencode($consumer_secret) . '&';
    //     $oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
    //     $oauth['oauth_signature'] = $oauth_signature;

    //     $header = array(
    //         self::buildAuthorizationHeader($oauth),
    //         'X-Yahoo-App-Id: ' . $app_id
    //     );
    //     $options = array(
    //         CURLOPT_HTTPHEADER => $header,
    //         CURLOPT_HEADER => false,
    //         CURLOPT_URL => $url . '?' . http_build_query($query),
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_SSL_VERIFYPEER => false
    //     );
        
    //     $ch = curl_init();
    //     curl_setopt_array($ch, $options);
    //     $response = curl_exec($ch);
    //     curl_close($ch);
    //     print_r($response);
    //     $return_data = json_decode($response);
    //     print_r($return_data);
    //     return $return_data;
    // }
   
}


?>