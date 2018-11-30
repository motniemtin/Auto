<?php
namespace Motniemtin\Auto;

use Motniemtin\Auto\Auto;
use Exception;

class AutoProxy{
  private $keys=[ '7318a86a-c213-4b0a-b056-d96e9ba3db2c'
         ,'00fe5795-e439-456c-a8dc-da4d4df1b454',
          'ed8dd8c7-8145-4ae2-8a4f-464e07905447'];
  private $websites;
  public function __construct(){
    
  }
  public function AddKey($key){
    $keys[]=$key;
    $this->keys=array_unique($this->keys);
    file_put_contents("keys.json", json_encode($keys));
  }
  function AutoProxy(){
    $keys=file_get_contents("keys.json");
    $keys=json_decode($keys,1);
    if(json_last_error()!=JSON_ERROR_NONE){
      throw new Exception('Proxy keys invalid!');
    }
    $this->keys=$keys;
  }
  public function GetProxy(){
    $auto=new Auto(1,"proxy.cki");
    $auto->clearcookie();
    $proxy_html=$auto->get("https://gimmeproxy.com/api/getProxy?minSpeed=100&api_key=".$this->array_random($this->keys));
    $proxyjson=json_decode($proxy_html);    
    if(json_last_error()!=JSON_ERROR_NONE){
      throw new Exception('Error to get new proxy!'.$proxy_html);
    }
    if(!isset($proxyjson->curl)){
      throw new Exception('Error to get new proxy!'.$proxy_html);
    }else{        
    return $proxyjson->curl;
    }
  }
  function array_random($arr, $num = 1) {
    shuffle($arr);
    $r = array();
    for ($i = 0; $i < $num; $i++) {
        $r[] = $arr[$i];
    }
    return $num == 1 ? $r[0] : $r;
  }
}