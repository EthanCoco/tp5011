<?php
namespace app\index\validate;
use think\Validate;

class User extends Validate{
	protected 	$rule = [
					'ucount'	=>	'require|unique:user|alphaNum|max:20|min:2|checkCount:',
					'upass'		=>	'require',
					'uemail'	=>	'require|email',
					'verify'	=>	'require',
					'uname'		=>	'require|chsDash'
				];
	
	protected	$field = [
					'ucount'	=>	'账号',
					'upass'		=>	'密码',
					'uemail'	=>	'邮箱',
					'verify'	=>	'验证码',
					'uname'		=>	'昵称',
				];
	
	protected 	$message = [
					'ucount.require'	=>	'账号不能为空',
					'ucount.unique'		=>  '账号已经存在',
					'ucount.eq'			=>	'账号不存在',
					'ucount.alphaNum'	=>	'【格式错误】账号只能是字母和数字，且首字符必须为英文，至少要两个字符，最大不超过20个字符',
					'ucount.max'		=>	'【最大不超过20个字符】账号只能是字母和数字，且首字符必须为英文，至少要两个字符，最大不超过20个字符',
					'ucount.min'		=>	'【至少要两个字符】账号只能是字母和数字，且首字符必须为英文，至少要两个字符，最大不超过20个字符',
					'upass.require'		=>	'密码不能为空',
					'uemail.require'	=>	'邮箱不能为空',
					'uemail.email'		=>	'邮箱格式不正确',
					'uemail.unique'		=>	'邮箱已经被注册了',
					'verify.require'	=>	'验证码不能为空',
					'uname.require'		=>	'昵称不能为空，只能是汉字、字母、数字和下划线_及破折号-',
					'uname.chsDash'		=>	'昵称不能为空，只能是汉字、字母、数字和下划线_及破折号-',
				];
	
	protected	$scene = [
					//login
					'login'		=>	['ucount'=>'require','upass'],
					//find back user acount
					'findCount' =>	['uemail','verify'],
					//register
					'register'	=>	['ucount','upass','uemail'=>'require|email|unique:user','verify','uname'],	
					//judge user acount was already exists
					'is_reg_ucount'=>['ucount'],
					//judge user email was already exists
					'is_reg_uemail'=>['uemail'=>'require|email|unique:user'],
					
					'is_ver_ucount'=>['ucount'=>'require|eq:null'],
				];
	//when register, validate the user acount
	protected function checkCount($value,$rule){
		if(is_numeric(mb_substr($value,0,1))){
			return "【首字符必须为英文】账号只能是字母和数字，且首字符必须为英文，至少要两个字符，最大不超过20个字符";
		}
		return true;
	}
}
