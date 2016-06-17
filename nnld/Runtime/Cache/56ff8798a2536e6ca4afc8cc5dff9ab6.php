<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Data Manage</title>
<style type="text/css">
<!--
body{ font-family:Verdana, Geneva, sans-serif; font-size:12px; line-height:180%;}
.STYLE1 {color: #FF0000}
.STYLE2 {color: #00CC99}
-->
</style>
<style type="text/css">
<!--
#apDiv1 {
	position:absolute;
	top:0px;
	left:0px;
	width:100%;
	height:100%;
	z-index:1;
	background-color: #CCC;
	filter:alpha(opacity=90); -moz-opacity:0.9; opacity:0.9;
	text-align: center;
}
#apDiv1 #contt {
	margin:auto;
	padding:auto;
	width: 400px;
	margin-top: 150px;
	background-color: #FFF;
	border: 2px solid #999;
}
#apDiv1 #contt img{
	margin-top: 5px;
	margin-right: 20px;
	margin-bottom: 5px;
	margin-left: 5px;
}
#ctop{
	margin-top: 20px;
}
#ccont{
	padding: 5px;
	height: 30px;
}
#cnet{
	margin-top: 10px;
	padding: 5px;
	height: 30px;
	position:relative;
}
#cbtm{
	margin-top: 10px;
	padding: 5px;
	height: 30px;
	margin-bottom: 10px;
}
#status{
	line-height:28px;
}
-->
</style>
<style type="text/css">
<!--
#apDiv2 {
	position:absolute;
	top:0px;
	left:0px;
	width:100%;
	height:100%;
	z-index:1;
	background-color: #CCC;
	filter:alpha(opacity=90); -moz-opacity:0.9; opacity:0.9;
	text-align: center;
}
#apDiv2 #contt2 {
	margin:auto;
	padding:auto;
	width: 400px;
	margin-top: 150px;
	background-color: #FFF;
	border: 2px solid #999;
}
#apDiv2 #contt2 img{
	margin-top: 5px;
	margin-right: 20px;
	margin-bottom: 5px;
	margin-left: 5px;
}
#ctop2{
	margin-top: 20px;
}
#ccont2{
	padding: 5px;
	height: 30px;
}
#cnet2{
	margin-top: 10px;
	padding: 5px;
	height: 30px;
	position:relative;
}
#cbtm2{
	margin-top: 10px;
	padding: 5px;
	height: 30px;
	margin-bottom: 10px;
}
#status2{
	line-height:28px;
}
-->
</style>
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
function checkpresent(nn,mm,recod,mrecod){
	var mwidth=380;
	var sMsg=(recod/mrecod)*mwidth;
	if(nn=="0"&&mm=="0"){
		document.getElementById("status").innerHTML = "所有数据表备份完成"; 
		document.getElementById("progress").style.width = mwidth + "px";
		document.getElementById("percent").innerHTML = "100%"; 
	}else{
		document.getElementById("status").innerHTML = "正在备份第 "+nn+" 张数据表["+recod+"/"+mrecod+" 条数据] / 共 "+mm+" 张数据表"; 
		document.getElementById("progress").style.width = sMsg + "px";
		document.getElementById("percent").innerHTML = parseInt(recod / mrecod * 100) + "%"; 
	}
}
function okdone(){
	var okprint="<img src=\"__PUBLIC__/Images/is_ok.png\" name=\"数据库备份完成\" align=\"absmiddle\" />数据库备份完成";
	document.getElementById("ctop").innerHTML=okprint;
	document.getElementById("ccont").innerHTML="备份完成！";
	document.getElementById("cbtm").style.display="block";
	document.getElementById("action_a").focus();
}
function buttonn(){
	if(confirm("温馨提示：\n\n备份数据库所需时间根据数据源大小决定，备份期间请不要进行其他操作。\n\n您确定要备份当前数据库吗？")){
		document.getElementById("apDiv1").style.display="block";
		document.getElementById("ccont").focus();
		document.getElementById("ifra1").src='__URL__/DBBeiFen/Cid/'+Math.random();
		setTimeout("ajaxfunction()",2000);
	}
}
function ajaxfunction(){
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
			checkpresent('0','0','0','0')
			//alert("备份完成");
			okdone();
		}
	}
	var url="__URL__/endgookweb";
	url+="/cid/"+Math.random();
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
		
}
</script>

<script>
function restorepresent(nn,mm,recod,mrecod){
	var mwidth=380;
	var sMsg=(recod/mrecod)*mwidth;
	if(nn=="0"&&mm=="0"){
		document.getElementById("status2").innerHTML = "所有数据表还原完成"; 
		document.getElementById("progress2").style.width = mwidth + "px";
		document.getElementById("percent2").innerHTML = "100%"; 
	}else{
		document.getElementById("status2").innerHTML = "正在还原第 "+nn+" 张数据表["+recod+"/"+mrecod+" 条数据] / 共 "+mm+" 张数据表"; 
		document.getElementById("progress2").style.width = sMsg + "px";
		document.getElementById("percent2").innerHTML = parseInt(recod / mrecod * 100) + "%"; 
	}
}
function restoredone(){
	var okprint="<img src=\"__PUBLIC__/Images/is_ok.png\" name=\"数据库还原完成\" align=\"absmiddle\" />数据库还原完成";
	document.getElementById("ctop2").innerHTML=okprint;
	document.getElementById("ccont2").innerHTML="还原完成！";
	document.getElementById("cbtm2").style.display="block";
	document.getElementById("action_b").focus();
}
function buttonm(vpath){
	if(confirm("温馨提示：\n\n还原数据库所需时间根据数据源大小决定，还原期间请不要关闭浏览器，以免照成数据丢失。\n\n您确定要还原当前数据库吗？")){
		document.getElementById("apDiv2").style.display="block";
		document.getElementById("ccont2").focus();
		document.getElementById("ifra2").src='__URL__/DBHuanYuan/fname/'+vpath+'/Cid/'+Math.random();
		setTimeout("re_ajaxfunction()",2000);
	}
}
function re_ajaxfunction(){
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
			restorepresent('0','0','0','0')
			restoredone();
		}
	}
	var url="__URL__/endgookweb";
	url+="/cid/"+Math.random();
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
		
}
</script>
</head>

<body>
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td style="font-size:14px; font-weight:bold; line-height:30px;" align="center">数据库备份/还原</td>
  </tr>
  <tr>
    <td align="center">
<input type="button" name="action" value="数据库备份" onclick="buttonn();" />
<br /><br />
<table width="750" class="tab3" border="0" cellpadding="3" cellspacing="1" style="background:#CCC;">
	<thead>
    <tr align="center">
      	<th width="10%" nowrap bgcolor="#EEEEEE"><span>ID</span></th>
        <th width="40%" nowrap bgcolor="#EEEEEE"><span>备份名称</span></th>
		<th width="25%" nowrap bgcolor="#EEEEEE">备份时间</th>
    <th width="25%" nowrap bgcolor="#EEEEEE"><span>操作</span></th>
        </tr>
    </thead>
    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><form action="__URL__/indexAC/" method="post" name="form<?php echo ($i); ?>" id="form<?php echo ($i); ?>">
    <tr class="content_td lz" align="center">
    	<td nowrap bgcolor="#FFFFFF"><?php echo ($i); ?></td> 
        <td nowrap bgcolor="#FFFFFF"><?php echo ($vo['name']); ?></td>
        <td nowrap bgcolor="#FFFFFF"><?php echo (date("Y-m-d H:i:s",$vo['time'])); ?></td>
        <td nowrap bgcolor="#FFFFFF">
        <input name="action" type="submit" value="下载" id="action" onclick="{if(confirm('您确定要下载吗？')){return true;}return false;}"/>
        <input name="action" type="button" value="还原" id="action" onclick="buttonm('<?php echo $vo['getpath'] ?>');"/>
        <input name="fname" type="hidden" id="fname" value="<?php echo ($vo['path']); ?>" />
        <input name="mname" type="hidden" id="fname" value="<?php echo ($vo['name']); ?>" />
        <input name="action" type="submit" value="删除" id="action" onclick="{if(confirm('您确定要删除吗？')){return true;}return false;}"/></td>
    </tr>
    </form><?php endforeach; endif; else: echo "" ;endif; ?>
</table>
<table width="700" border="0" cellspacing="5" cellpadding="0">
  <tr>
    <td class="hong">共计：<?php echo ($count); ?> 个文件/文件夹</td>
  </tr>
</table>
</td>
  </tr>
</table>

<div id="apDiv1" style="display:none;">
<div id="contt">
  <div id="ctop"><img src="__PUBLIC__/Images/loading3.gif" alt="" name="数据库备份中" align="absmiddle" />数据库备份中，请您耐心等待...</div>
  <div id="cnet">
  <!--start-->
	<div style="padding: 0; background-color: white; border: 1px solid navy; width: 380px" align="left"> 
    <div id="progress" style="padding: 0; background-color: #FFCC66; border: 0; width: 0px; text-align: center;   height: 20px"></div>
    </div> 
    <div id="status">&nbsp;</div>
    <div id="percent" style="position:absolute; top: 8px; left:45%; text-align: center; font-weight: bold; font-size: 8pt; font-family: Tahoma;">0%</div>
  <!--end-->
  </div>
  <div id="ccont">数据备份完成前请不要进行其他操作，以免造成数据丢失。</div>
  <div id="cbtm" style="display:none"><input type="button" id="action_a" name="action_a" value="确认" onclick="window.location='__URL__/index/'" /></div>
  <iframe src="" width="200" height="500" style="display:none" id="ifra1"></iframe>
</div>
</div>

<div id="apDiv2" style="display:none">
<div id="contt2">
  <div id="ctop2"><img src="__PUBLIC__/Images/loading3.gif" alt="" id="backup" name="backup" align="absmiddle" />数据库还原中，请您耐心等待...</div>
  <div id="cnet2">
  <!--start-->
	<div style="padding: 0; background-color: white; border: 1px solid navy; width: 380px" align="left"> 
    <div id="progress2" style="padding: 0; background-color: #FFCC66; border: 0; width: 0px; text-align: center;   height: 20px"></div>
    </div> 
    <div id="status2">&nbsp;</div>
    <div id="percent2" style="position:absolute; top: 8px; left:45%; text-align: center; font-weight: bold; font-size: 8pt; font-family: Tahoma;">0%</div>
  <!--end-->
  </div>
  <div id="ccont2">数据还原完成前请不要进行操作，不要关闭浏览器，以免造成数据丢失。</div>
  <div id="cbtm2" style="display:none"><input type="button" id="action_b" name="action_b" value="确认" onclick="window.location='__URL__/index/'" /></div>
  <iframe src="" width="200" height="30" style="display:none" id="ifra2"></iframe>
</div>
</div>

</body>
</html>