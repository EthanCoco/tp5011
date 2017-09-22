<?php
namespace app\index\model;
use think\Model;
use think\Db;
class Index extends Model{
	public static function listMenuInfo(){
		$infos = Db::name('desktop')
									->field('openurl,iconurl,title,fai')
									->where('status',1)
									->order('ordersrot')
									->select();
									
    	$jsonData = [];
    	
    	foreach($infos as $info){
    		$jsonData[] = [
    			'openurl'	=>	url($info['openurl']),
    			'iconurl'	=>	$info['iconurl'],
    			'title'		=>	$info['title'],
    			'color'		=>	randrgb(),
    			'fai'		=>	$info['fai'],
    		];
    	}
    	
		return $jsonData;
	}
	
	public static function listDesktopInfo($uid = ''){
		$infos = Db::name('desktop')
									->join('__USER_DESKTOP__','desktopid = id','inner')
									->field('openurl,iconurl,title,fai')
									->where('status',1)
									->where('uid',$uid)
									->order('ordersrot')
									->select();
									
    	$jsonData = [];
    	
    	foreach($infos as $info){
    		$jsonData[] = [
    			'openurl'	=>	url($info['openurl']),
    			'iconurl'	=>	$info['iconurl'],
    			'title'		=>	$info['title'],
    			'color'		=>	randrgb(),
    			'fai'		=>	$info['fai'],
    		];
    	}
    	
		return $jsonData;
	}
	
	
}
