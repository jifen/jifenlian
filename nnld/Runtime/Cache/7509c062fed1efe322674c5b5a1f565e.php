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

<script type="text/javascript" src="__PUBLIC__/Js/UserJs.js"></script>
<div class="ncenter_box">
<div class="accounttitle"><h1>后台修改会员资料&nbsp;&nbsp;[<a href='javascript:history.back()'>返回</a>] </h1></div>
    <form method='post' id="form1" action="__URL__/adminuserDataSave" >
      <table width="100%" border="0" cellpadding="3" cellspacing="0" class="tab4">
        <tr style="display:none;">
          <td width="23%" align="right">所属分公司：</td>
          <td colspan="2" ><input name="companyname" type="text" value="<?php echo ($vo['company_name']); ?>" style="background-color:#ddd" readonly  /></td>
        </tr>



   <!--     <tr>
          <td width="23%" align="right">所属报单中心：</td>
          <td colspan="2" ><input name="shopname" type="text" value="<?php echo ($vo['shop_name']); ?>" style="background-color:#ddd" readonly  /></td>
        </tr>

        -->

        <tr>
          <td align="right">推荐会员编号：</td>
          <td colspan="2" ><input name="ReName" type="text" id="ReName" value="<?php echo ($vo['re_name']); ?>" style="background-color:#ddd" readonly /></td>
        </tr>


   <!--
        <tr>
          <td align="right">安置人：</td>
          <td colspan="2" ><input  type="text"  value="<?php echo (user_id($vo['father_id'])); ?>" style="background-color:#ddd" readonly /></td>
        </tr>

       -->

        <tr style="display:none;">
          <td align="right">节点人编号：</td>
          <td colspan="2" ><input name="father" type="text" id="father" value="<?php echo ($vo['father_name']); ?>" style="background-color:#ddd;" readonly /></td>
        </tr>
        <?php if(empty($User_namex)): else: ?>
        <tr>
        <td align="right"><?php echo ($User_namex); ?>：</td>
          <td width="14%"><input name="UserID" type="text" id="UserID" value="<?php echo ($vo['user_id']); ?>" style="background-color:#ddd;" readonly="readonly" class="ipt"/></td>
          <td width="63%">&nbsp;</td>
        </tr><?php endif; ?>
     <!--   <?php if(empty($Nick_namex)): else: ?>
        <tr>
        <td align="right">姓名：</td>
          <td><input name="NickName" type="text" id="NickName" value="<?php echo ($vo['nickname']); ?>" class="ipt" onkeyup="javascript:Null_Full(this.name)" onfocus="notice('0','')" onblur="notice('0','none')"/></td>
          <td><div id="NickName1" class="info"><div id="0" class="focus_r" style="display:none;"><div class="msg_tip">请输入姓名。</div></div></div></td>
        </tr><?php endif; ?> -->
        <tr>
          <td align="right">一级密码：</td>
          <td><input name="pwd1" type="text" id="pwd1" value="<?php echo ($vo['pwd1']); ?>" class="ipt" onfocus="notice('1','')"  onblur="" /></td>
          <td></td>
        </tr>
        <tr>
          <td align="right">二级密码：</td>
          <td><input name="pwd2" type="text" id="pwd2" class="ipt" value="<?php echo ($vo['pwd2']); ?>" onfocus="notice('2','')"  onblur=""/></td>
          <td></td>
        </tr>
<!--          <tr>
          <td align="right">三级密码：</td>
          <td><input name="pwd3" type="text" id="pwd3" class="ipt" value="<?php echo ($vo['pwd3']); ?>" onfocus="notice('2','')"  onblur=""/></td>
          <td></td>
        </tr> -->
        
        <tr style="display:none">
          <td colspan="3" style="height:5px;"><hr></td>
        </tr>
        <tr style="display:none">
          <td align="right">密保问题：</td>
          <td><input name="wenti" type="text" id="wenti" class="ipt" value="<?php echo ($vo['wenti']); ?>"/></td>
          <td></td>
        </tr>
        <tr style="display:none">
          <td align="right">密保答案：</td>
          <td><input name="wenti_dan" type="text" id="wenti_dan" class="ipt" value="<?php echo ($vo['wenti_dan']); ?>"/></td>
          <td></td>
        </tr>
        <tr>
          <td colspan="3" style="height:5px;"><hr></td>
        </tr>
        <tr>
          <td align="right">开户银行：</td>
          <td><select name="BankName" onchange="javasctip:bank_us(this.value);" style="width: 130px;">

            <option value="中国工商银行" <?php if(($vo["bank_name"]) == "中国工商银行"): ?>selected<?php endif; ?>>中国工商银行</option>
            <option value="中国建设银行" <?php if(($vo["bank_name"]) == "中国建设银行"): ?>selected<?php endif; ?>>中国建设银行</option>
            <option value="中国交通银行" <?php if(($vo["bank_name"]) == "中国交通银行"): ?>selected<?php endif; ?>>中国交通银行</option>
            <option value="中国农业银行" <?php if(($vo["bank_name"]) == "中国农业银行"): ?>selected<?php endif; ?>>中国农业银行</option>
            <option value="中国招商银行" <?php if(($vo["bank_name"]) == "中国招商银行"): ?>selected<?php endif; ?>>中国招商银行</option>

            </select></td>
          <td>&nbsp;</td>
        </tr>


        <tr>
          <td align="right">开户姓名：</td>
          <td><input name="UserName" type="text" id="UserName" class="ipt" value="<?php echo ($vo['user_name']); ?>" onkeyup="javascript:Null_Full(this.name)" onfocus="notice('4','')"  onblur="notice('4','none')" /></td>
          <td><div id="UserName1" class="info"><div id="4" class="focus_r" style="display:none;"><div class="msg_tip">请输入您的姓名。</div></div></div></td>
        </tr>


        <tr>
          <td align="right">身份证号：</td>
          <td><input name="UserCode" type="text" id="UserCode" value="<?php echo ($vo['user_code']); ?>" maxlength="18" class="ipt" onkeyup="javascript:Null_Int(this.name)" onfocus="notice('8','')"  onblur="notice('8','none')" /></td>
          <td><div id="UserCode1" class="info"><div id="8" class="focus_r" style="display:none;"><div class="msg_tip">请输入您的身份证号。</div></div></div></td>
        </tr>



        <tr>
          <td align="right"><span id="bank_id"><?php if(($vo['bank_name']) == "财付通"): ?>财付通号<?php else: ?>银行卡号<?php endif; ?></span>：</td>
          <td><input name="BankCard" type="text" id="BankCard" value="<?php echo ($vo['bank_card']); ?>" class="ipt" onkeyup="javascript:Null_Int(this.name)" onfocus="notice('3','')"  onblur="notice('3','none')" /></td>
          <td><div id="BankCard1" class="info"><div id="3" class="focus_r" style="display:none;"><div class="msg_tip">请输入号码。</div></div></div></td>
        </tr>




  <!--      <tr>
          <td align="right">收货省份：</td>
          <td nowrap="nowrap"><input name="BankProvince" type="text" class="ipt" value="<?php echo ($vo['bank_province']); ?>" size="18" onkeyup="javascript:Null_Full(this.name)" onfocus="notice('5','')"  onblur="notice('5','none')" /></td>
          <td><div id="BankProvince1" class="info"><div id="5" class="focus_r" style="display:none;"><div class="msg_tip">请输入您的收货省份。</div></div></div></td>
        </tr>



        <tr>
          <td align="right">收货城市：</td>
          <td nowrap="nowrap"><input name="BankCity"     type="text" class="ipt" value="<?php echo ($vo['bank_city']); ?>" size="18" onkeyup="javascript:Null_Full(this.name)" onfocus="notice('6','')"  onblur="notice('6','none')" /></td>
          <td><div id="BankCity1" class="info"><div id="6" class="focus_r" style="display:none;"><div class="msg_tip">请输入您的收货城市。</div></div></div></td>
        </tr>

    -->


        <tr>
          <td align="right">详细开户地址：</td>
          <td nowrap="nowrap"><input name="BankAddress" type="text" id="BankAddress" class="ipt" value="<?php echo ($vo['bank_address']); ?>" size="20" onkeyup="javascript:Null_Full(this.name)" onfocus="notice('7','')"  onblur="notice('7','none')" /></td>
          <td><div id="BankAddress1" class="info"><div id="7" class="focus_r" style="display:none;"><div class="msg_tip">请输入您的详细开户地址。</div></div></div></td>
        </tr>


        <!--
        <tr>
          <td align="right">身份证号：</td>
          <td><input name="UserCode" type="text" id="UserCode" value="<?php echo ($vo['user_code']); ?>" maxlength="18" class="ipt" onkeyup="javascript:Null_Int(this.name)" onfocus="notice('8','')"  onblur="notice('8','none')" /></td>
          <td><div id="UserCode1" class="info"><div id="8" class="focus_r" style="display:none;"><div class="msg_tip">请输入您的身份证号。</div></div></div></td>
        </tr>
        <tr>
          <td align="right">联系地址：</td>
          <td><input name="UserAddress" type="text" id="UserAddress" value="<?php echo ($vo['user_address']); ?>" size="20" maxlength="80" class="ipt" onkeyup="javascript:Null_Full(this.name)" onfocus="notice('9','')"  onblur="notice('9','none')" /></td>
          <td><div id="UserAddress1" class="info"><div id="9" class="focus_r" style="display:none;"><div class="msg_tip">请输入您的联系地址。</div></div></div></td>
        </tr>

        <tr>
          <td align="right">Q Q：</td>
          <td><input name="qq" type="text" id="qq" value="<?php echo ($vo['qq']); ?>" maxlength="45" size="20"  class="ipt" onkeyup="javascript:Null_Int(this.name)" onfocus="notice('12','')"  onblur="notice('12','none')" /></td>
          <td><div id="qq1" class="info"><div id="12" class="focus_r" style="display:none;"><div class="msg_tip">请输入您的 Q Q。</div></div></div></td>
        </tr>

        -->

        <tr>
          <td align="right">手机号码：</td>
          <td><input name="UserTel" type="text" id="UserTel" value="<?php echo ($vo['user_tel']); ?>" maxlength="45" size="20"  class="ipt" onkeyup="javascript:Null_Full(this.name)" onfocus="notice('10','')"  onblur="notice('10','none')" /></td>
          <td><div id="UserTel1" class="info"><div id="10" class="focus_r" style="display:none;"><div class="msg_tip">请输入您的手机号码。</div></div></div></td>
        </tr>


        <tr>
          <td height="30" align="right">住址省份：</td>
          <td><input size="20" name="province" id="province" type="text" value="<?php echo ($vo['province']); ?>" class="ipt" /></td>
          <td></td>
        </tr>
        <tr>
          <td height="30" align="right">住址城市：</td>
          <td><input size="20" name="city" id="city" type="text" value="<?php echo ($vo['city']); ?>" class="ipt" /></td>
          <td></td>
        </tr>


        <tr>
          <td height="30" align="right">详细联系地址：</td>
          <td><input size="20" name="address" type="text" id="address" value="<?php echo ($vo['address']); ?>" class="ipt" onkeyup="javascript:Null_Full(this.name)" onfocus="notice('77','')"  onblur="notice('77','none')"/></td>
          <td><div id="address1" class="info"><div id="77" class="focus_r" style="display:none;"><div class="msg_tip">请输入详细联系地址。</div></div></div></td>
        </tr>

    <!--    <tr>
          <td align="right">收货地址：</td>
          <td><input name="get_address" type="text" id="get_address" value="<?php echo ($vo['get_address']); ?>" maxlength="45" size="20"  class="ipt" onkeyup="javascript:Null_Full(this.name)" onfocus="notice('1000','')"  onblur="notice('1000','none')" /></td>
          <td><div id="get_address1" class="info"><div id="1000" class="focus_r" style="display:none;"><div class="msg_tip">请输入您的收货地址。</div></div></div></td>
        </tr>  -->


        <tr style="display: none;">
          <td align="right">E-Mail：</td>
          <td><input name="email" type="text" id="email" value="<?php echo ($vo['email']); ?>" maxlength="45" size="20"  class="ipt" onkeyup="javascript:Email(this.name)" onfocus="notice('11','')"  onblur="notice('11','none')" /></td>
          <td><div id="email1" class="info"><div id="11" class="focus_r" style="display:none;"><div class="msg_tip">请输入您的 E-Mail。</div></div></div></td>
        </tr>

        <tr>
          <td colspan="3" style="height:5px;"><hr></td>
        </tr>


        <?php if(($isAdmin) == "1"): ?><tr>
          <td align="right">奖励账户：</td>
          <td><input name="AgentUse" type="text" id="AgentUse" value="<?php echo ($vo['agent_use']); ?>" maxlength="20" class="ipt" onkeyup="javascript:Null_Int(this.name)" onfocus="notice('13','')"  onblur="notice('13','none')"/></td>
          <td><div id="AgentUse1" class="info"><div id="13" class="focus_r" style="display:none;"><div class="msg_tip">请输入数字。</div></div></div></td>
        </tr>


        <tr style="">
          <td align="right"> 注册积分：</td>
          <td><input name="AgentCash" type="text" id="AgentCash" value="<?php echo ($vo['agent_cash']); ?>" maxlength="20" class="ipt" onkeyup="javascript:Null_Int(this.name)" onfocus="notice('14','')"  onblur="notice('14','none')"/></td>
          <td><div id="AgentCash1" class="info"><div id="14" class="focus_r" style="display:none;"><div class="msg_tip">请输入数字。</div></div></div></td>
        </tr>




         <!--      <tr >
                 <td align="right">消费积分：</td>
                 <td><input name="agent_xf" type="text" id="agent_xf" value="<?php echo ($vo['agent_xf']); ?>" maxlength="20" class="ipt" onkeyup="javascript:Null_Int(this.name)" onfocus="notice('22','')"  onblur="notice('22','none')" /></td>
                 <td><div id="agent_xf1" class="info"><div id="22" class="focus_r" style="display:none;"><div class="msg_tip">请输入数字。</div></div></div></td>
               </tr>


               <tr style="">
                 <td align="right">活跃积分：</td>
                 <td><input name="AgentCf" type="text" id="AgentCf" value="<?php echo ($vo['agent_cf']); ?>" maxlength="20" class="ipt" onkeyup="javascript:Null_Int(this.name)" onfocus="notice('14','')"  onblur="notice('14','none')"/></td>
                 <td><div id="AgentCf1" class="info"><div id="14" class="focus_r" style="display:none;"><div class="msg_tip">请输入数字。</div></div></div></td>
               </tr>    -->


          <tr style="">
            <td align="right">VAP积分：</td>
            <td><input name="AgentGc" type="text" id="AgentGc" value="<?php echo ($vo['agent_gc']); ?>" maxlength="20" class="ipt" onkeyup="javascript:Null_Int(this.name)" onfocus="notice('14','')"  onblur="notice('14','none')"/></td>
            <td><div id="AgentGc1" class="info"><div id="14" class="focus_r" style="display:none;"><div class="msg_tip">请输入数字。</div></div></div></td>
          </tr>


    <!--      <tr style="">
            <td align="right">消费基金：</td>
            <td><input name="AgentGp" type="text" id="AgentGp" value="<?php echo ($vo['agent_gp']); ?>" maxlength="20" class="ipt" onkeyup="javascript:Null_Int(this.name)" onfocus="notice('194','')"  onblur="notice('194','none')"/></td>
            <td><div id="AgentGp1" class="info"><div id="194" class="focus_r" style="display:none;"><div class="msg_tip">请输入数字。</div></div></div></td>
          </tr>  -->





          <tr>
            <td align="right">会员级别：</td>
            <td><select name="u_level" style="width: 130px;">

              <?php if(is_array($s4)): $k = 0; $__LIST__ = $s4;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><option value="<?php echo ($k-1); ?>"
                <?php if($vo["u_level"] == $k-1): ?>selected<?php endif; ?>

              ><?php echo ($v); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>


            </select></td>
            <td>&nbsp;</td>
          </tr><?php endif; ?>





        <tr style="display:none">
          <td align="right">开通积分：</td>
          <td><input name="AgentKt" type="text" id="AgentKt" value="<?php echo ($vo['agent_kt']); ?>" maxlength="20" class="ipt" onkeyup="javascript:Null_Int(this.name)" onfocus="notice('AgentKt1','')"  onblur="notice('AgentKt1','none')" /></td>
          <td><div id="AgentKt1" class="info" style="display:none;"><div class="focus_r"><div class="msg_tip">请输入数字。</div></div></div></td>
        </tr>
        <tr style="display: none;">
          <td align="right">购物积分：</td>
          <td><input name="AgentXf" type="text" id="AgentXf" value="<?php echo ($vo['agent_xf']); ?>" maxlength="20" class="ipt" onkeyup="javascript:Null_Int(this.name)" onfocus="notice('AgentXf1','')"  onblur="notice('AgentXf1','none')" /></td>
          <td><div id="AgentXf1" class="info" style="display:none;"><div class="focus_r"><div class="msg_tip">请输入数字。</div></div></div></td>
        </tr>

        <tr style="display:none">
          <td align="right">股积分：</td>
          <td><input name="gp_num" type="text" id="gp_num" value="<?php echo ($vo['gp_num']); ?>" maxlength="20" class="ipt" onkeyup="javascript:Null_Int(this.name)" onfocus="notice('gp_num1','')"  onblur="notice('gp_num1','none')" /></td>
          <td><div id="gp_num1" class="info" style="display:none;"><div class="focus_r"><div class="msg_tip">请输入数字。</div></div></div></td>
        </tr>
        <tr style="display:none">
          <td align="right">网络结构图：</td>
          <td><input name="wang_j" type="radio" id="wang_j" value="0" <?php if(($vo['wang_j']) == "0"): ?>checked<?php endif; ?> class="ipt_radi"/>
          开启
          <input type="radio" name="wang_j" id="wang_j" value="1" <?php if(($vo['wang_j']) == "1"): ?>checked<?php endif; ?> class="ipt_radi"/>
          关闭</td>
          <td>&nbsp;</td>
        </tr>
        <tr style="display:none">
          <td align="right">推荐结构图：</td>
          <td><input name="wang_t" type="radio" id="wang_t" value="0" <?php if(($vo['wang_t']) == "0"): ?>checked<?php endif; ?> class="ipt_radi"/>
          开启
          <input type="radio" name="wang_t" id="wang_t" value="1" <?php if(($vo['wang_t']) == "1"): ?>checked<?php endif; ?> class="ipt_radi"/>
          关闭</td>
          <td>&nbsp;</td>
        </tr>
        <tr style="display:none">
          <td align="right">总奖励：</td>
          <td><input name="zjj" type="text" id="zjj" value="<?php echo ($vo['zjj']); ?>" maxlength="20" class="ipt" onkeyup="javascript:Null_Int(this.name)" onfocus="notice('15','')"  onblur="notice('15','none')" /></td>
          <td><div id="zjj1" class="info"><div id="15" class="focus_r" style="display:none;"><div class="msg_tip">请输入数字。</div></div></div></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="2"><input type="hidden" name="ID" value="<?php echo ($vo['id']); ?>" >
            <input type="submit" value="修改" class="button_text">
            &nbsp;
            <input type="reset" value="重设" class="button_text">
            &nbsp;
            <input type="button" value="返回" class="button_text" onclick="javescript:window.location.href='__URL__/adminMenber'"/></td>
        </tr>
      </table>
    </form>
</div>
</body></html>