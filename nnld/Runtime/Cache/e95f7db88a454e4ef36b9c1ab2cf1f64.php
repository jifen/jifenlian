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
<div class="accounttitle"><h1>系统公告 </h1></div>
<form name="form3" method="post" action="__URL__/NewsAC">
<table width="100%" class="tab3" border="0" cellpadding="3" cellspacing="1" id="tb1" bgcolor="#b9c8d0">
    <thead>
        <tr>
        <th width="5%"></th>
        <th width="10%"><span>序号</span></th>
        <th width="10%"><span>新闻类型</span></th>
        <th width="30%"><span>新闻标题</span></th>
        <th width="20%"><span>发布时间</span></th>
        <th width="10%"><span>置顶</span></th>
        <th width="10%"><span>新闻状态</span></th>
        <th width="10%"><span>操作</span></th>
        </tr>
    </thead>
    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr align="center">
        <td><div align="center">
        <input type="checkbox" name="tabledb[]" value="<?php echo ($vo['id']); ?>" class="btn2" />
        </div></td>
        <td><?php echo ($key+1); ?></td>
        <td>
        <?php if(($vo['type']) == "1"): ?>新闻资讯<?php endif; ?>
        <?php if(($vo['type']) == "2"): ?>常见问题<?php endif; ?>
        </td>
        <td><?php if(($vo["baile"]) == "1"): ?><font color=red>[置顶] </font><?php endif; echo (mysubstr($vo['title'],20)); ?></td>
        <td><?php echo (date('Y-m-d H:i:s',$vo["create_time"])); ?></td>
        <td><?php if(($vo['baile']) == "1"): ?><span class="STYLE3">置顶</span><?php endif; if(($vo['baile']) == "0"): ?>未置顶<?php endif; ?></td>
        <td><?php if(($vo['status']) == "1"): ?>启用<?php endif; if(($vo['status']) == "0"): ?><span class="STYLE1">禁用</span><?php endif; ?></td>
        <td><a href="__URL__/News_edit/EDid/<?php echo ($vo['id']); ?>">编辑</a></td>
    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
</table>
<table width="100%" class="tab3_bottom" border="0" cellpadding="0" cellspacing="1">
    <tr>
        <td>
        <input name="全选" type="button" class="button_text" id="全选" onclick="CheckAll(this.form)" value="全选" />	  &nbsp;&nbsp;
        <input type="submit" name="action" value="添加新闻" class="button_text">&nbsp; &nbsp;
        <input type="submit" name="action" value="启用" class="button_text">&nbsp; &nbsp;
        <input type="submit" name="action" value="禁用" class="button_text">&nbsp; &nbsp;
        <input type="submit" name="action" value="设置置顶" class="button_text">&nbsp; &nbsp;
        <input type="submit" name="action" value="取消置顶" class="button_text">&nbsp; &nbsp;
        <input type="submit" name="action" value="删除" class="button_text"></td>
    </tr>
</table>
</form>
<table width="100%" class="tab3_bottom" border="0" cellpadding="0" cellspacing="1">
    <tr>
        <td><?php echo ($page); ?></td>
    </tr>
</table>
</div>
</body>
</html>
<script>new TableSorter("tb1");</script>