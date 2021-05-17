<?php

namespace App\Http\Controllers\API;
session_start();
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use \App\Bitrix\Deal;
use \App\Bitrix\Contact;
use \App\Bitrix\Lead;
use \App\Helper;

class StatisticAPI extends Controller
{
    function page_customer(){
        return view('master1');
    }
	function get_pipeline_by_user(){
        $deal =new Deal;
        $id_user = json_decode($_COOKIE['vstk-login']);
        $id_user = $id_user[0];
        $temp = json_decode($deal->crm_deal_list([
            "filter"=>["COMPANY_ID"=>$id_user],
            "order"=> ["DATE_CREATE"=> "DESC"]
        ]),true);
        $data_deal = [];
        $pipeline = json_decode($deal->crm_dealcategory_list([]),true);
        /*tạo bộ lọc tổng số deal theo ngày tháng*/
        for($i=0;$i<count($temp['result']);$i++){
            $date_create = date_create($temp['result'][$i]['DATE_CREATE']);
            $date_create = date_format($date_create,"Y-m");
            $present_time = date("Y-m");
            if($date_create == $present_time){
                array_push($data_deal,$temp['result'][$i]);//data deal theo tháng
            }
        }
        /*lọc pipeline của user*/
        $list_pipeline = [];
        for($i = 0;$i < count($data_deal);$i++){
            for($j=0;$j<count($pipeline['result']);$j++){
                if($data_deal[$i]['CATEGORY_ID'] == $pipeline['result'][$j]['ID']){
                    $list_pipeline[$pipeline['result'][$j]['ID']] = $pipeline['result'][$j]['NAME'];
                }
            }
        }
        return $list_pipeline;
    }
    function sum_customer(Request $request){
        $deal =new Deal;
        $id_user = $_COOKIE['vstk-login'];
        $id_pipeline = $request->input('id_pipeline');
        $data_deal=[];
        $result = [];
        $temp = json_decode($deal->crm_deal_list([
            "filter"=>["COMPANY_ID"=>$id_user],
            "order"=> ["DATE_CREATE"=> "DESC"]
        ]),true);
        /*tạo bộ lọc tổng số deal theo ngày tháng*/
        for($i=0;$i<count($temp['result']);$i++){
            $date_create = date_create($temp['result'][$i]['DATE_CREATE']);
            $date_create = date_format($date_create,"Y-m");
            $present_time = date("Y-m");
            if($date_create == $present_time){
                array_push($data_deal,$temp['result'][$i]);//data deal theo tháng
            }
        }
        $list_stage = json_decode($deal->crm_dealcategory_stage_list([
            'id'=>$id_pipeline
        ]),true);
        for($i=0;$i<count($list_stage['result']);$i++){
            for($j=0;$j<count($data_deal);$j++){
                if($list_stage['result'][$i]['STATUS_ID'] == $data_deal[$j]['STAGE_ID']){
                    if(isset($result[$list_stage['result'][$i]['NAME']])){
                        $result[$list_stage['result'][$i]['NAME']] +=1;
                    }else{
                        $result[$list_stage['result'][$i]['NAME']] =1;
                    }
                    
                }
            }
        }
        return $result;

    }
    function sum_commission(Request $request){
        $id_user = json_decode($_COOKIE['vstk-login']);
        $id_user = $id_user[0];
        $deal = new Deal;
        $date_save_commission = '';
        $hour_save_commission = '';
        $temp = $deal->crm_deal_list([
            "filter"=>["COMPANY_ID"=>$id_user],
            "order"=>["DATE_CREATE"=> "DESC"],
        ]);
        $data_commission = Storage::directories('upload/commission');
        $temp = json_decode($temp,true);
        $date_deal_won = '';
        $hours_deal_won = '';
        $result = [];
        $data_deal = [];
        /*tạo bộ lọc tổng số deal theo ngày tháng và pipeline*/
        for($i=0;$i<count($temp['result']);$i++){
            $date_create = date_create($temp['result'][$i]['DATE_CREATE']);
            $date_create = date_format($date_create,"Y-m");
            $present_time = date("Y-m");
            $stage_won = 'C'.$temp['result'][$i]['CATEGORY_ID'].':WON';
            if($date_create == $present_time){
                if($temp['result'][$i]['STAGE_ID'] == $stage_won){
                    array_push($data_deal,$temp['result'][$i]);//data deal theo tháng
                }
            }
        }
        for($i=0;$i<count($data_deal);$i++){
            $date = $data_deal[$i]['DATE_MODIFY'];
            $date = date_create($date);
            $date_deal_won = date_format($date,"Y-m-d");
            $hours_deal_won = date_format($date,"H");
            $id_pipeline = $data_deal[$i]['CATEGORY_ID'];
            $id_deal = $data_deal[$i]['ID'];
            $dk1 = false;
            $dk2 = false;
            $dk3 = false;
            for($j=0;$j<count($data_commission);$j++){
                $temp_f1 = explode("/",$data_commission[$j]);
                $temp_array = [];
                $date_save_commission = $temp_f1[2];// lấy ngày, tháng tạo thư mục
                if( $date_deal_won == $date_save_commission){ //ngày tháng deal tạo = ngay tháng tạo hoa hồng
                    $dk1 = true;
                    $housr_temp = Storage::directories($data_commission[$j]);
                    for($k = 0;$k<count($housr_temp);$k++){
                        $housr_save_commission = explode("/",$housr_temp[$k]);
                        $housr_save_commission = $housr_save_commission[3];//lấy giờ tạo hoa hồng
                        if($hours_deal_won == $housr_save_commission){//kiểm tra dael tạo = giờ tạo hoa hồng
                            $dk2 = true;
                            $id_pipeline = $data_deal[$i]['CATEGORY_ID'];
                            $id_deal = $data_deal[$i]['ID'];
                            $price = $data_deal[$i]['OPPORTUNITY'];
                            $folder_commission = $date_save_commission.'/'. $housr_save_commission;
                            $result[$id_pipeline][$folder_commission][$i] = ['id'=>$id_deal,'price'=>$price];
                        }
                    }
                    if($dk2 == false){
                        for($k = count($housr_temp)-1;$k>=0;$k--){
                            $housr_save_commission = explode("/",$housr_temp[$k]);
                            $housr_save_commission = $housr_save_commission[3];
                            $id_pipeline = $data_deal[$i]['CATEGORY_ID'];
                            $id_deal =  $data_deal[$i]['ID'];
                            $price = $data_deal[$i]['OPPORTUNITY'];
                            $folder_commission = $date_save_commission.'/'. $housr_save_commission;
                            if($housr_save_commission < $hours_deal_won){
                                $result[$id_pipeline][$folder_commission][$i] = ['id'=>$id_deal,'price'=>$price];
                                break;
                            }
                        }
                    }
                }
            }
            if($dk1 == false){
                for($j=count($data_commission)-1;$j>0;$j--){
                    
                    $temp_f1 = explode("/",$data_commission[$j]);
                    $date_save_commission = $temp_f1[2];
                    if($date_save_commission < $date_deal_won){
                        $temp_housr = Storage::directories($data_commission[$j]);
                        $housr_save_commission = explode("/",$temp_housr[count($temp_housr)-1]);
                        $housr_save_commission = $housr_save_commission[3];
                        for($k = count($temp_housr)-1;$k>=0;$k--){
                            $housr_save_commission = explode("/",$temp_housr[$k]);
                            $housr_save_commission = $housr_save_commission[3];
                            $id_pipeline = $data_deal[$i]['CATEGORY_ID'];
                            $price = $data_deal[$i]['OPPORTUNITY'];
                            $folder_commission = $date_save_commission.'/'. $housr_save_commission;
                            if($housr_save_commission < $hours_deal_won){
                                $result[$id_pipeline][$folder_commission][$i] = ['id'=>$id_deal,'price'=>$price];
                                break;
                            }
                        }
                        
                        break;
                    }
                }
            }
           
        }
        $pipeline = json_decode($deal->crm_dealcategory_list([]),true);
        $sum_commission = ['total_commission'=>0,'detail'=>[]];
        foreach($result as $id_pipeline => $value){
            $temp_sum = 0;
            foreach($value as $folder_commission => $deals){
                $commission = Storage::get('upload/commission/'.$folder_commission.'/data_commission.txt');
                $commission = explode("\n",$commission);
                $type_commission = explode("^",$commission[0]);
                $type_commission = $type_commission[1];
                $data_deal_commission = explode("|",$commission[1]);
                $price = 0;
                foreach($deals as $value3){
                    $price= $value3['price'];
                }
                for($j=0;$j<count($data_deal_commission);$j++){
                    $x = explode("^",$data_deal_commission[$j]);
                    $id = $x[0];
                    $value_commission = $x[1];
                    if($id == $id_pipeline){
                        if($type_commission == 'percent'){
                            $temp_sum += ($price * $value_commission)/100;
                        }else{
                            $temp_sum += $price + $value_commission;
                        }
                    }
                }
            }
            
            for($i=0;$i<count($pipeline['result'])-1;$i++){
                if($id_pipeline == $pipeline['result'][$i]['ID']){
                    $sum_commission['total_commission'] += $temp_sum;
                    array_push($sum_commission['detail'],['id'=>$id_pipeline,'name'=>$pipeline['result'][$i]['NAME'],'commission'=>$temp_sum]);
                }
            }
        }
        return $sum_commission;
    }
}