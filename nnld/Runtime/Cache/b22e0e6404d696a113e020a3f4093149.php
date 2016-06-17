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
<div class="accounttitle"><h1>产品管理 </h1></div>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

<!--

<tr align="left">
	<td><input type="button" name="action" value="管理产品分类" onClick="window.location='__URL__/cptype_index/'" class="btn1"></td>
</tr>

-->

</table>
<table width="100%" class="tab3" border="0" cellpadding="3" cellspacing="0" id="tb1">
<form action="__URL__/pro_zz" method="post" name="form3" id="form3">
<tr align="center">
	<th ></th>
	<th nowrap >商品名称</th>
	<th nowrap >会员价</th>
	<th nowrap >发布时间</th>
	<th nowrap >图片地址</th>
	<th nowrap >屏蔽</th>
	<th nowrap >操作</th>
	</tr>
<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr align="center"> 
	<td><div align="center">
	  <input type="checkbox" name="checkbox[]" value="<?php echo ($vo['id']); ?>" class="btn2">
	  </div></td>
	<td nowrap ><?php echo (substr($vo['name'],0,60)); ?></td>
	<td nowrap ><?php echo (($vo["money"])?($vo["money"]):0.00); ?></td>
	<td nowrap ><?php echo (date('Y-m-d H:i:s',$vo["create_time"])); ?></td>

	<td nowrap ><?php if(($vo['img']) == ""): else: ?>
	  <a href="<?php echo ($vo['img']); ?>" target="_blank" title="查看原图">查看大图<img src="__PUBLIC__/Images/image_arrow.png" width="16" height="16" align="middle"/></a><?php endif; ?></td>
	<td nowrap ><?php if(($vo['yc_cp']) == "1"): ?><font color="red">屏蔽</font><?php else: ?>不屏蔽<?php endif; ?></td>
	<td><a href="__URL__/pro_edit/EDid/<?php echo ($vo['id']); ?>">编辑</a></td>
	</tr><?php endforeach; endif; else: echo "" ;endif; ?>
<tr><input name="allcheckboxs" type="hidden" value="">
	<td colspan=10>
    <input name="全选" type="button" class="btn1" id="全选" onclick="CheckAll(this.form)" value="全选" />&nbsp; &nbsp;
	  <input type="submit" name="action" value="添加" onClick="return allcheckbox();" class="btn1">&nbsp; &nbsp;
	  <input type="submit" name="action" value="删除" onClick="return allcheckbox();" class="btn1">&nbsp; &nbsp;
      <input type="submit" name="action" value="屏蔽产品" class="btn1">&nbsp; &nbsp;
	  <input type="submit" name="action" value="解除屏蔽" class="btn1"></td>
</tr>
</form>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr align="center">
	<td><?php echo ($page); ?></td>
</tr>
</table>
<table width="100%" align="center" style="padding-top:10px; padding-bottom:10px;">
    <tr>
    <td align="center">
    <form method='post' action="__URL__/pro_index/">标题：
	<input name="stitle" type="text" id="stitle" title="查询"></span>
	<input type="submit" name="Submit" value="查询" class="btn1"/>
	</form>
    </td>
    </tr>
</table>
</div>
</body>
</html>