<?php
namespace app\index\controller\test;
use think\Controller;
use think\Request;
class Test extends Controller{
	public function index(Request $req){
		$info = $req::instance()->param();
		dump($info);
//		$event = \think\Loader::controller('Testevent', 'event');
//		echo $event->insert(); 
		return "多级控制器测试";
	}
}
