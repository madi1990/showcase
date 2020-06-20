<?php
namespace App\Http\Controllers\Api;

class ApiResponse{
    private $code;
    private $type;
    private $message = "";

    private $defaultHeader = [
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Methods' => 'POST, GET, PUT, DELETE',
        'Access-Control-Allow-Headers' => '*',
    ];
    
    public function __construct($code = 0, $type = '', $message = '', $customHeader = array()){
        $this->code = $code;
        $this->type = $type;
        $this->message = $message;
        foreach($customHeader as $header => $value) {
            $this->defaultHeader[$header] = $value;
        }
    }

    public function setCode($code){
        $this->code = $code;
    }

    public function setType($type){
        $this->type = $type;
    }

    public function setMessage($message){
        $this->message = $message;
    }
    
    public function outputResponse($type = 'json'){
        // Add a wrapper
        $this->data = array('code' => $this->code, 'type' => $this->type, 'message' => $this->message);
		if($type == 'json')return $this->asJSON();
		if($type == 'array') return $this->asArray();
        if($type == 'query') return $this->asQueryString();
        if($type == 'xml') return $this->asXML();
		return $this->asXML();
    }

    public function asQueryString(){
		$string = "";
		foreach($this->data as $key => $value){
			if(empty($string)) $string = "?$key=$value";
			else $string = $string. "&". urlencode($key). "=". urlencode($value);
		}
		return \Response($string);
    }
    
    public function asXML(){
		$xml = new \SimpleXMLElement("<?xml version=\"1.0\" encoding=\"UTF-8\"?><ApiResponse/>");
		foreach($this->data as $key => $value){
			if(is_array($value)){
				$xml->addChild($key);
				foreach($value as $key2 => $value2){
					$xml->{$key}->{$key2} = $value2;
				}
			} else {
				$xml->{$key} = $value;
			}
		}
        $status = 200;
        $this->defaultHeader['Content-Type'] = 'application/xml';
        return \Response::make($xml->asXML(), $status, $this->defaultHeader);
    }
    
	public function asJSON(){
		$json = $this->data;
		return \Response::json($json, 200, $this->defaultHeader);
    }
    
	public function asArray(){
		return $this->data;
	}
}