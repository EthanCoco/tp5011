<?php
// 应用公共文件
use think\Config;
/**
 * 系统邮件发送函数
 * @param string $tomail 接收邮件者邮箱
 * @param string $name 接收邮件者名称
 * @param string $subject 邮件主题
 * @param string $body 邮件内容
 * @param string $attachment 附件列表
 * @return boolean
 * @author static7 <static7@qq.com>
 */
function send_mail($to, $title, $content) {
	//实例化PHPMailer对象
    $mail = new \PHPMailer\PHPMailer\PHPMailer(); 
    //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码          
    $mail->CharSet = Config::get('email.charset');  
    //设定使用SMTP服务
    $mail->IsSMTP();  
    //smtp服务器的名称              
    $mail->Host = Config::get('email.host'); 
    //启用smtp认证
    $mail->SMTPAuth = Config::get('email.smtpauth'); 
    //邮箱名
    $mail->Username = Config::get('email.username'); 
    //邮箱密码
    $mail->Password = Config::get('email.password'); 
    //发件人地址
    $mail->From = Config::get('email.from'); 
    //发件人姓名
    $mail->FromName = Config::get('email.fromname'); 
    //设置每行字符长度
    $mail->WordWrap = Config::get('email.wordwarp'); 
    //是否HTML格式邮件
    $mail->IsHTML = Config::get('email.ishtml'); 
    //收件人地址
    $mail->AddAddress($to);
    //邮件主题
    $mail->Subject =$title; 
    //邮件内容
    $mail->Body = $content; 
    $mail->AltBody = "这是一个纯文本的身体在非营利的HTML电子邮件客户端"; //邮件正文不支持HTML的备用显示
    return $mail->Send() ? true : $mail->ErrorInfo;
}

/**
 * 创建目录 如果目录不存在则创建目录
 * @param string $dir 创建目录
 * @param string $mode 目录权限
 */
function mkdirs($dir, $mode = 0777){
    if (is_dir($dir) || @mkdir($dir, $mode)) return TRUE;
    if (!mkdirs(dirname($dir), $mode)) return FALSE;
    return @mkdir($dir, $mode);
} 