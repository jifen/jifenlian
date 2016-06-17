<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ($System_namex); ?></title>
<link href="__PUBLIC__/Css/body.css" rel="stylesheet" media="screen" type="text/css" />
<link href="__PUBLIC__/Css/menu.css" rel="stylesheet" media="screen" type="text/css" />
<link href="__PUBLIC__/Css/main.css" rel="stylesheet" media="all" type="text/css" />
<script type="text/javascript">document.write("<scr"+"ipt src=\"__PUBLIC__/Js/Base.js\"></sc"+"ript>")</script>
<script type="text/javascript">document.write("<scr"+"ipt src=\"__PUBLIC__/Js/prototype.js\"></sc"+"ript>")</script>
<script type="text/javascript">document.write("<scr"+"ipt src=\"__PUBLIC__/Js/mootools.js\"></sc"+"ript>")</script>
<script type="text/javascript">document.write("<scr"+"ipt src=\"__PUBLIC__/Js/Ajax/ThinkAjax.js\"></sc"+"ript>")</script>
<script type="text/javascript">document.write("<scr"+"ipt src=\"__PUBLIC__/Js/Form/CheckForm.js\"></sc"+"ript>")</script>
<script type="text/javascript">document.write("<scr"+"ipt src=\"__PUBLIC__/Js/common.js\"></sc"+"ript>")</script>
<script type="text/javascript">document.write("<scr"+"ipt src=\"__PUBLIC__/Js/Util/ImageLoader.js\"></sc"+"ript>")</script>
<script type="text/javascript">document.write("<scr"+"ipt src=\"__PUBLIC__/Js/myfocus-1.0.4.min.js\"></sc"+"ript>")</script>
<script type="text/javascript">document.write("<scr"+"ipt src=\"__PUBLIC__/Js/all.js\"></sc"+"ript>")</script>
<script type="text/javascript">document.write("<scr"+"ipt src=\"__PUBLIC__/Js/jquery-1.7.2.min.js\"></sc"+"ript>")</script>

<script type="text/javascript">document.write("<scr"+"ipt src=\"__PUBLIC__/Js/jquery.SuperSlide.2.1.1.source.js\"></sc"+"ript>")</script>
<script language="JavaScript">
ifcheck = true;
function CheckAll(form)
{
	for (var i=0;i<form.elements.length-2;i++)
	{
		var e = form.elements[i];
		e.checked = ifcheck;
	}
	ifcheck = ifcheck == true ? false : true;
}
</script>
<script>
//function checkLeave(){
//	window.parent.stateChangeIE();
//}
</script>
</head>
<body style=" background: none;">

<style>
.treep1{display:;}
.treep2{display:none;}
.sub_bav td {
    border: 0px solid #D0D0D0 !important;
    border-collapse: collapse;
    padding: 2px;
}
table{ border:0px !important; padding:0px !important;}
td{ border:0px !important; padding:0px !important;}
p,div{ line-height:0px !important;}
</style>

<script type="text/javascript" src="__PUBLIC__/Js/tree.js"></script>
<div class="ncenter_box" style="min-height:500px;">
<div class="accounttitle"><h1>业务关系表 </h1></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <form method='post' action="__URL__/TreeAjax/">
  <tr>
    <td height="30">&nbsp;&nbsp;会员编号：
    <input type="text" name="UserID" title="帐号查询"  >
    <input type="submit" name="Submit" value="查询" class="btn1"/>
    &nbsp;&nbsp;&nbsp;&nbsp;
    总人数：<b><?php echo ($all_nn); ?></b> 人&nbsp;&nbsp;&nbsp;&nbsp;主要市场:<?php echo ($bing); ?>&nbsp;&nbsp;其余市场:<?php echo ($small); ?>
    </td>
  </tr>
  </form>
  <tr>
    <td><?php echo ($myStr); ?></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="<?php echo ($myTabN); ?>">
  <tr>
    <td>
    <?php if(is_array($z_tree)): $i = 0; $__LIST__ = $z_tree;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$z_tt): $mod = ($i % 2 );++$i;?><div><?php echo ($z_tt[0]); ?></div>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" id="<?php echo ($z_tt[1]); ?>" class="treep2">
      <tr>
        <td id="<?php echo ($z_tt[1]); ?>_tree"><?php echo ($z_tt[2]); ?><img src="__PUBLIC__/Images/loading2.gif" align="absmiddle"></td>
      </tr>
    </table><?php endforeach; endif; else: echo "" ;endif; ?>
    </td>
  </tr>
</table>
<table width="90%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="30">&nbsp;&nbsp;
    <?php if(is_array($s10)): $i = 0; $__LIST__ = $s10;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$svo): $mod = ($i % 2 );++$i;?><!--<strong><span class="STYLE3"><?php echo ($s10[$key]); ?></span></strong>&nbsp;&nbsp;--><?php endforeach; endif; else: echo "" ;endif; ?></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="30">说明：<img src="__PUBLIC__/Images/tree/center.gif" width="18" height="18" />公司<img src="__PUBLIC__/Images/tree/Official.gif" width="18" height="18" />已开通 <img src="__PUBLIC__/Images/tree/trial.gif" width="18" height="18" />未开通</td>
  </tr>
</table>
</div>
</body>
</html>
<script>
function openmm(oid,tid,mid,numm,ppath){
	var tobj = document.getElementById(oid);
	var mobj = document.getElementById(tid);
	var cmid = "o"+tid;
	var cobj = document.getElementById(cmid);
	var coimg = cobj.src;
	if(tobj.className=="treep2"){
		tobj.className="treep1";
		var opppid = oid+"_tree";
		ajaxChech(opppid,mid,numm,ppath)
	}else{
		tobj.className="treep2";
	}
	cobj.src = mobj.src;
	mobj.src = coimg;
	

}
function ajaxChech(vid,aid,nnn,pp){
	var xmlHttp;
	try{
		//FF Opear 8.0+ Safair
		xmlHttp=new XMLHttpRequest();
	}
	catch(e){
		try{
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(e){
			alert("您的浏览器不支持AJAX");
			return false;    
		}
	}
	xmlHttp.onreadystatechange=function(){
		if(xmlHttp.readyState==4){
			var valuet = xmlHttp.responseText;
			document.getElementById(vid).innerHTML=valuet;
		}
	}
	var url="__URL__/ajax_tree_m/";
	url+="/reid/"+aid+"/nn/"+nnn+"/pp/"+pp;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
</script>