<?php
/**
 * 私有配置
 */
return [
	//自动登录过期时间一周
    'auto_login_time'					 => 604800,
    //邮箱验证码过期时间 10分钟
    'mail_verify_time'					 => 300,
    //重置密码链接加密字符
    'secret_str'						 => 'Q0P1W2O3E4I5R6U7T8Y9A0L1S2K3D4J5F6H7Z8M9X0N1C2B3V4G',
    //注册邮箱验证码过期时间 1小时
    'reg_verify_time'					 => 60*60*60,
];
