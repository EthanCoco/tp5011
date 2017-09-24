<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Cache;
use think\Config;
use think\Session;
use think\Validate;
use app\index\model\User;
class Login extends Base{
	public function _initialize(){
		//rewrite parent initialize function
	}
	
	/*point login page*/
	public function login(){
		return $this->fetch('login/login');
	}
	
	/*login*/
	public function isLogin(){
		// user acount
		$ucount = $this->request->post('ucount');
		// user password 
		$upass = $this->request->post('upass');
		//is auto login 
		//$isAutoLogin = intval($this->request->post('isAutoLogn',0));
		//validate the login rule of scene
		$this->myValidate(['ucount'=>$ucount,'upass'=>$upass],'User.login');
		//get user data by user acount 
		$info = User::findByKey('ucount',$ucount);
		
		// if data is empty then show user acount is not exists
		if(!empty($info)){
			//user password encryption with md5
			$realUpass =  MD5(hash('sha256', $upass));
			//is same with user data of password
			if($realUpass != $info['upass']){
				$result = ['code'=>300,'msg'=>'密码不正确'];
			//the acount is disable
			}elseif($info['ustatus'] == 0){
				$result = ['code'=>300,'msg'=>'账号被禁用'];
			}else{
				//return data
				$result = ['code'=>200,'msg'=>'登录成功'];
				//set session
				//user ID
				Session::set('uid',$info['uid']);
				//acount
				Session::set('ucount',$info['ucount']);
				//nickname 
				Session::set('uname',$info['uname']);
				//email 
				Session::set('uemail',$info['uemail']);
				//user type 
				Session::set('utype',$info['utype']);
				//user head image url 
				Session::set('uimageurl',$info['uimageurl']);
				//User login times
				Session::set('ulogintime',intval($info['ulogintime']) + 1);
				
				//auot login is true 
				//if($isAutoLogin == 1){
					//set the auto login of the expiration date 
				//	Cache::set($ucount, 1,Config::get('self.auto_login_time'));
				//}
				//update login record
				//last login time 
				$data['ulasttime'] = date('Y-m-d H:i:s',time());
				//last login ip 
				$data['uip'] = ip2long($this->request->ip());
				//update login times
				$data['ulogintime'] = intval($info['ulogintime']) + 1;
				//update information
				User::updateById($info['uid'],$data);
			}
		}else{
			$result = ['code'=>300,'msg'=>'账号不存在'];
		}
		//return result
		return $this->myInfo($result);
	}
	
	/*找回账号页面*/
	public function getAcountPage(){
		return $this->fetch('login/getAcountpage');
	}
	
	/*找回用户账号*/
	public function getAcount(){
		//邮箱
		$uemail = $this->request->post('uemail');
		//验证码
		$verify = $this->request->post('verify');
		//验证邮箱
		$this->myValidate(['uemail'=>$uemail],'User.findCount');
		//校验验证码是否正确
		if(!captcha_check($verify)){
			return $this->myInfo(['code'=>300,'msg'=>'验证码不正确']);
		}
		//通过邮箱获取用户信息
		$info = User::findByKey('uemail',$uemail);
		//判断邮箱是否存在
		if(empty($info)){
			return $this->myInfo(['code'=>300,'mag'=>'邮箱不存在']);
		}else{
			//收件人
			$to = $info['uemail'];
			//邮件主题
	        $title = '找回账号';
	        //邮件内容
	        $content = '您的账号是【'.$info['ucount'].'】，请熟记您的账号！';
	        //发送邮件
	        if(send_mail($to,$title,$content)){
	        	return $this->myInfo(['code'=>200,'msg'=>'发送成功']);
	        }else{
	        	return $this->myInfo(['code'=>3006,'msg'=>'邮件发送失败，请稍后再试']);
	        }
		}
	}
	
	/*验证账号是否存在*/
	public function verifyUcount(){
		//用户账号
		$ucount = $this->request->post('ucount');
		//指定唯一字段用户账号获取信息
		$info = User::findByKey('ucount',$ucount);
		//判断账号是否存在
		if(empty($info)){
			return $this->myInfo(['code'=>300,'msg'=>'账号不存在']);
		}else{
			//判断账号是否被禁用
			if($info['ustatus'] == 0){
				return $this->myInfo(['code'=>300,'msg'=>'账号被禁用']);
			}
			return $this->myInfo(['code'=>200,'msg'=>'']);
		}
	}
	
	/*发送验证码邮箱接收*/
	public function getMailCode(){
		$uemail = $this->request->post('uemail');
		//指定唯一字段邮箱获取信息
		$info = User::findByKey('uemail',$uemail);
		if(empty($info)){
			return $this->myInfo(['code'=>3005]);
		}else{
			//判断账号是否被禁用
			if($info['ustatus'] == 0){
				return $this->myInfo(['code'=>3003]);
			}
			//收件人
			$to = $info['uemail'];
			//邮件主题
	        $title = '验证码';
	        //验证码
	        $verify = mt_rand(100000,999999);
	        //邮件内容
	        $content = '您的验证码是【'.$verify.'】，请不要泄露！【5分钟内有效】';
	        //发送邮件
	        if(send_mail($to,$title,$content)){
	        	//设置缓存
	        	Cache::set($uemail, 1,Config::get('self.mail_verify_time'));
	        	return $this->myInfo(['code'=>200,'msg'=>'发送成功']);
	        }else{
	        	return $this->myInfo(['code'=>3006]);
	        }
		}
	}
	
	/*重置密码验证*/
	public function resetVerify(){
		//用户账号
		$ucount = $this->request->post('ucount');
		//用户邮箱
		$uemail = $this->request->post('uemail');
		//验证码
		$verify = $this->request->post('verify');
		//获取缓存验证码
		$vcode = Cache::get($uemail);
		//判断验证码是否过期
		if($vcode){
			//判断验证码是否正确
			if($vcode != $verify){
				return $this->myInfo(['code'=>3004]);
			}
		}else{
			return $this->myInfo(['code'=>3007]);
		}
		//指定唯一字段用户账号获取信息
		$info = User::findByKey('ucount',$ucount);
		//判断用户是否存在
		if(!empty($info)){
			//判断账号是否被禁用
			if($info['ustatus'] == 0){
				return $this->myInfo(['code'=>3003]);
			}
			//判断邮箱是否存在
			if($uemail != $info['uemail']){
				return $this->myInfo(['code'=>3005]);
			}
			//邮箱和密码加密key值
			$key = md5($uemail.$info['upass']);
			//邮箱加key生成字符串值
			$str = base64_encode($uemail.'+'.$key);
			//当前时间
			$time = time();
			//加密code
			$code = md5(Config::get('self.secret_str').$time);
			//生成get字符串值
			$returnStr = "uid=".$info['uid']."&str=".$str."&code=".$code."&time=".$time;
			//设置链接的有效期(十分钟)
			Cache::set('MOD_PWD_'.$uemail, $info['uid'],600);
			//返回字符
			return $this->myInfo(['code'=>200,'data'=>['str'=>$returnStr]]);
		}else{
			return $this->myInfo(['code'=>3001]);
		}
	}
	
	/*重置密码动作*/
	public function resetPwd(){
		//用户ID
		$uid = $this->request->post('uid','');
		//email+key字符值
		$string = $this->request->post('str','');
		//加密字符+时间加密
		$code = $this->request->post('code','');
		//时间
		$time = $this->request->post('time','');
		//新密码
		$upass = $this->request->post('upass','');
		//判断是否缺少必须验证项
		if($uid == '' || $string == '' || $code == '' || $time == ''){
			return $this->myInfo(['code'=>3000]);
		}
		//转码
		$str = base64_decode($string);
		//分开邮箱和key
		$arr = explode('+',$str);
		//邮箱
		$uemail = $arr[0];
		//获取缓存值ID
		$checkId = Cache::get('MOD_PWD_'.$uemail);
		//判断是否过期
		if(!$checkId){
			return $this->myInfo(['code'=>3008]);
		//判断uid是否被修改
		}elseif($checkId != $uid){
			return $this->myInfo(['code'=>3000]);
		}
		//获取用户信息
		$info = User::findByKey('uemail',$uemail);
		//拼接key值判断
		$key = md5($email.$info['upass']);
		//判断key值是否相等
		if($key != $arr[1]){
			return $this->myInfo(['code'=>3000]);
		}
		//生成code判断
		$codeR = md5(Config::get('self.secret_str').$time);
		//判断code是否被修改
		if($code != $codeR){
			return $this->myInfo(['code'=>3000]);
		}
		//更新密码
		$flag = User::updateById($checkId,['upass'=>MD5(hash('sha256', $upass))]);
		//判断修改是否成功
		if($flag !== false){
			return $this->myInfo(['code'=>200,'msg'=>'修改密码成功']);
		}else{
			return $this->myInfo(['code'=>3009]);
		}
	}
	
	/*judge email was already register*/
	public function verifyUemail(){
		//email
		$uemail = $this->request->post('uemail');
		$this->myValidate(['uemail'=>$uemail],'User.is_reg_uemail');
		//point the unique column of uemail and get datas
		//$info = User::findByKey('uemail',$uemail);
		//judge email was already register 
		//if(!empty($info)){
		//	return $this->myInfo(['code'=>3010]);
		//}
		
		//send verify code to user email
		//reciver
		$to = $uemail;
		//theme
        $title = '验证码';
        //verify code
        $verify = mt_rand(100000,999999);
        //content
        $content = '您的注册验证码是【'.$verify.'】，请不要泄露！【1小时内有效】';
        //set cache
        Cache::set('REG_CODE_'.$uemail, 1,Config::get('self.reg_verify_time'));
        //send
        if(send_mail($to,$title,$content)){
        	return $this->myInfo(['code'=>200,'msg'=>'发送成功']);
        }else{
        	//delete cache
        	Cache::rm('REG_CODE_'.$uemail); 
        	return $this->myInfo(['code'=>300,'msg'=>'发送邮件失败，请稍后再试']);
        }
	}
	
	/*judge acount was already register*/
	public function ucountIsReg(){
		$ucount = $this->request->post('ucount');
		$this->myValidate(['ucount'=>$ucount],'User.is_reg_ucount');
		//point the unique column of uemail and get datas
		//$info = User::findByKey('ucount',$ucount);
		//judge acount was already register 
		//if(!empty($info)){
		//	return $this->myInfo(['code'=>3011]);
		//}
		return $this->myInfo(['code'=>200,'msg'=>'恭喜你，此账号可以使用']);
	}
	
	/*register*/
	public function reg(){
		//user email
		$uemail = $this->request->post('uemail');
		//verify code
		$verify = $this->request->post('verify');
		//user acount
		$ucount = $this->request->post('ucount');
		//user nickname
		$uname = $this->request->post('uname');
		//user password
		$upass = $this->request->post('upass');
		
		//validate register columns 
		$this->myValidate([
			'uemail'	=> $uemail,
			'verify'	=> $verify,
			'ucount'	=> $ucount,
			'uname'		=> $uname,
			'upass'		=> $upass,
		],'User.register');
		//point the unique column of uemail and get datas
		//$info = User::findByKey('uemail',$uemail);
		//judge email was already register 
		//if(!empty($info)){
		//	return $this->myInfo(['code'=>3010]);
		//}
		////point the unique column of uemail and get datas
		//$info1 = User::findByKey('ucount',$ucount);
		//judge acount was already register 
		//if(!empty($info1)){
		//	return $this->myInfo(['code'=>3011]);
		//}
		//get cache verify code 
		$vcode= Cache::get('REG_CODE_'.$uemail);
		//judge the verify code was already over time 
		if(!$vcode){
			return $this->myInfo(['code'=>300,'msg'=>'验证码已过期，请重新发送']);
		//judge the verify code is right
		}elseif($verify != $vcode){
			return $this->myInfo(['code'=>300,'msg'=>'验证码错误']);
		}
		//will need insert to database data
		$data['ucount'] = $ucount;
		$data['uemail'] = $uemail;
		$data['uname'] = $uname;
		$data['upass'] = MD5(hash('sha256', $upass));
		$data['uregtime'] = date('Y-m-d H:i:s',time());
		//register user
		$result = User::add(0,$data);
		if($result){
			return $this->myInfo(['code'=>200,'msg'=>'注册成功']);
		}else{
			return $this->myInfo(['code'=>300,'msg'=>'注册失败，请稍后再试']);
		}
	}
	
}
