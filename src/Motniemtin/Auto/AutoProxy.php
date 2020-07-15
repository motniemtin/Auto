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
    $proxy_html=$this->proxySite("https://gimmeproxy.com/api/getProxy?get=true&supportsHttps=true&maxCheckPeriod=3600");
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
  public function proxySite($url){
    $server=$this->array_random(array('us', 'eu'),1);
    if($server=="us"){
      $server=$server.rand(1,15);
    }else{
      $server=$server.rand(1,10);
    }
    $serverUrl='https://'.$server.'.proxysite.com/includes/process.php?action=update';
    $auto=new Auto(1,"proxy.cki");
//     echo $serverUrl;
//     echo 'server-option='.$server.'&d='.urlencode($url);
//     exit();
    return $auto->post($serverUrl, 'server-option='.$server.'&d='.urlencode($url), 'https://www.proxysite.com/');
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