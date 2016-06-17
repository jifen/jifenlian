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

<script language=javascript src="__PUBLIC__/Js/wpCalendar.js"></script>
<div class="ncenter_box">
<div class="accounttitle"><h1>当期出纳 </h1></div>
<table width="100%" class="tab3" border="0" cellpadding="3" cellspacing="1" id="tb1" bgcolor="#b9c8d0">
<thead>
    <tr class="tabletd" align="center">
      <th nowrap ><span>序列号</span></th>
      <th nowrap ><span>结算时间</span></th>
      <th nowrap ><span>当期收入</span></th>
      <th nowrap ><span>当期支出</span></th>
      <th nowrap ><span>本期赢利</span></th>
      <th nowrap ><span>拔出比率</span></th>
    </tr>
</thead>
    <tr class="content_td"  align="center">
      <td>-</td>
      <td>本期</td>
      <td><a href="__APP__/YouZi/adminFinanceList/sDate/<?php echo ($list4); ?>"><?php echo ($list3['0']); ?></a></td>
      <td>0</td>
      <td><?php echo ($list3['0']); ?></td>
      <td>-</td>
    </tr>
	<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="content_td" align="center">
      <td><?php echo ($vo['id']); ?></td>
      <td><?php echo (date('Y-m-d H:i:s',$vo["benqi"])); ?></td>
      <td><a href="__APP__/YouZi/adminFinanceList/sDate/<?php echo ($vo['shangqi']); ?>/eDate/<?php echo ($vo['benqi']); ?>"><?php echo ($list1["$i"]['0']); ?></a></td>
      <td><a href="__APP__/YouZi/adminFinanceTableShow/did/<?php echo ($vo['id']); ?>"><?php echo ($list1["$i"]['1']); ?></a></td>
      <td><?php echo ($list1["$i"]['2']); ?></td>
      <td><?php echo ($list1["$i"]['3']); ?>%</td>
      </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    <tr class="content_td" align="center" >
      <td>合计</td>
      <td>&nbsp;</td>
      <td><?php echo ($list2['1']); ?></td>
      <td><?php echo ($list2['2']); ?></td>
      <td><?php echo ($list2['3']); ?></td>
      <td><?php echo ($list2['4']); ?>%</td>
    </tr>
    </table>
    <table width="100%" class="tab3_bottom" border="0" cellpadding="0" cellspacing="1">
    <tr class="content_td" align="center" >
      <td colspan="6" align="left"><input name="button3" type="button" onclick="window.location.href='__URL__/financeDaoChu_ChuN/p/<?php echo ($PP); ?>/'" value="导出Excel" class="button_text" /></td>
      </tr>
  </table>
    <table width="100%" class="tab3_bottom" border="0" cellpadding="0" cellspacing="1">
    <tr class="content_td" align="center" >
      <td colspan="6"><?php echo ($page); ?></td>
      </tr>

</table>
</div>
</body>
</html>
<script>new TableSorter("tb1");</script>