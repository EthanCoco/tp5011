<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Cache;
use think\Config;
use think\Session;
use app\index\model\User;
class Login extends Base{
	public function _initialize(){
		//重写父方法，避免认证
	}
	
	/*登录页面*/
	public function login(){
		return $this->fetch('login/login');
	}
	
	/*登录*/
	public function isLogin(){
		//用户账户
		$ucount = $this->request->post('ucount');
		//密码
		$upass = $this->request->post('upass');
		//是否自动登录
		$isAutoLogin = intval($this->request->post('isAutoLogn',0));
		
		//通过账号获取用户信息
		$info = User::findByKey('ucount',$ucount);
		
		//判断数据是否为空，如果为空则账号不存在
		if(!empty($info)){
			//密码加密处理
			$realUpass =  MD5(hash('sha256', $upass));
			//判断密码是否相等
			if($realUpass != $info['upass']){
				$result = ['code'=>3002];
			//判断账号是否被禁用
			}elseif($info['ustatus'] == 0){
				$result = ['code'=>3003];
			}else{
				//返回成功数据
				$result = ['code'=>200];
				//设置session
				//用户ID
				Session::set('uid',$info['uid']);
				//账号
				Session::set('ucount',$info['ucount']);
				//昵称
				Session::set('uname',$info['uname']);
				//邮箱
				Session::set('uemail',$info['uemail']);
				//用户类型
				Session::set('utype',$info['utype']);
				//用户头像地址
				Session::set('uimageurl',$info['uimageurl']);
				//判断是否自动登录
				if($isAutoLogin == 1){
					//设置自动登录过期时间
					Cache::set($ucount, 1,Config::get('self.auto_login_time'));
				}
				//更新登录记录
				//最后登录时间
				$data['ulasttime'] = date('Y-m-d H:i:s',time());
				//最后登录IP
				$data['uip'] = ip2long(get_client_ip());
				//更新
				User::updateById($info['uid'],$data);
			}
		}else{
			$result = ['code'=>3001];
		}
		//返回结果
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
		//校验验证码是否正确
		if(!captcha_check($verify)){
			return $this->myInfo(['code'=>3004]);
		}
		//通过邮箱获取用户信息
		$info = User::findByKey('uemail',$uemail);
		//判断邮箱是否存在
		if(empty($info)){
			return $this->myInfo(['code'=>3005]);
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
	        	return $this->myInfo(['code'=>3006]);
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
			return $this->myInfo(['code'=>3001]);
		}else{
			//判断账号是否被禁用
			if($info['ustatus'] == 0){
				return $this->myInfo(['code'=>3003]);
			}
			return $this->myInfo(['code'=>200]);
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
	
	/*验证邮箱是否被注册过*/
	public function verifyUemail(){
		//邮箱
		$uemail = $this->request->post('uemail');
		//指定唯一字段邮箱获取信息
		$info = User::findByKey('uemail',$uemail);
		//判断邮箱是否被注册过
		if(!empty($info)){
			return $this->myInfo(['code'=>3010]);
		}
		//发送验证码到邮件
		//收件人
		$to = $uemail;
		//邮件主题
        $title = '验证码';
        //验证码
        $verify = mt_rand(100000,999999);
        //邮件内容
        $content = '您的注册验证码是【'.$verify.'】，请不要泄露！【1小时内有效】';
        //发送邮件
        if(send_mail($to,$title,$content)){
        	//设置缓存
        	Cache::set('REG_CODE_'.$uemail, 1,Config::get('self.reg_verify_time'));
        	return $this->myInfo(['code'=>200,'msg'=>'发送成功']);
        }else{
        	return $this->myInfo(['code'=>3006]);
        }
	}
	
	/*判断账号是否被注册过*/
	public function ucountIsReg(){
		$ucount = $this->request->post('ucount');
		//指定唯一字段用户账号获取信息
		$info = User::findByKey('ucount',$ucount);
		//判断账号是否被注册过
		if(!empty($info)){
			return $this->myInfo(['code'=>3011]);
		}
		return $this->myInfo(['code'=>200]);
	}
	
	/*注册*/
	public function reg(){
		//邮箱
		$uemail = $this->request->post('uemail');
		//验证码
		$verify = $this->request->post('verify');
		//用户账号
		$ucount = $this->request->post('ucount');
		//用户昵称
		$uname = $this->request->post('uname');
		//密码
		$upass = $this->request->post('upass');
		//指定唯一字段邮箱获取信息
		$info = User::findByKey('uemail',$uemail);
		//判断邮箱是否被注册过
		if(!empty($info)){
			return $this->myInfo(['code'=>3010]);
		}
		//指定唯一字段账号获取信息
		$info1 = User::findByKey('ucount',$ucount);
		//判断账号是否被注册过
		if(!empty($info1)){
			return $this->myInfo(['code'=>3011]);
		}
		//验证码
		$vcode= Cache::get('REG_CODE_'.$uemail);
		//判断验证码是否过期
		if(!$vcode){
			return $this->myInfo(['code'=>3007]);
		//判断验证码是否正确
		}elseif($verify != $vcode){
			return $this->myInfo(['code'=>3004]);
		}
		//插入的数据
		$data['ucount'] = $ucount;
		$data['uemail'] = $uemail;
		$data['uname'] = $uname;
		$data['upass'] = MD5(hash('sha256', $upass));
		$data['uregtime'] = date('Y-m-d H:i:s',time());
		//注册用户
		$result = User::add(0,$data);
		if($result){
			return $this->myInfo(['code'=>200,'msg'=>'注册成功']);
		}else{
			return $this->myInfo(['code'=>3012]);
		}
	}
	
}
