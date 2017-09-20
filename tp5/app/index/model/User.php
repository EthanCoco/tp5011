<?php
namespace app\index\model;
use think\Model;
use think\Db;
class User extends Model{
	/*指定唯一字段查询单挑记录*/
	public static function findByKey($name,$value){
		$info = Db::name('user')->where([$name=>$value])->find();
		return $info;
	}
	
	/*指定ID更新数据*/
	public static function updateById($id,$data = []){
		$flag = Db::name('user')->where(['uid'=>$id])->update($data);
		if($flag !== 0){
			return true;
		}
		return false;
	}
	
	/*添加数据【type=0添加单条记录，type=1批量添加】*/
	public static function add($type = 0,$data = []){
		if($type == 0){
			$result = Db::name('user')->insertGetId($data);
		}else{
			$result = Db::name('user')->insertAll($data);
		}
		return $result;
	}
	
	/*获取编辑信息【type=0基本资料，type=1个人信息，type=2联系方式】*/
	public static function getProfile($type = 0,$uid){
		$infos = Db::name('ucname')->alias('a')
								   ->join('__UINFO__ b','b.cname=a.name and b.ctype='.$type.' and b.uid='.$uid,'left')
								   ->where(['a.type'=>$type,'a.status'=>1])
								   ->order('a.id asc')
								   ->field('a.name,a.zhname,b.cvalue,b.cseen,b.chome')
								   //->fetchSql(true)
								   ->select();
		return $infos;
	}
	
	/*批量添加个人信息*/
	public static function addProfile($type,$uid,$data = []){
		$flag = Db::name('uinfo')->where(['ctype'=>$type,'uid'=>$uid])->delete();
		if($flag !== 0){
			$temp = Db::name('uinfo')->insertAll($data);
			if($temp !== false){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	/*修改账号*/
	public static function updateUcount($uid,$ucount){
		$flag = Db::name('user')->whereNotIn('uid',$uid)->where(['ucount'=>$ucount])->count('uid');
		if($flag){
			$result = ['code'=>3015];
		}else{
			$temp =self::updateById($uid,['ucount'=>$ucount]);
			if($temp !== 0){
				$result = ['code'=>200];
			}else{
				$result = ['code'=>3009];
			}
		}
		return $result;
	}
	
	/*修改 密码*/
	public static function updatePwd($uid,$oldpass,$newpass){
		$info = self::findByKey('uid',$uid);
		if($info['upass'] != MD5(hash('sha256', $oldpass))){
			$result = ['code'=>3016];
		}else{
			$temp =self::updateById($uid,['upass'=>MD5(hash('sha256', $newpass))]);
			if($temp !== 0){
				$result = ['code'=>200];
			}else{
				$result = ['code'=>3009];
			}
		}
		return $result;
	}
	
	/*修改邮箱*/
	public static function updateUemail($uid,$upass,$uemail){
		$info = self::findByKey('uid',$uid);
		if($info['upass'] != MD5(hash('sha256', $upass))){
			$result = ['code'=>3016];
		}else{
			$flag = Db::name('user')->whereNotIn('uid',$uid)->where(['uemail'=>$uemail])->count('uid');
			if($flag){
				$result = ['code'=>3010];
			}else{
				$temp =self::updateById($uid,['uemail'=>$uemail]);
				if($temp !== 0){
					$result = ['code'=>200];
				}else{
					$result = ['code'=>3009];
				}
			}
		}
		return $result;
	}
}

