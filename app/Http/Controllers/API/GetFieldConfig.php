<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ConfigField extends Controller
{
	function get_config($id_pipeline){
        $data_field = file('./MVC/Upload/data_field.txt');
        $data = [];
        $pipeline = '';
        $length = count($data_field);
        if($id == ""){
            for($i=0;$i<$length;$i++){
                $temp = explode('^',$data_field[$i]);
                $data[$i][0] = $temp[0]; 
                $data[$i][1] = explode('&',$temp[1]);
                echo $temp[1];
            }
        }else{
            for($i=0;$i<$length;$i++){
                $temp = explode('^',$data_field[$i]);
                if($id == $temp[0]){
                    $data[0][0] = $temp[0];
                    $data[0][1] = explode('&',rtrim($temp[1],"\n"));
                }
            }
        }
        echo json_encode($data);
    }
}
