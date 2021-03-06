<?php

namespace App\Http\Controllers\API;
session_start();
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use \App\Bitrix\Company;
use \App\Helper;

class UserAPI extends Controller
{
    function page_login(){
        return view('login.index');
    }
    function page_reset_pass(){
        return view('user.resetpass');
    }
    function page_create_new_pass(){
        return view('user.createnewpass');
    }
    function logout(){
        setcookie("vstk-login", "", time()-83600);
        return view('login.index');
    }
	function login(Request $request){
        $cp = new Company;
        $acount = Helper::replace_html($request->input('email'));
        $password = Helper::replace_html($request->input('password'));
        $remember = Helper::replace_html($request->input('remember'));
        if($acount != "" && $password !=""){
            $result = $cp->crm_company_list([
                "filter"=>["EMAIL"=>$acount,"UF_CRM_1618939334410"=>md5(trim($password))]
            ]);
            if(is_string($result)||is_object($result)){
                $result = json_decode($result,true);
                if(isset($result['result']) && count($result['result'])>0){
                    if(count($result['result'])>0){
                        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
                        $size = strlen( $chars );
                        $str='VSTK-';
                        for( $i = 0; $i < 150; $i++ ) {
                            $str .= $chars[ rand( 0, $size - 1 ) ];
                        }
                        $user = json_encode([$result['result'][0]['ID'],$acount,$password]);
                        setcookie('vstk-login',$user, time() + (10800), "/");
                        if($remember == true){
                            setcookie('user',$user, time() + (86400 * 30), "/");
                        }else{
                            setcookie("user", "", time() - 3600);
                        }
                        return true;
                    }
                }else{
                    return Helper::json_error('Th??ng tin t??i kho???n kh??ng ch??nh x??c!');
                }
            }
        }else{
            return Helper::json_error('T??i kho???n ho???c m???t kh???u kh??ng ???????c ????? tr???ng!');
        }
        
    } 
    //ki???m tra tk t???n t???i trong h??? th???ng
    function check_email_user(Request $request){
        $cp = new Company;
        $message = '';
        $result = [];
        $email = Helper::replace_html($request->input('email'));
        $ip_client = $this->get_ip_address(); 
        if(isset($_SESSION[$ip_client])){
            if(time()<$_SESSION[$ip_client][1]+60){
                if($_SESSION[$ip_client][0] < 10){
                    $_SESSION[$ip_client][0]++;
                    $message = $_SESSION[$ip_client][0];
                    $result = $cp->crm_company_list([
						"filter"=>["EMAIL"=>$email]
					]);
                    $result = json_decode($result);
                }else{
                    return Helper::json_error('B???n ???? g???i y??u c???u qu?? s??? l???n cho ph??p!');
                }
            }else{
                $_SESSION[$ip_client][1] = time();
                $_SESSION[$ip_client][0] = 1;
                $result = $cp->crm_company_list([
					"filter"=>["EMAIL"=>$email]
				]);
                $result = json_decode($result);
            }
        }else{
            $_SESSION[$ip_client]=[1,time()];
            $result = $cp->crm_company_list([
				"filter"=>["EMAIL"=>$email]
			]);
            $result = json_decode($result,true);
        }
        if(isset($result['result'])&&count($result['result'])>0){
            return $result['result'][0];
        }else{
            return Helper::json_success('Email x??c nh???n ???????c g???i v??? h???p th?? c???a b???n. Vui l??ng x??c nh???n ????? ?????t l???i m???t kh???u!');
        }
        
    }
    //t???o link reset
    function create_link_reset(Request $request){
        $cp = new Company;
		$result = $cp->crm_company_update([
			"id"=>$request->input('id'),
			"fields"=>["UF_CRM_1618939379772"=>1]
		]);
        return Helper::json_success('Email x??c nh???n ???????c g???i v??? h???p th?? c???a b???n. Vui l??ng x??c nh???n ????? ?????t l???i m???t kh???u!');
    }
    //x??c nh???n reset
    function confirm_reset(Request $request){
        $cp = new Company;
        $password = trim(Helper::replace_html($request->input('password')));
        $id = trim(Helper::replace_html($request->input('id')));
        $code = trim(Helper::replace_html($request->input('code')));
		$result = $cp->crm_company_list([
			"filter"=>[
				'=ID' => $id,
				'=UF_CRM_1618939432985' => $code
			]
		]);
        $result = json_decode($result,true);
        if(isset($result['result'])){
            if(count($result['result'])>0){
                return $this->save_pass(["id"=>$id,"password"=>$password]);
            }else{
                return Helper::json_error('C???p nh???t th???t b???i!');
            }
        }else{
            return Helper::json_error('C???p nh???t th???t b???i!');
        }
    }
    function save_pass($param){
        $cp = new Company;
        $reg = preg_match("#^(?=.*[A-Z])(?=.*[!\@\#\$\&\*]).{8}#", $param['password']);
        if($reg == 1){
            $result = $cp->crm_company_update([
                "id" => $param['id'],
                "fields"=>[
                    'UF_CRM_1618939334410' => md5($param['password'])
                ]
            ]);
            return Helper::json_sucess('C???p nh???t th??nh c??ng');
        }else{
            return Helper::json_error('????? d??i t???i thi???u 8 k?? t???, ph???i c?? ch???a k?? t??? in hoa v?? c??c k?? t??? ?????c bi???t (!,@,#,$,&,*)');
        }
    }
    function get_ip_address() { 
        if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
            $ip = $_SERVER['HTTP_CLIENT_IP'];  
        }  
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
        }  
        else{  
            $ip = $_SERVER['REMOTE_ADDR'];  
        }  
        return $ip;  
    }
}