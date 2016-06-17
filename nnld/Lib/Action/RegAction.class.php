<?php
class RegAction extends CommonAction{
	function _initialize() {
		$this->_inject_check(0);//调用过滤函数
		$this->_Config_name();
		header("Content-Type:text/html; charset=utf-8");
	}

	//注册协议
	public function reader($RID,$FID,$TP,$TYPE) {
        $url = __URL__."/users/ck/1/RID/".$RID."/FID/".$FID."/TPL/".$TP."/type/".$TYPE;
        $this->assign("url",$url);
        
        $plan = M('plan')->where('id=2')->find();
        $this->assign('plan',$plan['content']);
        
        $this->display('reader');
    }
	
	/**
	 * 会员注册
	 * **/
	public function users($Urlsz=0){

		$this->_checkUser();
		$fck = M ('fck');
		$fee = M ('fee');
		$RID = (int) $_GET['RID'];
		$FID = (int) $_GET['FID'];
		$TP = (int) $_GET['TPL'];
		if (empty($TPL))$TPL = 0;
		$TPL = array();
		for($i=0;$i<5;$i++){
			$TPL[$i] = '';
		}
		$TPL[$TP] = 'selected="selected"';

	/*	if($_GET['ck'] != 1){   //未同意条款
            $this->reader($RID,$FID,$TP,$_GET['type']);
            exit;
        }
*/
		//===报单中心
		$zzc = array();
		$where = array();
		$where['id'] = $_SESSION[C('USER_AUTH_KEY')];
		$field ='user_id,is_agent,agent_cash,shop_name,u_level';
		$rs = $fck ->where($where)->field($field)->find();
		$money = $rs['agent_cash'];
		$mmuserid = $rs['user_id'];
		if ($rs['u_level'] >= 1){
			$zzc[1] = $rs['user_id'];

		}else{
			$mrs = M('fck')->where('id=1')->field('id,user_id')->find();
			$zzc[1] = $mrs['user_id'];
		}
		$this->assign('myid',$zzc[1]);

		$this->assign('ben', $rs['user_id']);


		//===推荐人
		$where['id'] = $RID;
		$field ='user_id,is_agent';
		$rs = $fck ->where($where)->field($field)->find();
		if ($rs){
			$zzc[2] = $rs['user_id'];
		}else{
			$zzc[2] = $mmuserid;
		}
		$zzc[2] = $mmuserid;
		//===接点人
		$where['id'] = $FID;
		$field ='user_id,is_agent';
		$rs = $fck ->where($where)->field($field)->find();
		if ($rs){
			$zzc[3] = $rs['user_id'];
		}else{
			$zzc[3] = '';
		}

		$arr = array();
            $arr['UserID'] = $this->_getUserID();
            $this->assign('flist',$arr);

		$product = M ('product');
		$pwhere = array();
		$pwhere['yc_cp'] = 0;
		$prs = $product->where($pwhere)->select();
		$this->assign('plist',$prs);



		$fee_s = $fee->field('s2,s9,i4,str29,str99,s10,str28')->find();
		$s9 = $fee_s['s9'];
		$s9 = explode('|',$s9);
		$s10 = $fee_s['s10'];
		$s10 = explode('|',$s10);

		$i4 = $fee_s['i4'];
		if ($i4==0){
			$openm=1;
		}else{
			$openm=0;
		}
		//输出银行
		$bank = explode('|',$fee_s['str29']);
		//输出级别名称
            $Level = explode('|',C('Member_Level'));
		//输出注册单数
		$Single = explode('|',C('Member_Single'));
		//输出一单的金额

		$wentilist = explode('|',$fee_s['str99']);

		$this->assign('s9',$s9);


		$str28 = explode('|',$fee_s['str28']);

		$this->assign('str28',$str28);


		$this->assign('s10',$s10);
		$this->assign('openm',$openm);
		$this->assign('bank',$bank);
            $this->assign('Level',$Level);
		$this->assign('Single',$Single);
		$this->assign('Money',$fee_s['s2']);
		$this->assign('Money1',$money);
		$this->assign('wentilist',$wentilist);

		unset($bank,$Level,$$Level);

	    $this->assign('TPL',$TPL);
		$this->assign('zzc',$zzc);

		if (APP_DEBUG) {
			$regData = array();
			$regData['pwd1'] = '111111';
			$regData['pwd2'] = '222222';
			$regData['bank_card'] = '222222';
			$regData['user_name'] = '富贵';
			$regData['user_code'] = '11111111';
			$regData['qq'] = '11111111';
			$regData['user_tel']  = '15555555555';
			$regData['address1']  = '1';
			$regData['address2']  = '2';
			$regData['address3']  = '3';
			$this->assign('regData',$regData);
		}

		unset($fck,$TPL,$where,$field,$rs,$data_temp,$temp_rs,$rs);
		$this->display('users');
	}
	
	/**
	 * 注册确认
	 * **/
	public function usersConfirm() {
		$this->_checkUser();


        $fee =M('fee')->find(1);

		$id = $_SESSION[C('USER_AUTH_KEY')];
		$fck    = M ('fck');
		$rs = $fck -> field('is_pay,agent_cash') -> find($id);
		if($rs['is_pay'] == 0){
			$this->error('临时会员不能注册会员！');
			exit;
		}
		if (strlen($_POST['UserID'])<1){
			$this->error('会员编号不能少！');
			exit;
		}
		if (!preg_match('/^[0-9a-z]{2,16}$/i',trim($_POST['UserID']))) {
			$this->error('会员编号只能由字母与数字组成,且在2-16位之间！');
			exit;
		}
		$this->assign('UserID',$_POST['UserID']);

		

/*
		$data = array();  //创建数据对象
		$shopid = trim($_POST['shopid']);  //所属报单中心帐号
		if (empty($shopid)){
			$this->error('请输入报单中心编号！');
			exit;
		}

		$smap = array();
		$smap['user_id'] = $shopid;
		$smap['is_agent'] = array('gt',1);
		$shop_rs = $fck->where($smap)->field('id,user_id')->find();
		if (!$shop_rs){
			$this->error('没有该报单中心！');
			exit;
		}
		$this->assign('shopid',$shopid);
		unset($smap,$shop_rs,$shopid);


*/



		//检测推荐人
		$RID = trim($_POST['RID']);  //获取推荐会员帐号
		$mapp  = array();
		$mapp['user_id']	= $RID;
		$mapp['is_pay']	    = array('gt',0);
		$authInfoo = $fck->where($mapp)->field('id,user_id,re_level,re_path')->find();
		if ($authInfoo){
			$this->assign('RID',$RID);
			$data['re_id'] = $authInfoo['id'];
		}else{
			$this->error('推荐人不存在！');
			exit;
		}
		unset($authInfoo,$mapp);




		//检测上节点人
/*		$FID = trim($_POST['FID']);  //上节点帐号
		$mappp  = array();
		$mappp['user_id'] = $FID;
		$authInfoo = $fck->where($mappp)->field('id,p_path,p_level,user_id,is_pay,tp_path,re_nums')->find();
		if ($authInfoo){
			$this->assign('FID',$FID);
			$fatherispay = $authInfoo['is_pay'];
			$data['father_id'] = $authInfoo['id'];                        //上节点ID
			$tp_path = $authInfoo['tp_path'];
			// if ($authInfoo['re_nums'] == 0 && (int)$_POST['TPL'] == 1) {
			// 	$this->error('接点人右区未激活');
			// }
		}else{
			$this->error('接点人不存在！');
			exit;
		}
		unset($authInfoo,$mappp);   */





		/*

            $TPL = (int)$_POST['TPL'];
            $where = array();
            $where['father_id'] = $data['father_id'];
            $where['treeplace'] = $TPL;
            $rs = $fck->where($where)->field('id')->find();
            if ($rs){
                $this->error('该位置已经注册！');
                exit;
            }
            if($TPL==0){
                $zy_n = "左区";
            }elseif($TPL==1){
                $zy_n = "右区";
            }else{
                $TPL = 0;
                $zy_n = "左区";
            }
            $this->assign('zy_n',$zy_n);
            $this->assign('TPL',$TPL);

            if($fatherispay==0&&$TPL>0){
                $this->error('接点人开通后才能在此位置注册！');
                exit;
            }



            $renn = $fck->where('re_id='.$data['re_id'].' and is_pay>0')->count();
            if($renn<1){
                $tjnn = $renn+1;
                if($renn==0){
                    $oktp = 0;
                    $errtp = "左区";
                }
                $zz_id = $this->pd_left_us($data['re_id'],$oktp);
                $zz_rs = $fck->where('id='.$zz_id)->field('id,user_id')->find();
                if($zz_id!=$data['father_id']){
                    $this->error('推荐第'.$tjnn.'人必须放在'.$zz_rs['user_id'].'的'.$errtp.'！');
                    exit;
                }
                if($TPL!=$oktp){
                    $this->error('推荐第'.$tjnn.'人必须放在'.$zz_rs['user_id'].'的'.$errtp.'！');
                    exit;
                }
            }
            unset($rs,$where,$TPL);

        */


/*		$sum = 0;
		for($i = 0;$i < count($_POST['money']);$i++){

			$sum += $_POST['money'][$i];

		}







		   $cpzj = $sum;
           if($cpzj < $fee['s9']){
			   $this->error('注册金额不可小于'.$fee['s9']);
			   exit;
		   }

           if($cpzj%$fee['s9'] != 0){

			   $this->error('注册金额必须为'.$fee['s9'].'的倍数');
			   exit;
		   }

		*/




		$fwhere = array();//检测帐号是否存在
		$fwhere['user_id'] = trim($_POST['UserID']);
		$frs = $fck->where($fwhere)->field('id')->find();
		if ($frs){
			$this->error('该会员编号已存在！');
			exit;
		}
		$kk = stripos($fwhere['user_id'],'-');
		if($kk){
			$this->error('会员编号中不能有扛(-)符号！');
			exit;
		}
		unset($fwhere,$frs);




		$errmsg="";


		if(empty($_POST['UserCode'])){
			$errmsg.="<li>请填写身份证号码！</li>";
		}


		if($_POST['UserCode'] && strlen($_POST['UserCode']) != 18){
			$errmsg.="<li>身份证不符合,请重新填写！</li>";
		}
		$this->assign('UserCode',$_POST['UserCode']);


		if(empty($_POST['BankCard'])){
			$errmsg.="<li>银行卡号不能为空！</li>";
		}
		$this->assign('BankCard',$_POST['BankCard']);
		$huhu=trim($_POST['UserName']);
		if(empty($huhu)){
			$errmsg.="<li>请填写开户姓名！</li>";
		}
		$this->assign('UserName',$_POST['UserName']);

		if(empty($_POST['UserTel'])){
			$errmsg.="<li>请填写手机号码！</li>";
		}

		if(strlen($_POST['UserTel']) != 11){
			$errmsg.="<li>手机号码不正确！</li>";
		}

		$map[]=array();
		$map['user_tel']=array('eq',$_POST['UserTel']);
		$wuges = M('fck')->where($map)->count();
		if($wuges >5){
			$errmsg.="<li>每一个手机号码只能5个会员注册！</li>";
		}
		$this->assign('UserTel',$_POST['UserTel']);


		/*
                if(empty($_POST['qq'])){
                    $errmsg.="<li>请填写QQ号码！</li>";

                }
                $this->assign('qq',$_POST['qq']);

                if(empty($_POST['wenti_dan'])){
                    $errmsg.="<li>密保答案不能为空！</li>";
                }
                $this->assign('wenti_dan',$_POST['wenti_dan']);

        */



// 		if(empty($_POST['UserEmail'])){
// 			$errmsg.="<li>请填写您的邮箱地址，找回密码时需使用！</li>";
// 		}
		$this->assign('UserEmail',$_POST['UserEmail']);

		$usercc=trim($_POST['UserCode']);
		if(strlen($_POST['UserCode']) != 18){
			$errmsg.="<li>身份证号码不正确！</li>";
		}


		$date=substr($usercc,6,4);

	   if($date <1956 ){
		   $errmsg.="<li>1956年出生的不允许注册！</li>";
	   }

       $map[]=array();
	   $map['user_code']=array('eq',$_POST['UserCode']);
	   $wuge = M('fck')->where($map)->count();
		if($wuge >5){
			$errmsg.="<li>每一个身份证号码只能5个会员注册！</li>";
		}

		$this->assign('UserCode',$_POST['UserCode']);




		if(strlen($_POST['Password']) < 1 or strlen($_POST['Password']) > 16 or strlen($_POST['PassOpen']) < 1 or strlen($_POST['PassOpen']) > 16){
			$this->error('密码应该是1-16位！');
			exit;
		}
		if($_POST['Password'] != $_POST['rePassword']){  //一级密码
			$this->error('一级密码两次输入不一致111！');
			exit;
		}
		if($_POST['PassOpen'] != $_POST['rePassOpen']){  //二级密码
			$this->error('二级密码两次输入不一致！');
			exit;
		}
		if($_POST['Password'] == $_POST['PassOpen']){  //二级密码
			$this->error('一级密码与二级密码不能相同！');
			exit;
		}
		$this->assign('Password',$_POST['Password']);
		$this->assign('PassOpen',$_POST['PassOpen']);


		if($_POST['province']=="请选择"){
			$errmsg.="<li>请填写住址省份！</li>";
		}
		if($_POST['city']=="请选择"){
			$errmsg.="<li>请填写住址城市！</li>";
		}
		if(empty($_POST['address'])){
			$errmsg.="<li>请填写住址详细地址！</li>";
		}


		$us_name = $_POST['us_name'];
		$us_address = $_POST['us_address'];
		$us_tel = $_POST['us_tel'];
		if(empty($us_name)){
			$errmsg.="<li>请输入收货人姓名！</li>";
		}
		if(empty($us_address)){
			$errmsg.="<li>请输入收货地址！</li>";
		}
		if(empty($us_tel)){
			$errmsg.="<li>请输入收货人电话！</li>";
		}

		


		$this->assign('us_name', $us_name);
		$this->assign('us_address', $us_address);
		$this->assign('us_tel', $us_tel);




		$s_err = "<ul>";
		$e_err = "</ul>";
		if(!empty($errmsg)){
			$out_err = $s_err.$errmsg.$e_err;
			$this->error($out_err);
			exit;
		}




		$uLevel = $_POST['u_level'];
		$this->assign('u_level',$_POST['u_level']);
		$fee  = M ('fee') -> find();
		$s    = $fee['s9'];
		$s10 = explode('|',$fee['s10']);
		$this->assign('uarray',$s10);
		$s9 = explode('|',$fee['s9']);
		$s2 = explode('|',$fee['s2']);
		$trueCpzj = $s9[$uLevel];
		
		$ul     = $s9[$uLevel];





		/*
		$product = M ('product');
		$gouwu = M ('gouwu');
		$ydate = time();
		$cpid = $_POST['uid'];//所以产品的ID
		if (empty($cpid)){
			$this->error('请选择产品！');
			exit;
		}
		$pro_where = array();
		$pro_where['id'] = array ('in',$cpid);
		$pro_rs = $product->where($pro_where)->select();
		$cpmoney = 0;//产品总价
		$txt = "";
		foreach ($pro_rs as $pvo){
			$aa = "shu".$pvo['id'];
			$cc = $_POST[$aa];
			if ($cc != 0) {
				$cpmoney = $cpmoney + $pvo['a_money'] * $cc;
				$txt .= $pvo['id'] .',';
				$shu[$pvo['id']] = $cc;
			}
		}
		unset($pro_rs);
		if($cpmoney != $trueCpzj){
			$this->error('产品金额必需为'.$trueCpzj.'，请重新选择！');
			exit;
		}
		$this->assign('shu', $shu);
		$this->assign('pro_path', $txt);



		
		$pro_where = array();
		$pro_where['id'] = array ('in',$txt. '0');
		$pro_rs = $product->where($pro_where)->select();
		
		$this->assign('plist', $pro_rs);
		*/


		$this->assign('id',$_POST['id']);
		$this->assign('shuliang',$_POST['shuliang']);
		$this->assign('money',$_POST['money']);


		$this->assign('cpzj',$_POST['cpzj']);
		$this->assign('BankName',$_POST['BankName']);
		$this->assign('BankProvince',$_POST['BankProvince']);
		$this->assign('BankCity',$_POST['BankCity']);
		$this->assign('BankAddress',$_POST['BankAddress']);


		$this->assign('province',$_POST['province']);
		$this->assign('city',$_POST['city']);
		$this->assign('address',$_POST['address']);
		
		$this->assign('UserAddress',$_POST['UserAddress']);
		$this->assign('qq',$_POST['qq']);
		
		$this->display();

	}
	
	/**
	 * 注册处理
	 * **/
	public function usersAdd() {
		$this->_checkUser();
		$id = $_SESSION[C('USER_AUTH_KEY')];
		$fck    = D ('Fck');  //注册表
        $uLevel = $_POST['u_level'];
        $fee  = M ('fee') -> find();
        $s    = $fee['s9'];
        $s2 = explode('|',$fee['s2']);
        $s9 = explode('|',$fee['s9']);

      //  $f4 = (int)$s2[$uLevel];//认购单数


        $ul     = $s9[$uLevel];
        $rs = $fck->field('is_pay')->find($id);
		// $agent_use = $rs['agent_use'];
	 //    if($agent_use < $ul){
  //          $this->error('货币余额不足！');
  //          exit;
  //      }
		
		if($rs['is_pay'] == 0){
			$this->error('临时会员不能注册会员！');
			exit;
		}
		if (strlen($_POST['UserID'])<1){
			$this->error('会员编号不能少！');
			exit;
		}
		if (!preg_match('/^[0-9a-z]{2,16}$/i',trim($_POST['UserID']))) {
			$this->error('会员编号只能由字母与数字组成,且在2-16位之间！');
			exit;
		}



	/*

		$data = array();  //创建数据对象
		//检测报单中心
		$shopid = trim($_POST['shopid']);  //所属报单中心帐号
		if (empty($shopid)){
			$this->error('请输入报单中心编号！');
			exit;
		}
		$smap = array();
		$smap['user_id'] = $shopid;
		$smap['is_agent'] = array('gt',1);
		$shop_rs = $fck->where($smap)->field('id,user_id')->find();
		if (!$shop_rs){
			$this->error('没有该报单中心！');
			exit;
		}else{
			$data['shop_id']   = $shop_rs['id'];      //隶属会员中心编号
			$data['shop_name'] = $shop_rs['user_id']; //隶属会员中心帐号
		}
		unset($smap,$shop_rs,$shopid);

		*/




		//检测推荐人
		$RID = trim($_POST['RID']);  //获取推荐会员帐号
		$mapp  = array();
		$mapp['user_id']	= $RID;
		$mapp['is_pay']	    = array('gt',0);
		$authInfoo = $fck->where($mapp)->field('id,user_id,re_level,re_path')->find();
		if ($authInfoo){
			$data['re_path'] = $authInfoo['re_path'].$authInfoo['id'].',';  //推荐路径
			$data['re_id'] = $authInfoo['id'];                              //推荐人ID
			$data['re_name'] = $authInfoo['user_id'];                       //推荐人帐号
			$data['re_level'] = $authInfoo['re_level'] + 1;                 //代数(绝对层数)
		}else{
			$this->error('推荐人不存在！');
			exit;
		}
		unset($authInfoo,$mapp);




	/*	//检测上节点人
		$FID = trim($_POST['FID']);  //上节点帐号
		$mappp  = array();
		$mappp['user_id'] = $FID;
		$mappp['is_pay']  = array('gt',0);
		$authInfoo = $fck->where($mappp)->field('id,p_path,p_level,user_id,is_pay,tp_path,re_nums')->find();
		if ($authInfoo){
			$fatherispay = $authInfoo['is_pay'];
			$data['p_path'] = $authInfoo['p_path'].$authInfoo['id'].',';  //绝对路径
			$data['father_id'] = $authInfoo['id'];                        //上节点ID
			$data['father_name'] = $authInfoo['user_id'];                 //上节点帐号
			$data['p_level'] = $authInfoo['p_level'] + 1;                 //上节点ID
			$tp_path = $authInfoo['tp_path'];
			// if ($authInfoo['re_nums'] == 0 && (int)$_POST['TPL'] == 1) {
			// 	$this->error('接点人右区未激活');
			// }
		}else{
			$this->error('上级会员不存在！');
			exit;
		}
*/

	/*
		unset($authInfoo,$mappp);
		$TPL = (int)$_POST['TPL'];
		$where = array();
		$where['father_id'] = $data['father_id'];
		$where['treeplace'] = $TPL;
		$rs = $fck->where($where)->field('id')->find();
		if ($rs){
			$this->error('该位置已经注册！');
			exit;
		}else{
			$data['treeplace'] = $TPL;
			if(strlen($tp_path)==0){
				$data['tp_path'] = $TPL;
			}else{
				$data['tp_path'] = $tp_path.",".$TPL;
			}
		}
//
		if($fatherispay==0&&$TPL>0){
			$this->error('接点人开通后才能在此位置注册！');
			exit;
		}

*/



	/*

		$renn = $fck->where('re_id='.$data['re_id'].' and is_pay>0')->count();
		if($renn<1){
			$tjnn = $renn+1;
			if($renn==0){
				$oktp = 0;
				$errtp = "左区";
			}
			$zz_id = $this->pd_left_us($data['re_id'],$oktp);
			$zz_rs = $fck->where('id='.$zz_id)->field('id,user_id')->find();
			if($zz_id!=$data['father_id']){
				$this->error('推荐第'.$tjnn.'人必须放在'.$zz_rs['user_id'].'的'.$errtp.'！');
				exit;
			}
			if($TPL!=$oktp){
				$this->error('推荐第'.$tjnn.'人必须放在'.$zz_rs['user_id'].'的'.$errtp.'！');
				exit;
			}
		}
		unset($rs,$where,$TPL);

		*/



		$fwhere = array();//检测帐号是否存在
		$fwhere['user_id'] = trim($_POST['UserID']);
		$frs = $fck->where($fwhere)->field('id')->find();
		if ($frs){
			$this->error('该会员编号已存在！');
			exit;
		}
		$kk = stripos($fwhere['user_id'],'-');
		if($kk){
			$this->error('会员编号中不能有扛(-)符号！');
			exit;
		}
		unset($fwhere,$frs);

		$errmsg="";

	/*	if(empty($_POST['wenti_dan'])){
			$errmsg.="<li>密保答案不能为空！</li>";
		}
		if(empty($_POST['qq'])){
			$errmsg.="<li>请填写QQ号码！</li>";
		}
		if(empty($_POST['UserCode'])){
			$errmsg.="<li>请填写身份证号码！</li>";
		}

	*/



		if(empty($_POST['BankCard'])){
			$errmsg.="<li>银行卡号不能为空！</li>";
		}
		$huhu=trim($_POST['UserName']);
		if(empty($huhu)){
			$errmsg.="<li>请填写开户姓名！</li>";
		}





		if(empty($_POST['UserTel'])){
			$errmsg.="<li>请填写手机号码！</li>";
		}

        if(strlen($_POST['UserTel']) != 11){
			$errmsg.="<li>手机号码不正确！</li>";
		}






// 		if(empty($_POST['UserEmail'])){
// 			$errmsg.="<li>请填写您的邮箱地址，找回密码时需使用！</li>";
// 		}

		$usercc=trim($_POST['UserCode']);


		if(strlen($_POST['UserCode']) != 18){
			$errmsg.="<li>身份证号码不正确！</li>";
		}



		if(strlen($_POST['Password']) < 1 or strlen($_POST['Password']) > 16 or strlen($_POST['PassOpen']) < 1 or strlen($_POST['PassOpen']) > 16){
			$this->error('密码应该是1-16位！');
			exit;
		}
		if($_POST['Password'] == $_POST['PassOpen']){  //二级密码
			$this->error('一级密码与二级密码不能相同！');
			exit;
		}

		$us_name = $_POST['us_name'];
		$us_address = $_POST['us_address'];
		$us_tel = $_POST['us_tel'];



		if(empty($us_name)){
			$errmsg.="<li>请输入收货人姓名！</li>";
		}
		if(empty($us_address)){
			$errmsg.="<li>请输入收货地址！</li>";
		}
		if(empty($us_tel)){
			$errmsg.="<li>请输入收货人电话！</li>";
		}

		$s_err = "<ul>";
		$e_err = "</ul>";
		if(!empty($errmsg)){
			$out_err = $s_err.$errmsg.$e_err;
			$this->error($out_err);
			exit;
		}





		$Arr1=$_POST['id'];
        $Arr2=$_POST['shuliang'];
        $Arr3=$_POST['money'];
		$Arr4 = array();
		foreach ($Arr1 as $k => $r) {
			$Arr4[] = array($Arr1[$k],$Arr2[$k],$Arr3[$k]);
         }

		foreach($Arr4 as $k=>$v){

			$data['pid']=$Arr4[$k][0];
			$data['shuliang']=$Arr4[$k][1];
			$data['price']=$Arr4[$k][2]/$Arr4[$k][1];
			$data['total']=$Arr4[$k][2];
			$data['adt']=time();
			$data['user_id']=$_POST['UserID'];
			$data['user_tel']=$_POST['us_tel'];
			$data['user_address']=$_POST['us_address'];
			$data['username']=$_POST['us_name'];
			$res = M('fahuo')->add($data);

		}



		$Money = explode('|',C('Member_Money'));  //注册金额数组

		$new_userid = $_POST['UserID'];


		$data['cpzj_level']  = array_search($_POST['cpzj'],$s9);

		$data['user_id']             = $new_userid;
		$data['bind_account']        = '3333';
		$data['last_login_ip']       = '';                            //最后登录IP
		$data['verify']              = '0';
		$data['status']              = 1;                             //状态(?)
		$data['type_id']             = '0';
		$data['last_login_time']     = time();                        //最后登录时间
		$data['login_count']         = 0;                             //登录次数
		$data['info']                = '信息';
		$data['name']                = '名称';
		$data['password']            = md5(trim($_POST['Password']));  //一级密码加密
		$data['passopen']            = md5(trim($_POST['PassOpen']));  //二级密码加密
		$data['pwd1']                = trim($_POST['Password']);       //一级密码不加密
		$data['pwd2']                = trim($_POST['PassOpen']);       //二级密码不加密

		$data['wenti']				= trim($_POST['wenti']);  //密保问题
		$data['wenti_dan']			= trim($_POST['wenti_dan']);  //密保答案

		$data['bank_name']           = $_POST['BankName'];             //银行名称
		$data['bank_card']           = $_POST['BankCard'];             //帐户卡号
		$data['user_name']           = $_POST['UserName'];             //姓名
		$data['nickname']			  = $_POST['UserID'];//$_POST['nickname'];  //昵称
		$data['bank_province']       = $_POST['BankProvince'];  //省份
		$data['bank_city']           = $_POST['BankCity'];      //城市
		$data['bank_address']        = $_POST['BankAddress'];          //开户地址
		//$data['user_post']           = $_POST['UserPost']; 		   //
		$data['user_code']           = $_POST['UserCode'];             //身份证号码
		$data['user_address']        = $_POST['UserAddress'];          //联系地址
		$data['email']               = $_POST['UserEmail'];            //电子邮箱
		$data['qq']              	 = $_POST['qq'];            	   //qq
		$data['user_tel']            = $_POST['UserTel'];              //联系电话
		$data['get_address']            = $_POST['us_address'];

		$data['province']            = $_POST['province'];
		$data['city']            = $_POST['city'];
		$data['address']            = $_POST['address'];


		$data['is_pay']              = 0;                              //是否开通
		$data['rdt']                 = time();                         //注册时间
		// $data['pdt']                 = time();
		$data['u_level']             = array_search($_POST['cpzj'],$s9);                      //注册等级
		$data['cpzj']                = $_POST['cpzj'];
		$data['cpzj_pv']                = $_POST['cpzj']*0.8;

		//注册金额
		// $data['cpzj_pay']            = $cpzj_pay;							//单量
		$data['f4']                  = 1;							//单量
		$data['wlf']                 = 0;                              //网络费
		$data['reg_id']				 = $_SESSION[C('USER_AUTH_KEY')]; // 注册人

		// $fck->startTrans(); //开始事务
		$result = $fck->add($data);
		unset($data);
		if($result) {
			$product = M ('product');
			$txt = $_POST['pro_path'];
			$gouwu = M ('gouwu');
				$where1['id'] = array ('in',$txt.'0');
				$rs1 = $product->where($where1)->select();
				$i=0;
				$p=array();
				foreach ($rs1 as $b) {
					$id = $b['id'];
					$cpid = $b['id'];
					$aa1 = "shu" . $b['id'];
					$cc1 = $_POST[$aa1];
					if ($cc1 != 0) {
						$hy1 = $b['a_money'];

						$p[$i] = $hy1 * $cc1;
						$p1 = $hy1 * $cc1;
						$i++;

						$gwd = array();
						$gwd['uid'] = $result;
						$gwd['user_id'] = $new_userid;
						$gwd['did'] = $cpid;
						$gwd['lx'] = 0;
						$gwd['ispay'] = 0;
						$gwd['pdt'] = time();
						$gwd['money'] = $hy1;
						$gwd['shu'] = $cc1;
						$gwd['cprice'] = $p1;
						$gwd['us_name'] = $us_name;
						$gwd['us_address'] = $us_address;
						$gwd['us_tel'] = $us_tel;
						$gwd['type'] =1;
						$gouwu->add($gwd);
					}
				}
				unset($product,$gouwu,$rs1);
			
			$_SESSION['new_user_reg_id'] = $result;

			echo "<script>window.location='".__URL__."/users_ok/';</script>";
			exit;
		} else {
			$this->error('会员注册失败！');
			exit;
		}
	}
	
	/**
	 * 注册完成
	 * **/
	public function users_ok(){
		$this->_checkUser();
		$gourl = __APP__."/Reg/users/";
		if(!empty($_SESSION['new_user_reg_id'])){

			$fck = M('fck');
			$fee_rs = M ('fee') -> find();

			$this -> assign('s8',$fee_rs['s8']);
			$this -> assign('alert_msg',$fee_rs['str28']);
			$this -> assign('s17',$fee_rs['s17']);

			$myrs = $fck->where('id='.$_SESSION['new_user_reg_id'])->find();
			$this->assign('myrs',$myrs);

			$this->assign('gourl',$gourl);
			unset($fck,$fee_rs);
			$this->display();
		}else{
			echo "<script>window.location='".$gourl."';</script>";
			exit;
		}
	}
	
	
	
	//前台注册
	public function us_reg(){
		$fck = M ('fck');
		$fee = M ('fee');
		$reid = (int)$_GET['rid'];
		
		$fee_rs = $fee->field('s9,str21,str27,str29,str99')->find();
		$this->assign('fflv',$fee_rs['str21']);
		$this->assign('str27',$fee_rs['str27']);
		$s9 = $fee_rs['s9'];
		$s9 = explode('|',$s9);
		$this->assign('s9',$s9);
		$bank = explode('|',$fee_rs['str29']);
		$this->assign('bank',$bank);
		$wentilist = explode('|',$fee_rs['str99']);
		$this->assign('wentilist',$wentilist);
		
		$arr = array();
		$arr['UserID'] = $this->_getUserID();
		$this->assign('flist',$arr);
		
		//检测推荐人
		$where = array();
		$where['id'] = $reid;
		$where['is_pay'] = array('gt',0);
		$field ='id,user_id,nickname,us_img,is_agent,shop_name';
		$rs = $fck ->where($where)->field($field)->find();
		if($rs){
			if(empty($rs['us_img'])){
				$rs['us_img'] = "__PUBLIC__/Images/tirns.jpg";
			}
			if($rs['is_agent']==2){
				$this->assign('shopname',$rs['user_id']);
			}else{
				$this->assign('shopname',$rs['shop_name']);
			}
			$this->assign('rs',$rs);
			$this->assign('reid',$reid);
//		}else{
//			echo "<script>";
//			echo "alert('推广参数错误！');";
//			echo "window.location='".__APP__."/Public/login/';";
//			echo "</script>";
//			exit;
		}
		$plan = M ('plan');
		$prs = $plan->find(4);
		$this->assign('prs',$prs);
		$this->display();
	}
	
	//前台注册处理
	public function us_regAC() {
		$fck    = M ('fck');  //注册表

		if (strlen($_POST['UserID'])<1){
			$this->error('会员编号不能少！');
			exit;
		}

		$data = array();  //创建数据对象
		//检测报单中心
		$shopid = trim($_POST['shopid']);  //所属报单中心帐号
		if (empty($shopid)){
			$this->error('请输入报单中心编号！');
			exit;
		}
		$smap = array();
		$smap['user_id'] = $shopid;
		$smap['is_agent'] = array('gt',1);
		$shop_rs = $fck->where($smap)->field('id,user_id')->find();
		if (!$shop_rs){
			$this->error('没有该报单中心！');
			exit;
		}else{
			$data['shop_id']   = $shop_rs['id'];      //隶属会员中心编号
			$data['shop_name'] = $shop_rs['user_id']; //隶属会员中心帐号
		}
		unset($smap,$shop_rs,$shopid);

		//检测推荐人
		$RID = trim($_POST['RID']);  //获取推荐会员帐号
		$mapp  = array();
		$mapp['user_id']	= $RID;
		$mapp['is_pay']	    = array('gt',0);
		$authInfoo = $fck->where($mapp)->field('id,user_id,re_level,re_path')->find();
		if ($authInfoo){
			$data['re_path'] = $authInfoo['re_path'].$authInfoo['id'].',';  //推荐路径
			$data['re_id'] = $authInfoo['id'];                              //推荐人ID
			$data['re_name'] = $authInfoo['user_id'];                       //推荐人帐号
			$data['re_level'] = $authInfoo['re_level'] + 1;                 //代数(绝对层数)
		}else{
			$this->error('推荐人不存在！');
			exit;
		}
		unset($authInfoo,$mapp);

		//检测上节点人
		$FID = trim($_POST['FID']);  //上节点帐号
		$mappp  = array();
		$mappp['user_id'] = $FID;
//		$mappp['is_pay']  = array('gt',0);
		$authInfoo = $fck->where($mappp)->field('id,p_path,p_level,user_id,is_pay,tp_path')->find();
		if ($authInfoo){
			$fatherispay = $authInfoo['is_pay'];
			$data['p_path'] = $authInfoo['p_path'].$authInfoo['id'].',';  //绝对路径
			$data['father_id'] = $authInfoo['id'];                        //上节点ID
			$data['father_name'] = $authInfoo['user_id'];                 //上节点帐号
			$data['p_level'] = $authInfoo['p_level'] + 1;                 //上节点ID
			$tp_path = $authInfoo['tp_path'];
		}else{
			$this->error('上级会员不存在！');
			exit;
		}
		unset($authInfoo,$mappp);
 		$TPL = (int)$_POST['TPL'];
		$where = array();
		$where['father_id'] = $data['father_id'];
		$where['treeplace'] = $TPL;
		$rs = $fck->where($where)->field('id')->find();
		if ($rs){
			$this->error('该位置已经注册！');
			exit;
		}else{
			$data['treeplace'] = $TPL;
			if(strlen($tp_path)==0){
				$data['tp_path'] = $TPL;
			}else{
				$data['tp_path'] = $tp_path.",".$TPL;
			}
		}

		if($fatherispay==0&&$TPL>0){
			$this->error('接点人开通后才能在此位置注册！');
			exit;
		}
//
//		$renn = $fck->where('re_id='.$data['re_id'].' and is_pay>0')->count();
//		if($renn<1){
//			$tjnn = $renn+1;
//			if($renn==0){
//				$oktp = 0;
//				$errtp = "A部门";
//			}
//			$zz_id = $this->pd_left_us($data['re_id'],$oktp);
//			$zz_rs = $fck->where('id='.$zz_id)->field('id,user_id')->find();
//			if($zz_id!=$data['father_id']){
//				$this->error('推荐第'.$tjnn.'人必须放在'.$zz_rs['user_id'].'的'.$errtp.'！');
//				exit;
//			}
//			if($TPL!=$oktp){
//				$this->error('推荐第'.$tjnn.'人必须放在'.$zz_rs['user_id'].'的'.$errtp.'！');
//				exit;
//			}
//		}
		unset($rs,$where,$TPL);

		$fwhere = array();//检测帐号是否存在
		$fwhere['user_id'] = trim($_POST['UserID']);
		$frs = $fck->where($fwhere)->field('id')->find();
		if ($frs){
			$this->error('该会员编号已存在！');
			exit;
		}
		$kk = stripos($fwhere['user_id'],'-');
		if($kk){
			$this->error('会员编号中不能有扛(-)符号！');
			exit;
		}
		unset($fwhere,$frs);

		$errmsg="";
		if(empty($_POST['wenti_dan'])){
			$errmsg.="<li>密保答案不能为空！</li>";
		}
		if(empty($_POST['BankCard'])){
			$errmsg.="<li>银行卡号不能为空！</li>";
		}
		$huhu=trim($_POST['UserName']);
		if(empty($huhu)){
			$errmsg.="<li>请填写开户姓名！</li>";
		}
		if(empty($_POST['UserCode'])){
			$errmsg.="<li>请填写身份证号码！</li>";
		}
		if(empty($_POST['UserTel'])){
			$errmsg.="<li>请填写电话号码！</li>";
		}
		if(empty($_POST['qq'])){
			$errmsg.="<li>请填写QQ号码！</li>";
		}
// 		if(empty($_POST['UserEmail'])){
// 			$errmsg.="<li>请填写您的邮箱地址，找回密码时需使用！</li>";
// 		}

		$usercc=trim($_POST['UserCode']);

		if(strlen($_POST['Password']) < 1 or strlen($_POST['Password']) > 16 or strlen($_POST['PassOpen']) < 1 or strlen($_POST['PassOpen']) > 16){
			$this->error('密码应该是1-16位！');
			exit;
		}
		if($_POST['Password'] == $_POST['PassOpen']){  //二级密码
			$this->error('一级密码与二级密码不能相同！');
			exit;
		}

//		$us_name = $_POST['us_name'];
//		$us_address = $_POST['us_address'];
//		$us_tel = $_POST['us_tel'];
//		if(empty($us_name)){
//			$errmsg.="<li>请输入收货人姓名！</li>";
//		}
//		if(empty($us_address)){
//			$errmsg.="<li>请输入收货地址！</li>";
//		}
//		if(empty($us_tel)){
//			$errmsg.="<li>请输入收货人电话！</li>";
//		}

		$s_err = "<ul>";
		$e_err = "</ul>";
		if(!empty($errmsg)){
			$out_err = $s_err.$errmsg.$e_err;
			$this->error($out_err);
			exit;
		}


		$uLevel = $_POST['u_level'];
		$fee  = M ('fee') -> find();
		$s    = $fee['s9'];
		$s2 = explode('|',$fee['s2']);
		$s9 = explode('|',$fee['s9']);
		$s15 = explode('|',$fee['s15']);

		$F4     = $s2[$uLevel];//认购单数
		$ul     = $s9[$uLevel];
		$gp     = $s15[$uLevel];

		$Money = explode('|',C('Member_Money'));  //注册金额数组

		$new_userid = $_POST['UserID'];

		$data['user_id']             = $new_userid;
		$data['bind_account']        = '3333';
		$data['last_login_ip']       = '';                            //最后登录IP
		$data['verify']              = '0';
		$data['status']              = 1;                             //状态(?)
		$data['type_id']             = '0';
		$data['last_login_time']     = time();                        //最后登录时间
		$data['login_count']         = 0;                             //登录次数
		$data['info']                = '信息';
		$data['name']                = '名称';
		$data['password']            = md5(trim($_POST['Password']));  //一级密码加密
		$data['passopen']            = md5(trim($_POST['PassOpen']));  //二级密码加密
		$data['pwd1']                = trim($_POST['Password']);       //一级密码不加密
		$data['pwd2']                = trim($_POST['PassOpen']);       //二级密码不加密

		$data['wenti']				= trim($_POST['wenti']);  //密保问题
		$data['wenti_dan']			= trim($_POST['wenti_dan']);  //密保答案

		$data['bank_name']           = $_POST['BankName'];             //银行名称
		$data['bank_card']           = $_POST['BankCard'];             //帐户卡号
		$data['user_name']           = $_POST['UserName'];             //姓名
		$data['nickname']			  = $_POST['UserID'];//$_POST['nickname'];  //昵称
		$data['bank_province']       = $_POST['BankProvince'];  //省份
		$data['bank_city']           = $_POST['BankCity'];      //城市
		$data['bank_address']        = $_POST['BankAddress'];          //开户地址
		//$data['user_post']           = $_POST['UserPost']; 		   //
		$data['user_code']           = $_POST['UserCode'];             //身份证号码
// 		$data['user_address']        = $_POST['UserAddress'];          //联系地址
// 		$data['email']               = $_POST['UserEmail'];            //电子邮箱
		$data['qq']              	 = $_POST['qq'];            	   //qq
		$data['user_tel']            = $_POST['UserTel'];              //联系电话
		$data['is_pay']              = 0;                              //是否开通
		$data['rdt']                 = time();                         //注册时间
//		$data['pdt']                 = strtotime(date('Y-m-d'));
		$data['u_level']             = $uLevel+1;                      //注册等级
		$data['cpzj']                = $ul;                          //注册金额
		$data['f4']                  = $F4;							//单量
		$data['gp_num']              = $gp;							//原始股
		$data['wlf']                 = 0;                              //网络费
		
		$result = $fck->add($data);
		unset($data,$fck);
		if($result) {
			echo "<script>";
			echo "alert('恭喜您注册成功，您的账户编号：".$new_userid."，请及时开通正式会员！');";
			echo "window.location='".__APP__."/Public/login/';";
			echo "</script>";
			exit;
		}else{
			$this->error('会员注册失败！');
			exit;
		}
	}
	
	//生成会员编号
	private function _getUserID(){
		$fck = M('fck');
//		$fee = M('fee');
//		$fee_rs = $fee->field('us_num')->find(1);
//		$us_num = $fee_rs['us_num'];
//		$first_n = 800000000;
//		$mynn = $first_n+$us_num;
		
		$mynn = ''.rand(1000000,9999999);
		
//		if($us_num<10){
//			$mynn = "00000".$us_num;
//		}elseif($us_num<100){
//			$mynn = "0000".$us_num;
//		}elseif($us_num<1000){
//			$mynn = "000".$us_num;
//		}elseif($us_num<10000){
//			$mynn = "00".$us_num;
//		}elseif($us_num<100000){
//			$mynn = "0".$us_num;
//		}else{
//			$mynn = $us_num;
//		}
		$fwhere['user_id'] = $mynn;
		$frss = $fck->where($fwhere)->field('id')->find();
		if ($frss){
			return $this->_getUserID();
		}else{
			unset($fck,$fee);
			return $mynn;
		}
	}
	
	//判断最左区
	public function pd_left_us($uid,&$tp){
		$fck = M('fck');
		$c_l = $fck->where('father_id='.$uid.' and treeplace='.$tp.'')->field('id')->find();
		if($c_l){
			$n_id = $c_l['id'];
			$tp = 0;
			$ren_id = $this->pd_left_us($n_id,$tp);
		}else{
			$ren_id = $uid;
		}
		unset($fck,$c_l);
		return $ren_id;
	}
	
	//
	public function find_agent(){
		$fck = M('fck');
		$where = "is_agent=2 and is_pay>0";
		$s_echo = '<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tab1"><tr><td>';
		$e_echo = '</td></tr></table>';
		$m_echo = "";
		$c_l = $fck->where($where)->field('user_id,user_name,shop_a')->select();
		foreach($c_l as $ll){
			$m_echo .= "<li><b>".$ll['user_id']."</b>(".$ll['user_name'].")<br>".$ll['shop_a']."</li>";
		}
		unset($fck,$c_l);
		echo $s_echo.$m_echo.$e_echo;
	}
	
	
	
	// 找回密码1
	public function find_pw() {
		$_SESSION['us_openemail']="";
		$this->display('find_pw');
	}

	// 找回密码2
	public function find_pw_s() {
		if(empty($_SESSION['us_openemail'])){
			if(empty($_POST['us_name'])&&empty($_POST['us_email'])) {
				$_SESSION = array();
				$this->display('../Public/LinkOut');
				return;
			}
			$ptname=$_POST['us_name'];
			$us_email=$_POST['us_email'];
			$fck = M('fck');
			$rs=$fck->where("user_id='".$ptname."'")->field('id,email,user_id,user_name,pwd1,pwd2')->find();
			if ($rs==false){
				$errarry['err']='<font color=red>注：找不到此会员编号！</font>';
				$this->assign('errarry',$errarry);
				$this->display('find_pw');
			}else{
				if($us_email<>$rs['email']){
					$errarry['err']='<font color=red>注：邮箱验证失败！</font>';
					$this->assign('errarry',$errarry);
					$this->display('find_pw');
				}else{

					$passarr=array();
					$passarr[0]=$rs['pwd1'];
					$passarr[1]=$rs['pwd2'];
					
					$title = '感谢您使用密码找回';
					
					$body="<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"font-size:12px; line-height:24px;\">";
					$body=$body."<tr>";
					$body=$body."<td height=\"30\">尊敬的客户:".$rs['user_name']."</td>";
					$body=$body."</tr>";
					$body=$body."<tr>";
					$body=$body."<td height=\"30\">你的账户编号:".$rs['user_id']."</td>";
					$body=$body."</tr>";
					$body=$body."<tr>";
					$body=$body."<td height=\"30\">一级密码为:".$rs['pwd1']."</td>";
					$body=$body."</tr>";
					$body=$body."<tr>";
					$body=$body."<td height=\"30\">二级密码为:".$rs['pwd2']."</td>";
					$body=$body."</tr>";
					$body=$body."此邮件由系统发出，请勿直接回复。<br>";
					$body=$body."</td></tr>";
					$body=$body."<tr>";
					$body=$body."<td height=\"30\" align=\"right\">".date("Y-m-d H:i:s")."</td>";
					$body=$body."</tr>";
					$body=$body."</table>";

					$this->send_email($us_email,$title,$body);

					$_SESSION['us_openemail']=$us_email;
					$this->find_pw_e($us_email);
				}
			}
		}else{
			$us_email=$_SESSION['us_openemail'];
			$this->find_pw_e($us_email);
		}
	}

	// 找回密码3
	public function find_pw_e($us_email) {
		$this->assign('myask',$us_email);
		$this->display('find_pw_s');
	}
	
	public function send_email($useremail,$title='',$body='')
	{

		require_once "stemp/class.phpmailer.php";
		require_once "stemp/class.smtp.php";

		$arra=array();

		$mail = new PHPMailer();
		$mail->IsSMTP();                  // send via SMTP
		$mail->Host  = "smtp.163.com";   // SMTP servers
		$mail->SMTPAuth = true;           // turn on SMTP authentication
		$mail->Username = "yuyangtaoyecn";     // SMTP username     注意：普通邮件认证不需要加 @域名
		$mail->Password = "yuyangtaoyecn666";          // SMTP password
		$mail->From  = "yuyangtaoyecn@163.com";        // 发件人邮箱
		$mail->FromName =  "商务会员管理系统";    // 发件人
		$mail->CharSet  = "utf-8";              // 这里指定字符集！
		$mail->Encoding = "base64";
		$mail->AddAddress("".$useremail."","".$useremail."");    // 收件人邮箱和姓名
		//$mail->AddAddress("119515301@qq.com","text");    // 收件人邮箱和姓名
		$mail->AddReplyTo("".$useremail."","163.com");
		$mail->IsHTML(true);    // send as HTML
		$mail->Subject  = $title; // 邮件主题
		$mail->Body = "".$body."";// 邮件内容
		$mail->AltBody ="text/html";
//		$mail->Send();

		if(!$mail->Send())
		{
		echo "Message could not be sent. <p>";
		echo "Mailer Error: " . $mail->ErrorInfo;
		exit;
		}
		//echo "Message has been sent";
	}

}
?>