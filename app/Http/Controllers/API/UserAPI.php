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
                    return Helper::json_error('Thông tin tài khoản không chính xác!');
                }
            }
        }else{
            return Helper::json_error('Tài khoản hoặc mật khẩu không được để trống!');
        }
        
    } 
    //kiểm tra tk tồn tại trong hệ thống
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
                    return Helper::json_error('Bạn đã gửi yêu cầu quá số lần cho phép!');
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
            return Helper::json_success('Email xác nhận được gửi về hộp thư của bạn. Vui lòng xác nhận để đặt lại mật khẩu!');
        }
        
    }
    //tạo link reset
    function create_link_reset(Request $request){
        $cp = new Company;
		$result = $cp->crm_company_update([
			"id"=>$request->input('id'),
			"fields"=>["UF_CRM_1618939379772"=>1]
		]);
        return Helper::json_success('Email xác nhận được gửi về hộp thư của bạn. Vui lòng xác nhận để đặt lại mật khẩu!');
    }
    //xác nhận reset
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
                return Helper::json_error('Cập nhật thất bại!');
            }
        }else{
            return Helper::json_error('Cập nhật thất bại!');
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
            return Helper::json_sucess('Cập nhật thành công');
        }else{
            return Helper::json_error('Độ dài tối thiểu 8 ký tự, phải có chứa ký tự in hoa và các ký tự đặc biệt (!,@,#,$,&,*)');
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