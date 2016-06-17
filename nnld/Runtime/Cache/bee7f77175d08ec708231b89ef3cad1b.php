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
<div class="accounttitle"><h1>账户查询 </h1></div>
    <table width="100%" border="0" cellspacing="10" cellpadding="0">
              <tr>
                <td width="18%" align="right">会员名称：</td>
                <td width="82%" align="left"><?php echo ($rs['user_id']); ?></td>
              </tr>
      <!--  <tr>
            <td width="18%" align="right">签约金额：</td>
            <td width="82%" align="left"><?php echo ($rs['cpzj']); ?></td>
        </tr>  -->
			  <tr>
                <td width="18%" align="right">推荐人数：</td>
                <td width="82%" align="left"><?php echo ($rs['re_nums']); ?>人</td>
              </tr>
              <tr>
                <td align="right">会员类型：</td>
                <td align="left"><?php echo ($mycg); ?></td>
              </tr>

              <tr>
                 <td align="right">奖励积分：</td>
                 <td align="left"><?php echo ($rs['agent_use']); ?></td>
              </tr>

              <tr>
                <td align="right">注册积分：</td>
                <td align="left"><?php echo ($rs['agent_cash']); ?></td>
             </tr>




      <!--      <tr>
            <td align="right"> 消费积分：</td>
            <td align="left"><?php echo ($rs['agent_xf']); ?></td>
        </tr>
        <tr>
            <td align="right"> 活跃积分：</td>
            <td align="left"><?php echo ($rs['agent_cf']); ?></td>
        </tr>
        <tr>
            <td align="right"> 消费基金：</td>
            <td align="left"><?php echo ($rs['agent_gp']); ?></td>
        </tr>  -->


        <tr>
            <td align="right"> 可用vap积分：</td>
            <td align="left"><?php echo ($rs['agent_gc']); ?></td>
        </tr>


     <!--   <tr>
            <td align="right"> 可用vap积分：</td>
            <td align="left"><?php echo ($rs['vap_xiaofei']); ?></td>
        </tr>  -->

        <tr>
            <td align="right"> 冻结vap积分：</td>
            <td align="left"><?php echo ($rs['vap_total']); ?></td>
        </tr>

        <!-- <tr>
             <td align="right"> 爱心基金：</td>
             <td align="left"><?php echo ($rs['agent_kt']); ?></td>
         </tr>
             <tr>
              <td align="right"> 签约总业绩：</td>
              <td align="left"><?php echo ($rs['team_yj']); ?></td>
          </tr>

          <tr>
              <td align="right">股票：</td>
              <td align="left"><?php echo ($rs['agent_gp']); ?></td>
          </tr>
             <tr>
                 <td align="right">B网的级别：</td>
                 <td align="left">
                    <?php if(($rss["u_level"]) == ""): ?>无
                        <?php else: ?>
                        <?php echo ($rss["u_level"]); ?>级别<?php endif; ?>
                 </td>
                </tr>
          <tr>
              <td align="right">B网奖励币：</td>
              <td align="left"><?php echo ($rs['agent_cf']); ?></td>
          </tr>

                <tr>
                  <td align="right">B网升级币：</td>
                  <td align="left"><?php echo ($rs['agent_cash']); ?></td>
                </tr>

  -->
              <!--<tr>
                <td align="right">电子积分账户：</td>
                <td align="left"><?php echo ($rs['agent_cash']); ?></td>
              </tr>
              <tr>
                <td align="right">现金账户：</td>
                <td align="left"><?php echo ($rs['agent_cf']); ?></td>
              </tr>-->
              <!-- <tr>
                <td align="right">开通积分余额：</td>
                <td align="left"><?php echo ($rs['agent_kt']); ?></td>
              </tr>

              <tr style="display:none">
                <td align="right">股权兑换积分：</td>
                <td align="left"><?php echo ($rs['agent_gp']); ?></td>
              </tr>
              <tr style="display:none">
                <td align="right">持股数量：</td>
                <td align="left"><?php echo ($rs['agent_gp']); ?></td>
              </tr>
              <?php if(($qk) > "0"): ?><tr style="display:none;">
                <td align="right">当前欠款：</td>
                <td align="left"><?php echo ($qk); ?></td>
              </tr>  --><?php endif; ?>
              
            </table>
</div>
</body>
</html>