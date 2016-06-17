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
<div class="accounttitle"><h1><?php echo ($province); ?>会员&nbsp;&nbsp;[<a href='javascript:history.back()'>返回</a>] </h1></div>
<form name="form3" method="post" action="__URL__/adminMenberAC">
<table width="100%" class="tab3" border="0" cellpadding="3" cellspacing="1" id="tb1" bgcolor="#b9c8d0">
	<thead>
    <tr align="center">
        <th><span>会员编号</span></th>
       
        <th><span>推荐人编号</span></th>
        <th><span>服务中心编号</span></th>
       
        <th><span>姓名</span></th>
        <th><span>住址省份</span></th>
        <th><span>住址城市</span></th>
        <th><span>住址联系地址</span></th>
        <th><span>会员类型</span></th>
         <th><span>注册金额</span></th>
      <!--  <th><span>联系电话</span></th>-->
        <!-- <th><span>分公司</span></th> -->
        <th><span>服务中心</span></th>
        <!-- <th><span>注册时间</span></th> -->
        <th><span>开通时间</span></th>
        </tr>
    </thead>
    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="content_td lz" align="center">
        <td><?php echo ($vo['user_id']); ?></td>
        <td><?php echo ($vo['re_name']); ?></td>
        <td><?php echo ($vo['shop_name']); ?></td>
        <td><?php echo ($vo['user_name']); ?></td>
        <td><?php echo ($vo['province']); ?></td>
        <td><?php echo ($vo['city']); ?></td>
        <td><?php echo ($vo['address']); ?></td>
        <td>


              <?php echo ($level[$vo['u_level']]); ?>



        </td>
         <td><?php echo ($vo['cpzj']); ?></td>
       <!-- <td><?php echo ($vo['user_tel']); ?></td>-->
         <!-- <td><?php if(($vo['is_company']) == "2"): ?><span style="color:BLUE;">是</span><?php else: ?>否<?php endif; ?></td> -->
        <td><?php if(($vo['is_agent']) > "1"): ?><span style="color:BLUE;">是</span><?php else: ?>否<?php endif; ?></td>
        <!-- <td><?php echo (date('Y-m-d H:i:s',$vo["rdt"])); ?></td> -->
        <td><?php echo (date('Y-m-d H:i:s',$vo["pdt"])); ?></td>

        </tr><?php endforeach; endif; else: echo "" ;endif; ?>


<tr>
<td colspan="14" align="center"><font color="#FF0000"> 总人数： <?php echo ($f4_count); ?></font></td>
</tr>
</table>

    <!--
   <table width="100%" class="tab3_bottom" border="0" cellpadding="0" cellspacing="1">
       <tr>
            <td width="60%">
         <input name="全选" type="button" class="button_text" id="全选" onclick="CheckAll(this.form)" value="全选" />	  &nbsp;&nbsp;
         <input type="submit" name="action" value="解锁会员" class="button_text" onclick="{if(confirm('确定要解锁会员吗?')){return true;}return false;}">&nbsp;&nbsp;
         <input type="submit" name="action" value="锁定会员" class="button_text" onclick="{if(confirm('确定要锁定会员吗?')){return true;}return false;}">&nbsp;&nbsp;

       <input type="submit" name="action" value="删除会员" class="button_text" onclick="{if(confirm('确定要删除会员吗?')){return true;}return false;}">&nbsp;&nbsp;



         <input type="submit" name="action" value="开启奖励" class="button_text" onclick="{if(confirm('确定要开启奖励吗?')){return true;}return false;}">&nbsp;&nbsp;

         <input type="submit" name="action" value="关闭奖励" class="button_text" onclick="{if(confirm('确定要关闭奖励吗?')){return true;}return false;}">&nbsp;&nbsp;
   -->
       <!--   <input type="submit" name="action" value="解锁升级" class="button_text" onclick="{if(confirm('确定要解锁升级吗?')){return true;}return false;}">&nbsp;&nbsp;  -->


      <!--<input type="submit" name="action" value="开启打卡奖" class="button_text" onclick="{if(confirm('确定要开启打卡奖吗?')){return true;}return false;}">&nbsp;&nbsp;
	  <input type="submit" name="action" value="关闭打卡奖" class="button_text" onclick="{if(confirm('确定要关闭打卡奖吗?')){return true;}return false;}">&nbsp;&nbsp;-->
         <!-- <input type="submit" name="action" value="开启分红奖" class="button_text" onclick="{if(confirm('确定要开启分红奖吗?')){return true;}return false;}">&nbsp;&nbsp; -->
	  <!-- <input type="submit" name="action" value="关闭分红奖" class="button_text" onclick="{if(confirm('确定要关闭分红奖吗?')){return true;}return false;}">&nbsp;&nbsp;
      
      
      <input type="submit" name="action" value="设为服务中心" class="button_text" onclick="{if(confirm('确定要将选中会员设为服务中心吗?')){return true;}return false;}">&nbsp;&nbsp;  -->



      <!-- <input type="submit" name="action" value="设为分公司" class="button_text" onclick="{if(confirm('确定要将选中会员设为分公司吗?')){return true;}return false;}">&nbsp;&nbsp; -->
      <!-- <input type="submit" name="action" value="设为代理商" class="button_text" onclick="{if(confirm('确定要将选中会员设为代理商吗?')){return true;}return false;}">&nbsp;&nbsp; -->
	  <!--<input type="submit" name="action" value="奖励转电子积分" class="button_text" onclick="{if(confirm('确定要将此会员的奖励积分全部转为电子积分吗?')){return true;}return false;}"></td>
    </tr>
</table>-->
<table width="100%" class="tab3_bottom" border="0" cellpadding="0" cellspacing="1">
    <tr>
        <td><?php echo ($page); ?></td>
    </tr>
</table>
</form>


    <!--
  <table width="100%" align="center">
      <tr>
      <td align="center"><form method='post' action="__URL__/member/">搜索会员：<input type="text" name="UserID" placeholder="请根据选择输入相应的查询" style="width: 180px;">


        &nbsp;&nbsp; 条件搜索：
      <select name="action" style="width: 120px;">
            <option value="0">会员编号</option>
            <option value="1">会员名字</option>
            <option value="2">会员类型</option>
            <option value="3">推 荐 人</option>
            <option value="4">服务中心</option>

      </select>  -->


        <!-- 时间：
         <select name="u_type">
                             <option value="">全部</option>
                             <option value="a">0个月</option>
                             <?php if(is_array($s9)): $i = 0; $__LIST__ = $s9;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$svo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($svo); ?>"><?php echo ($svo); ?>个月</option><?php endforeach; endif; else: echo "" ;endif; ?>
         </select> -->
<!--     状态：
    <select name="state_type">
                        <option value="">全部</option>
                        <option value="1">已到期</option>
                        <option value="2">未到期</option>
    </select>
    <input type="submit" name="Submit" value="查询"  class="button_text"/>
    &nbsp;
    <input name="button3" type="button" onclick="window.location.href='__URL__/financeDaoChu_MM/'" value="导出Excel" class="button_text" />
    </form></td>
    </tr>
</table>

-->

<table width="100%" align="center" style="display:none">
    <tr>
    <td align="center"><form method='post' action="__URL__/adminMenber/">搜索会员业绩：
    开始日期：<input name="sNowDate" type="text" id="sNowDate" onFocus="showCalendar(this)" readonly /> 
     &nbsp;结束日期：  <input name="endNowDate" type="text" id="endNowDate" onFocus="showCalendar(this)" readonly />
    
    会员编号 ： <input type="text" name="RID" title="帐号查询">
    <input type="submit" name="Submit" value="查询"  class="button_text"/>
    &nbsp;
    
    </form></td>
    </tr>
</table>





</div>
</body>
</html>
<script>new TableSorter("tb1");</script>