<?php
namespace app\index\controller;
use think\Session;
use think\Validate;
class Base extends \think\Controller{
    /*初始化操作*/
    public function _initialize(){
    	//开发阶段使用
    	//Session::set('uid',1);
    	//获取session ID
		$sessionLogin = Session::get('uid');
		//判断是否登录状态
		if(empty($sessionLogin)){
			//销毁session
			session_destroy();
			//跳转到登录页面
			$this->redirect(url('index/login/login'));
		}
	}
	
    /*返回json数据*/
   	public function myInfo($data){
   		return json($data);exit;
   	}
    
    /*validate function*/
    public function myValidate($validate_data = [],$validate_scene = ''){
    	if(empty($validate_data) || empty($validate_scene)){
    		echo  json_encode(['code'=>300,'msg'=>'传入参数格式不正确，需要两个参数且不为空']);exit;
    	}
    	
    	if(!is_array($validate_data)){
    		echo  json_encode(['code'=>300,'msg'=>'传入参数格式不正确，第一个参数需要数组格式']);exit;
    	}
    	
    	if(!is_string($validate_scene)){
    		echo json_encode(['code'=>300,'msg'=>'传入参数格式不正确，第二个参数需要字符串格式']);exit;
    	}
    	
    	$res = $this->validate($validate_data,$validate_scene);

    	if(true !== $res){
    		echo json_encode(['code'=>300,'msg'=>$res]);exit;
    	}
    }
    
    
	/*上传图片 并 生成缩略图*/
	public function uploadImage(){
		//获取上传图片文件
		$file = $_FILES['image'];
		//获取文件类型
		$type = $_FILES['image']["type"];
		//当前时间
		$timeNow = date('Y-m-d H:i:s',time());
		//年月
		$timeNowMonth = date('Ym',time());
		//图片后缀
		$type = substr($_FILES['image']['name'], strpos($_FILES['image']['name'], '.')+1);
		//临时文件
		$tmpfile = time();
		//文件名
		$fileName = $tmpfile.'.'.$type;
		//判断图片格式
		if(!in_array($type, ['jpg','gif','png','JPG','GIF','PNG'])){
			return ['code'=>3013];
		}
		//判断图片大小
		if($_FILES['image']['size'] > 2*1024*1024){
			return ['code'=>3014];
		}
		//存储路径（项目）
		$createDir = './uploads/'.$timeNowMonth;
		//存储路径（数据库）
		$saveDir = str_replace('\\','/',ROOT_PATH) . '/uploads/'.$timeNowMonth;
		//创建目录
		mkdirs($createDir);
		move_uploaded_file($_FILES['image']['tmp_name'], $createDir."/".$fileName);
		
		//生成缩略图
		//打开图片
		$image = \think\Image::open($createDir."/".$fileName);
		//缩略图名称
		$thumbName = explode('.', $fileName)[0].'_thumb.jpg';
		//生成缩略图
		$image->thumb(150,150,\think\Image::THUMB_CENTER)->save($createDir."/".$thumbName);
		//返回结果
		return ['code'=>200,'data'=>['info'=>$saveDir."/".$thumbName]];
	}
   
}
