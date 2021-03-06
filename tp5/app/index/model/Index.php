<?php
namespace app\index\model;
use think\Model;
use think\Db;
class Index extends Model{
	public static function listMenuInfo(){
		$folders = Db::name('menuFolder')->select();
		$jsonData = [];
		foreach($folders as $f){
			$infos = Db::name('desktop')
									->field('openurl,iconurl,title,fai')
									->where('status',1)
									->where('menupid',$f['mid'])
									->order('ordersrot')
									->select();
			if(!empty($infos)){
				$tempData = [];
		    	foreach($infos as $info){
		    		$tempData[] = [
		    			'openurl'	=>	url($info['openurl']),
		    			'iconurl'	=>	$info['iconurl'],
		    			'title'		=>	$info['title'],
		    			'color'		=>	randrgb(),
		    			//'fai'		=>	$info['fai'],
		    		];
		    	}
		    	$jsonData[] = [
					'name' 		=> 	$f['mname'],
					'mfa'  		=> 	$f['mfa'],
					'mcolor'	=>	randrgb(),
					'sub'		=>  $tempData
				];
			}
		}
		//dump($jsonData);exit;
		return $jsonData;
	}
	
	public static function listDesktopInfo($uid = ''){
		$unionQuery = Db::name('desktop')
									->join('__USER_DESKTOP__','desktopid = id','inner')
									->field('openurl,iconurl,title,fai')
									->where('status',1)
									->where('sysdef',0)
									->where('uid',$uid)
									//->order('ordersrot')
									->select(false);
									
    	$infos = Db::name('desktop')
									->join('__USER_DESKTOP__','desktopid = id','left')
									->field('openurl,iconurl,title,fai')
									->where('status',1)
									->where('sysdef',1)
									->where('uid is null')
									->union($unionQuery,true)
									//->order('ordersrot')
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
	
	public static function listMessage($uid){
		$unionQuery  = Db::name('newmsg')->alias('a')
										 ->field('a.msgid,a.title,a.content,a.fun,a.type,a.sendid,a.reciveid,a.status,a.sendtime,0 id')
										 ->where('a.status',0)
										 ->where('a.reciveid',$uid)
										 ->where('a.type',2)
										 ->order('sendtime desc')
										 ->select(false);
		$infos = Db::name('newmsg')->alias('a')
								   ->join('__USER_NEWMSG__ b','b.msgid=a.msgid and b.uid='.$uid,'left')
								   ->where('a.type',1)
								   ->where('uid is null')
								   ->field('a.msgid,a.title,a.content,a.fun,a.type,a.sendid,a.reciveid,a.status,a.sendtime,b.id')
								   ->union($unionQuery,true)
								   ->select();
		return $infos;
	}
	
	public static function readMsg($type,$extra,$uid){
		if($type == 1){
			Db::name('userNewmsg')->insert(['uid'=>$uid,'msgid'=>$extra,'status'=>1]);
		}elseif($type == 2){
			Db::name('newmsg')->where('msgid',$extra)->update(['status'=>1]);
		}
	}
	
}
