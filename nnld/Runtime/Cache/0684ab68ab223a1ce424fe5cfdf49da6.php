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
<div class="accounttitle"><h1>编辑公告 &nbsp;&nbsp;[<a href='javascript:history.back()'>返回列表</a>] </h1></div>
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="tab4">
<form method='post' id="form1" name="form1" action="__URL__/News_editAc"  enctype="multipart/form-data">
<tr> 
	<td width="15%" align="right">标题：</td>
	<td width="85%"><input type="text" class="huge bLeftRequire" name="title" value="<?php echo ($vo["title"]); ?>"></td>
</tr>
<tr>
    <td align="right">类型：</td>
    <td><select name="type" id="type">
        <option value="1" <?php if(($vo["type"]) == "1"): ?>selected<?php endif; ?>>新闻资讯</option>
        <option value="2" <?php if(($vo["type"]) == "2"): ?>selected<?php endif; ?>>常见问题</option>
        </select></td>
</tr>
<tr class="content_td"> 
	<td align="right">内容：</td>
	<td>
    <?php echo ($html); ?>
	</td>
</tr>
<tr>
                <td align="right">发布时间：</td>
                <td ><input  name="addtime" type="text" id="addtime" value="<?php echo (date('Y-m-d H:i:s',$vo["create_time"])); ?>" size="20" maxlength="50"></td>
            </tr>
<tr class="content_td"> 
	<td></td>
	<td class="center"><div style="width:85%;margin:5px">
	<input type="hidden" class="huge bLeftRequire" name="ID" value="<?php echo ($vo['id']); ?>">
	<input type="submit" value="更新" class="button_text">
	</div></td>
</tr>
</form>
</table>
</div>
</body>
</html>