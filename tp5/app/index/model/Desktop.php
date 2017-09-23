<?php
namespace app\index\model;
use think\Model;
use think\Db;
class Desktop extends Model{
	/*修改邮箱*/
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
}

