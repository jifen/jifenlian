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
<div class="accounttitle"><h1>发布公告 &nbsp;&nbsp;[<a href='javascript:history.back()'>返回列表</a>] </h1></div>
<form method='post' id="form1" name="form1" action="__URL__/News_add_save">
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="tab4">
    <tr>
        <td width="15%" align="right">标题：</td>
        <td width="85%"><input  name="title" type="text" size="50" maxlength="200"></td>
    </tr>
    <tr>
        <td align="right">类型：</td>
        <td><select name="type" id="type">
        <option value="1" selected="selected">新闻资讯</option>
        <option value="2">常见问题</option>
        </select></td>
    </tr>
    <tr> 
        <td align="right">内容：</td>
        <td>
        <?php echo ($html); ?>
        </td>
    </tr>
    <tr>
        <td align="right">发布时间：</td>
        <td ><input  name="addtime" type="text" id="addtime" value="<?php echo ($nowtime); ?>" size="20" maxlength="50"></td>
    </tr>
    <tr>
        <td></td>
        <td class="center">
        <input type="hidden" name="status" value="1">
        <input type="hidden" name="user_id" value="1">
        <input type="submit" value="保存" class="button_text">
        　
        <input type="reset" name="button" id="button" value="重置" class="button_text" />
        　
        <input type="button" name="button2" id="button2" value="返回" class="button_text" onclick="location.href='__URL__/index'"/>
        </td>
    </tr>
    <tr>
    <td colspan="2" style="height:10px"></td>
    </tr>
</table>
</form>
</div>
</body>
</html>