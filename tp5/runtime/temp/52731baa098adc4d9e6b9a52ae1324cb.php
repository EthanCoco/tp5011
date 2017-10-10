<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:54:"D:\wamp\www\tp5\web/../app/index\view\index\index.html";i:1506245156;s:64:"D:\wamp\www\tp5\web/../app/index\view\default\public\header.html";i:1506087774;s:64:"D:\wamp\www\tp5\web/../app/index\view\default\public\footer.html";i:1506087774;}*/ ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <title>工作区</title>
    <link rel='Shortcut Icon' type='image/x-icon' href='__WIMG__/img/windows.ico'>
    <script type="text/javascript" src="__WJS__/jquery-2.2.4.min.js"></script>
    <link href="__WCSS__/animate.css" rel="stylesheet">
    <script type="text/javascript" src="__STATIC__/component/layer-v3.0.3/layer/layer.js"></script>
    <link rel="stylesheet" href="__STATIC__/component/font-awesome-4.7.0/css/font-awesome.min.css">
    <link href="__WCSS__/default.css" rel="stylesheet">
    <script type="text/javascript" src="__WJS__/win10.js"></script>
</head>
<body>
<style>
    * {
        font-family: "Microsoft YaHei", 微软雅黑, "MicrosoftJhengHei", 华文细黑, STHeiti, MingLiu
    }

    /*Custom style with Magnet*/
    .win10-block-content-text {
        line-height: 44px;
        text-align: center;
        font-size: 16px;
    }
</style>
<script>
	//init home page function
    Win10.onReady(function () {
        //set wallpaper
        Win10.setBgUrl({
            main: '__WIMG__/img/wallpapers/main.jpg',
            mobile: '__WIMG__/img/wallpapers/mobile.jpg',
        });

        Win10.setAnimated([
            'animated flip',
            'animated bounceIn',
        ], 0.01);
    });
    
    var logintimes = '<?php echo session('ulogintime') ?>';
    if(logintimes == 1){
		setTimeout(function () {
            Win10.newMsg(0,'推荐全屏', '按下F11全屏以达到最佳视觉效果(点击进入)',function () {
                Win10.enableFullScreen();
            })
        }, 1500);
	}
    setInterval(function(){
    	var mids = [];
    	$.post("<?php echo url('index/showMsgInfo'); ?>",{},function(json){
	    	var msg_len = json.length;
	    	if(msg_len > 0){
	    		$('#win10_command_center .msg').each(function(){
	    			var type = $(this).attr('type');
	    			var msgid = $(this).attr('msgid');
	    			if(typeof msgid !== "undefined" && msgid != ""){
	    				mids.push(parseInt(msgid)) ;
	    			}
				});
				for(var i = 0; i < msg_len; i++){
					if($.inArray(json[i].msgid,mids) == "-1"){
						if(json[i].fun  == ""){
		    				Win10.newMsg(json[i].type,json[i].title,json[i].content,function(){},json[i].msgid);
		    			}else{
		    				var fun = json[i].fun;
		    				Win10.newMsg(json[i].type,json[i].title,json[i].content,function(){
			    				eval("("+fun+")");
			    			},json[i].msgid);
		    			}
					}
				}
	    	}
		});
    },60000*5);
</script>
<div id="win10">
	<!--desktop list menu-->
    <div class="desktop">
        <div id="win10-shortcuts" class="shortcuts-hidden">
            <?php if(is_array($desktopInfo) || $desktopInfo instanceof \think\Collection || $desktopInfo instanceof \think\Paginator): $i = 0; $__LIST__ = $desktopInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            	<div class="shortcut" ondblclick="Win10.openUrl('<?php echo $vo['openurl']; ?>','<img class=\'icon\' src=\'<?php echo $vo['iconurl']; ?>\' /><?php echo $vo['title']; ?>')">
	                <img class="icon" src="<?php echo $vo['iconurl']; ?>"/>
	                <div class="title"><?php echo $vo['title']; ?></div>
	            </div>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
    
    <!--bottom list menu-->
    <div id="win10-menu" class="hidden">
        <div class="list win10-menu-hidden animated animated-slideOutLeft">
        	<?php if(is_array($menuInfo) || $menuInfo instanceof \think\Collection || $menuInfo instanceof \think\Paginator): $i = 0; $__LIST__ = $menuInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        	<div style="color:<?php echo $vo['mcolor']; ?>" class="item"><i class="<?php echo $vo['mfa']; ?>"></i><span><?php echo $vo['name']; ?></span></div>
        	<?php if(is_array($vo['sub']) || $vo['sub'] instanceof \think\Collection || $vo['sub'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['sub'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub): $mod = ($i % 2 );++$i;?>
        	<div style="color:<?php echo $sub['color']; ?>" class="sub-item" onclick="Win10.openUrl('<?php echo $sub['openurl']; ?>','<img class=\'icon\' src=\'<?php echo $sub['iconurl']; ?>\' /><?php echo $sub['title']; ?>')">
	        	<?php echo $sub['title']; ?>
	       	</div>
        	<?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
        	
        	
        	
           
            <div class="item" onclick="Win10.logout('<?php echo url('index/logout'); ?>')"><i class="black icon fa fa-sign-out fa-fw"></i>退出</div>
            <div class="item" onclick="Win10.exit()"><i class="black icon fa fa-power-off fa-fw"></i>关机</div>
        </div>
        
        <div class="blocks">
            <div class="menu_group">
                <div class="title">Welcome</div>
                <div class="block" loc="1,1" size="6,4">
                    <div class="content">
                        <div style="font-size:100px;line-height: 132px;margin: 0 auto ;display: block"
                             class="fa fa-fw fa-windows win10-block-content-text"></div>
                        <div class="win10-block-content-text" style="font-size: 22px">欢迎使用 Win10-UI</div>
                    </div>
                </div>
            </div>
        </div>
        <div id="win10-menu-switcher"></div>
    </div>
    
    <!--right messge block-->
    <div id="win10_command_center" class="hidden_right">
        <div class="title">
            <h4 style="float: left">消息中心 </h4>
            <span id="win10_btn_command_center_clean_all">全部清除</span>
        </div>
        <div class="msgs"></div>
    </div>
    
    <!--bottom button list-->
    <div id="win10_task_bar">
        <div id="win10_btn_group_left" class="btn_group">
            <div id="win10_btn_win" class="btn"><span class="fa fa-windows"></span></div>
            <div class="btn" id="win10-btn-browser"><span class="fa fa-internet-explorer"></span></div>
        </div>
        <div id="win10_btn_group_middle" class="btn_group"></div>
        <div id="win10_btn_group_right" class="btn_group">
            <div class="btn" id="win10_btn_time"></div>
            <div class="btn" id="win10_btn_command"><span id="win10-msg-nof" class="fa fa-comment-o"></span></div>
            <div class="btn" id="win10_btn_show_desktop"></div>
        </div>
    </div>
</div>
	</body>
</html>

