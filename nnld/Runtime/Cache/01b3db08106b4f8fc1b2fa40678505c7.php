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

<div class="ncenter_box">
<div class="accounttitle"><h1>首页图片管理 </h1></div>
<form method='post' id="myform" action="__URL__/setParameterSave_B" >
<table width="100%" cellpadding=3 cellspacing=0 border=0 id="tb1" class="tab4">
<tr  class="content_td">
                <td width="15%" >&nbsp;</td>
                <td width="85%">&nbsp;</td>
</tr>
<tr>
				<td align="right">首页图片1：</td>
				<td class="center"><input name="str21" type="text" id="str21" value="<?php echo ($fee_str21); ?>" size="40" maxlength="80" /></td>
</tr>
<tr>
				<td align="right">上传图片1：</td>
				<td class="center"><iframe src="__URL__/upload_add_a" width="350" height="30" scrolling="no" frameborder="0"></iframe>上传格式：jpg,png,gif</td>
</tr>
<tr>
				<td align="right">首页图片2：</td>
				<td class="center"><input name="str22" type="text" id="str22" value="<?php echo ($fee_str22); ?>" size="40" maxlength="80" /></td>
</tr>
<tr>
				<td align="right">上传图片2：</td>
				<td class="center"><iframe src="__URL__/upload_add_b" width="350" height="30" scrolling="no" frameborder="0"></iframe>上传格式：jpg,png,gif</td>
</tr>
<tr>
				<td align="right">首页图片3：</td>
				<td class="center"><input name="str23" type="text" id="str23" value="<?php echo ($fee_str23); ?>" size="40" maxlength="80" /></td>
</tr>
<tr>
				<td align="right">上传图片3：</td>
				<td class="center"><iframe src="__URL__/upload_add_c" width="350" height="30" scrolling="no" frameborder="0"></iframe>上传格式：jpg,png,gif</td>
</tr>
<tr>
  <td></td>
  <td class="center">
    <input type="submit" value="修改" class="button_text">
    <input type="reset" value="还原" class="button_text"></td>
</tr>
</table>
</form>
</div>
</body>
</html>