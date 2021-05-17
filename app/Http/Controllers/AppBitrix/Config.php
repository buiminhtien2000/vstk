<?php

namespace App\Http\Controllers\AppBitrix;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use \App\Bitrix\Deal;
use \App\Helper;

class Config extends Controller
{
    function page_config_filed(){
        return View('admin.config');
    }
    function get_deal_field(){
        $deal = new Deal;
        $temp = $deal->crm_deal_fields([]);
        $temp = json_decode($temp,true);
        $result = [];
        foreach ($temp['result'] as $key1 => $val1) {
            foreach($val1 as $key2 =>$val2 ){
                if(isset($key2['title'])){
                    $result['result'][$key1]=$val2;
                }else{
                    $result['result'][$key1]=$val2;
                }
                
            }
        }
        return $result;
    }
	function save_config_field(Request $requet){
        $temp = [];
        $data = json_encode($requet->input('data'));
        $data = json_decode($data,true);
        $text = '';
        for($i = 0;$i< count($data);$i++){
            $temp[$i][0] = $data[$i]['id_pipeline'];
            $temp[$i][1] = $data[$i]['field'];
        }
        for($i = 0;$i<count($temp);$i++){
            $text .= $temp[$i][0]."^";
            foreach($temp[$i][1] as $field){
                $text .= $field."&";
            }
            $text = rtrim($text,"&");
            $text.="\n";
        }
        $result = Storage::put('upload/field/data_field.txt', $text);
        if($result == false){
            return Helper::json_error('Lưu thất bại!');
        }else{
            return  Helper::json_success('Lưu thành công!');
        }
    }
    function get_config_field(Request $requet){
        $deal = new Deal;
        $id=$requet->input('id_pipeline');
        $data_field = Storage::get('upload/field/data_field.txt');
        $data_field = explode("\n",$data_field);
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
                    $data[0] = $temp[0];
                    $data[1] = explode('&',rtrim($temp[1],"\n"));
                }
            }
        }
        $field = json_decode($deal->crm_deal_fields([

        ]),true);
        $result = [];
        foreach($field['result'] as $key => $value){    
            foreach($data[1] as $key2 => $value2){
                if($key == $value2){
                    if(isset($value['title'])){
                        $result[0]=$data[0];
                        $result[1][$value2] = $value['title'];
                    }else{
                        $result[0]=$data[0];
                        $result[1][$value2] = $value['listLabel'];
                    }
                    
                }
            }
        }
        return $result;
    }
    function save_config_commission(Request $requet){
        $temp = [];
        $data = json_encode($requet->input('data'));
        $data = json_decode($data,true);
        $text = 'type_commission^'.$data['type_commission']."\n";
        for($i = 0;$i<count($data['data']);$i++){
            if(!is_numeric($data['data'][$i]['value']) || empty($data['data'][$i]['value'])){
                $text.=$data['data'][$i]['id'].'^0|';
            }else{
                $text.=$data['data'][$i]['id'].'^'.$data['data'][$i]['value'].'|';
            }
        }
        $text = rtrim($text,"|");
        $result = Storage::put('upload/commission/'.date("Y-m-d").'/'.date("H").'/data_commission.txt', $text);
        if($result == false){
            return Helper::json_error('Lưu thất bại!');
        }else{
            return  Helper::json_success('Lưu thành công!');
        }
    }
    
}