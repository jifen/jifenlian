<?php 

class CurrencyAction extends CommonAction {
	
	function _initialize() {
		$this->_checkUser();
		$this->_Config_name();//调用参数
		header("Content-Type:text/html; charset=utf-8");
		ob_clean();
	}

	public function cody(){
		//===================================二级验证
		$UrlID = (int) $_GET['c_id'];
		if (empty($UrlID)){
			$this->error('二级密码错误!');
			exit;
		}
		if(!empty($_SESSION['user_pwd2'])){
			$url = __URL__."/codys/Urlsz/$UrlID";
			$this->_boxx($url);
			exit;
		}
		$cody   =  M ('cody');
        $list	=  $cody->where("c_id=$UrlID")->field('c_id')->find();
		if ($list){
			$this->assign('vo',$list);
			$this->display('../Public/cody');
			exit;
		}else{
			$this->error('二级密码错误!');
			exit;
		}
	}


		public function codys(){
				//=============================二级验证后调转页面
				$Urlsz = (int) $_POST['Urlsz'];
				if(empty($_SESSION['user_pwd2'])){
					$pass  = $_POST['oldpassword'];
					$fck   =  M ('fck');
					if (!$fck->autoCheckToken($_POST)){
						$this->error('页面过期请刷新页面!');
			            exit();
					}
					if (empty($pass)){
						$this->error('二级密码错误!');
						exit();
					}
		
					$where = array();
					$where['id'] = $_SESSION[C('USER_AUTH_KEY')];
					$where['passopen'] = md5($pass);
					$list = $fck->where($where)->field('id,is_agent')->find();
					if($list == false){
						$this->error('二级密码错误!');
						exit();
					}
					$_SESSION['user_pwd2'] = 1;
				}else{
					$Urlsz = $_GET['Urlsz'];
				}
				switch ($Urlsz){
					case 1;
						$_SESSION['Urlszpass'] = 'MyssPaoYingTao';
						$bUrl = __URL__.'/frontCurrency';//
						$this->_boxx($bUrl);
						break;
				
					case 2;
						$_SESSION['Urlszpass'] = 'MyssGuanPaoYingTao';
						$bUrl = __URL__.'/adminCurrency';//
						$this->_boxx($bUrl);
						break;

					case 4;
						$_SESSION['Urlszpass'] = 'MyssGuanPaoYingTao';
						$bUrl = __URL__.'/BCurrency';//
						$this->_boxx($bUrl);
						break;
					
					default;
						$this->error('二级密码错误!');
						exit;
				}
			}



	//三级密码验证
	public function codyT(){
		$UrlID = (int)$_GET['c_id'];
		if (empty($UrlID)){
			$this->error('三级密码错误!');
			exit;
		}
	
		$fck   =  M ('cody');
        $list	=  $fck->where("c_id=$UrlID")->getField('c_id');
		if (!empty($list)){
			$this->assign('vo',$list);
			
			$this->display('../Public/codyT');
			exit;
		}else{
			$this->error('三级密码错误!');
			exit;
		}
	}
	//三级验证后调转页面
	public function codyTs(){
		$Urlsz = $_POST['Urlsz'];
		
		$pass  = $_POST['oldpassword'];
		$fck   =  M ('fck');
	    if (!$fck->autoCheckToken($_POST)){
            $this->error('页面过期请刷新页面!');
            exit();
        }
		if (empty($pass)){
			$this->error('三级密码错误!');
			exit();
		}

		$where =array();
		$where['id'] = $_SESSION[C('USER_AUTH_KEY')];
		$where['passopentwo'] = md5($pass);
		$list = $fck->where($where)->field('id')->find();
		if($list == false){
			$this->error('三级密码错误!');
			exit();
		}
		
		switch ($Urlsz){
			case 1;
				$_SESSION['Urlszpass'] = 'MyssPaoYingTao';
				$bUrl = __URL__.'/frontCurrency';//
				$this->_boxx($bUrl);
				break;
		
			case 2;
				$_SESSION['Urlszpass'] = 'MyssGuanPaoYingTao';
				$bUrl = __URL__.'/adminCurrency';//
				$this->_boxx($bUrl);
				break;

			case 4;
				$_SESSION['Urlszpass'] = 'MyssGuanPaoYingTao';
				$bUrl = __URL__.'/BCurrency';//

				$this->_boxx($bUrl);
				break;

			default;
				$this->error('三级密码错误!');
				break;
		}
	}

	//===================================================货币提现
	public function frontCurrency($Urlsz=0){
		if ($_SESSION['Urlszpass'] == 'MyssPaoYingTao'){
			$tiqu = M('tiqu');
			$fck = M('fck');
			$map['uid'] = $_SESSION[C('USER_AUTH_KEY')];

			$field  = '*';
            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $tiqu->where($map)->count();//总页数
    	    $listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $Page = new ZQPage($count,$listrows,1);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $list = $tiqu->where($map)->field($field)->order('id desc')->page($Page->getPage().','.$listrows)->select();
            $this->assign('list',$list);//数据输出到模板
            //=================================================

			$where = array();
			$ID = $_SESSION[C('USER_AUTH_KEY')];
			$where['id'] = $ID;
			$field = '*';
			$rs = $fck ->where($where)->field($field)->find();

			$fee_rs = M ('fee') -> find();
			$s13 = explode("|", $fee_rs['s13']);
			$this -> assign('hl',$s13[1]);


			$this -> assign('menber',$fee_rs['s8']);
			$this -> assign('minn',$fee_rs['s16']);
			$this->assign('type',$ID);
			$this->assign('rs',$rs);
			unset($tiqu,$fck,$where,$ID,$field,$rs);
			$this->display ('frontCurrency');
			return;
		}else{
			$this->error ('错误!');
			exit;
		}
	}





	//=================================================提现提交
	public function frontCurrencyConfirm(){
		if ($_SESSION['Urlszpass'] == 'MyssPaoYingTao'){  //提现权限session认证

			$fee_rs = M ('fee') -> find();

		$ePoints = (int) trim($_POST['ePoints']);

			$type = $_POST['type'];


			$fck = M ('fck');
			$day_now = date("d");
//			if($day_now!=5&&$day_now!=15&&$day_now!=25){
//				$this->error('今日不能提现!');
//				exit;
//			}
			if (empty($ePoints) || !is_numeric($ePoints)){
				$this->error('金额不能为空!');
				exit;
			}
			if (strlen($ePoints) > 12){
				$this->error ('金额太大!');
				exit;
			}
			if ($ePoints <= 0){
				$this->error ('金额输入不正确!');
				exit;
			}


		/*
			 $day_now = date("w");
             $s7=explode('|',$fee_rs['s7']);
			 $days='';
             foreach($s7 as $k=>$v){
				// $s7[$k] = "星期".$v;
				 if($v==7){
					 $s7[$k]=0;
				 }
					 $days .="星期".$v;
			 }


			*/

/*
			if (!in_array($day_now, $s7)) {
				$this->error ('今日'.$days.'可提现');
				exit;
			}

*/



//			$newWeek = date(w);
//			if($newWeek != 1 ){
//				$this->error('只能星期一才能提现');
//				exit;
//			}



			$where = array();
			$ID = $_SESSION[C('USER_AUTH_KEY')];
			$user = $fck->field('is_zz')->find($ID);
			if ($user['is_zz'] != 0) {
				$this->error('提现功能已被限制');
			}
			if($ID == 1){
				$inUserID =  $_POST['UserID'];           //要提现的会员帐号 800000登录时可以帮其它会员申请提现
			}else{
				$inUserID =  $_SESSION['loginUseracc'];  //登录的会员帐号 user_id
			}
			$tiqu = M ('tiqu');                      //转帐表
			//查询条件
			$where['user_id'] = $inUserID;
			$field ='*';
			$fck_rs = $fck ->where($where)->field($field)->find();
			if (!$fck_rs){
				$this->error('没有该会员!');
				exit;
			}
//			$is_agent = $fck_rs['is_agent'];
//			if($fck_rs['id']==1){
//				$is_agent = 0;
//			}
//			if($is_agent==2){
//				$this->error('报单中心不能申请提现！');
//				exit;
//			}




		 if($type == 1){
			 $AgentUse = $fck_rs['agent_use'];
			 if ($AgentUse < $ePoints){
				 $this->error('奖金积分不足!');
				 exit;
			 }
		 }


			if($type == 2){
				$AgentUse = $fck_rs['vap_xiaofei'];
				if ($AgentUse < $ePoints){
					if($AgentUse == 0){
						$vap_xiaofei=0;
					}else{
						$vap_xiaofei=$fck_rs['vap_xiaofei'];
					}

					$this->error('vap积分不足,只能提现'.$vap_xiaofei.'!');
					exit;
				}
			}


			$s_nowd = strtotime(date("Y-m-d"));
			$e_nowd = $s_nowd+3600*24;

//			$where2 = array();
//			$where2['uid'] = $fck_rs['id'];   //申请提现会员ID
//			$where2['rdt'] = array(array('egt',$s_nowd),array('lt',$e_nowd));
//			$field1 = 'id';
//			$vo5 = $tiqu ->where($where2)->count();
//			if ($vo5>0){
//				$this->error('每天限制提现一次!');
//				exit;
//			}

			$where1 = array();
			$where1['uid'] = $fck_rs['id'];   //申请提现会员ID
			$where1['is_pay'] = 0;
			$where1['type'] = 1;//申请提现是否通过
			$field1 = 'id';
			$vo3 = $tiqu ->where($where1)->field($field1)->find();
			if ($vo3){
				$this->error('上次提现还没通过审核!');
				exit;
			}






			$s16 = $fee_rs['s16'];
			$ks_m = $fee_rs['s8'];

			$hB = $s16;//最低提现额
			$bs = $hB;//倍数

			if($type == 1){

			if ($ePoints < $hB){
				$this->error ('提现金额最低额度为 '.$hB.' ');
				exit;
			}

			if ($ePoints % $bs){
				$this->error ('提现金额必须为 '.$bs.' 的倍数!');
				exit;
			}

		  }


			if($type == 2){

				if ($ePoints % 100){
					$this->error ('提现金额必须为 100 的倍数!');
					exit;
				}

			}




			$bank_name = $fck_rs['bank_name'];  //开户银行
			$bank_card = $fck_rs['bank_card'];  //银行卡号
			$user_name = $fck_rs['user_name'];   //开户姓名
			$bank_province  = $fck_rs['bank_province']; 
			$bank_city      = $fck_rs['bank_city']; 
			$bank_address = $fck_rs['bank_address'];   //开户姓名
			$user_tel = $fck_rs['user_tel'];   //开户姓名
//			$qq        = $fck_rs['qq'];   //财富通QQ
//			if(empty($user_name) or empty($bank_card) or empty($bank_name)){
//				$this->error ('请输入完整的开户信息!');
//				exit;
//			}



			$ePoints_two = $ePoints - ($ePoints * $ks_m / 100);  //提现扣税
//			$ePoints_two = $ePoints - $fee_rs['s8'];  //提现扣税

			$nowdate = strtotime(date('c'));
			//开始事务处理
			$tiqu->startTrans();

			//插入提现表
			$data                 = array();
			$data['uid']          = $fck_rs['id'];
			$data['user_id']      = $inUserID;
			$data['rdt']          = $nowdate;
			$data['money']        = $ePoints;
			$data['money_two']    = $ePoints_two;
			$data['epoint']       = $ePoints;
			$data['is_pay']       = 0;
			$data['bank_name']    = $bank_name;  //银行名称
			$data['bank_card']    = $bank_card;  //银行地址
			$data['user_name']    = $user_name;  //开户名称
			$data['x1']           = $bank_province;
			$data['x2']           = $bank_city;
			$data['bank_address'] = $bank_address;
			$data['user_tel'] = $user_tel;
			$data['type'] = $type;
			$rs2 = $tiqu->add($data);
			unset($data,$vo3,$where1);
			if ($rs2){

				//提交事务
				if($type == 1){
					$fck->execute("UPDATE __TABLE__ SET agent_use=agent_use-{$ePoints} WHERE id={$fck_rs['id']}");
				}

				if($type == 2){
					$fck->execute("UPDATE __TABLE__ SET vap_xiaofei=vap_xiaofei-{$ePoints} WHERE id={$fck_rs['id']}");


				}



				$tiqu->commit();
				$bUrl = __URL__.'/frontCurrency';
				$this->_box(1,'积分提现成功！',$bUrl,1);
				exit;
			}else{
				//事务回滚：
				$tiqu->rollback();
				$this->error('积分提现失败！');
				exit;
			}
		}else{
			$this->error('错误！');
			exit;
		}
	}


	//=================================================提现提交
	public function BCurrencyConfirm(){

			$ePoints = (int) trim($_POST['ePoints']);
			$fck = M ('fck');
			$day_now = date("d");
//			if($day_now!=5&&$day_now!=15&&$day_now!=25){
//				$this->error('今日不能提现!');
//				exit;
//			}
			if (empty($ePoints) || !is_numeric($ePoints)){
				$this->error('金额不能为空!');
				exit;
			}
			if (strlen($ePoints) > 12){
				$this->error ('金额太大!');
				exit;
			}
			if ($ePoints <= 0){
				$this->error ('金额输入不正确!');
				exit;
			}
//			$newWeek = date(w);
//			if($newWeek != 1 ){
//				$this->error('只能星期一才能提现');
//				exit;
//			}

			$where = array();
			$ID = $_SESSION[C('USER_AUTH_KEY')];
			$user = $fck->field('is_zz')->find($ID);
			if ($user['is_zz'] != 0) {
				$this->error('提现功能已被限制');
			}
			if($ID == 1){
				$inUserID =  $_POST['UserID'];           //要提现的会员帐号 800000登录时可以帮其它会员申请提现
			}else{
				$inUserID =  $_SESSION['loginUseracc'];  //登录的会员帐号 user_id
			}
			$tiqu = M ('tiqu');                      //转帐表
			//查询条件
			$where['user_id'] = $inUserID;
			$field ='*';
			$fck_rs = $fck ->where($where)->field($field)->find();
			if (!$fck_rs){
				$this->error('没有该会员!');
				exit;
			}
//			$is_agent = $fck_rs['is_agent'];
//			if($fck_rs['id']==1){
//				$is_agent = 0;
//			}
//			if($is_agent==2){
//				$this->error('报单中心不能申请提现！');
//				exit;
//			}

			$AgentUse = $fck_rs['agent_gc'];
			if ($AgentUse < $ePoints){
				$this->error('金额不足!');
				exit;
			}

			$s_nowd = strtotime(date("Y-m-d"));
			$e_nowd = $s_nowd+3600*24;

//			$where2 = array();
//			$where2['uid'] = $fck_rs['id'];   //申请提现会员ID
//			$where2['rdt'] = array(array('egt',$s_nowd),array('lt',$e_nowd));
//			$field1 = 'id';
//			$vo5 = $tiqu ->where($where2)->count();
//			if ($vo5>0){
//				$this->error('每天限制提现一次!');
//				exit;
//			}


/*		if(time()-$fck_rs['b_time'] < 86400*3){
           $this->error('隔两天才取现两天');
			exit;
		}

*/
			$where1 = array();
			$where1['uid'] = $fck_rs['id'];   //申请提现会员ID
			$where1['is_pay'] = 0;
		    $where1['type'] = 2;
		//申请提现是否通过
			$field1 = 'id';
			$vo3 = $tiqu ->where($where1)->field($field1)->find();
			if ($vo3){
				$this->error('上次提现还没通过审核!');
				exit;
			}

			$fee_rs = M ('fee') -> find();

			$s16 = $fee_rs['i5'];
			$ks_m = $fee_rs['i6'];
		    $ks_ms = $fee_rs['s8'];
			$hB = $s16;//最低提现额
			$bs = $hB;//倍数
			if ($ePoints < 100){
				$this->error ('提现金额最低额度为100');
				exit;
			}

	/*	if ($ePoints > $ks_m){
			$this->error ('提现金额最低额度为 '.$ks_m.' ');
			exit;
		}  */
//			if($ks_m>$s16){
//				$this->error ('提现失败，提现手续费大于最低提现额度，请联系管理员！');
//				exit;
//			}

			if ($ePoints % 100){
				$this->error ('提现金额必须为 100 的倍数!');
				exit;
			}

			$bank_name = $fck_rs['bank_name'];  //开户银行
			$bank_card = $fck_rs['bank_card'];  //银行卡号
			$user_name = $fck_rs['user_name'];   //开户姓名
			$bank_province  = $fck_rs['bank_province'];
			$bank_city      = $fck_rs['bank_city'];
			$bank_address = $fck_rs['bank_address'];   //开户姓名
			$user_tel = $fck_rs['user_tel'];   //开户姓名
//			$qq        = $fck_rs['qq'];   //财富通QQ
//			if(empty($user_name) or empty($bank_card) or empty($bank_name)){
//				$this->error ('请输入完整的开户信息!');
//				exit;
//			}



			$ePoints_two = $ePoints - ($ePoints * $ks_ms / 100);  //提现扣税
//			$ePoints_two = $ePoints - $fee_rs['s8'];  //提现扣税

			$nowdate = strtotime(date('c'));
			//开始事务处理
			$tiqu->startTrans();
		    $times= strtotime(date('Y-m-d'));

			//插入提现表
			$data                 = array();
			$data['uid']          = $fck_rs['id'];
			$data['user_id']      = $inUserID;
			$data['rdt']          = $nowdate;
			$data['money']        = $ePoints;
			$data['money_two']    = $ePoints_two;
			$data['epoint']       = $ePoints;
			$data['is_pay']       = 0;
			$data['bank_name']    = $bank_name;  //银行名称
			$data['bank_card']    = $bank_card;  //银行地址
			$data['user_name']    = $user_name;  //开户名称
			$data['x1']           = $bank_province;
			$data['x2']           = $bank_city;
			$data['bank_address'] = $bank_address;
			$data['user_tel'] = $user_tel;
		    $data['type'] = 2;
			$rs2 = $tiqu->add($data);
			unset($data,$vo3,$where1);
			if ($rs2){
				//提交事务
				$fck->execute("UPDATE __TABLE__ SET agent_gc=agent_gc-{$ePoints} WHERE id={$fck_rs['id']}");
				$fck->execute("UPDATE __TABLE__ SET b_time={$times} WHERE id={$fck_rs['id']}");

				$tiqu->commit();
				$bUrl = __URL__.'/BCurrency';
				$this->_box(1,'VAP积分提现成功！',$bUrl,1);
				exit;
			}else{
				//事务回滚：
				$tiqu->rollback();
				$this->error('VAP积分提现失败！');
				exit;
			}
	}
	


	public function BCurrency($Urlsz=0){
		if ($_SESSION['Urlszpass'] == 'MyssGuanPaoYingTao'){
			$tiqu = M('tiqu');
			$fck = M('fck');
			$map['uid'] = $_SESSION[C('USER_AUTH_KEY')];
			$map['type'] = 2;
			$field  = '*';
			//=====================分页开始==============================================
			import ( "@.ORG.ZQPage" );  //导入分页类
			$count = $tiqu->where($map)->count();//总页数
			$listrows = C('ONE_PAGE_RE');//每页显示的记录数
			$Page = new ZQPage($count,$listrows,1);
			//===============(总页数,每页显示记录数,css样式 0-9)
			$show = $Page->show();//分页变量
			$this->assign('page',$show);//分页变量输出到模板
			$list = $tiqu->where($map)->field($field)->order('id desc')->page($Page->getPage().','.$listrows)->select();
			$this->assign('list',$list);//数据输出到模板
			//=================================================

			$where = array();
			$ID = $_SESSION[C('USER_AUTH_KEY')];
			$where['id'] = $ID;
			$rs = $fck ->where($where)->find();

			$fee_rs = M ('fee') -> find();
			$s13 = explode("|", $fee_rs['s13']);
			$this -> assign('hl',$s13[1]);
			$this -> assign('rmb',$fee_rs['i6']);


			$url = "https://api.allcoin.com/api/v1/ticker?symbol=vap_usd";
			$res = file_get_contents($url);
			$res = json_decode($res,true);
			$this -> assign('huilv',$res['ticker']['last']);


			$this -> assign('menber',$fee_rs['s8']);
			$this -> assign('minn',$fee_rs['s16']);

			$this -> assign('xiao',$fee_rs['i5']);
			$this -> assign('da',$fee_rs['i6']);

			$this->assign('type',$ID);
			$this->assign('rs',$rs);
			unset($tiqu,$fck,$where,$ID,$field,$rs);
			$this->display ('BCurrency');
			return;
		}else{
			$this->error ('错误!');
			exit;
		}
	}


	//=============撤销提现
	public function BCurrencyDel(){

			$tiqu = M ('tiqu');
			$uid = $_SESSION[C('USER_AUTH_KEY')];
			$id = (int) $_GET['id'];
			$where = array();
			$where['id']  = $id;
			$where['uid'] = $uid;   //申请提现会员ID
			$where['is_pay'] = 0;            //申请提现是否通过
			$field = 'id,money,uid';
			$trs = $tiqu ->where($where)->field($field)->find();
			if ($trs){
				$fck = M ('fck');
				$fck->execute("UPDATE __TABLE__ SET agent_cf=agent_cf+{$trs['money']} WHERE id={$trs['uid']}");
				$tiqu->where($where)->delete();
				$bUrl = __URL__.'/BCurrency';
				$this->_box(1,'撤销提现！',$bUrl,1);
				exit;
			}else{
				$this->error('没有该记录!');
				exit;
			}
	}


	
	//=============撤销提现
	public function frontCurrencyDel(){
	    if ($_SESSION['Urlszpass'] == 'MyssPaoYingTao'){
			$tiqu = M ('tiqu');
			$uid = $_SESSION[C('USER_AUTH_KEY')];
			$id = (int) $_GET['id'];
	    	$where = array();
	    	$where['id']  = $id;
	        $where['uid'] = $uid;   //申请提现会员ID
	        $where['is_pay'] = 0;            //申请提现是否通过
	        $field = '*';
	        $trs = $tiqu ->where($where)->field($field)->find();
	        if ($trs){
	            $fck = M ('fck');
				if($trs['type']==1){
					$fck->execute("UPDATE __TABLE__ SET agent_use=agent_use+{$trs['money']} WHERE id={$trs['uid']}");
				}

				if($trs['type']==2){
					$fck->execute("UPDATE __TABLE__ SET vap_xiaofei=vap_xiaofei+{$trs['money']} WHERE id={$trs['uid']}");
				}

	            $tiqu->where($where)->delete();
	            $bUrl = __URL__.'/frontCurrency';
                $this->_box(1,'撤销提现！',$bUrl,1);
                exit;
	        }else{
	        	$this->error('没有该记录!');
                exit;
	        }
	    }else{
            $this->error('错误!');
            exit;
        }
	}

	//===============================================提现管理
	public function adminCurrency(){
		$this->_Admin_checkUser();//后台权限检测
		if ($_SESSION['Urlszpass'] == 'MyssGuanPaoYingTao'){
			$tiqu = M ('tiqu');
			$fck = M('fck');
			$fee_rs = M ('fee')->field('str5,s13') -> find();
			$str5 = $fee_rs['str5'];
			$s13 = explode("|", $fee_rs['s13']);
			$this -> assign('hl',$s13[1]);

			$UserID = $_POST['UserID'];
			if (!empty($UserID)){
				$map['user_id'] = array('like',"%".$UserID."%");
			}
            $field  = '*';
            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $tiqu->where($map)->count();//总页数
//       		$listrows = C('ONE_PAGE_RE');//每页显示的记录数
       		$listrows = 20;	//每页显示的记录数
            $page_where = 'UserID=' . $UserID;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $list = $tiqu->where($map)->field($field)->order('id desc')->page($Page->getPage().','.$listrows)->select();
            $i=0;
            foreach($list as $vvv){
            	$uuid = $vvv['uid'];
            	$urs = $fck->where('id='.$uuid)->field('bank_address')->find();
            	if($urs){
            		$list[$i]['bank_address'] = $urs['bank_address'];
            	}
            	$i++;
            }
			$this->assign('list',$list);//数据输出到模板
			//=================================================
			$this->display('adminCurrency');
		}else{
			$this->error('错误!');
			exit;
		}
	}
	//处理提现
	public function adminCurrencyAC(){
		$this->_Admin_checkUser();//后台权限检测
		//处理提交按钮
		$action = $_POST['action'];
		//获取复选框的值
		$PTid = $_POST['tabledb'];
		$fck = M ('fck');
		if (empty($PTid)){
			$bUrl = __URL__.'/adminCurrency';
			$this->_box(0,'请选择！',$bUrl,1);
			exit;
		}
		switch ($action){
			case '确认':
				$this->_adminCurrencyConfirm($PTid);
				break;
			case '删除':
				$this->_adminCurrencyDel($PTid);
				break;
		default:
			$bUrl = __URL__.'/adminCurrency';
			$this->_box(0, '没有该记录！', $bUrl,1);
			break;
		}
	}
	
	//====================================================确认提现
	private function _adminCurrencyConfirm($PTid){
		$this->_Admin_checkUser();//后台权限检测
		if ($_SESSION['Urlszpass'] == 'MyssGuanPaoYingTao'){
			$tiqu = M ('tiqu');
			$fck = M('fck');//
			$history = M('history');
			$where = array();
			$where['is_pay'] = 0;
			$where['id'] = array ('in',$PTid);
			$rs = $tiqu->where($where)->select();
			
			$data = array();
			$fck_where = array();
			$nowdate = strtotime(date('c'));
			foreach($rs as $rss){
				$fck_where['id'] = $rss['uid'];
				$rsss = $fck->where($fck_where)->field('id,user_id,agent_use')->find();
				if ($rsss){
					$result = $tiqu->execute("UPDATE __TABLE__ set `is_pay`=1 where `id`=".$rss['id']);
					if($result){
						//插入历史表
						$data = array();
						$data['uid']			= $rsss['id'];//提现会员ID
						$data['user_id']		= $rsss['user_id'];
						$data['action_type']	= 18;
						$data['pdt']			= mktime();//提现时间
						$data['epoints']		= $rss['money'];//进出金额
						$data['allp']			= $rss['money_two'];
						$data['bz']				= '18';//备注
						$data['type']			= 2;//1 转帐  2 提现
						$history->add($data);
						unset($data);

						$fck->execute("UPDATE __TABLE__ set zsq=zsq+".$rss['money'].",tx_num=tx_num+1 where `id`=".$rss['uid']);
					}
				}else{
					$tiqu->execute("UPDATE __TABLE__ set `is_pay`=1 where `id`=".$rss['id']);
				}
			}
			unset($tiqu,$fck,$where,$rs,$history,$data,$nowdate,$fck_where);
			$bUrl = __URL__.'/adminCurrency';
			$this->_box(1,'确认提现！',$bUrl,1);
		}else{
			$this->error('错误!');
			exit;
		}
	}
	//删除提现
	private function _adminCurrencyDel($PTid){
		$this->_Admin_checkUser();//后台权限检测
		if ($_SESSION['Urlszpass'] == 'MyssGuanPaoYingTao'){
			$tiqu = M ('tiqu');
			$where = array();
//			$where['is_pay'] = 0;
			$where['id'] = array ('in',$PTid);
			$trs = $tiqu->where($where)->select();
			$fck = M ('fck');
			foreach ($trs as $vo){
				$isok = $vo['is_pay'];
				$money=$vo['money'];


				if($isok==0 && $vo['type']==1){
					$fck->execute("UPDATE __TABLE__ SET agent_use=agent_use+{$money} WHERE id={$vo['uid']}");
				}

				if($isok==0 && $vo['type']==2){
					$fck->execute("UPDATE __TABLE__ SET vap_xiaofei=vap_xiaofei+{$money} WHERE id={$vo['uid']}");
				}


			}



			$rs = $tiqu->where($where)->delete();
			if ($rs){
				$bUrl = __URL__.'/adminCurrency';
				$this->_box(1,'删除成功！',$bUrl,1);
				exit;
			}else{
				$bUrl = __URL__.'/adminCurrency';
				$this->_box(0,'删除失败！',$bUrl,1);
				exit;
			}
		}else{
			$this->error('错误!');
			exit;
		}
	}
//导出excel
	public function DaoChu(){
		$this->_Admin_checkUser();//后台权限检测
		if ($_SESSION['Urlszpass'] == 'MyssGuanPaoYingTao'){
			$title   =   "数据库名:test,   数据表:test,   备份日期:"   .   date("Y-m-d   H:i:s");
			header("Content-Type:   application/vnd.ms-excel");
			header("Content-Disposition:   attachment;   filename=Cash.xls");
			header("Pragma:   no-cache");
			header("Content-Type:text/html; charset=utf-8");
			header("Expires:   0");
			echo   '<table   border="1"   cellspacing="2"   cellpadding="2"   width="50%"   align="center">';
			//   输出标题
			echo   '<tr   bgcolor="#cccccc"><td   colspan="3"   align="center">'   .   $title   .   '</td></tr>';
			//   输出字段名
			echo   '<tr >';
			echo   "<td>会员编号</td>";
			echo   "<td>开户名</td>";
			echo   "<td>开户银行</td>";
			echo   "<td>银行帐号</td>";
			echo   "<td>开户省份</td>";
			echo   "<td>提现金额</td>";
			echo   "<td>实发金额</td>";
			echo   "<td>提现时间</td>";
			echo   "<td>状态</td>";
			echo   '</tr>';
			//   输出内容
			$tiqu = M ('tiqu');
			$trs = $tiqu->select();
			foreach($trs as $row)   {

			if ($row['is_pay']==0){
			    $isPay = '未确认';
			}else{
			    $isPay = '已确认';
			}
			echo   '<tr>';
			echo   '<td>'   .   $row['user_id']   .   '</td>';
			echo   '<td>'   .   $row['user_name']   .   '</td>';
			echo   '<td>'   .   $row['bank_name']   .   '</td>';
			echo   "<td>"  .  chr(28).$row['bank_card'] .  "</td>";
			echo   '<td>'   .   $row['x1']   .   '</td>';
			echo   '<td>'   .   $row['money']   .   '</td>';
			echo   '<td>'   .   $row['money_two']   .   '</td>';
			echo   '<td>'   .   date('Y-m-d',$row['rdt'])   .   '</td>';
			echo   '<td>'   .  $isPay    .   '</td>';
			echo   '</tr>';
			}
			echo   '</table>';
			}else{
				$this->error('错误!');
				exit;
			}
	}

	public function DaoChu1(){
		$this->_Admin_checkUser();//后台权限检测
		if ($_SESSION['Urlszpass'] == 'MyssGuanPaoYingTao'){
			$title   =   "数据库名:test,   数据表:test,   备份日期:"   .   date("Y-m-d   H:i:s");
			header("Content-Type:   application/vnd.ms-excel");
			header("Content-Disposition:   attachment;   filename=test.xls");
			header("Pragma:   no-cache");
			header("Content-Type:text/html; charset=utf-8");
			header("Expires:   0");
			echo   '<table   border="1"   cellspacing="2"   cellpadding="2"   width="50%"   align="center">';
			//   输出标题
			echo   '<tr   bgcolor="#cccccc"><td   colspan="3"   align="center">'   .   $title   .   '</td></tr>';
			//   输出字段名
			echo   '<tr >';
			echo   "<td>会员编号</td>";
			echo   "<td>开户名</td>";
			echo   "<td>开户银行</td>";
			echo   "<td>银行帐号</td>";
			echo   "<td>开户详细地址</td>";
			echo   "<td>提现金额</td>";
			echo   "<td>实发金额</td>";
			echo   "<td>提现时间</td>";
			echo   "<td>状态</td>";
			echo   '</tr>';
			//   输出内容
			$tiqu = M ('tiqu');
			$trs = $tiqu->select();
			foreach($trs as $row)   {

			if ($row['is_pay']==0){
			    $isPay = '未确认';
			}else{
			    $isPay = '已确认';
			}
			echo   '<tr>';
			echo   '<td>'   .   $row['user_id']   .   '</td>';
			echo   '<td>'   .   $row['user_name']   .   '</td>';
			echo   '<td>'   .   $row['bank_name']   .   '</td>';
			echo   "<td>,"  .  chr(28).$row['bank_card'] .  "</td>";
			echo   '<td>'   .   $row['bank_address']   .   '</td>';
			echo   '<td>'   .   $row['money']   .   '</td>';
			echo   '<td>'   .   $row['money_two']   .   '</td>';
			echo   '<td>'   .   date('Y-m-d',$row['rdt'])   .   '</td>';
			echo   '<td>'   .  $isPay    .   '</td>';
			echo   '</tr>';
			}
			echo   '</table>';
			}else{
				$this->error('错误!');
				exit;
			}
	}


	

}
?>