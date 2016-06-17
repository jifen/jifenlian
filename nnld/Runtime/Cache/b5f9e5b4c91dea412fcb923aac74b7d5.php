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
<div class="accounttitle"><h1>修改密码 </h1></div>
    <div class="c_p5"><div class="tips">请选择修改密码级别，输入旧密码及您要修改成为的新密码，输入验证码，点击确认。 </div></div>
        <table width="100%" border="0" cellpadding="3" cellspacing="0">
        <form method='post' name="login" action="__URL__/changepasswordSave/">
          <tr>
            <td colspan="3" class="tabletd">&nbsp;</td>
            </tr>
          <tr>
            <td width="30%" align="right">密码级别：</td>
            <td width="20%"><input name="type" type="radio" class="ipt_radi" value="1" checked="checked" />
              一级&nbsp;&nbsp;&nbsp;&nbsp;
  <input type="radio" name="type" value="2" class="ipt_radi" />
              二级  &nbsp;&nbsp;&nbsp;&nbsp;
              
                <!-- <input type="radio" name="type" value="3" class="ipt_radi" />
              三级 -->
              </td>
            <td width="50%">&nbsp;</td>
          </tr>
          <tr>
            <td width="29%" align="right">旧密码：</td>
            <td width="14%"><input name="oldpassword" id="oldpassword" type="password" maxlength="50" class="ipt" onkeyup="javascript:Null_Full(this.name)" onfocus="notice('0','')"  onblur="notice('0','none')"/></td>
            <td width="57%"><div id="oldpassword1" class="info"><div id="0" class="focus_r" style="display:none;"><div class="msg_tip">请输入旧密码。</div></div></div></td>
          </tr>
          <tr>
            <td align="right">新密码：</td>
            <td><input  name="password" id="password" type="password" maxlength="50" class="ipt" onkeyup="javascript:Null_Full(this.name)" onfocus="notice('1','')" onblur="notice('1','none')"/></td>
            <td><div id="password1" class="info"><div id="1" class="focus_r" style="display:none;"><div class="msg_tip">请输入新密码。</div></div></div></td>
          </tr>
          <tr>
            <td align="right">确认新密码：</td>
            <td><input  name="repassword" id="repassword" type="password" maxlength="50" class="ipt" onkeyup="javascript:yhrePass(this.name,'password')" onfocus="notice('2','')" onblur="notice('2','none')"//></td>
            <td><div id="repassword1" class="info"><div id="2" class="focus_r" style="display:none;"><div class="msg_tip">确认新密码。</div></div></div></td>
          </tr>



     <!--     <tr>
            <td align="right">验证码：</td>
            <td><input name="verify" type="text" class="small bLeftRequire" size="4" maxlength="4" />
                <img src="__APP__/Public/verify/" border="0" alt="点击刷新验证码" id="verifyImg" onclick="fleshVerify()" style="cursor:pointer" align="absmiddle" />&nbsp;</td>
            <td>&nbsp;</td>
          </tr>  -->


            <tr>
                <td align="right">验证码：</td>
                <td><input name="yanzhengmas" type="text" class="ipt"  onblur="yanzhengma(this.value)" placeholder="请输入验证码"/>&nbsp;&nbsp;<br/><input type="button" id="fasong" value="发送短信" onclick="send(<?php echo ($id); ?>)">&nbsp;&nbsp;<a id="msgd"></a></td>

            </tr>



          <tr>
            <td colspan="3" style="height:5px;"><hr></td>
            </tr>
          <tr>
          <tr style="display:none">
            <td align="right">密保问题：</td>
            <td><?php echo ($vo['wenti']); ?></td>
            <td>&nbsp;</td>
            </tr>
          <tr style="display:none">
            <td align="right">请回答密保答案：</td>
            <td><input name="wenti_dan" type="text" id="wenti_dan" value="" class="ipt"/></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td><span class="tCenter" >
              <input name="submit"  type="submit" class="button_text1" value="确 认" alt="确认" />
              <input name="button"  type="reset" class="button_text1" value="重 置" alt="取消" />
            </span></td>
            <td>&nbsp;</td>
          </tr>
          </form>
        </table>
</div>
</body>
</html>
<script language="JavaScript">
function fleshVerify(){
//重载验证码
var timenow = new Date().getTime();
$('verifyImg').src= '__APP__/Public/verify/'+timenow;
}



function send(uid) {

    $.ajax({
        method: "POST",
        url: "__APP__/Change/sendmessage",
        data: { uid: uid ,type: 3}
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
        data: { yanzhen: yanzhengma,type: 3}
    })
            .done(function( msg ) {

                $("#msgd").html(msg);

            });

}





</script>