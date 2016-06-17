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
<style>
.us img{border:1px solid #999; width:100px; height:100px;}
.us_btn{height:27px; line-height:27px; font-size:12px; font-weight:bold; padding:0 10px; text-decoration:underline;}
</style>
<div class="ncenter_box">
<div class="accounttitle"><h1>修改资料 </h1></div>

    <div class="c_p5"><div class="tips">请认真修改自己的个人信息。</div></div>
        <table width="100%" border="0" cellpadding="3" cellspacing="0">
          <form method='post' id="form1" action="__URL__/changedataSave" >
          <tr>
            <td colspan="3" style="height:5px;"></td>
            </tr>


    <!--
          <tr>
            <td width="25%" height="30" align="right">所属报单中心：</td>
            <td width="25%"><input size="40" name="UserID" type="text" id="UserID" value="<?php echo ($vo['shop_name']); ?>" style="background-color:#ddd;" readonly="readonly" class="ipt" /></td>
            <td width="50%">&nbsp;</td>
            </tr>  -->


          <tr>
            <td width="25%" height="30" align="right">推荐人：</td>
            <td width="25%"><input size="40" name="UserID2" type="text" id="UserID2" value="<?php echo ($vo['re_name']); ?>" style="background-color:#ddd;" readonly="readonly" class="ipt" /></td>
            <td width="50%">&nbsp;</td>
            </tr>
            
          <tr style="display:none;">
            <td height="30" align="right">接点人：</td>
            <td><input size="40" name="UserID3" type="text" id="UserID3" value="<?php echo ($vo['father_name']); ?>" style="background-color:#ddd;" readonly="readonly"  class="ipt"/></td>
            <td>&nbsp;</td>
            </tr>

        <tr>
        <td height="30" align="right">会员编号：</td>
          <td><input size="40" name="UserID" type="text" id="UserID" value="<?php echo ($vo['user_id']); ?>" style="background-color:#ddd;" readonly="readonly" class="ipt"/></td>
          <td>&nbsp;</td>
        </tr>


    <!--    <tr>
            <td width="25%" height="30" align="right">姓名：</td>
            <td width="25%"><input size="40" name="NickName" type="text" id="NickName" value="<?php echo ($vo['nickname']); ?>" class="ipt"  style="background-color:#ddd;" readonly="readonly" /></td>
            <td width="50%">&nbsp;</td>
            </tr>   -->

            <tr>
              <td height="30" colspan="3" style="height:5px;"><hr></td>
            </tr>


            <tr>
              <td height="30" align="right">开户姓名：</td>
              <td><input size="40" name="UserName" type="text" id="UserName" value="<?php echo ($vo['user_name']); ?>" class="ipt"  /></td>
              <td></td>
            </tr>

            <tr>
              <td height="30" align="right">身份证号：</td>
              <td><input size="40" name="UserCode" type="text" id="UserCode" value="<?php echo ($vo['user_code']); ?>" class="ipt"/></td>
              <td></td>
            </tr>


          <tr>
            <td height="30" align="right">开户银行：</td>
        <td><select name="BankName" id="BankName" style="width: 250px;">
            <option value="中国工商银行" <?php if(($vo["bank_name"]) == "中国工商银行"): ?>selected<?php endif; ?>>中国工商银行</option>
            <option value="中国建设银行" <?php if(($vo["bank_name"]) == "中国建设银行"): ?>selected<?php endif; ?>>中国建设银行</option>
            <option value="中国交通银行" <?php if(($vo["bank_name"]) == "中国交通银行"): ?>selected<?php endif; ?>>中国交通银行</option>
            <option value="中国农业银行" <?php if(($vo["bank_name"]) == "中国农业银行"): ?>selected<?php endif; ?>>中国农业银行</option>
            <option value="中国招商银行" <?php if(($vo["bank_name"]) == "中国招商银行"): ?>selected<?php endif; ?>>中国招商银行</option>

                </select>
            </td>

            <td>&nbsp;</td>
          </tr>
          <tr>
            <td height="30" align="right"><span id="bank_id">银行卡号</span>：</td>
            <td><input size="40" name="BankCard" type="text" id="BankCard" value="<?php echo ($vo['bank_card']); ?>" class="ipt" maxlength="19" /></td>
            <td></td>
            </tr>







          <tr>
            <td height="30" align="right">详细开户地址：</td>
            <td><input size="40" name="BankAddress" type="text" id="BankAddress" value="<?php echo ($vo['bank_address']); ?>" class="ipt" /></td>
            <td></td>
            </tr>

       <!--
          <tr>
            <td height="30" colspan="3" style="height:5px;"><hr></td>
            </tr>
          <tr>
            <td height="30" align="right">身份证号：</td>
            <td><input size="40" name="UserCode" type="text" id="UserCode" value="<?php echo ($vo['user_code']); ?>" class="ipt"/></td>
            <td></td>
            </tr>
          <tr>
            <td height="30" align="right">Q Q 号码：</td>
            <td><input size="40" name="qq" type="text" id="qq" value="<?php echo ($vo['qq']); ?>" class="ipt" onkeyup="javascript:Null_Int(this.name)" onfocus="notice('9','')"  onblur="notice('9','none')" maxlength="19" /></td>
            <td><div id="qq1" class="info"><div id="9" class="focus_r" style="display:none;"><div class="msg_tip">请输入号码。</div></div></div></td>
          </tr>
          <tr>
            <td height="30" align="right">联系地址：</td>
            <td><input size="40" name="UserAddress" type="text" id="UserAddress" value="<?php echo ($vo['user_address']); ?>" class="ipt" onkeyup="javascript:Null_Full(this.name)" onfocus="notice('6','')"  onblur="notice('6','none')"/></td>
            <td><div id="UserAddress1" class="info"><div id="6" class="focus_r" style="display:none;"><div class="msg_tip">请输入联系地址。</div></div></div></td>
            </tr>

            -->

          <tr>
            <td height="30" align="right">手机号码：</td>
            <td><input size="40" name="UserTel" type="text" id="UserTel" value="<?php echo ($vo['user_tel']); ?>" class="ipt" onkeyup="javascript:Null_Full(this.name)" onfocus="notice('7','')"  onblur="notice('7','none')"/></td>
            <td><div id="UserTel1" class="info"><div id="7" class="focus_r" style="display:none;"><div class="msg_tip">请输入手机号码。</div></div></div></td>
            </tr>


              <tr>
                  <td height="30" align="right">住址省份：</td>
                  <td><input size="40" name="province" id="province" type="text" value="<?php echo ($vo['province']); ?>" class="ipt" /></td>
                  <td></td>
              </tr>
              <tr>
                  <td height="30" align="right">住址城市：</td>
                  <td><input size="40" name="city" id="city" type="text" value="<?php echo ($vo['city']); ?>" class="ipt" /></td>
                  <td></td>
              </tr>


              <tr>
                  <td height="30" align="right">详细联系地址：</td>
                  <td><input size="40" name="address" type="text" id="address" value="<?php echo ($vo['address']); ?>" class="ipt" onkeyup="javascript:Null_Full(this.name)" onfocus="notice('77','')"  onblur="notice('77','none')"/></td>
                  <td><div id="address1" class="info"><div id="77" class="focus_r" style="display:none;"><div class="msg_tip">请输入详细联系地址。</div></div></div></td>
              </tr>



              <tr>
                  <td height="30" align="right">验证码：</td>
                  <td><input name="yanzhengmas" type="text" class="ipt"  onblur="yanzhengma(this.value)"/>&nbsp;&nbsp;<br/><input type="button" id="fasong"  value="发送短信" onclick="send(<?php echo ($id); ?>)">&nbsp;&nbsp;<a id="msgd"></a></td>
                  <td></td>
              </tr>



              <tr>
            <td height="30" align="right">注册时间：</td>
            <td><?php if(isset($vo['rdt'])): echo (date('Y-m-d H:i:s',$vo['rdt'])); ?>
                  <?php else: ?>
              无<?php endif; ?></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td height="30" align="right">开通时间：</td>
            <td>
            <?php if(($vo['is_pay']) == "0"): ?>未开通
            <?php else: ?>
            <?php echo (date('Y-m-d H:i:s',$vo['pdt'])); endif; ?></td>
            <td>&nbsp;</td>
          </tr>
          <tr style="display:none">
            <td height="30" align="right">修改密保问题：</td>
            <td>
          <select name="xg_wenti">
            	<option value="">选择密保问题</option>
              <?php if(is_array($wentilist)): $i = 0; $__LIST__ = $wentilist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($voo); ?>" <?php if(($voo) == $vo['wenti']): ?>selected<?php endif; ?> ><?php echo ($voo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select></td>
            <td></td>
          </tr>
          <tr style="display:none">
            <td height="30" align="right">修改密保答案：</td>
            <td><input size="40" name="xg_wenti_dan" type="text" id="xg_wenti_dan" value="" class="ipt"/></td>
            <td><div class="info"><div class="focus_r"><div class="msg_tip">不修改请留空。</div></div></div></td>
          </tr>
          <tr style="display:none">
            <td height="30" colspan="3" style="height:5px;"><hr></td>
          </tr>
          <tr style="display:none">
            <td height="30" align="right">密保问题：</td>
            <td><?php echo ($vo['wenti']); ?></td>
            <td>&nbsp;</td>
            </tr>
          <tr style="display:none">
            <td height="30" align="right">请回答密保答案：</td>
            <td><input size="40" name="wenti_dan" type="text" id="wenti_dan" value="" class="ipt"/></td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td colspan="3" style="height:5px;"><hr></td>
            </tr>
          <tr>
          <tr>
            <td height="25" colspan="3" align="center">
            <input size="40" type="hidden" name="ID" value="<?php echo ($vo['id']); ?>" >
            <input size="40" type="submit" value="修改" class="button_text">&nbsp;&nbsp;
            <input size="40" name="重置" type="reset" class="button_text" value="重置"></td>
          </tr>
          </form>
        </table>
</div>
</body>
</html>
<script>
var i=document.getElementById("BankName").selectedIndex;
function setDefault() {
    document.getElementById("BankName").selectedIndex=i;
}
function send(uid) {
    $.ajax({
        method: "POST",
        url: "__APP__/Change/sendmessage",
        data: { uid: uid ,type: 2}
    })
            .done(function( msg ) {
                $("#msgd").html(msg);
                if(msg == "验证码已经发送,请注意查收"){

                  //  $('#fasong').val("已发送");
                    time();
                }
            });
}


var wait=60;
function time() {
    if (wait == 0) {
        $('#fasong').attr("disabled",false);
        $('#fasong').val("发送短信");
        $("#msgd").html('');
        wait = 60;
    } else {
        $('#fasong').val(wait+"s后可发送");
        $('#fasong').attr("disabled",true);
        wait--;
        setTimeout(function() {
                    time()
                },
                1000)
    }
}


function yanzhengma(yanzhengma) {
    $.ajax({
        method: "POST",
        url: "__APP__/Change/yanzhengma",
        data: { yanzhen: yanzhengma,type: 2}
    })
            .done(function( msg ) {
                $("#msgd").html(msg);
            });
}
</script>