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
    
    /*logout this system*/
    public function logout(){
    	session_destroy();
    	$this->redirect(url('index/login/login'));
    }
    
    
    /************************************************start work area**********************************************/
	/*point user management page*/
	public function user(){
		return $this->fetch('user/index');
	}    
}
