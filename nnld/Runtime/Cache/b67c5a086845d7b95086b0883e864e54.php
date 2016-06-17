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



<!--<div class="gongggtiy">公告：<?php echo ($top_new['title']); ?></div>-->
<!-- 				left -->

<div class="img-manage">
        <ul>

            <li><a href="__APP__/Msg/inmsg">

                <?php if(($count_msg > 0)): ?><img src="__PUBLIC__/Images/tixina.gif" alt="" border="0"/>
                <?php else: ?>
                   <img src="__PUBLIC__/Images/icon_1.png" alt="" border="0"/><?php endif; ?>

                查阅信箱</a></li>
          <li><a href="__APP__/Bonus/cody/c_id/1"><img src="__PUBLIC__/Images/icon_3.png" alt="" border="0"/>奖励明细</a></li>
          <li><a href="__APP__/Reg/users"><img src="__PUBLIC__/Images/icon_5.png" alt="" border="0"/> 会员注册</a></li>
          <li><a href="__APP__/Change/cody/c_id/3"><img src="__PUBLIC__/Images/icon_4.png" alt="" border="0"/>账户查询</a></li>
          <li><a href="__APP__/Change/cody/c_id/1"><img src="__PUBLIC__/Images/icon_6.png" alt="" border="0"/> 账户修改</a></li>
          <li><a href="__APP__/News/News"><img src="__PUBLIC__/Images/icon_7.png" alt="" border="0"/> 新闻中心</a></li>

        </ul>
        <div class="clear"></div>
      </div>
<div class="ncenter_box0" style="margin-top:10px;" >
    <!--<div class="ntr1_left">
    <table class="ccdd" cellspacing=0 cellpadding=0 border=0>
            <tbody>
            <tr>
              <td align=right height=20>会员编号:</td>
              <td align=left><span><?php echo ($fck_rs['user_id']); ?></span></td></tr>
            <tr>
              <td align=right height=20>会员类型:</td>
              <td align=left><span><?php echo ($u_level); ?> </span></td></tr>
            <tr>
              <td align=right height=20>总奖励:</td>
              <td align=left><span><?php echo ($fck_rs['zjj']); ?></span></td></tr>
            <tr>
              <td align=right height=20>剩余奖励:</td>
              <td align=left><span><?php echo ($fck_rs['agent_use']); ?></span></td>
            </tr>

              <td align=right height=20>邮件提醒:</td>
              <td align=left>
              <?php if((${info_count}) > "0"): ?><img src="__PUBLIC__/Images/mail_on.gif" />
              <?php else: ?>
              <img src="__PUBLIC__/Images/mail_off.jpg" /><?php endif; ?>
              <a href="__APP__/Msg/inmsg">(<?php echo ($info_count); ?>)查看>></a></td></tr>
            <tr>
            <td colspan="2" align=center height=20>[ <a href="/A085/index.php/Public/LogOut/" onClick="{if(confirm('确定安全退出吗?')){this.document.selform.submit();return true;}return false;}" target="_top">安全退出</a> ]</td>
              </tr>
        </tbody></table>


    </div>-->
    <div class="ntr1_right">
    <div class="ntr1_left2">
        <div class="mem">
                <!--          <p style=" line-height:10px; height:10px;">&nbsp;</p>-->
                <p>会员编号： <span style="color:#F00"><?php echo ($fck_rs['user_id']); ?></span></p>
                <p>会员级别： <span  style="color:#F00"><?php echo ($u_level); ?>&nbsp;&nbsp;</span></p>

                <p>奖励积分： <span style="color:#F00"><?php echo ($fck_rs['agent_use']); ?></span></p>
                <p>注册积分： <span style="color:#F00"><?php echo ($fck_rs['agent_cash']); ?></span></p>


             <!--
                <p>消费积分： <span style="color:#F00"><?php echo ($fck_rs['agent_xf']); ?></span></p>
                <p>活跃积分： <span style="color:#F00"><?php echo ($fck_rs['agent_cf']); ?></span></p>
                <p>消费基金： <span style="color:#F00"><?php echo ($fck_rs['agent_gp']); ?></span></p>              -->


            <p>可用vap积分： <span style="color:#F00"><?php echo ($fck_rs['agent_gc']); ?></span></p>
          <!--  <p> 可用vap积分： <span style="color:#F00"><?php echo ($fck_rs['vap_xiaofei']); ?></span></p>  -->
            <p> 冻结vap积分： <span style="color:#F00"><?php echo ($fck_rs['vap_amount']); ?></span></p>
              <!--  <p>爱心基金： <span style="color:#F00"><?php echo ($fck_rs['agent_kt']); ?></span></p>  -->


            <div class="fovxbre">
           
            </div>
        </div>
    </div>


        <!-- js滚动 -->
    <div class="focusBox">
	
    <ul class="pic">


 		<?php if(is_array($all_img)): $i = 0; $__LIST__ = $all_img;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li ><a href="javascript:void(0)" target="_blank"><img src="<?php echo ($v); ?>" ></a></li><?php endforeach; endif; else: echo "" ;endif; ?>


		
        
        </ul>
	<a class="prev" href="javascript:void(0)" ></a>
    
    <a class="next" href="javascript:void(0)"></a>
	<ul class="hd">
		<li class=""></li>
		<li class=""></li>
		
	
	</ul>
</div>
<script type="text/javascript">			
jQuery(".focusBox").hover(function(){ jQuery(this).find(".prev,.next").stop(true,true).fadeTo("show",0.2) },function(){ jQuery(this).find(".prev,.next").fadeOut() });	
jQuery(".focusBox").slide({ mainCell:".pic",effect:"fold", autoPlay:true, delayTime:600, trigger:"click"});	</script>
        <!-- 结束 js滚动 -->

    </div>

</div>

</div>
<div class="ncenter_box2">

    <div class="ntr1_rigkj2">

<?php
 $url = "https://www.allcoin.com/"; $res = file_get_contents($url); if(preg_match("/<table[^>]+>(.*)<\/table>/isU", $res ,$match)) { print_r($match[0]); } else { echo "不匹配."; } ?>

<!--
<?php
 $url = "https://www.allcoin.com/"; $ch = curl_init(); $timeout = 50; curl_setopt($ch, CURLOPT_URL, $url); curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout); $contents = curl_exec($ch); curl_close($ch); if(preg_match("/<table[^>]+>(.*)<\/table>/isU", $contents ,$match)) { print_r($match[0]); } else { echo "不匹配."; } ?>

   -->



</div>

</div>

<div class="ncenter_box2" style="margin-top:10px;">
    
    <div class="ntr1_rigkj2">
        <div class="miandgengd"><a href="__APP__/News/News/">更多...</a></div>
        <div class="bar_cont">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php if(is_array($f_list)): $i = 0; $__LIST__ = $f_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                        <td style="border-bottom:1px dotted #5991e8 !important;">&nbsp;&nbsp;<img src="__PUBLIC__/Images/li.gif">&nbsp;&nbsp;[<font color="#FF0000">新闻公告</font>]&nbsp;&nbsp;<a href="__APP__/News/News_show/NewID/<?php echo ($vo["id"]); ?>"><?php echo ($vo['title']); ?></a>&nbsp;&nbsp;<font color='#999999' style="float:right;">[<?php echo (date('Y-m-d',$vo["create_time"])); ?>]</font></td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </table>
        </div>

    </div>

</div>

<style>

    #main-table{ background:#FFF; width: 100%;}
    #main-table td{ text-align:center; height:24px; line-height:24px; padding:2px;font-size:12px; border:1px solid #FFF;}
    #main-table th{ background:url(__PUBLIC__/Images/bar_header.gif) repeat-x; height:28px; line-height:28px; text-align:center;font-weight:bold; border:1px solid #e4e4e4; font-size:12px;}
    #main-table th:hover{ background:url(__PUBLIC__/Images/th_hover3.gif) repeat-x; height:28px; line-height:28px; text-align:center; font-weight:bold;}
    #main-table {
        border-collapse:collapse;
        border-spacing:0;
        jerry:expression(cellSpacing="0");
    }

</style>







</body></html>



<script type="text/javascript">
    //计时
    var setTime = setInterval(setAllTime, 1000);
    var showTime3 = 0;
    function setAllTime () {
        ++showTime3;
        var objs = $("span[name='lestTime']");
        $.each( objs, function( key, value ) {
            var beginTime = $(this).data('time');
            if (!beginTime || beginTime<0)
            {
                $(this).html("升级超时")
                return};
            var time = beginTime - showTime3;
            if (time<=0) {
                $(this).html("升级超时")
                return;
            };

            var second = time % 60;
            time -= second;
            var min = (time % 3600) / 60;
            time -= min * 60;
            var hour = (time % 86400) / 3600;
            time -= hour * 3600;
            var day = time / 86400;
            $(this).html(day+ "天" + hour + "时" + min + "分" + second+ "秒");
        });

        if (showTime3 == 1) {
            window.parent.turnHeight('main');
        }
    }
</script>