<?php
namespace app\index\controller;
use think\Session;
use app\index\model\Desktop as D;
use app\index\model\Index as I;
class Desktop extends Base{
	/*list treegrid*/
	public function listInfo(){
		// get desktop tree table datas
		$infos = D::getListInfo(Session::get('uid'));
		// return the datas
		return $this->myInfo($infos);
	}
	
	/*show and hide the function in the desktop*/
	public function ShowHide(){
		// will deal type show and hide
		$type = $this->request->post('type');
		// user defined functions
		$sysdef_ids0 = $this->request->post('sysdef_ids0');
		// system default functions 
		$sysdef_ids1 = $this->request->post('sysdef_ids1');
		// do show and hide operate
		$result = D::showHide(Session::get('uid'),$type,json_decode($sysdef_ids0),json_decode($sysdef_ids1));
		// return the result
		return $this->myInfo($result);
	}
}
