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
<div class="accounttitle"><h1>会员确认 </h1></div>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tab1">
  <tr>
    <td>
    <form method='post' id="form1" name="form1" action="__URL__/usersAdd"/>
    <table width="100%" border="0" cellpadding="3" cellspacing="0" class="tab4">




  <!--    <tr>
        <td width="25%" height="30" align="right"><span class="zc_hong">*</span> 所属报单中心：</td>
        <td><?php echo ($shopid); ?></td>
        </tr>   -->
      <tr>
        <td width="25%" height="30" align="right"><span class="zc_hong">*</span> 推荐人：</td>
        <td><?php echo ($RID); ?></td>
        </tr>


    <!--  <tr >
        <td height="30" align="right"><span class="zc_hong">*</span> 安置人：</td>
        <td><?php echo ($FID); ?></td>
        </tr>  -->


      <tr>
        <td height="30" align="right"><span class="zc_hong">*</span> 会员编号：</td>
        <td><?php echo ($UserID); ?></td>
        </tr>


   <!--   <tr>
        <td height="30" align="right">所在区域：</td>
        <td>
        <?php echo ($zy_n); ?>
        </td>
        </tr>  -->

      <tr>
        <td height="30" colspan="2" style="height:5px;"><hr></td>
      </tr>
      <tr>
        <td height="30" align="right"><span class="zc_hong">*</span> 一级密码：</td>
        <td><?php echo ($Password); ?></td>
        </tr>
      <tr>
        <td height="30" align="right"><span class="zc_hong">*</span> 二级密码：</td>
        <td><?php echo ($PassOpen); ?></td>
        </tr>
      <tr>
        <td height="30" colspan="2" style="height:5px;"><hr></td>
      </tr>






      <tr>
        <td height="30" align="right"><span class="zc_hong">*</span> 开户姓名：</td>
        <td><?php echo ($UserName); ?></td>
      </tr>


      <tr>
        <td height="30" align="right"><span class="zc_hong">*</span>身份证号：</td>
        <td><?php echo ($UserCode); ?></td>
      </tr>


      <tr>
        <td height="30" align="right"><span class="zc_hong">*</span> 开户银行：</td>
        <td><?php echo ($BankName); ?></td>
        </tr>
      <tr>
        <td height="30" align="right"><span class="zc_hong">*</span>银行卡号：</td>
        <td><?php echo ($BankCard); ?></td>
        </tr>
      <tr>
        <td height="30" align="right"><span class="zc_hong">*</span>详细开户地址：</td>
        <td><?php echo ($BankAddress); ?></td>
      </tr>
      <tr>

   <!--
      <tr>
        <td height="30" align="right">开户省份：</td>
        <td><?php echo ($BankProvince); ?></td>
        </tr>
      <tr>
        <td height="30" align="right">开户城市：</td>
        <td><?php echo ($BankCity); ?></td>
        </tr>
    -->
      <tr>
        <td height="30" align="right"><span class="zc_hong">*</span>手机号码：</td>
        <td><?php echo ($UserTel); ?></td>
      </tr>



      <tr>
        <td height="30" align="right"><span class="zc_hong">*</span>详细住址省份：</td>
        <td><?php echo ($province); ?></td>
      </tr>
      <tr>

      <tr>
        <td height="30" align="right"><span class="zc_hong">*</span>详细住址城市：</td>
        <td><?php echo ($city); ?></td>
      </tr>
      <tr>


      <tr>
        <td height="30" align="right"><span class="zc_hong">*</span>详细联系地址：</td>
        <td><?php echo ($address); ?></td>
      </tr>

      <!--


       <tr>
         <td height="30" align="right"><span class="zc_hong">*</span>身份证号：</td>
         <td><?php echo ($UserCode); ?></td>
         </tr>
       <tr>
         <td height="30" align="right">联系地址：</td>
         <td><?php echo ($UserAddress); ?></td>
         </tr>
       <tr>
         <td height="30" align="right"><span class="zc_hong">*</span>E-Mail：</td>
         <td><?php echo ($UserEmail); ?></td>
         </tr>
      <tr>
        <td height="30" align="right"><span class="zc_hong">*</span>Q Q：</td>
        <td><?php echo ($qq); ?></td>
        </tr>

-->

      <tr>
        <td height="30" colspan="2" style="height:5px;"><hr></td>
      </tr>
      <tr>
            <td height="30" align="right">注册金额：</td>
            <td><?php echo ($cpzj); ?></td>
      </tr>
<!-- <tr>
<td colspan="3" >
<table width="90%" class="tab3" border="0" cellpadding="3" cellspacing="1" id="tb1" align="center" bgcolor="#b9c8d0">

  <tr align="center" class="size14">
    <th width="20%" nowrap height="25">产品名称</th>
    <th width="20%" nowrap>产品价格</th>
    <th width="20%" nowrap>数量</th>
    <th width="20%" nowrap>总金额</th>
    <th width="20%" nowrap>备注说明</th>
  </tr>

    <?php if(is_array($plist)): $i = 0; $__LIST__ = $plist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr align="center">
      <td nowrap height="22"><?php echo ($vo["name"]); ?></td>
      <td nowrap><?php echo ($vo["a_money"]); ?></td>
      <td nowrap><input name="shu<?php echo ($vo["id"]); ?>" type="text" onClick="this.value=''" onKeyUp="he<?php echo ($vo["id"]); ?>.value=this.value*<?php echo ($vo["a_money"]); ?>;value=value.replace(/[^0-9]/g,'');" value="<?php echo ($shu[$vo['id']]); ?>" size="6" maxlength="5" readonly="readonly" />
        <input type="hidden" name="uid[]" value="<?php echo ($vo["id"]); ?>"/></td>
      <td nowrap><input name="he<?php echo ($vo["id"]); ?>" type="text" size="6" value="<?php echo ($shu[$vo['id']]*$vo["a_money"]); ?>" readonly /></td>
      <td align="center">
      <a href="__APP__/Gouwu/Cpcontent/id/<?php echo ($vo["id"]); ?>">点击查看</a></td>
    </tr><?php endforeach; endif; else: echo "" ;endif; ?>

</table>
</td>
</tr>



              <tr>
                <td width="20%" align="right"><span class="hong">* </span>收货人姓名：</td>
                <td><?php echo ($us_name); ?></td>
              </tr>
              <tr>
                <td align="right"><span class="hong">* </span>收货地址：</td>
                <td><?php echo ($us_address); ?></td>
              </tr>
              <tr>
                <td align="right"><span class="hong">* </span>收货人电话：</td>
                <td><?php echo ($us_tel); ?></td>
              </tr>
-->



      <tr>
        <td height="30" align="right">
        <input name="shopid" type="hidden" id="shopid" value="<?php echo ($shopid); ?>" class="ipt"/>
        <input name="RID" id="RID" type="hidden" value="<?php echo ($RID); ?>" class="ipt"/>
        <input name="FID" id="FID" type="hidden"  value="<?php echo ($FID); ?>" class="ipt"/>
        <input name="UserID" id="UserID" type="hidden"  value="<?php echo ($UserID); ?>" class="ipt"/>
        <input name="TPL" id="TPL" type="hidden"  value="<?php echo ($TPL); ?>" class="ipt"/>
        <input name="Password" type="hidden" class="ipt"  id="Password" value="<?php echo ($Password); ?>"/>
        <input name="PassOpen" type="hidden" class="ipt"  id="PassOpen" value="<?php echo ($PassOpen); ?>"/>
        <input name="wenti" type="hidden" class="ipt"  id="wenti" value="<?php echo ($wenti); ?>"/>
        <input name="wenti_dan" type="hidden" class="ipt"  id="wenti_dan" value="<?php echo ($wenti_dan); ?>"/>
        
        <input name="BankName" type="hidden" class="ipt"  id="BankName" value="<?php echo ($BankName); ?>"/>
        <input name="BankCard" type="hidden" class="ipt"  id="BankCard" value="<?php echo ($BankCard); ?>"/>
        <input name="UserName" type="hidden" class="ipt"  id="UserName" value="<?php echo ($UserName); ?>"/>
        
        <input name="BankProvince" type="hidden" class="ipt"  id="BankProvince" value="<?php echo ($BankProvince); ?>"/>
        <input name="BankCity" type="hidden" class="ipt"  id="BankCity" value="<?php echo ($BankCity); ?>"/>
        <input name="BankAddress" type="hidden" class="ipt"  id="BankAddress" value="<?php echo ($BankAddress); ?>"/>
        
        <input name="UserCode" type="hidden" class="ipt"  id="UserCode" value="<?php echo ($UserCode); ?>"/>
        <input name="UserAddress" type="hidden" class="ipt"  id="UserAddress" value="<?php echo ($UserAddress); ?>"/>
        <input name="UserEmail" type="hidden" class="ipt"  id="UserEmail" value="<?php echo ($UserEmail); ?>"/>
        <input name="qq" type="hidden" class="ipt"  id="qq" value="<?php echo ($qq); ?>"/>
        <input name="UserTel" type="hidden" class="ipt"  id="UserTel" value="<?php echo ($UserTel); ?>"/>
        
        <input name="u_level" type="hidden" class="ipt"  id="u_level" value="<?php echo ($u_level); ?>"/>

        <input name="cpzj" type="hidden" class="ipt"  id="cpzj" value="<?php echo ($cpzj); ?>"/>

        
        <input name="us_name" type="hidden" id="us_name" value="<?php echo ($us_name); ?>" maxlength="20" class="inpt"/>
        <input name="us_address" type="hidden" id="us_address" value="<?php echo ($us_address); ?>" maxlength="100" class="inpt"/>
        <input name="us_tel" type="hidden" id="us_tel" value="<?php echo ($us_tel); ?>" maxlength="20" class="inpt"/>
        
         <input name="pro_path" type="hidden" id="pro_path" value="<?php echo ($pro_path); ?>" maxlength="20" class="inpt"/>



          <input name="province" type="hidden" value="<?php echo ($province); ?>"  class="inpt"/>
          <input name="city" type="hidden" value="<?php echo ($city); ?>"  class="inpt"/>
          <input name="address" type="hidden" value="<?php echo ($address); ?>"  class="inpt"/>






          <?php if(is_array($id)): $i = 0; $__LIST__ = $id;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><input name="id[]" type="hidden" value="<?php echo ($v); ?>"  /><?php endforeach; endif; else: echo "" ;endif; ?>

          <?php if(is_array($shuliang)): $i = 0; $__LIST__ = $shuliang;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><input name="shuliang[]" type="hidden" value="<?php echo ($v); ?>" /><?php endforeach; endif; else: echo "" ;endif; ?>


            <?php if(is_array($money)): $i = 0; $__LIST__ = $money;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><input name="money[]" type="hidden" value="<?php echo ($v); ?>" /><?php endforeach; endif; else: echo "" ;endif; ?>
         
        </td>
        <td><span class="center">
          <input name="submit1" id="Access" type="submit" class="button_text" value="确定注册" />
          &nbsp;&nbsp;
          <input name="back" type="button" class="button_text" value="返回上一页" id="back" onclick="history.back(-1);" />
        </span></td>
        </tr>
    </table>
    </form>
    </td>
  </tr>
</table>
</div>
</body>
</html>