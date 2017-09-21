<?php
namespace app\index\validate;
use think\Validate;
class Demo extends Validate{
	protected $rule = [
		'name'	=> 'require|max:15|min:2',
		'email' => 'email',
		'age'	=> 'integer|egt:18',
		'weight'=> 'number',
		'acount' => 'checkAdmin:admin',
	];
	
	protected $field = [
		'name'	=> '姓名',
		'email'	=> '邮箱',
		'age'	=> '年龄',
		'weight'=> '重量',
	];
	
	protected $message = [
		'name.require'	=> '姓名不能为空',
		'name.max'		=> '姓名字符不能超过15个字符',
		'name.min'		=> '姓名字符最少需要两位字符',
		'email.email' 	=> '邮箱格式不正确',
		'age.integer'	=> '年龄只能输入整数',
		'age.egt'		=> '年龄必须满18岁',
		'weight.number' => '重量只能是数字',
	];	
	
	protected $scene = [
		'edit'	=> ['name','age'],
	];


	//自定义验证
	protected function checkAdmin($value,$rule,$data){
		return $rule == $value ? true : '不是管理员';
	}
}

