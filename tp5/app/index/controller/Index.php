<?php
namespace app\index\controller;
use think\Session;
use app\index\model\Index as I;
class Index extends Base{
	/*point home page*/
    public function index(){
    	// get all data to menu page 
    	$menuInfos = I::listMenuInfo();
    	//get use set desktop info to home page 
    	$desktopInfos = I::listDesktopInfo(Session::get('uid'));
    	
    	// assignment information 'index' page  
    	$this->assign(['menuInfo'=>$menuInfos,'desktopInfo'=>$desktopInfos]);
    	
		return $this->fetch('index/index');
    }
    
    /*show user messsage for not read*/
    public function showMsgInfo(){
    	// get user not read message include friend nessage and system message 
    	$infos = I::listMessage(Session::get('uid'));
    	// return results
    	return $this->myInfo($infos);
    }
    
    /*read msg*/
    public function readMsg(){
    	// the message type
    	$type = $this->request->post('type');
    	// will deal with data id
    	$extra = $this->request->post('extra');
    	// deal and do something
    	I::readMsg($type,$extra,Session::get('uid'));
    	// return the result
    	return $this->myInfo(['code'=>200]);
    }
    
    /*logout this system*/
    public function logout(){
    	session_destroy();
    	$this->redirect(url('index/login/login'));
    }
    
    
    /************************************************start work area**********************************************/
	/*point company website*/
	public function comwebsite(){
		return $this->fetch(APP_PATH.request()->module().'/view/default/public/website.html');
	}
	
	/*point user manual page*/
	public function usermanual(){
		return $this->fetch(APP_PATH.request()->module().'/view/default/public/manual.html');
	}
	
	/*point else help page*/
	public function help(){
		return $this->fetch(APP_PATH.request()->module().'/view/default/public/help.html');
	}
	
	/*point user management page*/
	public function user(){
		return $this->fetch('index/user/user');
	}
	
	/*point desktop set page*/
	public function desktop(){
		return $this->fetch('index/system/desktop');
	}    
}
