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
<div class="accounttitle"><h1><?php echo ($title); ?></h1> </div>
<table width="100%" class="tab3" border="0" cellpadding="5" cellspacing="0" id="tb1">
<form name="form3" method="post" action="__URL__/premAddSave">
<tr>
				<td align="right" >&nbsp;</td>
				<td >&nbsp;</td>
</tr>
<tr>
				<td align="right" >权限：</td>
				<td >
                <select name="isBoss" size="1" id="isBoss">
				    <option value="0" <?php if(($rs['is_boss']) == "0"): ?>selected="selected"<?php endif; ?> >无权限</option>
				    <option value="2" <?php if(($rs['is_boss']) == "2"): ?>selected="selected"<?php endif; ?> >有权限</option>
			    </select>
                </td>
</tr>
<tr>
				<td width="39%" align="right" ><strong>后台管理</strong></td>
				<td width="61%" ><input name="全选" type="button" class="button_text" id="全选" onclick="CheckAll(this.form)" value="全选" /></td>
</tr>
<tr>
				<td align="right" >&nbsp;</td>
				<td ><span class="center">
								<input name="is_boss[]" type="checkbox" id="is_boss[]" value="1" <?php echo ($ars[1]); ?> />
				</span>当期出纳</td>
</tr>
<tr>
				<td align="right" >&nbsp;</td>
				<td ><span class="center">
								<input name="is_boss[]" type="checkbox" id="is_boss[]" value="2" <?php echo ($ars[2]); ?> />
				奖励查询</span></td>
</tr>
<tr>
				<td align="right" >&nbsp;</td>
				<td ><span class="center">
								<input name="is_boss[]" type="checkbox" id="is_boss[]" value="3" <?php echo ($ars[3]); ?> />
				会员审核</span></td>
</tr>
<tr>
				<td align="right" >&nbsp;</td>
				<td ><span class="center">
								<input name="is_boss[]" type="checkbox" id="is_boss[]" value="4" <?php echo ($ars[4]); ?> />
				会员管理</span></td>
</tr>
<tr>
				<td align="right" >&nbsp;</td>
				<td ><span class="center">
								<input name="is_boss[]" type="checkbox" id="is_boss[]" value="8" <?php echo ($ars[8]); ?> />
				充值管理</span></td>
</tr>




<tr>
				<td align="right" >&nbsp;</td>
				<td ><span class="center">
								<input name="is_boss[]" type="checkbox" id="is_boss[]" value="16" <?php echo ($ars[16]); ?> />
				产品管理</span></td>
</tr>



<!--

<tr>
				<td align="right" >&nbsp;</td>
				<td ><span class="center">
								<input name="is_boss[]" type="checkbox" id="is_boss[]" value="5" <?php echo ($ars[5]); ?> />
				服务中心</span></td>
</tr>

-->


<tr>
				<td align="right" >&nbsp;</td>
				<td ><span class="center">
								<input name="is_boss[]" type="checkbox" id="is_boss[]" value="14" <?php echo ($ars[14]); ?> />
				结算销售奖</span></td>
</tr>



<tr>
				<td align="right" >&nbsp;</td>
				<td ><span class="center">
								<input name="is_boss[]" type="checkbox" id="is_boss[]" value="6" <?php echo ($ars[6]); ?> />
				结算服务佣金</span></td>
</tr>


	<tr>
		<td align="right" >&nbsp;</td>
		<td ><span class="center">
                    			<input name="is_boss[]" type="checkbox" id="is_boss[]" value="9" <?php echo ($ars[9]); ?> />
                结算市场积分</span></td>
	</tr>

	<tr>
		<td align="right" >&nbsp;</td>
		<td ><span class="center">
								<input name="is_boss[]" type="checkbox" id="is_boss[]" value="15" <?php echo ($ars[15]); ?> />
				结算董事奖励</span></td>
	</tr>

<tr>
				<td align="right" >&nbsp;</td>
				<td ><span class="center">
								<input name="is_boss[]" type="checkbox" id="is_boss[]" value="17" <?php echo ($ars[17]); ?> />
				奖励明细</span></td>
</tr>

<tr>
				<td align="right" >&nbsp;</td>
				<td ><span class="center">
								<input name="is_boss[]" type="checkbox" id="is_boss[]" value="7" <?php echo ($ars[7]); ?> />
				提现管理</span></td>
</tr>

<tr>
				<td align="right" >&nbsp;</td>
				<td ><span class="center">
								<input name="is_boss[]" type="checkbox" id="is_boss[]" value="10" <?php echo ($ars[10]); ?> />
				新闻公告</span></td>
</tr>










<tr>
                <td align="right" >&nbsp;</td>
                <td ><span class="center">
                    			<input name="is_boss[]" type="checkbox" id="is_boss[]" value="18" <?php echo ($ars[18]); ?> />
                省级人数</span></td>
</tr>




<tr>
                <td align="right" >&nbsp;</td>
                <td ><span class="center">
                    			<input name="is_boss[]" type="checkbox" id="is_boss[]" value="19" <?php echo ($ars[19]); ?> />
                首页图片</span></td>
</tr>

<tr>
				<td align="right" >&nbsp;</td>
				<td ><span class="center">
								<input name="is_boss[]" type="checkbox" id="is_boss[]" value="11" <?php echo ($ars[11]); ?> />
				数据库备份</span></td>
</tr>
<tr>
				<td align="right" >&nbsp;</td>
				<td ><span class="center">
								<input name="is_boss[]" type="checkbox" id="is_boss[]" value="12" <?php echo ($ars[12]); ?> />
				参数设置</span></td>
</tr>





<tr>
				<td align="right" >&nbsp;</td>
				<td ><span class="center">
								<input name="is_boss[]" type="checkbox" id="is_boss[]" value="20" <?php echo ($ars[20]); ?> />
				物流管理</span></td>
</tr>

	<tr>
		<td align="right" >&nbsp;</td>
		<td ><span class="center">
								<input name="is_boss[]" type="checkbox" id="is_boss[]" value="21" <?php echo ($ars[21]); ?> />
				积分纪录</span></td>
	</tr>



	<tr>
		<td align="right" >&nbsp;</td>
		<td ><span class="center">
								<input name="is_boss[]" type="checkbox" id="is_boss[]" value="22" <?php echo ($ars[22]); ?> />
				VAP解冻记录</span></td>
	</tr>




	<tr>
		<td align="right" >&nbsp;</td>
		<td ><span class="center">
								<input name="is_boss[]" type="checkbox" id="is_boss[]" value="23" <?php echo ($ars[23]); ?> />
				IP白名单</span></td>
	</tr>





	<tr>
		<td align="right" >&nbsp;</td>
		<td ><span class="center">
								<input name="is_boss[]" type="checkbox" id="is_boss[]" value="13" <?php echo ($ars[13]); ?> />
				清空数据</span></td>
	</tr>








<tr>
				<td align="right" ><input name="id" type="hidden" id="id" value="<?php echo ($rs['id']); ?>" /></td>
				<td ><input type="submit" name="button" id="button" value="提交" class="button_text" />&nbsp;
                <input type="button" name="button" id="button" value="返回" class="button_text" onclick="history.back();"/></td>
</tr>
<tr align="center">
	<td colspan="2">&nbsp;</td>
</tr>
</form>
</table>
    </div>
    <div class="bar_foot"></div>
</div>
</body>
</html>