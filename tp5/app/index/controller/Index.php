<?php
namespace app\index\controller;
use app\index\model\Index as I;
class Index extends Base{
	/*point home page*/
    public function index(){
    	// get desktop table data to home page 
    	$infos = I::listInfo();
    	//definde jsonData array
    	$jsonData = [];
    	//create url
    	foreach($infos as $info){
    		$jsonData[] = [
    			'openurl'	=>	url($info['openurl']),
    			'iconurl'	=>	$info['iconurl'],
    			'title'	=>	$info['title'],
    		];
    	}
    	// assignment '$info' to 'index' page  
    	$this->assign('info',$jsonData);
		return $this->fetch('index/index');
    }
    
    /************************************************start work area**********************************************/
	/*point user management page*/
	public function user(){
		return $this->fetch('user/index');
	}    
}
