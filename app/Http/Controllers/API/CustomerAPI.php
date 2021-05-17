<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use \App\Bitrix\Deal;
use \App\Bitrix\Contact;
use \App\Helper;

class CustomerAPI extends Controller
{
    function page_customer(){
        return view('customer.index');
    }
    function page_customer_detail(){
        return view('customer.customer_detail');
    }
    function get_pipeline(){
        $deal = new Deal;
        $temp = json_decode($deal->crm_dealcategory_list([
        ]),true);
        return $temp['result'];
    }
    public function parseImport(Request $request)
    {

        $path = $request->file('csv_file')->getRealPath();

        if ($request->has('header')) {
            $data = Excel::load($path, function($reader) {})->get()->toArray();
        } else {
            $data = array_map('str_getcsv', file($path));
        }

        if (count($data) > 0) {
            if ($request->has('header')) {
                $csv_header_fields = [];
                foreach ($data[0] as $key => $value) {
                    $csv_header_fields[] = $key;
                }
            }
            $csv_data = array_slice($data, 0, 2);

            $csv_data_file = CsvData::create([
                'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
                'csv_header' => $request->has('header'),
                'csv_data' => json_encode($data)
            ]);
        } else {
            return redirect()->back();
        }

        return view('import_fields', compact( 'csv_header_fields', 'csv_data', 'csv_data_file'));

    }
	function get_customer(){
        $id_user = json_decode($_COOKIE['vstk-login']);
        $id_user = $id_user[0];
        $deal = new Deal;
        $temp = json_decode($deal->crm_deal_list([
            "filter"=>["COMPANY_ID"=>$id_user]/*$id_user]*/,
            "order"=>["DATE_CREATE"=> "DESC"]
        ]),true);
        $data_deal = [];
        $list_stage= [];
        /*tạo bộ lọc tổng số deal theo ngày tháng và pipeline*/
        for($i=0;$i<count($temp['result']);$i++){
            $date_create = date_create($temp['result'][$i]['DATE_CREATE']);
            $date_create = date_format($date_create,"Y-m");
            $present_time = date("Y-m");
            if($date_create == $present_time){
                array_push($data_deal,$temp['result'][$i]);//data deal theo tháng
            }
        }

        for($i=0;$i<count($data_deal);$i++){
            $list_stage = json_decode($deal->crm_dealcategory_stage_list([
                'id'=>$data_deal[$i]['CATEGORY_ID'] ]),true);
                for($j=0;$j<count($list_stage['result']);$j++){
                    if($data_deal[$i]['STAGE_ID'] == $list_stage['result'][$j]['STATUS_ID']){
                        $data_deal[$i]['STAGE_ID'] = $list_stage['result'][$j]['NAME'];
                    }
                }
            
        }
        return $data_deal;
    }
    function add_customer(Request $request){
        $deal = new Deal;
        $id_deal = $request->input('id_deal');
        $result = json_decode($deal->crm_deal_get([
            "id"=>$id_deal,
        ]),true);
        if(isset($result['result'])&&count($result['result'])>0){
            return $result['result'];
        }else{
            return Helper::json_success('Dữ liệu yêu cầu không có trong hệ thống');
        }
    }
    function get_customer_by_id(Request $request){
        $deal = new Deal;
        $id_deal = $request->input('id_deal');
        $result = json_decode($deal->crm_deal_get([
            "id"=>$id_deal,
        ]),true);
        if(isset($result['result'])&&count($result['result'])>0){
            return $result['result'];
        }else{
            return Helper::json_success('Dữ liệu yêu cầu không có trong hệ thống');
        }
    }
    function get_contact_customer(Request $request){
        $ct = new Contact;
        $id_contact = $request->input('id_contact');
        $result = json_decode($ct->crm_contact_get([
            "id"=>$id_contact,
        ]),true);
        if(isset($result['result'])&&count($result['result'])>0){
            return $result['result'];
        }else{
            return Helper::json_success('Dữ liệu yêu cầu không có trong hệ thống');
        }
    }
    function filter_customer(Request $request){
        $id_user = json_decode($_COOKIE['vstk-login']);
        $id_user = $id_user[0];
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');
        $deal = new Deal;
        $temp = json_decode($deal->crm_deal_list([
            "filter"=>["COMPANY_ID"=>$id_user],
            "order"=>["DATE_CREATE"=> "DESC"]
        ]),true);
        $data_deal = [];
        for($i=0;$i<count($temp['result']);$i++){
            $date_create = date($temp['result'][$i]['DATE_CREATE']);
            $date_create = strtotime($date_create);
            if($date_create >= $from_date && $date_create <= $to_date){
                array_push($data_deal,$temp['result'][$i]);//data deal theo tháng
            }
        }
        return $data_deal;
    }
    function search_customer(Request $request){
        $id_user = json_decode($_COOKIE['vstk-login']);
        $id_user = $id_user[0];
        $key_work = $request->input('key_work');
        $deal = new Deal;
        $temp = json_decode($deal->crm_deal_list([
            "filter"=>["COMPANY_ID"=>$id_user,"%TITLE"=>$key_work],
            "order"=>["DATE_CREATE"=> "DESC"]
        ]),true);
        return $temp['result'];
    }
    function update_customer(Request $request){ 
        $ct = new Contact;
        $deal = new Deal;
        $id_deal = $request->input('id_deal');
        $id_contact = $request->input('id_contact');
        $data= $request->input('data');
        $temp1 = $deal->crm_deal_update([
            "id"=>$id_deal,
            "fields"=>[
                "TITLE"=> $data['title'],
            ]
        ]);
        $temp2 = $ct->crm_contact_update([
            "id"=>$id_contact,
            "fields"=>[
                "PHONE"=>[
                    "VALUE"=>$data['sdt'],
                    "VALUE_TYPE"=>'WORK',
                ],
                "EMAIL"=>[
                    "VALUE"=>$data['email'],
                    "VALUE_TYPE"=>'WORK',
                ],
                "NAME"=>$data['name'],
                "ADDRESS"=>$data['address'],
            ]
        ]);
        if($temp1['result'] ==true && $temp2['result']==true){
            Helper::json_success('Lưu thành công!');
        }else{
            Helper::json_error('Lưu thất bại!');
        }
    }
}