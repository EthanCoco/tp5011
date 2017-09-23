<?php
namespace app\index\controller;
use think\Session;
use app\index\model\Desktop as D;

class Desktop extends Base{
	public function listInfo(){
		$infos = D::getListInfo($id,Session::get('uid'));
		return $this->myInfo($infos);
	}
}
