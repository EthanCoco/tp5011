<?php
namespace app\index\model;
use think\Model;
use think\Db;
class Desktop extends Model{
	public static function getListInfo($uid){
		$items = [];
		$result = [];
		$folders = Db::name('menuFolder')->select();
		foreach($folders as $f){
			$subInfo = Db::name('desktop')->where('menupid',$f['mid'])
										  ->where('status',1)
										  ->select();
			if(!empty($subInfo)){
				$f['state'] = 'closed';
				array_push($items, $f);
			}
		}
		foreach($items as $it){
			$unionQuery = Db::name('desktop')
										->join('__USER_DESKTOP__','desktopid = id','inner')
										->field('id,title,openurl,iconurl,sysdef,menupid,udid')
										->where('status',1)
										->where('sysdef',0)
										->where('uid',$uid)
										->where('menupid',$it['mid'])
										->select(false);
			$unionQuery2 = Db::name('desktop')
										->join('__USER_DESKTOP__','desktopid = id','left')
										->field('id,title,openurl,iconurl,sysdef,menupid,udid')
										->where('status',1)
										->where('sysdef',1)
										->where('uid',$uid)
										->where('menupid',$it['mid'])
										->select(false);
	    	$subInfo = Db::name('desktop')
										->join('__USER_DESKTOP__','desktopid = id','left')
										->field('id,title,openurl,iconurl,sysdef,menupid,udid')
										->where('status',1)
										//->where('sysdef',1)
										//->where('uid',$uid)
										->where('menupid',$it['mid'])
										->where('udid is null')
										->union($unionQuery,true)
										->union($unionQuery2,true)
										->select();
			$tempData = [];
			foreach($subInfo as $sub){
				$tempData[] = [
					'id'		=>	'sub_'.$sub['id'],
					'name'		=>	$sub['title'],
					'openurl'	=>	$sub['openurl'],
					'iconurl'	=>	"<img class='icon' style='display: inline-block; vertical-align: middle;' width='20' height='20' src='".$sub['iconurl']."' />",
					'sysdef'	=>	$sub['sysdef'] == 1 ? '是' : '否',
					'sysdef_no'	=>	$sub['sysdef'],
					'indesktop'	=>	($sub['sysdef'] == 1) ? (!empty($sub['udid']) ? '不显示' : '显示') : (!empty($sub['udid']) ? '显示' : '不显示'  )
				];
			}
			
			$result[] = [
				'id'	=>	'pid_'.$it['mid'],
				'name'	=>	$it['mname'],
				'openurl'	=>	'',
				'iconurl'	=>	'',
				'sysdef'	=>	'',
				'indesktop'	=>	'',
				'children' 	=>	$tempData
			];
		}
		return ['rows'=>$result];
	}
	
	public static function showHide($uid,$type,$def0,$def1){
		$def0_len = count($def0);
		$def1_len = count($def1);
		if($type == 0){
			if($def0_len > 0){
				Db::name('userDesktop')->where('uid',$uid)->where('desktopid','in',$def0)->delete();
				$data = [];
				for($i = 0; $i < $def0_len; $i++){
					$data[] = [
						'uid' 		=>	$uid,
						'desktopid' =>	$def0[$i]
					];
				}
				Db::name('userDesktop')->insertAll($data);
			}
			if($def1_len > 0){
				Db::name('userDesktop')->where('uid',$uid)->where('desktopid','in',$def1)->delete();
			}
			$result = ['code'=>200,'msg'=>'设置成功'];
		}elseif($type == 1){
			if($def0_len > 0){
				Db::name('userDesktop')->where('uid',$uid)->where('desktopid','in',$def0)->delete();
			}
			if($def1_len > 0){
				Db::name('userDesktop')->where('uid',$uid)->where('desktopid','in',$def1)->delete();
				$data = [];
				for($i = 0; $i < $def1_len; $i++){
					$data[] = [
						'uid' 		=>	$uid,
						'desktopid' =>	$def1[$i]
					];
				}
				Db::name('userDesktop')->insertAll($data);
			}
			$result = ['code'=>200,'msg'=>'设置成功'];
		}else{
			$result = ['code'=>300,'msg'=>'非法操作'];
		}
		return $result;
	}
	
	
	
}

