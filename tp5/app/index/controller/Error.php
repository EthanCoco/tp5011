<?php
namespace app\index\controller;
use think\Request;
/**
 * 空控制器定义
 */
class Error{
	public function index(Request $req){
		$name = $req->controller();
		return '控制器【'.$name.'】不存在';
	}
	
}
