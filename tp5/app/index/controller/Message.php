<?php
namespace app\index\controller;
//use think\Request;
use think\Session;
use app\index\model\Message as Msg;
class Message extends Base{
	/*获取消息列表*/
    public function listinfo(){
    	//展示列表数据类型（1=收件信息，2=发件信息，3=未读信息）
		$type = $this->request->post('type');
		//获取数据信息
		$result = Msg::listinfo($type,Session::get('uid'));
		//返回数据
		return $this->myInfo(['code'=>200,'data'=>$result]);
    }
    
    /*修改消息状态（未读，已读，删除）*/
   	public function dealMessage(){
   		//需要处理成的状态(1=未读，2=已读，0=删除)
   		$mstatus = $this->request->post('mstatus');
   		//需要处理的数据ID（字符串格式）
   		$mid = $this->request->post('mid');
   		//去除拼接的ID
   		$mid = rtrim($mid, ','); 
   		//处理状态
   		$result = Msg::updateMsg(['mstatus'=>$mstatus],['mid'=>['in',(string)$mid]]);
   		//返回结果值
   		return $this->myInfo($result);
   	}
   	
   	/*获取一条详细消息*/
   	public function getSingleMsg(){
   		//消息ID
   		$mid = $this->request->post('mid');
   		//获取消息相关信息
   		$info = Msg::findSingleMsg($mid);
   		//返回结果集
   		return $this->myInfo(['code'=>200,'data'=>$info]);
   	}
   	
   	
   	/*短消息备份*/
  	public function backMessage(){
  		//用户账号
  		$ucount = $this->request->post('ucount','');
  		//获取需要备份的数据
  		$result = Msg::getMsgInfos(Session::get('uid'),$ucount);
  		//判断是否出错
  		if($result['code'] != 200){
  			return $this->myInfo($result);
  		}else{
  			//备份消息
  			$fileName = date('Y-m-d',time()).time().'.txt';
  			header("Content-Type: application/octet-stream");      
			if (preg_match("/MSIE/", $_SERVER['HTTP_USER_AGENT']) ) {      
			    header('Content-Disposition:  attachment; filename="' . $fileName . '"');      
			} elseif (preg_match("/Firefox/", $_SERVER['HTTP_USER_AGENT'])) {      
			    header('Content-Disposition: attachment; filename*="utf8' .  $fileName . '"');      
			} else {      
			    header('Content-Disposition: attachment; filename="' .  $fileName . '"');      
			}
  			if(!empty($result['data'])){
  				foreach($result['data'] as $info){
  					echo "发送时间：".$info['mtime']."\r\n";
  					echo "发送人：".$info['uname']."\r\n";
  					echo "标题：".$info['mtitle']."\r\n";
  					echo "内容："."\r\n";
  					echo "\r\n";
  					echo $info['mcontent']."\r\n";
  					echo "\r\n";
  				}
  			}else{
  				echo "";
  			}
  		}
  	}
  	
  	/*保存短消息*/
  	public function saveMessage(){
  		//收件者
  		$ucount = $this->request->post('ucount');
  		//标题
  		$mtitle = $this->request->post('mtitle');
  		//内容
  		$mcotent = $this->request->post('mcontent');
  		//数据
  		$data['mtitle'] = $mtitle;
  		$data['mcontent'] = $mcotent;
  		//消息状态默认为1
  		$data['mstatus'] = 1;
  		//发送时间
  		$data['mtime'] = date('Y-m-s H:i:s',time());
  		//发送者ID
  		$data['muid'] = Session::get('uid');
  		
  		//发送信息
  		$result = Msg::saveMsgInfo($ucount,$data);
  		//返回结果集
  		return $this->myInfo($result);
  	}
  	
  	
}
