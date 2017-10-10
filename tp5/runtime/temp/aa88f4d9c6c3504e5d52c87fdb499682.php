<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:53:"D:\wamp\www\tp5\web/../app/index\view\user\index.html";i:1505999531;}*/ ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>上传图片测试</title>
	</head>
	<body>
		<form action="<?php echo url('user/upload'); ?>" method="post" enctype="multipart/form-data">
			<input type="file" name="image" />
			<input type="submit" value="上传" />
		</form>
	</body>
</html>
