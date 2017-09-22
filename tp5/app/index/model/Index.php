<?php
namespace app\index\model;
use think\Model;
use think\Db;
class Index extends Model{
	public static function listInfo(){
		$infos = Db::name('desktop')
									->field('openurl,iconurl,title')
									->where('status',1)
									->order('ordersrot')
									->select();
		return $infos;
	}
	
	
}
