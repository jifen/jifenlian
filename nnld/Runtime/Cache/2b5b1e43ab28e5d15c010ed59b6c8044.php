<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ($System_namex); ?></title>
<link href="__PUBLIC__/Css/login.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">document.write("<scr"+"ipt src=\"__PUBLIC__/Js/Base.js\"></sc"+"ript>")</script>
<script type="text/javascript">document.write("<scr"+"ipt src=\"__PUBLIC__/Js/prototype.js\"></sc"+"ript>")</script> 
<script type="text/javascript">document.write("<scr"+"ipt src=\"__PUBLIC__/Js/mootools.js\"></sc"+"ript>")</script> 
<script type="text/javascript">document.write("<scr"+"ipt src=\"__PUBLIC__/Js/Ajax/ThinkAjax.js\"></sc"+"ript>")</script> 
<script type="text/javascript">document.write("<scr"+"ipt src=\"__PUBLIC__/Js/Form/CheckForm.js\"></sc"+"ript>")</script> 
<script type="text/javascript">document.write("<scr"+"ipt src=\"__PUBLIC__/Js/common.js\"></sc"+"ript>")</script> 
<script type="text/javascript">document.write("<scr"+"ipt src=\"__PUBLIC__/Js/ie6png.js\"></sc"+"ript>")</script> 

<script language="JavaScript">
<!--
var PUBLIC	 =	 '__PUBLIC__';
ThinkAjax.image = [	 '__PUBLIC__/Images/loading2.gif', '__PUBLIC__/Images/ok.gif','__PUBLIC__/Images/update.gif' ]
ThinkAjax.updateTip	=	'登录中～';
function loginHandle(data,status){
	if (status==1)
	{
	$('result').innerHTML	=	'<span style="color:blue"><img SRC="__PUBLIC__/Images/ok.gif" WIDTH="20" HEIGHT="20" BORDER="0" ALT="" align="absmiddle" > 登录成功！3 秒后跳转～</span>';
	$('form1').reset();
	window.location = '__URL__';
	}else{
		fleshVerify();
	}
}
function fleshVerify(type){
	//重载验证码
	var timenow = new Date().getTime();
	if (type)
	{
	$('verifyImg').src= '__URL__/verify/adv/1/'+timenow;
	}else{
	$('verifyImg').src= '__URL__/verify/'+timenow;
	}
}
if(navigator.userAgent.indexOf("MSIE")>0) 
{ 
	//IE 
	document.onkeydown=function(){
		if(13 == event.keyCode){
			ThinkAjax.sendForm('form1','__URL__/checkLogin/',loginHandle,'result');
		}
	} 
}else{ 
	//非IE 
	window.onkeydown=function(){
		if(13 == event.keyCode){
			ThinkAjax.sendForm('form1','__URL__/checkLogin/',loginHandle,'result');
		}
	
	} 
}

//-->
</script>
  <script src="__PUBLIC__/Js/iepng.js"></script>
  <!--[if lte IE 6]>
<script type="text/javascript" src="js/iepng.js"></script>
<script type="text/javascript">
   EvPNG.fix('div, ul, img, li, input,a,img,p');
</script> 
<![endif]-->
</head>


<body onLoad="document.login.account.focus()" class="loginbody"  >

	<form method='post' name="login" id="form1"  >

      <div class="maincon">
        <div class="inputp">
		
          <ul class="inparea"> 
          
            <li><span class="op1"></span><span class=" intx">
             <input name="account" type="text" class="input_0" size="30" maxlength="50" check="Require" warning="请输入帐号">
              </span></li>
            <li><span class="op2"></span><span class=" intx">
            <input name="password" type="password" class="input_1" size="30" maxlength="50" check="Require" warning="请输入密码">
              </span></li>
			  
			 
              <li><span class="op3"></span><span class="yzintx">
              <input name="verify" type="text" check="Require" warning="请输入验证码" class="input_2" size="4" maxlength="4">
              </span><span><img id="verifyImg" src="__URL__/verify/" onclick="fleshVerify()" border="0" alt="点击刷新验证码" style="cursor:pointer" align="absmiddle" />
							<a href="#" onclick="fleshVerify()" title="点击刷新验证码"  style=" text-decoration:none; color:#FFF; font-size:12px; padding-left: 5px;">换一张</a></span></li>
            <li><span class="op4"></span><span class="subt" >
             <input type="hidden" name="ajax" value="1">
	<input style=" display:inline; float:left; margin-right:15px; font-size:14px; font-weight:bold;" type="button" class="sumbt" value="立即登录"  onClick="ThinkAjax.sendForm('form1','__URL__/checkLogin/',loginHandle,'result')" onmouseover="this.className='sumbt2';" onmouseout="this.className='sumbt';" />
           <!--  <input style=" display:inline; float:left;" name="重置" type="reset" class="sumbt" onmouseover="this.className='sumbt2';" onmouseout="this.className='sumbt';" value="取 消" /></span></li>-->
             
            <li><div class="error"><div id="result" style="margin-left:40px; color:#FFD074"></div></div></li>
            
          </ul>
        </div>
        <div class="footlogo"></div>
        <div class="clearb"></div>
      </div>

</form>

</body>
</html>