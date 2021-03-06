<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:63:"D:\wamp\www\tp5\web/../app/index\view\index\system\desktop.html";i:1506190782;s:66:"D:\wamp\www\tp5\web/../app/index\view\default\public\children.html";i:1506189410;s:64:"D:\wamp\www\tp5\web/../app/index\view\default\public\footer.html";i:1506087774;}*/ ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<link rel='Shortcut Icon' type='image/x-icon' href='__WIMG__/img/windows.ico'>
	    <script type="text/javascript" src="__WJS__/jquery-2.2.4.min.js"></script>
	    <link href="__STATIC__/easyui/themes/default/easyui.css" rel="stylesheet">
	    <link href="__STATIC__/easyui/themes/color.css" rel="stylesheet">
	    <link href="__STATIC__/easyui/themes/icon.css" rel="stylesheet">
	    <link rel="stylesheet" href="__CSS__/animate.css">
		<link rel="stylesheet" href="__CSS__/toastr.min.css">
	    <script type="text/javascript" src="__STATIC__/easyui/jquery.easyui.min.js"></script>
	    <script type="text/javascript" src="__STATIC__/easyui/locale/easyui-lang-zh_CN.js"></script>
	    <script type="text/javascript" src="__JS__/bootstrap.min.js"></script>
		<script type="text/javascript" src="__JS__/toastr.min.js"></script>
		<script type="text/javascript" src="__WJS__/win10.child.js"></script>
	</head>
	<body>


<table id="desktop" fit="true"  toolbar="#toolbar" >
	<thead>
	</thead>
</table>
<div id="toolbar" style="padding:5px">
	<a href="#" class="easyui-linkbutton" iconCls="icon-show" plain="true" onclick="showOrHideDesktop(0)">显示桌面</a>
	<a href="#" class="easyui-linkbutton" iconCls="icon-hide" plain="true" onclick="showOrHideDesktop(1)">隐藏桌面</a>
</div>

<script>
$(function(){
	$('#desktop').treegrid({    
		url:"<?php echo url('desktop/listInfo'); ?>",
		loadMsg:'数据正在加载，请稍候......',
		idField:'id',    
		treeField:'name',   
		fit: true,
		fitColumns:true,
		rownumbers:true,
		resizeHandle:'both',
		singleSelect:false,
		frozenColumns:[[
	   		{field:'ck',checkbox:true},
	    	{field:'name',title:'名称',align:'center',width:200},
	    ]] ,
		columns:[[    
			{field:'id',title:'ID属性',width:'5%',align:'center',hidden:true} , 
		    {field:'openurl',title:'地址',align:'center',width:'30%'},    
			{field:'iconurl',title:'图标',align:'center',width:'10%'},    
			{field:'sysdef',title:'系统默认',align:'center',width:'18%'},   
			{field:'indesktop',title:'显示桌面',align:'center',width:'18%'},
		]]    
	}); 
});	

function showOrHideDesktop(type){
	var msg = ['显示桌面','隐藏桌面'];	
	var rows =  $("#desktop").treegrid('getSelections');
	//alert(JSON.stringify(rows));return;
	var rowLen = rows.length;
	if (rowLen == 0){  
        toastr.error("请选择需要"+msg[type]+"的数据");	return; 
    }
	var sysdef_ids0 = []; 
	var sysdef_ids1 = [];
	var msg_name = "";
	for (var i = 0; i < rows.length; i++) {
        var ids_array = rows[i].id.split("_");
        var sysdef = rows[i].sysdef_no;
		if(ids_array[0] == "sub"){
			if(sysdef == 1){
				sysdef_ids1.push(ids_array[1]);
			}else{
				sysdef_ids0.push(ids_array[1]);
			}
			msg_name += "【" + rows[i].name + "】、"; 
		}
    } 
	if(sysdef_ids1.length == 0 && sysdef_ids0.length == 0){
		toastr.error("请选择有效的节点数据操作");	return; 
	}
	$.post("<?php echo url('desktop/ShowHide'); ?>",{'type':type,'sysdef_ids0':JSON.stringify(sysdef_ids0),'sysdef_ids1':JSON.stringify(sysdef_ids1)},function(json){
		if(json.code == 200){
			$('#desktop').treegrid('reload');
			Win10_child.newMsg(0,'桌面显示修改', '您设置了' + msg_name.substring(0,msg_name.length-1) + (type == 0 ? "显示" : "不显示") + "在桌面上，请刷新页面才能生效哦",function () {});
		}
		toastr.error(json.msg);
	});
	//parent.$("#win_list_desktop_menu").load(window.parent.location.href+" #win_list_desktop_menu");
	
}


</script>




	</body>
</html>
