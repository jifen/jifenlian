<?php
//注册模块
class TransferAction extends CommonAction{
	
	public function _initialize() {
		header("Content-Type:text/html; charset=utf-8");
		$this->_Config_name();//调用参数
 		$this->_checkUser();
		//$this->_inject_check(1);//调用过滤函数
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
				$_SESSION['Urlszpass'] = 'MyssFenYingTao';
				$bUrl = __URL__.'/transferMoney';//注册积分转换
                $this->_boxx($bUrl);
				break;
			case 2;
				$_SESSION['UrlPTPass'] = 'MyssTransfer';
				$bUrl = __URL__.'/adminTransferMoney';//货币转账
				$this->_boxx($bUrl);
				break;
			case 3;
				$_SESSION['UrlPTPass'] = 'MyssTransfer';
				$bUrl = __URL__.'/vap';//vap转换
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
				$_SESSION['Urlszpass'] = 'MyssFenYingTao';
				$bUrl = __URL__.'/transferMoney';//货币转账注册积分转帐
                $this->_boxx($bUrl);
				break;
			case 2;
				$_SESSION['UrlPTPass'] = 'MyssTransfer';
				$bUrl = __URL__.'/adminTransferMoney';//货币转账
				$this->_boxx($bUrl);
				break;
			default;
				$this->error('三级密码错误!');
				break;
		}
	}
	
	//=============================================注册积分转帐(会员之间的注册积分转帐)
	public function transferMoney($Urlsz=0){
		if ($_SESSION['Urlszpass'] == 'MyssFenYingTao'){
			$zhuanj = M('zhuanj');
			$id = $_SESSION[C('USER_AUTH_KEY')];

			$this->assign('id',$id);
			// $map['in_uid'] = $_SESSION[C('USER_AUTH_KEY')];
			// $map['out_uid'] = $_SESSION[C('USER_AUTH_KEY')];
			// $map['_logic'] = 'or';
			// $map1['is_del'] = 0;

			$fee_rs = M ('fee') -> find();
			$str3 = $fee_rs['str3'];
			$str18 = $fee_rs['str18'];

			$s16 = $fee_rs['s16'];
			$this->assign('s16',$s16);
			$this->assign('str18',$str18);
	
			$map = "(in_uid=".$id." or out_uid=".$id.") and is_del=0";
			//			$id = $_SESSION[C('USER_AUTH_KEY')];
			//			$sql = "in_uid =".$id ." or out_uid = ".$id;
			$field  = '*';
			//=====================分页开始==============================================
			import ( "@.ORG.ZQPage" );  //导入分页类
			$count = $zhuanj->where($map)->count();//总页数
			$listrows = C('ONE_PAGE_RE');//每页显示的记录数
			$Page = new ZQPage($count,$listrows,1);
			//===============(总页数,每页显示记录数,css样式 0-9)
			$show = $Page->show();//分页变量
			$this->assign('page',$show);//分页变量输出到模板
			$list = $zhuanj->where($map)->field($field)->order('id desc')->page($Page->getPage().','.$listrows)->select();
			
			$this->assign('list',$list);//数据输出到模板
			//=================================================
	
			$fck = M ('fck');
			$where = array();
			$where['id'] = $_SESSION[C('USER_AUTH_KEY')];
			$field = 'agent_use,agent_cash,is_agent,agent_xf,agent_kt';
			$rs = $fck->where($where)->field($field)->find();
			$this->assign('rs',$rs);
			$this->display('transferMoney');
			return;
		}else{
			$this->error ('错误!');
			exit;
		}
	}
	
	
	public function transferMoneyAC(){


		$UserID = $_POST['UserID'];    //转入会员帐号(进帐的用户帐号)
		//	$ePoints = (int) $_POST['ePoints'];
		$ePoints = $_POST['ePoints'];  //转入金额
		$content = $_POST['content'];  //转帐说明
		$select = $_POST['select'];  //转帐类型
	
		$fck = M ('fck');
		$where = array();
		$where['id']= $_SESSION[C('USER_AUTH_KEY')];

		if($_POST['yanzhengmas'] != $_SESSION['jifen'] || $_POST['yanzhengmas']==''){

			$this->error("您的验证码不正确");
		}


		$f = $fck->where($where )->field('user_id,is_zz,re_path')->find();
		if ($f['is_zz'] != 0) {
			$this->error("转账功能已被限制");
		}
	
		if ($select==2) $UserID = $_SESSION['loginUseracc'];
	
		$fck = M ('fck');
		if (!$fck->autoCheckToken($_POST)){
			$this->error('页面过期，请刷新页面！');
			exit;
		}
		if (empty($ePoints) || !is_numeric($ePoints) || empty($UserID)){
			$this->error('输入不能为空!');
			exit;
		}
		if($ePoints <= 0){
			$this->error('输入的金额有误!');
			exit;
		}
		//		if($UserID == $f['user_id']){
		//			$this->error('不能转给自己!');
		//			exit;
		//		}

		$wheres['user_id']= array('eq',$UserID);

		$fs = $fck->where($wheres)->find();
	//	echo $fs=M()->getLastSql();die;



		$cuns['re_path']=array('like','%,'.$_SESSION[C('USER_AUTH_KEY')].',%');
		$cuns['user_id']=array('eq',$fs['user_id']);
		$shangjis=M('fck')->where($cuns)->find();





	//	echo $shangjis=M()->getLastSql();die;
		if($select != 2){

           $arr = explode(',',$f['re_path']);

			if(!$shangjis && !in_array($fs['id'],$arr)){
				$this->error("您所转让的会员没有血缘关系!");
			}
		}







		$this->_transferMoneyConfirm($UserID,$ePoints,$content,$select);
	}
	
	private function _transferMoneyConfirm($UserID='0',$ePoints=0,$content=null,$select=0){
		if ($_SESSION['Urlszpass'] == 'MyssFenYingTao'){  //转帐权限session认证
			$fck = M ('fck');
			$where = array();
			$ID = $_SESSION[C('USER_AUTH_KEY')];     //登录会员AutoId
			$inUserID =  $_SESSION['loginUseracc'];  //登录的会员帐号 user_id
			//转出
			$history = M ('history');  //明细表
			$zhuanj  = M ('zhuanj');   //转帐表
	
			$myww = array();
			$myww['id'] = array('eq',$ID);
			$mmrs = $fck->where($myww)->find();
			$mmid = $mmrs['id'];
			$mmisagent = $mmrs['is_agent'];
			if($mmid==1){
				$mmisagent = 0;
			}
	
			//查询条件
			$where['user_id'] = $inUserID;  //登录的会员帐号 user_id
			$field ='id,user_id,agent_use,is_agent,agent_cash,agent_kt';
			$vo2 = $fck ->where($where)->field($field)->find();
			$a_agent = $vo2['is_agent'];
	
			//转入会员
			$fck_where = array();
			$fck_where['user_id'] =$UserID;// strtolower($UserID);
			$vo = $fck ->where($fck_where)->field($field)->find();  //找出转入会员记录
			if (!$vo){
				$this->error('转入会员不存在!');
				exit;
			}
			$b_agent = $vo['is_agent'];
			
//			if($b_agent != 2 && $select==1){
//				$this->error('注册积分只能转账给报单中心!');
//				exit;
//			}
//			if($a_agent == 2 && $select==1){
//				$this->error('报单中心之间不能互转!');
//				exit;
//			}
			
			
			
	
			$fee_rs = M ('fee') -> find();
			$str3 = $fee_rs['str3'];
			$str18 = $fee_rs['str18'];

			$s16 = $fee_rs['s16'];
			$this->assign('s16',$s16);
			$this->assign('str18',$str18);
            $must_money = $fee_rs['str6'];
                        
			$hB = $str18;//倍数
			$mmB = $str18;//最低额
			if($select==1){
				if($ePoints<$mmB){
					$this->error ('转账最低额度必须为 '.$mmB.' ！');
					exit;
				}
			}
			if ($ePoints % $hB){
				$this->error ('额度必须为 '.$hB.' 的整数倍!');
				exit;
			}
	
			$AgentUse = $vo2['agent_use'];
			if($select==2){
				if ($AgentUse < $ePoints){            //判断注册积分余额
				$this->error('奖励积分余额不足');
				exit;
			}
			}

			$AgentUseTwo = $vo2['agent_cash'];
			if($select==3){
				if ($AgentUseTwo < $ePoints){            //判断奖金余额
					$this->error('注册积分余额不足!');
					exit;
				}
			}



			unset($vo2);
			$history->startTrans();//开始事物处理
			if($select==1){
				$fck->execute("update `nnld_fck` Set `agent_use`=agent_use-".$ePoints." where `id`=".$ID);
				$fck->execute("update `nnld_fck` Set `agent_use`=agent_use+".$ePoints." where `id`=".$vo['id']);
			}
			if($select==2){
				$fck->execute("update `nnld_fck` Set `agent_use`=agent_use-".$ePoints." where `id`=".$ID);
				$fck->execute("update `nnld_fck` Set `agent_cash`=agent_cash+".$ePoints." where `id`=".$ID);
			}
			if($select==3){
				$fck->execute("update `nnld_fck` Set `agent_cash`=agent_cash-".$ePoints." where `id`=".$ID);
				$fck->execute("update `nnld_fck` Set `agent_cash`=agent_cash+".$ePoints." where `id`=".$vo['id']);
			}


			if($select==4){
				$fck->execute("update `nnld_fck` Set `agent_cash`=agent_cash-".$ePoints." where `id`=".$ID);
				$fck->execute("update `nnld_fck` Set `agent_cash`=agent_cash+".$ePoints." where `id`=".$vo['id']);
			}
	
	
	
			$nowdate = time();
			$data = array();
			$data['uid']           = $ID;          //转出会员ID
			$data['user_id']       = $UserID;
			$data['did']           = $vo['id'];    //转入会员ID
			$data['user_did']      = $vo['user_id'];
			$data['action_type']   = 20;    //转入还是转出
			$data['pdt']           = $nowdate;     //转帐时间
			$data['epoints']       = $ePoints;     //进出金额
			$data['allp']          = 0;
			$data['bz']            = '转帐';     //备注
			$data['type']          = 1;   		   //1转帐
			$history->create();
			$rs2=$history->add($data);
			unset($data);
			//转账表
			$data = array();
			$data['in_uid']        = $vo['id'];           //转入会员ID
			$data['out_uid']       = $ID;
			$data['in_userid']     = $vo['user_id'];      //转入会员的登录帐号
			$data['out_userid']    = $inUserID;
			$data['epoint']        = $ePoints;            //进出金额
			$data['rdt']           = $nowdate;            //转帐时间
			$data['sm']            = noHTML($content);            //转帐说明
			//$data['type']          = 0;                 // 3为货币转为货币
			$data['type']   = $select;
			//dump($select);exit;
			$zhuanj->create();
			$rs4=$zhuanj->add($data);
			unset($data);
	
			//无错误提交数据
			if ($rs2 && $rs4){
				$history->commit();//提交事务
				$bUrl = __URL__.'/transferMoney';
				$this->_box(1,'操作成功！',$bUrl,1);
				exit;
			}else{
				$history->rollback();//事务回滚：
				$this->error('输入数据错误！');
			}
		}else{
			$this->error('错误！');
			exit;
		}
	}



	public function vap(){//echo "11";exit;

		$vap = M('vap');
		$id = $_SESSION[C('USER_AUTH_KEY')];
		$this->assign('id',$id);
	//	echo  sprintf("%.8f", 120.1234567890);

		$fee_rs = M ('fee') -> find();

		$this->assign('str18',$fee_rs['str18']);
		$this->assign('i6',$fee_rs['i6']);
		$this->assign('str32',$fee_rs['str32']);


		if($fee_rs['i13'] ==1){
			$url = "https://api.allcoin.com/api/v1/ticker?symbol=vap_usd";
			$res = file_get_contents($url);
			$res = json_decode($res,true);
			$fl = $res['ticker']['last'];
		}else{
			$fl = $fee_rs['s20'];
		}


		$this->assign('fl',$fl);





		$map['uid']=array('eq',$id);
		//			$id = $_SESSION[C('USER_AUTH_KEY')];
		//			$sql = "in_uid =".$id ." or out_uid = ".$id;
		$field  = '*';
		//=====================分页开始==============================================
		import ( "@.ORG.ZQPage" );  //导入分页类
		$count = $vap->where($map)->count();//总页数
		$listrows = C('ONE_PAGE_RE');//每页显示的记录数
		$Page = new ZQPage($count,$listrows,1);
		//===============(总页数,每页显示记录数,css样式 0-9)
		$show = $Page->show();//分页变量
		$this->assign('page',$show);//分页变量输出到模板
		$list = $vap->where($map)->field($field)->order('id desc')->page($Page->getPage().','.$listrows)->select();

		$this->assign('list',$list);//数据输出到模板
		//=================================================

		$fck = M ('fck');
		$where = array();
		$where['id'] = $_SESSION[C('USER_AUTH_KEY')];
		$field = 'agent_use,agent_cash,is_agent,agent_xf,agent_gc,agent_kt';
		$rs = $fck->where($where)->field($field)->find();
		$this->assign('rs',$rs);





		if($_POST['ePoints']){

			if($_POST['ePoints'] % $fee_rs['str18']){

				$this->error("必须为100的倍数");
			}

			if($_POST['ePoints'] > $rs['agent_use']){

				$this->error("大于已有的奖励积分");
			}

			$this->vap_ac($id,$_POST['ePoints'],$fl,$fee_rs['i6'],$fee_rs['str32'],$_POST['yanzhengmas']);


		}



		$this->display();

	}




	public function vap_ac($id,$ePoints,$fl,$i6,$str32,$yanzhengmas){
        if($fl == ''){
		  $this->error("数据错误");
	    }


			if ($yanzhengmas != $_SESSION['vap']) {
				$this->error('验证码错误！');

			}



        $all_money = $ePoints/($fl*$i6);
		$get_money = $all_money - $all_money*$str32/100;
		$data['uid']=$id;
		$data['vap_price']=$fl;
		$data['rmb']=$i6;
		$data['epoints']=$ePoints;
		$data['all_money']=sprintf("%.8f",$all_money);
		$data['get_money']=sprintf("%.8f",$get_money);
		$data['pdt']=time();
		$vap = M('vap')->add($data);
        if($vap){
           $jianshao=M('fck')->where('id='.$id)->setDec('agent_use',$ePoints);
			$jianshao=M('fck')->where('id='.$id)->setInc('agent_gc',sprintf("%.8f",$get_money));
			$this->success("转换成功");
		}
	}





		public function shifang(){


			if($_REQUEST['start'] && $_REQUEST['end']){
				$map['pdt'] = array(array('egt',strtotime($_REQUEST["start"])),array('elt',strtotime($_REQUEST["end"])));
				$this->assign('start',strtotime($_REQUEST["start"]));
				$this->assign('end',strtotime($_REQUEST["end"]));
			}

		/*	if($_REQUEST['user_id']){
				$map['user_id'] = array('eq',$_REQUEST['user_id']);
				$this->assign('user_id',$_REQUEST["user_id"]);
			}    */

			$shifang=M('shifang');

			$map['user_id'] = array('eq',$_SESSION['loginUseracc']);

			import ( "@.ORG.ZQPage" );  //导入分页类
			$count = $shifang->where($map)->count();//总页数
			$listrows = C('ONE_PAGE_RE');//每页显示的记录数
			$listrows = 15;//每页显示的记录数
			$page_where ='start='.$_REQUEST["start"].'&end='.$_REQUEST["end"];//分页条件
			$Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
			//===============(总页数,每页显示记录数,css样式 0-9)
			$show = $Page->show();//分页变量
			$this->assign('page',$show);//分页变量输出到模板
			$list = $shifang->order('pdt desc')->where($map)->page($Page->getPage().','.$listrows)->select();
			//  echo $list=M()->getLastSql();
			$this->assign('list',$list);//数据输出到模板

			$this->display();

		}




	public function adminTransferMoney(){
		$this->_Admin_checkUser();
		if ($_SESSION['UrlPTPass'] == 'MyssTransfer'){
			$zhuanj = M('zhuanj');
				
			$UserID = $_REQUEST['UserID'];
			$map = "is_del=0";
			if (!empty($UserID)){
				import ( "@.ORG.KuoZhan" );  //导入扩展类
				$KuoZhan = new KuoZhan();
				if ($KuoZhan->is_utf8($UserID) == false){
					$UserID = iconv('GB2312','UTF-8',$UserID);
				}
				unset($KuoZhan);
				//     		$map['in_userid'] = array('like',"%".$UserID."%");
				$map .= "and (in_userid like '%".$UserID."%') or (out_userid  like '%".$UserID."%') ";
				$UserID = urlencode($UserID);
			}
				
			import ( "@.ORG.ZQPage" );  //导入分页类
			$count = $zhuanj->where($map)->count();//总页数
			$listrows = C('ONE_PAGE_RE');//每页显示的记录数
			$page_where = 'UserID=' . $UserID;//分页条件
			$Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
			//===============(总页数,每页显示记录数,css样式 0-9)
			$show = $Page->show();//分页变量
			$this->assign('page',$show);//分页变量输出到模板
			$list = $zhuanj->where($map)->field('*')->order('rdt desc,id desc')->page($Page->getPage().','.$listrows)->select();
			$this->assign('list',$list);
				
			$this->display('adminTransferMoney');
		}else{
			$this->error('数据错误！');
			exit;
		}
		 
	}

	public function adminTransferMoneyAC(){
		//处理提交按钮
		$action = $_POST['action'];
		//获取复选框的值
		$PTid = $_POST['tabledb'];
		if (!isset($PTid) || empty($PTid)){
			$bUrl = __URL__.'/adminTransferMoney';
			$this->_box(0,'请选择会员！',$bUrl,1);
			exit;
		}
		switch ($action){
			case '删除';
				$this->_TransferDel($PTid);
				break;
		default;
			$bUrl = __URL__.'/adminTransferMoney';
			$this->_box(0,'没有该会员！',$bUrl,1);
			break;
		}
	}

	private function _TransferDel($PTid){
		$zhuanj = M('zhuanj');

		$where['id'] = array('in',$PTid);
		$rs = $zhuanj->where($where)->setField('is_del',1);
		if($rs){
			$this->success("删除成功");
			exit;
		}else{
			$this->success("删除失败");
			exit;
		}


	}

	
	
}
?>