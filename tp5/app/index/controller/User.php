<?php
namespace app\index\controller;
use think\Cache;
use think\Config;
use think\Session;
use app\index\model\User as U;
class User extends Base{
	/*用户信息首页*/
	public function index(){
		return $this->fetch('user/index');
	}
	
	/*上传图片*/
	public function upload(){
		//上传图片并处理图片
		$result = $this->uploadImage();
		//返回结果
		return $this->myInfo($result);
	}
	
	/*保存头像*/
	public function saveUimage(){
		$uimage = $this->request->post('uimage');
		$result = U::updateById(Session::get('uid'),['uimageurl'=>$uimage]);
		if($result){
			return $this->myInfo(['code'=>200]);
		}else{
			return $this->myInfo(['code'=>3009]);
		}
	}
	
	/*获取个人信息*/
	public function profile(){
		//获取展示信息的类型（0=基本信息，1=个人信息，2=联系方式）
		$type = $this->request->post('type');
		//获取信息
		$info = U::getProfile($type,Session::get('uid'));
		
		return $this->myInfo(['code'=>200,'data'=>$info]);
	}
	
	/*批量保存个人信息*/
	public function saveProfile(){
		//获取保存的信息
		$info = $this->request->post('info');
		//示例代码
		//$info = [['name','lucy',0,0],['gender',1,0,0],['marry',1,0,0],['字段名','字段值','可见设置','是否显示在首页']];
		//保存所属类型
		$type = $this->request->post('type');
		//数据大小
		$len = count($info);
		//用户ID
		$uid = Session::get('uid');
		//需要保存的数据
		$data = [];
		for($i = 0;$i<$len;$i++){
			$data[$i] = [
				'cname' => $info[$i][0],
				'cvalue'=> $info[$i][1],
				'cseen' => $info[$i][2],
				'chome' => $info[$i][3],
				'ctype' => $type,
				'uid'   => $uid
			];
		}
		//批量添加个人信息
		$flag = U::addProfile($type,$uid,$data);
		if($flag){
			return $this->myInfo(['code'=>200]);
		}else{
			return $this->myInfo(['code'=>3009]);
		}
	}
	
	/*修改昵称*/
	public function modNickName(){
		$uname = $this->request->post('uname');
		$flag = U::updateById(Session::get('uid'),['uname'=>$uname]);
		if($flag){
			return $this->myInfo(['code'=>200,'mag'=>'修改成功']);
		}else{
			return $this->myInfo(['code'=>3009]);
		}
	}
	
	/*修改账号名*/
	public function modUcount(){
		//账号
		$ucount = $this->request->post('ucount');
		//修改账号信息
		$result = U::updateUcount(Session::get('uid'),$ucount);
		//返回结果值
		return $this->myInfo($result);
	}
	
	/*修改密码*/
	public function modPwd(){
		//旧密码
		$oldpass = $this->request->post('oldpass');
		//新密码
		$newpass = $this->request->post('newpass');
		//修改验证密码
		$result = U::updatePwd(Session::get('uid'),$oldpass,$newpass);
		//返回结果值
		return $this->myInfo($result);
	}
	
	/*修改邮箱*/
	public function modUemail(){
		//密码
		$upass = $this->request->post('upass');
		//邮箱
		$uemail = $this->request->post('uemail');
		//修改验证邮箱
		$result = U::updateUemail(Session::get('uid'),$upass,$uemail);
		//返回结果值
		return $this->myInfo($result);
	}
	
	/*退出登录*/
	public function logout(){
		//销毁session
		session_destroy();
		//跳转到登录页面
		$this->redirect(url('index/login/login'));
	}
}