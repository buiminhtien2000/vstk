<?php

namespace App;

use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\DocBlock\Serializer;
use Illuminate\Support\Facades\Storage;
use \App\Models\Portal;
use \App\Models\Bitrix24App;
use Illuminate\Http\Request;
use App\Models\DuplicateControl;
use Session;

class Helper
{   
    const URL_WEBHOOK="https://eqvn.bitrix24.com/rest/17358/14cm3qno9ij1moe7/";
    public static function request($data){

        /*
          $data = [
               'url'       => '',
               'method'    => '',
               'params'    => '',
               'header'    => '',
               'encode'    => '',
          ];
         * */
        if($data && isset($data['url'])) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            if (isset($data['method'])) {
                if($data['method'] == 'POST') {
                    curl_setopt($ch, CURLOPT_POST, TRUE);
					if(!isset($data['header'])){
						$data['header'] = ['Content-type: application/x-www-form-urlencoded'];
					}
                }else{
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $data['method']);
                }

                if(isset($data['params']) && $data['params']){
					if(isset($data['encode'])){
						curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data['params']));
					}else if(isset($data['body'])){
						curl_setopt($ch, CURLOPT_POSTFIELDS, $data['params']);
					}else{
						curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data['params']));
					}
				}	
            }else{
				if(isset($data['params']) && $data['params'])
					$data['url'] .= '&' . http_build_query($data['params']);
			}
			
			curl_setopt($ch, CURLOPT_URL, $data['url']);
            
			if (isset($data['header'])) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, $data['header']);
            }
			
			$response = curl_exec($ch);

			curl_close($ch);
			
			$valid = json_decode($response);
			
			if (json_last_error() === JSON_ERROR_NONE) {
				$response = $valid;
			}

            return json_encode($response);
        }

        return '';
    }
    public static function json_success($data = null, $message = ''){
        return response()->json(['success' => 1, 'message' => $message, 'data' => $data]);
    }

    public static function json_error($message, $data = null){
        return response()->json(['success' => 0, 'message' => $message, 'data' => $data]);
    }
    public static function replace_html($param){
        return strip_tags($param);
    }
}