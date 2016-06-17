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
    <div class="accounttitle"><h1>IP白名单管理 </h1></div>
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

        <!--

        <tr align="left">
            <td><input type="button" name="action" value="管理产品分类" onClick="window.location='__URL__/cptype_index/'" class="btn1"></td>
        </tr>

        -->

    </table>
    <table width="100%" class="tab3" border="0" cellpadding="3" cellspacing="0" id="tb1">
        <form action="__URL__/Ip" method="post" name="form3" id="form3">
            <tr align="center">
                <th nowrap >序号</th>
                <th nowrap >IP白名单</th>
                <th nowrap > 添加时间</th>
                <th nowrap >操作</th>
            </tr>
            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr align="center">
                    <td nowrap ><?php echo ($key); ?></td>
                    <td nowrap ><?php echo ($v["ip_address"]); ?></td>
                    <td nowrap ><?php echo (date('Y-m-d H:i:s',$v["pdt"])); ?></td>
                    <td nowrap ><a href="__URL__/ip_del/id/<?php echo ($v["id"]); ?>">删除</a></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>

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
                <form method='post' action="__URL__/Ipadd/">IP地址：
                    <input name="ip_address" style="width: 200px; height: 30px;" type="text" id="ip"></span>
                    <input type="submit" name="Submit" value="添加" class="btn1"/>
                </form>
            </td>
        </tr>
    </table>
</div>
</body>
</html>