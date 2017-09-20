<?php
namespace app\index\model;
use think\Model;
use think\Db; 
class Message extends Model{
	/*获取消息列表数据*/
	public static function listinfo($type,$uid){
		if($type == 1){
			$info = Db::name('msg')->alias('a')
								   ->join('__USER__ b','b.uid=a.muid','left')
								   ->where('a.mstatus','in',[1,2])
								   ->where(['a.uid'=>$uid])
								   ->order('a.mtime desc')
								   ->field('a.mid,a.mtitle,a.mtime,a.muid,b.uname')
								   ->select(); 
		}elseif($type == 2){
			$info = Db::name('msg')->alias('a')
								   ->join('__USER__ b','b.uid=a.uid','left')
								   ->where('a.mstatus','in',[1,2])
								   ->where(['a.muid'=>$uid])
								   ->order('a.mtime desc')
								   ->field('a.mid,a.mtitle,a.mtime,a.uid,b.uname')
								   //->fetchSql(true)
								   ->select();
		}elseif($type == 3){
			$info = Db::name('msg')->alias('a')
								   ->join('__USER__ b','b.uid=a.muid','left')
								   ->where(['a.uid'=>$uid,'a.mstatus'=>1])
								   ->order('a.mtime desc')
								   ->field('a.mid,a.mtitle,a.mtime,a.muid,b.uname')
								   ->select(); 
		}
		
		return $info;
	}
	
	/*更改消息状态*/
	public static function updateMsg($data,$where){
		$flag = Db::name('msg')->where($where)->update($data);
		if($flag !== false){
			$result = ['code'=>200];
		}else{
			$result = ['code'=>3009];
		}
		return $result;
	}
	
	/*获取单条数据信息*/
	public static function findSingleMsg($mid){
		$info = Db::name('msg')->alias('a')
								   ->join('__USER__ b','b.uid=a.muid','left')
								   ->where(['a.mid'=>$mid])
								   ->order('a.mtime desc')
								   ->field('a.mid,a.mtitle,a.mcontent,a.mtime,a.muid,a.mstatus,b.uname,b.uimageurl')
								   ->find(); 
		return $info;
	}
	
	/*或许需要备份的数据*/
	public static function getMsgInfos($uid,$ucount){
		if($ucount != ''){
			$uinfo = Db::name('user')->where(['ucount'=>$ucount])->find();
			if(empty($uinfo)){
				return ['code'=>3001];
			}
			$info = Db::name('msg')->alias('a')
								   ->join('__USER__ b','b.uid=a.muid','left')
								   ->where('a.mstatus','in',[1,2])
								   ->where(['a.uid'=>$uid,'b.uid'=>$uinfo['uid']])
								   ->order('a.mtime desc')
								   ->field('a.mtitle,a.mtime,a.mcontent,b.uname')
								   ->select(); 
			return ['code'=>200,'data'=>$info];
		}else{
			$info = Db::name('msg')->alias('a')
								   ->join('__USER__ b','b.uid=a.muid','left')
								   ->where('a.mstatus','in',[1,2])
								   ->where(['a.uid'=>$uid])
								   ->order('a.mtime desc')
								   ->field('a.mtitle,a.mtime,a.mcontent,b.uname')
								   ->select(); 
			return ['code'=>200,'data'=>$info];
		}
	}
	
	/*保存发送消息*/
	public static function saveMsgInfo($ucount,$data){
		$uinfo = Db::name('user')->where(['ucount'=>$ucount])->find();
		if(empty($uinfo)){
			return ['code'=>3017];
		}elseif($uinfo['ustatus'] == 0){
			return ['code'=>3018];
		}else{
			$data['uid'] = $uinfo['uid'];
			$flag = Db::name('msg')->insert($data);
			if($flag !== 0){
				return ['code'=>200];
			}else{
				return ['code'=>3009];
			}
		}
	}
}

