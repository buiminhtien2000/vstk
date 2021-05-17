<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use \App\Bitrix\Deal;
use \App\Helper;

class DealAPI extends Controller
{
	function get_pipeline(){
        $deal = new Deal;
		$result = $deal->crm_dealcategory_list([
			"order"=> ["ID" => "ASC" ]
		]);
        return $result;
    }
    function get_stage(Request $request){
        $deal = new Deal;
        $id_pipeline = $request->input('id_pipeline');
		$result = $deal->crm_dealcategory_stage_list([
			"id"=> $id_pipeline
		]);
        return $result;
    }
    function get_deal(Request $request){
        $deal = new Deal;
        $id_pipeline = $request->input('id_pipeline');
        $id_user = $request->input('id_user');
        $result = $deal->crm_deal_list([
			"order"=> [
                "DATE_CREATE"=> "DESC"
            ],
            "filter"=> [
                "=CREATED_BY_ID"=> $id_user,
                "CATEGORY_ID"=>$id_pipeline
            ]
		]);
        return $result;
    }
}