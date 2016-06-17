<?php
//注册模块
class AgentAction extends CommonAction{
	
	public function _initialize() {
		header("Content-Type:text/html; charset=utf-8");
		$this->_Config_name();//调用参数
 		$this->_checkUser();
		//$this->_inject_check(1);//调用过滤函数
	}

	public function index(){

		$fck2=M('fck2')->where('is_time=1')->select();
		foreach($fck2 as $v){
			$lesstime= $v['time']-time();
			if($lesstime <=0){
				if($v['uid'] == 1){
					$data['is_time']=0;
					$data['is_suo']=0;
					$data['time']=0;
					$suo=M('fck2')->where('id=1')->setField($data);
					$suo1=M('fck')->where('id=1')->setField('is_suo',0);

				}else{
					$data['is_time']=0;
					$data['is_suo']=1;
					$data['time']=0;
					$suo=M('fck2')->where('id='.$v['id'])->setField($data);
					$suo1=M('fck')->where('id='.$v['uid'])->setField('is_suo',1);

				}
			}
		}

		$this->display();

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
			$list = $fck->where($where)->field('id,is_agent,is_company')->find();
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
				if($list['is_agent'] >=2){
					$this->error('您已经是服务中心!');
            		exit();
				}
				$_SESSION['Urlszpass'] = 'MyssXiGua';
				$bUrl = __URL__.'/agents';//申请代理
                $this->_boxx($bUrl);
			break;
				case 2;
				$_SESSION['Urlszpass'] = 'MyssShuiPuTao';
				$bUrl = __URL__.'/menber'; //未开通会员
				$this->_boxx($bUrl);
			break;
		
			case 3;
				$_SESSION['Urlszpass'] = 'Myssmenberok';
				$bUrl = __URL__.'/menberok'; //已开通会员
				$this->_boxx($bUrl);
			break;
			
			case 4;
				$_SESSION['UrlPTPass'] = 'MyssGuanXiGua';
				$bUrl = __URL__.'/adminAgents'; //后台确认报单中心
				$this->_boxx($bUrl);
			break;
			case 7;
				$_SESSION['UrlPTPass'] = 'MyssGuanXiGua';
				$bUrl = __URL__.'/upLevel'; //后台确认报单中心
				$this->_boxx($bUrl);
				break;
			case 8;
				$_SESSION['UrlPTPass'] = 'MyssGuanXiGua';
				$bUrl = __URL__.'/okLevel'; //后台确认报单中心
				$this->_boxx($bUrl);
				break;
			case 9;
				$_SESSION['UrlPTPass'] = 'MyssGuanXiGua';
				$bUrl = __URL__.'/uphistory'; //后台确认报单中心
				$this->_boxx($bUrl);
				break;
			case 5;
				$_SESSION['UrlPTPass'] = 'MyssGuanXiGuaCompany';
				$bUrl = __URL__.'/adminCompanys'; //后台确认分公司
				$this->_boxx($bUrl);
			break;
			case 6;
				if($list['is_company'] >=2){
					$this->error('您已经是分公司!');
            		exit();
				}
				$_SESSION['Urlszpass'] = 'MyssGuanXiGuaCompany';
				$bUrl = __URL__.'/companys';//申请代理
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
			$this->error('三级密码错误!1');
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
			case 4;
				$_SESSION['UrlPTPass'] = 'MyssGuanXiGua';
				$bUrl = __URL__.'/adminAgents'; //后台确认报单中心
				$this->_boxx($bUrl);
				break;
			case 5;
				$_SESSION['UrlPTPass'] = 'MyssGuanXiGuaCompany';
				$bUrl = __URL__.'/adminCompanys'; //后台确认分公司
				$this->_boxx($bUrl);
			break;
			default;
				$this->error('三级密码错误!');
				break;
		}
	}

	public function agents($Urlsz=0){
		//======================================申请会员中心/会员中心/服务中心
		if ($_SESSION['Urlszpass'] == 'MyssXiGua'){
			$fee_rs = M ('fee') -> find();
			$this->_levelShopConfirm($agentLevelArr);
			$this->assign('agentLevelArr',$agentLevelArr);
			$fck = M ('fck');
			$where = array();
			//查询条件
			$where['id'] = $_SESSION[C('USER_AUTH_KEY')];
			$field ='*';
			$fck_rs = $fck ->where($where)->field($field)->find();
	
			if (!$fck_rs) $this->error("错误");
			//会员级别
			switch($fck_rs['is_shengji']){
				case 0:
					$agent_status = '未申请互助';
					break;
				case 1:
					$agent_status = '申请成功';
					break;
				case 2:
					$agent_status =  '申请成功';
					break;
			}
			$this->assign ( 'agent_status',$agent_status);
			$this->assign ( 'fck_rs', $fck_rs);
			
			$Agent_Us_Name = C('Agent_Us_Name');
			$Aname = explode("|",$Agent_Us_Name);
			$this->assign ( 'sheng_money',$fee_rs['s2']);
			$this->assign ( 'Aname', $Aname);
			
			$this->display ('agents');

		}else{
			$this->error ('错误!');
			exit;
		}
	}
	
	
	public function agentsAC(){
		//================================申请会员中心中转函数
		$content  = $_POST['content'];
		$money  = $_POST['money'];
		$shoplx = 1;
		// $shoplx  = (int)$_POST['shoplx'];
		// if ($shoplx < 1 || $shoplx > 2) {
		// 	$this->error('错误');
		// }
		$fee=M('fee');
		$fee_rs=$fee->find(1);
		// $s14=(int)$fee_rs['s14'];
		$Fck = D ('Fck');
		$fck = M ('fck');
		$id = $_SESSION[C('USER_AUTH_KEY')];
		$where = array();
		$where['id'] = $id;
	
		$fck_rs = $fck->where($where)->field('*')->find();
	
		if($fck_rs){

		/*	if($fck_rs['is_pay']  == 0){
				$this->error ('临时会员不能申请!');
				exit;
			}
			if($fck_rs['is_agent']  == 1){
				$this->error('上次申请还没通过审核!');
				exit;
			}
			$minF4 = $fck_rs['l'] > $fck_rs['r'] ? $fck_rs['r'] : $fck_rs['l'];
			if ($minF4 < $fee_rs['s11']) {
				$this->error("小区业绩{$fee_rs['s11']}单以上才可以申请！");
			}

		*/
			// if ($fck_rs['td_yj'] < $fee_rs['str10']) {
			// 	$this->error('业绩达'.$fee_rs['str10'].'元以上才可申请!');
			// 	exit;
			// }
			// if($fck_rs['u_level'] < $fee_rs['str10']){
			// 	$this->error('您等级太低，不能申请报单中心!');
			// 	exit;
			// }
			 if($fck_rs['agent_use'] < $money){
			 	$this->error('您的奖金币余额不足');
			 	exit;
			 }
			// switch ($shoplx) {
			// 	case '1':
			// 		$shop_a = $_POST['ss1'];
			// 		$shop_b = $_POST['ss2'];
			// 		$shop_c = $_POST['ss3'];
			// 		break;
			// 	case '2':
			// 		$shop_a = $_POST['ss1'];
			// 		$shop_b = $_POST['ss2'];
			// 		$shop_c = '';
			// 		break;
			// 	default:
			// 		# code...
			// 		break;
			// }
			// $map = array();
			// $map['is_agent'] = array('gt',0);
			// $map['shop_a'] = $shop_a;
			// $map['shop_b'] = $shop_b;
			// $map['shop_c'] = $shop_c;
			// $map['shoplx'] = $shoplx;
			// $haveAgent = $fck->where($map)->field('id')->find();
			// if ($haveAgent) {
			// 	$this->error('此区域报单中心已存在或已被申请！');
			// }
		/*	if(empty($content)){
 				$this->error ('请输入备注!');
 				exit;
			}  */

				$nowdate = time();
				$result = $fck -> execute("update __TABLE__ set verify='".$content."',shengji_time=$nowdate,is_shengji=1,agent_use=agent_use-'".$money."' where id=".$id);
			   if($result){
				   $fckdata = $this->gongpaixtsmall();
				   $fckdata['uid']=$id;
				   $fckdata['user_id']=$fck_rs['user_id'];
				   $d =M('fck2')->add($fckdata);
				   $Fck->addencAdd($id,$fck_rs['user_id'],-$money,9);
				   $this->checkSheng($id);

			   }



			$bUrl = __URL__ .'/agents';
			$this->_box(1,'申请成功,请进入B网络图',$bUrl,2);
	
		}else{
			$this->error('非法操作');
			exit;
		}
	}


   public function checkSheng($id){
	   $fee=M('fee');
	   $fee_rs=$fee->find();
	   $suo_time = $fee_rs['str12']*60*60;
	   $fck2 = M('fck2');
	   $fck=$fck2->where('uid='.$id)->find();
	   if($fck['treeplace']==1){
          $jia=$fck2->where('id='.$fck['father_id'])->setInc('sheng',1);
		  $ff=$fck2->where('id='.$fck['father_id'])->find();
		  $data['is_time']= 1;
		  $data['time']=time()+$suo_time;
		  $jias=$fck2->where('id='.$fck['father_id'])->setField($data);
		   if($jia){
			   $this->checkSheng($ff['uid']);
		   }
	   }

   }




	public function adminSetAgent(){
		//=====================================后台服务中心级别管理
		$this->_Admin_checkUser();
		if ($_SESSION['UrlPTPass'] != 'MyssGuanXiGua'){
			$this->error('数据错误!');
			exit;
		}
		$fck = M('fck');
		$id = $_GET['id'];
		$user = $fck->field('id,user_id,shoplx,shop_a,shop_b,verify')->find($id);
		$this->assign('user',$user);
		$fee_rs = M('fee')->field('s5')->find(1);
		$this->_levelShopConfirm($lvArr);
		$this->assign('lvArr',$lvArr);

		$this->display ();
		return;
	}

	public function adminSetAgentAC(){
		//================================申请会员中心中转函数
		$this->_Admin_checkUser();
		if ($_SESSION['UrlPTPass'] != 'MyssGuanXiGua'){
			$this->error('数据错误!');
			exit;
		}
		$content  = $_POST['content'];
		$shoplx  = (int)$_POST['shoplx'];
		if ($shoplx < 1 || $shoplx > 2) {
			$this->error('请选择级别');
		}
		$fck = M ('fck');
		$id = (int)$_POST['id'];
		$where = array();
		$where['id'] = $id;
	
		$fck_rs = $fck->where($where)->field('id,is_pay,is_agent,shoplx,shop_a,shop_b')->find();
	
		if($fck_rs){
			if($fck_rs['is_pay']  == 0){
				$this->error ('临时会员不能修改!');
				exit;
			}
			// if($fck_rs['is_agent']  == 1){
			// 	$this->error('上次申请还没通过审核!');
			// 	exit;
			// }
			// if ($fck_rs['td_yj'] < $fee_rs['str10']) {
			// 	$this->error('业绩达'.$fee_rs['str10'].'元以上才可申请!');
			// 	exit;
			// }
			// if($fck_rs['u_level'] < $fee_rs['str10']){
			// 	$this->error('您等级太低，不能申请报单中心!');
			// 	exit;
			// }
			// if($fck_rs['agent_cash'] < $fee_rs['str11']){
			// 	$this->error('您的注册积分账户不足'.$fee_rs['str11'].'元!');
			// 	exit;
			// }
			// if (empty($shoplx)) {
			// 	$shoplx = $fck_rs['shoplx'];
			// }
			switch ($shoplx) {
				case '1':
					$shop_a = $_POST['ss1'];
					$shop_b = $_POST['ss2'];
					$shop_c = $_POST['ss3'];
					break;
				case '2':
					$shop_a = $_POST['ss1'];
					$shop_b = $_POST['ss2'];
					$shop_c = '';
					break;
				default:
					# code...
					break;
			}
			$map = array();
			$map['is_agent'] = array('gt',0);
			$map['shop_a'] = $shop_a;
			$map['shop_b'] = $shop_b;
			$map['shop_c'] = $shop_c;
			$map['shoplx'] = $shoplx;
			$haveAgent = $fck->where($map)->field('id')->find();
			// if ($haveAgent) {
			// 	$this->error('此区域报单中心已存在或已被申请！');
			// }
			// if(empty($content)){
 		// 		$this->error ('请输入备注!');
 		// 		exit;
			// }

			$result = $fck -> query("update __TABLE__ set verify='".$content."',shoplx=".$shoplx.",shop_a='".$shop_a."',shop_b='".$shop_b."',shop_c='".$shop_c."' where id=".$id);

	
			$bUrl = __URL__ .'/adminAgents';
			$this->_box(1,'修改成功！',$bUrl,2);
	
		}else{
			$this->error('非法操作');
			exit;
		}
	}

	public function companys($Urlsz=0){
		//======================================申请会员中心/代理中心/服务中心
		if ($_SESSION['Urlszpass'] == 'MyssGuanXiGuaCompany'){
			$fee_rs = M ('fee') -> find();
	
			$fck = M ('fck');
			$where = array();
			//查询条件
			$where['id'] = $_SESSION[C('USER_AUTH_KEY')];
			$field ='*';
			$fck_rs = $fck ->where($where)->field($field)->find();
	
			if ($fck_rs){
				//会员级别
				switch($fck_rs['is_company']){
					case 0:
						$agent_status = '未申请分公司!';
						break;
					case 1:
						$agent_status = '申请正在审核中!';
						break;
					case 2:
						$agent_status = '分公司已开通!';
						break;
				}
	
				$this->assign ( 'fee_s6',$fee_rs['i1']);
				$this->assign ( 'agent_level',0);
				$this->assign ( 'agent_status',$agent_status);
				$this->assign ( 'fck_rs', $fck_rs);
				
				$Agent_Us_Name = C('Agent_Us_Name');
				$Aname = explode("|",$Agent_Us_Name);
				$this->assign ( 'Aname', $Aname);
				
				$this->display ('companys');
			}else{
				$this->error ('操作失败!');
				exit;
			}
		}else{
			$this->error ('错误!');
			exit;
		}
	}
	
	
	public function companysAC(){
		//================================申请会员中心中转函数
		$content  = $_POST['content'];
		$fck = M ('fck');
		$id = $_SESSION[C('USER_AUTH_KEY')];
		$where = array();
		$where['id'] = $id;
		$fck_rs = $fck->where($where)->field('*')->find();
	
		if($fck_rs){
			if($fck_rs['is_pay']  == 0){
				$this->error ('临时会员不能申请!');
				exit;
			}
			if($fck_rs['is_company']  == 1){
				$this->error('上次申请还没通过审核!');
				exit;
			}
			if(empty($content)){
 				$this->error ('请输入备注!');
 				exit;
			}
	
			if($fck_rs['is_company'] == 0){
				$nowdate = time();
				$result = $fck -> query("update __TABLE__ set is_company=1,company_rdt=$nowdate,company_bz='".$content."' where id=".$id);
			}
	
			$bUrl = __URL__ .'/companys';
			$this->_box(1,'申请成功！',$bUrl,2);
	
		}else{
			$this->error('非法操作');
			exit;
		}
	}
	
	//未开通会员
	public function menber($Urlsz=0){
		//列表过滤器，生成查询Map对像
		if ($_SESSION['Urlszpass'] == 'MyssShuiPuTao'){
			$fck = M('fck');
			$map = array();
			$id = $_SESSION[C('USER_AUTH_KEY')];
			// $gid = (int) $_GET['bj_id'];
			// $map['shop_id'] = $id;
		//	$map['_string'] = "`shop_id`={$id}";


			$UserID = $_POST['UserID'];
				if (!empty($UserID)){
                    import ( "@.ORG.KuoZhan" );  //导入扩展类
                    $KuoZhan = new KuoZhan();
                    if ($KuoZhan->is_utf8($UserID) == false){
                        $UserID = iconv('GB2312','UTF-8',$UserID);
                    }
                    unset($KuoZhan);
                    $where['nickname'] = array('like',"%".$UserID."%");
                    $where['user_id'] = array('like',"%".$UserID."%");
                    $where['_logic']    = 'or';
                    $map['_complex']    = $where;
                    $UserID = urlencode($UserID);
                }


			$map['is_pay'] = array('eq',0);
			$map['re_id'] = array('eq',$id);


			// $map['_string'] = "shop_id=".$id." or re_id=".$id."";
            //查询字段
            $field  = '*';
            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $fck->where($map)->count();//总页数
    	    $listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $page_where = 'UserID='.$UserID;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $list = $fck->where($map)->field($field)->order('is_pay asc,pdt desc')->page($Page->getPage().','.$listrows)->select();
   //   echo $list=M()->getLastSql();

            $this->assign('list',$list);//数据输出到模板
            //=================================================
            
			$HYJJ = '';
            $this->_levelConfirm($HYJJ,1);

            $fee=M('fee')->find(1);
            $str28 = explode('|',$fee['str28']);
            $this->assign('voo',$str28);//会员级别


			$where = array();
			$where['id'] = $id;
			$fck_rs = $fck->where($where)->field('*')->find();
			$this->assign('frs',$fck_rs);//注册积分
			$this->display ('menber');
			exit;
		}else{
			$this->error('数据错误!');
			exit;
		}
	}



	//未开通会员
	public function menberok($Urlsz=0){
		//列表过滤器，生成查询Map对像
		if ($_SESSION['Urlszpass'] == 'Myssmenberok'){
			$fck = M('fck');
			$map = array();
			$id = $_SESSION[C('USER_AUTH_KEY')];
			$gid = (int) $_GET['bj_id'];
			$map['re_id'] = $id;
			$map['is_pay'] = array('gt',0);
			$UserID = $_POST['UserID'];

			if (!empty($UserID)){
				import ( "@.ORG.KuoZhan" );  //导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($UserID) == false){
                    $UserID = iconv('GB2312','UTF-8',$UserID);
                }
                unset($KuoZhan);
				$where['nickname'] = array('like',"%".$UserID."%");
				$where['user_id'] = array('like',"%".$UserID."%");
				$where['_logic']    = 'or';
				$map['_complex']    = $where;
				$UserID = urlencode($UserID);
			}



            //查询字段
            $field  = '*';
            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $fck->where($map)->count();//总页数
    	    $listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $page_where = 'UserID='.$UserID;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $list = $fck->where($map)->field($field)->order('is_pay asc,pdt desc')->page($Page->getPage().','.$listrows)->select();

            $this->assign('list',$list);//数据输出到模板
            //=================================================
            
			//$HYJJ = '';
            //$this->_levelConfirm($HYJJ,1);
			//$this->assign('voo',$HYJJ);//会员级别
			$fee=M('fee')->find(1);
			$str28 = explode('|',$fee['str28']);
			$this->assign('voo',$str28);//会员级别

			$where = array();
			$where['id'] = $id;
			$fck_rs = $fck->where($where)->field('*')->find();
			$this->assign('frs',$fck_rs);//注册积分
			$this->display ('menberok');
			exit;
		}else{
			$this->error('数据错误!');
			exit;
		}
	}
        
        //报单中心开通的会员
	public function shopMenber($Urlsz=0){
		//列表过滤器，生成查询Map对像
		$this->_Admin_checkUser();
		if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGua'){
			$fck = M('fck');
			$map = array();
			$id = (int) $_REQUEST['shopId'];
                        $this->assign('shopId',$id);
			$gid = (int) $_GET['bj_id'];
			$map['shop_id'] = $id;
			$map['is_pay'] = array('gt',0);
			$UserID = $_POST['UserID'];
			if (!empty($UserID)){
				import ( "@.ORG.KuoZhan" );  //导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($UserID) == false){
                    $UserID = iconv('GB2312','UTF-8',$UserID);
                }
                unset($KuoZhan);
				$where['nickname'] = array('like',"%".$UserID."%");
				$where['user_id'] = array('like',"%".$UserID."%");
				$where['_logic']    = 'or';
				$map['_complex']    = $where;
				$UserID = urlencode($UserID);
			}

            //查询字段
            $field  = '*';
            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $fck->where($map)->count();//总页数
    	    $listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $page_where = 'UserID='.$UserID;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $list = $fck->where($map)->field($field)->order('is_pay asc,pdt desc')->page($Page->getPage().','.$listrows)->select();
            $this->assign('list',$list);//数据输出到模板
            //=================================================
            
			$HYJJ = '';
            $this->_levelConfirm($HYJJ,1);
            $this->assign('voo',$HYJJ);//会员级别
			$where = array();
			$where['id'] = $id;
			$fck_rs = $fck->where($where)->field('*')->find();
			$this->assign('frs',$fck_rs);//开通币
			$this->display ('shopMenber');
			exit;
		}else{
			$this->error('数据错误!');
			exit;
		}
	}

	public function shopMenber2($Urlsz=0){
		//列表过滤器，生成查询Map对像
		$this->_Admin_checkUser();
		if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGuaCompany'){
			$fck = M('fck');
			$map = array();
			$id = (int) $_REQUEST['shopId'];
                        $this->assign('shopId',$id);
			$gid = (int) $_GET['bj_id'];
			$map['company_id'] = $id;
			$map['is_pay'] = array('gt',0);
			$UserID = $_POST['UserID'];
			if (!empty($UserID)){
				import ( "@.ORG.KuoZhan" );  //导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($UserID) == false){
                    $UserID = iconv('GB2312','UTF-8',$UserID);
                }
                unset($KuoZhan);
				$where['nickname'] = array('like',"%".$UserID."%");
				$where['user_id'] = array('like',"%".$UserID."%");
				$where['_logic']    = 'or';
				$map['_complex']    = $where;
				$UserID = urlencode($UserID);
			}

            //查询字段
            $field  = '*';
            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $fck->where($map)->count();//总页数
    	    $listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $page_where = 'UserID='.$UserID;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $list = $fck->where($map)->field($field)->order('is_pay asc,pdt desc')->page($Page->getPage().','.$listrows)->select();
            $this->assign('list',$list);//数据输出到模板
            //=================================================
            
			$HYJJ = '';
            $this->_levelConfirm($HYJJ,1);
            $this->assign('voo',$HYJJ);//会员级别
			$where = array();
			$where['id'] = $id;
			$fck_rs = $fck->where($where)->field('*')->find();
			$this->assign('frs',$fck_rs);//开通币
			$this->display ('shopMenber2');
			exit;
		}else{
			$this->error('数据错误!');
			exit;
		}
	}
	
	public function shopMenberExcel()
	{
		//列表过滤器，生成查询Map对像
		$this->_Admin_checkUser();
		if ($_SESSION['UrlPTPass'] != 'MyssGuanXiGua') {
			$this->error('数据错误!');
		}

		$fck = M('fck');
		$map = array();
		$id = (int) $_REQUEST['shopId'];
        $this->assign('shopId',$id);
		$gid = (int) $_GET['bj_id'];
		$map['shop_id'] = $id;
		$map['is_pay'] = array('gt',0);

		$where['id'] = $id;
		$shop = $fck->where($where)->field('user_id')->find();

        //查询字段
        $field  = '*';
        $list = $fck->where($map)->field($field)->order('is_pay asc,pdt desc')->select();
        $this->assign('list',$list);
        
		$HYJJ = '';
        $this->_levelConfirm($HYJJ,1);
        // $this->assign('voo',$HYJJ);//会员级别
		$where = array();
		$where['id'] = $id;
		$fck_rs = $fck->where($where)->field('*')->find();
		$this->assign('frs',$fck_rs);//开通币
		
		set_time_limit(0);
	
		header("Content-Type:   application/vnd.ms-excel");
		header("Content-Disposition:   attachment;   filename=".$shop['user_id']."旗下代理/客户.xls");
		header("Pragma:   no-cache");
		header("Content-Type:text/html; charset=utf-8");
		header("Expires:   0");
	
		$title   =   "服务中心".$shop['user_id']."旗下代理/客户 导出时间:".date("Y-m-d   H:i:s");
	
		echo   '<table   border="1"   cellspacing="2"   cellpadding="2"   width="50%"   align="center">';
		//   输出标题
		echo   '<tr   bgcolor="#cccccc"><td   colspan="7"   align="center">'   .   $title   .   '</td></tr>';
		//   输出字段名
		echo   '<tr  align=center>';
		echo   "<td>序号</td>";
		echo   "<td>会员编号</td>";
		echo   "<td>联系电话</td>";
		echo   "<td>注册时间</td>";
		echo   "<td>开通时间</td>";
		echo   "<td>加盟级别</td>";
		echo   "<td>注册金额</td>";
		echo   '</tr>';
		//   输出内容
	
		//		dump($list);exit;
	
		$i = 0;
		foreach($list as $row)   {
			$i++;
			$num = strlen($i);
			if ($num == 1){
				$num = '000'.$i;
			}elseif ($num == 2){
				$num = '00'.$i;
			}elseif ($num == 3){
				$num = '0'.$i;
			}else{
				$num = $i;
			}
	
			echo   '<tr align=center>';
			echo   '<td>'   .  chr(28).$num   .   '</td>';
			echo   "<td>"   .   $row['user_id'].  "</td>";
			echo   "<td>"   .   $row['user_tel'].  "</td>";
			echo   "<td>"   .   date("Y-m-d H:i:s",$row['rdt']).  "</td>";
			echo   "<td>"   .   date("Y-m-d H:i:s",$row['pdt']).  "</td>";
			echo   "<td>"   .   $HYJJ[$row['u_level']].  "</td>";
			echo   "<td>"   .   $row['cpzj'].  "</td>";
			echo   '</tr>';
		}
		echo   '</table>';

	}
	
	public function menberAC(){
		//处理提交按钮
		$action = $_POST['action'];
		//获取复选框的值
		$OpID = $_POST['tabledb'];

		if (!isset($OpID) || empty($OpID)){
			$bUrl = __URL__.'/menber';
			$this->_box(0,'没有该会员！',$bUrl,1);
			exit;
		}
		switch ($action){
			 case '开通会员':
			 	$this->_menberOpenUse($OpID);
			 	break;
			case '注册积分开通会员':
				$this->_menberOpenUse($OpID,1);
				break;
			case '复投币+注册积分开通会员':
				$this->_menberOpenUse($OpID,2);
				break;
			case '删除会员':
				$this->_menberDelUse($OpID);
				break;
			default:
				$bUrl = __URL__.'/menber';
				$this->_box(0,'没有该会员！',$bUrl,1);
				break;
		}
	}
	
	
	private function _menberOpenUse($OpID=0,$open_type=1){
		//=============================================开通会员
		if ($_SESSION['Urlszpass'] == 'MyssShuiPuTao'){
		    $fck = D ('Fck');
			$fee = M ('fee');
			$card = A('Phonecard');
			$shouru = M('shouru');

		    if (!$fck->autoCheckToken($_POST)){
                $this->error('页面过期，请刷新页面！');
                exit;
            }
            if ($open_type != 1 && $open_type != 2) {
            	$this->error('参数错误');
            }
            // 开通类型
            $moneyName = $open_type == 1 ? '注册积分' : '注册积分';

			//被开通会员参数
			$where = array();
			$where['id'] = array ('in',$OpID);  //被开通会员id数组
			$where['is_pay'] = 0;  //未开通的
			$field = '*';
			$vo = $fck ->where($where)->field($field)->select();
			$fee_rs = $fee -> find();
			$s4 = explode("|", $fee_rs['s4']);

			$bili = $fee_rs['s2']/100;


			if($fee_rs['i13'] ==1){
				$url = "https://api.allcoin.com/api/v1/ticker?symbol=vap_usd";
				$res = file_get_contents($url);
				$res = json_decode($res,true);
				$fl = $res['ticker']['last'];
			}else{
				$fl = $fee_rs['s20'];
			}


			$this->assign('fl',$fl);


			//报单中心参数
			$where_two =array();
			$field_two = '*';
			$ID = $_SESSION[C('USER_AUTH_KEY')];
			$where_two['id'] = $ID;
//			$where_two['is_agent'] = array('gt',1);
			$nowdate = strtotime(date('c'));
			$nowday=strtotime(date('Y-m-d'));
			$fck->emptyTime();
			foreach($vo as $voo){
				$rs = $fck->where($where_two)->field($field_two)->find();  //找出登录会员(必须为报单中心并且已经登录)
				if (!$rs){
					$this->error('会员错误！');
					exit;
				}
                // if ($rs['is_agent'] != 2){
                //     $this->error('只有成为报单中心才能报单！');
                //     exit;
                // }
				$ppath=$voo['p_path'];
				//上级未开通不能开通下级员工
				$frs_where['is_pay'] = array('eq',0);
				$frs_where['id'] = $voo['father_id'];
				$frs = $fck -> where($frs_where) -> find();
				if($frs){
					$this->error('开通失败，上级未开通');
					exit;
				}

				if ($open_type == 1) {
					$agent_use = $voo['cpzj'];
					$agent_cf = 0;
				}
				else {
					$agent_use = $voo['cpzj'] / 2;
					$agent_cf = $voo['cpzj'] / 2;
				}
	
				if ($rs['agent_cash'] < $agent_use){
					$bUrl = __URL__.'/menber';
					$this->_box(0,'注册积分余额不足！',$bUrl,1);
					exit;
				}
				if ($rs['agent_cf'] < $agent_cf){
					$bUrl = __URL__.'/menber';
					$this->_box(0,'复投币余额不足！',$bUrl,1);
					exit;
				}





				//给推荐人添加推荐人数或单数
				$fck->query("update __TABLE__ set `td_yj`=td_yj+".$voo['cpzj']*$bili.",`re_nums`=re_nums+1 where `id`=".$voo['re_id']);

				unset($re_rs);




				$rmb=$fee_rs['i6'];

				$data = array();
				$data['is_pay'] = 1;
				$data['open_id'] = $ID;
				$data['pdt'] = $nowdate;
				$data['open'] = 0;
				$data['open_type'] = $open_type;
				$data['get_date'] = $nowday;
				$mm = date('m',time());

				$rmb=$fee_rs['i6'];

				$s2=$fee_rs['s2'];


				$s5 = explode('|',$fee_rs['s5']);


				//	$data['agent_gc'] = $voo['cpzj']*$s5[$voo['u_level']]/100;

				$data['vap_total'] = ($voo['cpzj']*$s5[$voo['cpzj_level']]/100)/($rmb*$fl);
				$data['vap_all'] = ($voo['cpzj']*$s5[$voo['cpzj_level']]/100)/($rmb*$fl);//sarwen修改20160616
				$data['vap_amount'] = ($voo['cpzj']*$s5[$voo['cpzj_level']]/100)/($rmb*$fl);


				$data['fanli_time'] = $nowday;//当天没有分红奖
				//	$data['fafang_time'] = strtotime(date("Y-m-d",strtotime("+6 day")));
				$data['fafang_time'] = '1462032000';
				$data['fafang_cishu'] = 200;
				//开通会员
				$result = $fck->where('id='.$voo['id'])->save($data);
				unset($data,$varray);
				$data = array();
				$data['uid'] = $voo['id'];
				$data['user_id'] = $voo['user_id'];
				$data['in_money'] = $voo['cpzj'];
				$data['in_time'] = time();
				$data['in_bz'] = "新会员加入(".$moneyName.")";
				$rsd = $shouru->add($data);

				$money = $voo['cpzj'];  //找出该会员的注册金额
				$fck->query("update __TABLE__ set `agent_cash`=agent_cash-". $agent_use ." where `id`=".$ID);

				if ($open_type == 1) {
					$fck->addencAdd($rs['id'], $voo['user_id'], -$voo['cpzj'], 19);//历史记录
				}
				else {
					$fck->addencAdd($rs['id'], $voo['user_id'], -$voo['cpzj'], 19);//历史记录
				}



				$bid = $fck->_getTimeTableList(10799);
				$bid = $fck->_getTimeTableList(10800);
				$bid = $fck->_getTimeTableList(10801);
				$bonus = M('bonus');
				$md = $voo['cpzj']*$bili*0.01;
				$bonus->where('uid=10799')->order('id desc')->setInc('b8',$md);
				$bonus->where('uid=10800')->order('id desc')->setInc('b8',$md);
				$bonus->where('uid=10801')->order('id desc')->setInc('b8',$md);

				$fck->where('id=10799')->setInc('agent_use',$md);
				$fck->where('id=10800')->setInc('agent_use',$md);
				$fck->where('id=10801')->setInc('agent_use',$md);

				$fck->addencAdd(10799, $voo['user_id'], $md, 8);//历史记录
				$fck->addencAdd(10800, $voo['user_id'], $md, 8);//历史记录
				$fck->addencAdd(10801, $voo['user_id'], $md, 8);//历史记录
				//加到记录表
				/************T050业务逻辑***********/
			//	$fck->dsfenhong($voo['cpzj']*$bili);  //董事分红



				/************T050业务逻辑***********/
				//	$fck->dsfenhong($voo['cpzj']*$bili);  //董事分红


				//添加团队业绩
				$map = array();
				$map['id'] = array('in',$voo['re_path']);
				$fck->where($map)->setInc('team_yj',$voo['cpzj']*$bili);



				$fck->xiaoshoujiang($voo['id'],$voo['user_id'],$voo['cpzj'],$voo['cpzj_level'],$voo['cpzj']*$bili,$voo['u_level'],$voo['father_id'],$voo['re_id'],$voo['re_path'],$voo['p_path'],$nowdate);  //销售奖


				$fck->shjifen($voo['user_id'],$voo['re_path'],$voo['cpzj']*$bili);   //级差奖结算

				$fck->dsfenhong($voo['cpzj']*$bili);  // 董事分红


				$fck->dailiLevel($voo['re_path']);  // 代理级别


				$fck->dongshiLevel($voo['re_path']);  // 董事级别


				//	$fck->fuwuyj($voo['id'],$voo['user_id'],$voo['cpzj'],$voo['cpzj_level'],$voo['cpzj']*$bili,$voo['u_level'],$voo['father_id'],$voo['re_id'],$voo['re_path'],$voo['p_path'],$nowdate);  //服务佣金


			/*
			    $g = array();
				//	$g['u_level']=array('egt',3);
				$g['u_level'] = array(array('egt',3),array('elt',6), 'and') ;
				$jiancha=M('fck')->where($g)->select();


				if($jiancha) {
					$fck->jifen($voo['id'], $voo['user_id'], $voo['cpzj'], $voo['cpzj_level'], $voo['cpzj'] * $bili, $voo['u_level'], $voo['father_id'], $voo['re_id'], $voo['re_path'], $voo['p_path'], $nowdate);  //市场积分
				}

				*/


				$fck->shichangyj($voo['id'],$voo['user_id'],$voo['cpzj'],$voo['cpzj_level'],$voo['cpzj']*$bili,$voo['u_level'],$voo['father_id'],$voo['re_id'],$voo['re_path'],$voo['p_path'],$nowdate);  //市场业绩

				/************T050业务逻辑***********/












				/************T050业务逻辑***********/

				//统计单数
			//	$fck->xiangJiao($voo['id'], $voo['f4'], $voo['id']);

			//	$fck->jiandian($voo['user_id']);

				//算出奖金
			//	$fck->getusjj($voo['id'],1);



			//	$fck->benqi($voo['id'],$voo['shop_id'],$voo['cpzj']);



				// 显示购物
				M('gouwu')->where('uid='.$voo['id'])->setField('lx',1);
                                
                                //网络费
//				$fck->wlf($voo['id'],$voo['user_id']);

				// $this->addyj($voo['id'],$voo['cpzj']);

//				$f_numb = $s4[$voo['u_level']-1];
//				$card->fafang_card($voo['id'],$voo['user_id'],$f_numb);

			}
			unset($fck,$where,$where_two,$rs);
			if ($vo){
				unset($vo);
				$bUrl = __URL__.'/menber';
				$this->_box(1,'开通会员成功！',$bUrl,2);
				exit;
			}else{
				unset($vo);
				$bUrl = __URL__.'/menber';
				$this->_box(0,'开通会员失败！',$bUrl,1);
				exit;
			}
		}else{
			$this->error('错误！');
			exit;
		}
	}

    //会员自己开通

	public function OpenMyself(){
		
		$OpID = $_GET['uid'];

	    $fck = D ('Fck');
		$fee = M ('fee');
		$card = A('Phonecard');

	    if (!$fck->autoCheckToken($_POST)){
            $this->error('页面过期，请刷新页面！');
            exit;
        }

		//被开通会员参数
		$where = array();
		$where['id'] = array ('eq',$OpID);  //被开通会员id数组
		$where['is_pay'] = 0;  //未开通的
		$field = '*';
		$voo = $fck ->where($where)->field($field)->find();
		$fee_rs = $fee -> find();
		$s4 = explode("|", $fee_rs['s4']);

		//报单中心参数
		$where_two =array();
		$field_two = '*';
		$ID = $_SESSION[C('USER_AUTH_KEY')];
		$where_two['id'] = $ID;
		$nowdate = strtotime(date('c'));
		$nowday=strtotime(date('Y-m-d'));
		$fck->emptyTime();
		if($voo){
			$rs = $fck->where($where_two)->field($field_two)->find();  //找出登录会员(必须为报单中心并且已经登录)
			if (!$rs){
				$this->error('会员错误！');
				exit;
			}
			$ppath=$voo['p_path'];
			//上级未开通不能开通下级员工
			$frs_where['is_pay'] = array('eq',0);
			$frs_where['id'] = $voo['father_id'];
			$frs = $fck -> where($frs_where) -> find();
			if($frs){
				$this->error('开通失败，上级未开通');
				exit;
			}
			$money_a = $voo['cpzj'] ;	//百分之

			if ($rs['agent_cash'] < $money_a){
				$bUrl = __APP__.'/Public/main';
				$this->_box(0,'注册积分余额不足！',$bUrl,1);
				exit;
			}
			
			
			//给推荐人添加推荐人数或单数
			$fck->query("update __TABLE__ set `re_nums`=re_nums+1 where `id`=".$voo['re_id']);
			unset($re_rs);
			
			$data = array();
			$data['is_pay'] = 1;
			$data['pdt'] = $nowdate;
			$data['open'] = 2;
			$data['get_date'] = $nowday;
			$data['fanli_time'] = $nowday;//当天没有分红奖
			//开通会员
			$result = $fck->where('id='.$voo['id'])->save($data);
			unset($data,$varray);

			$money = $voo['cpzj'];  //找出该会员的注册金额
			$fck->query("update __TABLE__ set `agent_cash`=agent_cash-". $money_a ." where `id`=".$ID);
			$fck->addencAdd($rs['id'], $voo['user_id'], -$money_a, 19);//历史记录

			//统计单数
			$fck->xiangJiao($voo['id'], $voo['f4']);
			
			//算出奖金
			$fck->getusjj($voo['id'],1);

			$f_numb = $s4[$voo['u_level']-1];
			$card->fafang_card($voo['id'],$voo['user_id'],$f_numb);

		}
		unset($fck,$where,$where_two,$rs);
		if ($voo){
			unset($voo);
			$bUrl = __APP__.'/';
			// $this->_box(1,'激活成功！',$bUrl,2);
			echo "<script>alert('激活成功！');window.top.location='$bUrl'</script>";
			exit;
		}else{
			unset($voo);
			$bUrl = __APP__.'/Public/main';
			$this->_box(0,'激活失败！',$bUrl,1);
			exit;
		}
		
	}
	
	private function _menberDelUse($OpID=0){
		//=========================================删除会员
		if ($_SESSION['Urlszpass'] == 'MyssShuiPuTao'){
			$fck = M ('fck');
			$where['is_pay'] = 0;
			foreach($OpID as $voo){
				$rs = $fck -> find($voo);
				if($rs){
					$whe['father_name'] = $rs['user_id'];
					$rss = $fck -> where($whe)->field('id') -> find();
					if($rss){
						$bUrl = __URL__.'/menber';
						$this -> error('该 '. $rs['user_id'] .' 会员有下级会员，不能删除！');
						exit;
					}else{
						$where['id'] = $voo;
						$fck -> where($where) -> delete();
					}
				}else{
					$this->error('错误!');
				}
			}
			$bUrl = __URL__.'/menber';
			$this->_box(1,'删除会员！',$bUrl,1);
			exit;
		}else{
			$this->error('错误!');
		}
	}
	
	//已开通会员
	public function frontMenber($Urlsz=0){
		//列表过滤器，生成查询Map对像
		if ($_SESSION['Urlszpass'] == 'MyssDaShuiPuTao'){
			$fck = M('fck');
			$id = $_SESSION[C('USER_AUTH_KEY')];
			$map = array();
			$map['open'] = $id;
			$map['is_pay'] = array('gt',0);
			$UserID = $_POST['UserID'];
			if (!empty($UserID)){
				import ( "@.ORG.KuoZhan" );  //导入扩展类
				$KuoZhan = new KuoZhan();
				if ($KuoZhan->is_utf8($UserID) == false){
					$UserID = iconv('GB2312','UTF-8',$UserID);
				}
				unset($KuoZhan);
				$where['nickname'] = array('like',"%".$UserID."%");
				$where['user_id'] = array('like',"%".$UserID."%");
				$where['_logic']    = 'or';
				$map['_complex']    = $where;
				$UserID = urlencode($UserID);
			}
	
			//查询字段
			$field  = "*";
			//=====================分页开始==============================================
			import ( "@.ORG.ZQPage" );  //导入分页类
			$count = $fck->where($map)->count();//总页数
			$listrows = C('ONE_PAGE_RE');//每页显示的记录数
			$page_where = 'UserID='.$UserID;//分页条件
			$Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
			//===============(总页数,每页显示记录数,css样式 0-9)
			$show = $Page->show();//分页变量
			$this->assign('page',$show);//分页变量输出到模板
			$list = $fck->where($map)->field($field)->order('pdt desc')->page($Page->getPage().','.$listrows)->select();
	
			$HYJJ = '';
			$this->_levelConfirm($HYJJ,1);
			$this->assign('voo',$HYJJ);//会员级别
			$this->assign('list',$list);//数据输出到模板
			//=================================================
	
			$this->display ('frontMenber');
			exit;
		}else{
			$this->error('数据错误2!');
			exit;
		}
	}
	
	
	public function adminAgents(){
		//=====================================后台服务中心管理
		$this->_Admin_checkUser();
		if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGua'){
			$fck = M('fck');
			$UserID = $_POST['UserID'];
			if (!empty($UserID)){
				import ( "@.ORG.KuoZhan" );  //导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($UserID) == false){
                    $UserID = iconv('GB2312','UTF-8',$UserID);
                }
                unset($KuoZhan);
				$where['nickname'] = array('like',"%".$UserID."%");
				$where['user_id'] = array('like',"%".$UserID."%");
				$where['_logic']    = 'or';
				$map['_complex']    = $where;
				$UserID = urlencode($UserID);
			}
			//$map['is_del'] = array('eq',0);
			$map['is_agent'] = array('gt',0);
			if ($_SESSION[C('USER_AUTH_KEY')] != 1) {
				$map['id'] = array('neq',1);
			}
			if (method_exists ( $this, '_filter' )) {
				$this->_filter ( $map );
			}
            $field  = '*';
            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $fck->where($map)->count();//总页数
       		$listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $page_where = 'UserID=' . $UserID;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $list = $fck->where($map)->field($field)->order('id desc')->page($Page->getPage().','.$listrows)->select();
            $this->assign('list',$list);//数据输出到模板
            //=================================================
            
            // $Agent_Us_Name = C('Agent_Us_Name');
			// $Aname = explode("|",$Agent_Us_Name);
			$this->_levelShopConfirm($Aname);
			$this->assign ( 'Aname', $Aname);

			$this->display ('adminAgents');
			return;
		}else{
			$this->error('数据错误!');
			exit;
		}
	}

	public function okLevel(){
		//=====================================后台服务中心管理
		if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGua'){

			$uplevel =M('uplevel');
			import ( "@.ORG.ZQPage" );  //导入分页类
			$id = $_SESSION[C('USER_AUTH_KEY')];


			$map['paylevelAc_uid']=$id;


			$count = $uplevel->where($map)->count();//总页数
			$listrows = C('ONE_PAGE_RE');//每页显示的记录数
			$page_where = '';//分页条件
			$Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
			//===============(总页数,每页显示记录数,css样式 0-9)
			$show = $Page->show();//分页变量
			$this->assign('page',$show);//分页变量输出到模板
			$level = $uplevel->where($map)->order('adt_time desc')->page($Page->getPage().','.$listrows)->select();
			$this->assign ('level', $level);

			$this->display ();
			return;
		}else{
			$this->error('数据错误!');
			exit;
		}
	}



	public function uphistory(){
		//=====================================后台服务中心管理
		if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGua'){

			$uplevel =M('uplevel');
			import ( "@.ORG.ZQPage" );  //导入分页类

			if($_POST['user_id'] != null){
			   $where['user_id']=array('eq',$_POST['user_id']);
			   $f=M('fck')->where($where)->find();
                $map['get_uid']=array('eq',$f['id']);
				$map['pay_uid'] =array('eq',$f['id']);
				$map['_logic'] = 'OR';
			}else{
				$map['id']=array('gt',0);
			}

			$count = $uplevel->where($map)->count();//总页数

			$listrows = C('ONE_PAGE_RE');//每页显示的记录数
			$page_where = '';//分页条件
			$Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
			//===============(总页数,每页显示记录数,css样式 0-9)
			$show = $Page->show();//分页变量
			$this->assign('page',$show);//分页变量输出到模板
			$level = $uplevel->where($map)->order('adt_time desc')->page($Page->getPage().','.$listrows)->select();
			
			$this->assign ('level', $level);

			$this->display ();
			return;
		}else{
			$this->error('数据错误!');
			exit;
		}
	}





	public function okAC(){
		//=====================================后台服务中心管理
		    $Fck = D('Fck');
			$uplevel =M('uplevel');
		    $id = $_GET['id'];
		    $f=$uplevel->where('id='.$id)->find();
		    $pay_user_id=M('fck')->where('id='.$f['pay_uid'])->find();
            $data['is_ok']=1;
		    $data['pdt_time']=time();
		    $gai=$uplevel->where('id='.$id)->setField($data);
		    if($gai){
                $sheng=M('fck2')->where('uid='.$f['pay_uid'])->setField('u_level',$f['up_level']);
				$Fck->rw_bonuss($f['get_uid'],$pay_user_id['user_id'],5,$f['money']);
				$this->success('确认成功');
		    }

	}


	public function upLevel(){
		//=====================================后台服务中心管理
		if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGua'){

			$fee_rsd = M('fee') -> find();
			$sheng=explode('|',$fee_rsd['str17']);
			$this->assign ('sheng', $sheng);

			$fck = M('fck');
			$fck2 = M('fck2');
			$id = $_SESSION[C('USER_AUTH_KEY')];
			$fck_rs = $fck ->where('id='.$id)->find();
			$this->assign ( 'fck_rs', $fck_rs);

			$fck_rss = $fck2 ->where('uid='.$id)->find();
			$this->assign ('fck_rss', $fck_rss);

			$product = M ('product');
			$pwhere = array();
			$pwhere['yc_cp'] = 0;
			$prs = $product->where($pwhere)->select();
			$this->assign('plist',$prs);



            $map['get_uid']=array('eq',$id);
			import ( "@.ORG.ZQPage" );  //导入分页类
			$count = M('uplevel')->where($map)->count();//总页数
			$listrows = C('ONE_PAGE_RE');//每页显示的记录数
			$page_where = '';//分页条件
			$Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
			//===============(总页数,每页显示记录数,css样式 0-9)
			$show = $Page->show();//分页变量
			$this->assign('page',$show);//分页变量输出到模板
			$list = M('uplevel')->where($map)->order('adt_time desc')->page($Page->getPage().','.$listrows)->select();
			$this->assign('level',$list);//数据输出到模板
			//=================================================


			$this->display ();
			return;
		}else{
			$this->error('数据错误!');
			exit;
		}
	}



	public function levelAc(){
		//=====================================后台服务中心管理
		if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGua'){


			$Fck = D('Fck');
			$moneys = $_POST['moneys'];

			$user_id = $_POST['user_id'];
			$map['user_id']=array('eq',$user_id);


			$fck = M('fck');
			$fck2 = M('fck2');
			$id = $_SESSION[C('USER_AUTH_KEY')];
			$fck_rs = $fck ->where('id='.$id)->find();
			$this->assign ( 'fck_rs', $fck_rs);

			$he = $fck ->where($map)->find();
            if($he == false){
				$this->error('签约会员不存在');
				exit;
			}

			if($moneys%10000 != 0){

				$this->error('注册金额必须为10000的倍数');
				exit;
			}

			if($fck_rs['agent_cash']<$moneys){
				$this->error('注册积分余额不足');
				exit;
			}

			/*************寻找升级怪兽**************/

/*

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
				$data['user_id']=$fck_rs['user_id'];
				$data['user_tel']=$_POST['us_tel'];
				$data['user_address']=$_POST['us_address'];
				$data['username']=$_POST['us_name'];
				$res = M('fahuo')->add($data);

			}
*/

			$bian=$fck->where('id='.$id)->setDec('agent_cash',$moneys);
			if($bian){
				$uplevel=M('uplevel');
				$data['pay_uid']=$he['id'];
				$data['get_uid']=$id;
				$data['money']=$moneys;
				$data['before_money']=$he['cpzj'];
				$data['total_money']=$moneys+$he['cpzj'];
				$data['adt_time']=time();
				$uplevel->add($data);
				$bian=$fck->where('id='.$he['id'])->setInc('cpzj',$moneys);

				$Fck->getusjjs($he['id'],$moneys);

				$Fck->benqi($he['id'],$id,$fck_rs['cpzj']);


				$this->success('晋级成功');

			}

		}else{
			$this->error('数据错误!');
			exit;
		}
	}





	public function upLevels(){
		//=====================================后台服务中心管理
		if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGua'){

			$fee_rsd = M('fee') -> find();
			$sheng=explode('|',$fee_rsd['str17']);
			$this->assign ('sheng', $sheng);

			$fck = M('fck');
			$fck2 = M('fck2');
			$id = $_SESSION[C('USER_AUTH_KEY')];
			$fck_rs = $fck ->where('id='.$id)->find();
			$this->assign ( 'fck_rs', $fck_rs);

			$level =M('uplevel')->where('pay_uid='.$id)->order('pdt_time desc')->select();
			$this->assign('level',$level);

			$fck_rss = $fck2 ->where('uid='.$id)->find();
			$this->assign ('fck_rss', $fck_rss);

			$newstr = substr($fck_rss['p_path'],0,strlen($fck_rss['p_path'])-1);
			$newstr1 = substr($newstr,1,strlen($newstr )-1);



			$renren=explode(',',$newstr1);
			rsort($renren);

			array_splice($renren,3);

			$shangji=$renren[$fck_rss['u_level']];
			$yu = array_slice($renren, $fck_rss['u_level']+1);
			if($shangji != ''){
				$ji['id']=array('eq',$shangji);
				$shang=$fck2->where($ji)->find();
				$ceng = $fck_rss['p_level']-$shang['p_level']-1;
				$gaoji = $ceng+1;
				if($shang['u_level'] >= $gaoji && $shang['is_suo']==0){
					$father_id=$shang['uid'];
				}else{
					$zai['id']=array('in',$yu);
					$zai['u_level']=array('egt',$gaoji);
					$zai['is_suo']=array('eq',0);
					$shang=$fck2->where($zai)->limit(1)->order('id desc')->find();
					if($shang){
						$father_id=$shang['uid'];
					}else{
						$father_id=1;
					}
				}
			}else{
				$father_id=1;
			}


			$lingdao=$fck->where('id='.$father_id)->find();
			$this->assign('lingdao', $lingdao);

			$this->display ();
			return;
		}else{
			$this->error('数据错误!');
			exit;
		}
	}







	public function levelAcs(){
		//=====================================后台服务中心管理
		if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGua'){

			$Fck = D('Fck');
			$money = $_POST['money'];
			$fck = M('fck');
			$fck2 = M('fck2');
			$id = $_SESSION[C('USER_AUTH_KEY')];
			$fck_rs = $fck ->where('id='.$id)->find();
			$this->assign ( 'fck_rs', $fck_rs);


			$uplevel=M('uplevel');
			$fuck['pay_uid']=array('eq',$id);
			$fuck['is_ok']=array('eq',0);
			$sheng= $uplevel->where($fuck)->order('adt_time desc')->find();
            if($sheng){
				echo $this->error("请先联系上级升级您所申请的".$sheng['up_level']."级");
			}



			$fck_rss = $fck2 ->where('uid='.$id)->find();
			$this->assign ('fck_rss', $fck_rss);
            if($fck_rs['agent_cash']<$money){
				$this->error('升级币余额不足');
				exit;
			}

			/*************寻找升级怪兽**************/

			$newstr = substr($fck_rss['p_path'],0,strlen($fck_rss['p_path'])-1);
			$newstr1 = substr($newstr,1,strlen($newstr )-1);
			$renren=explode(',',$newstr1);
			rsort($renren);
            array_splice($renren,3);
			$shangji=$renren[$fck_rss['u_level']];
			$yu = array_slice($renren, $fck_rss['u_level']+1);
			if($shangji != ''){
				$ji['id']=array('eq',$shangji);
				$shang=$fck2->where($ji)->find();
				$ceng = $fck_rss['p_level']-$shang['p_level']-1;
				$gaoji = $ceng+1;
				if($shang['u_level'] >= $gaoji && $shang['is_suo']==0){
					$father_id=$shang['uid'];
				}else{
					$zai['id']=array('in',$yu);
					$zai['u_level']=array('egt',$gaoji);
					$zai['is_suo']=array('eq',0);
					$shang=$fck2->where($zai)->limit(1)->order('id desc')->find();
					if($shang){
						$father_id=$shang['uid'];
					}else{
						$father_id=1;
					}
				}
			}else{
				$father_id=1;
			}




			$bian=$fck->where('id='.$id)->setDec('agent_cash',$money);
			if($bian){
                $uplevel=M('uplevel');
                $data['get_uid']=$father_id;
			    $data['pay_uid']=$id;
				$data['money']=$money;
				$data['before_level']=$fck_rss['u_level'];
				$data['up_level']=$fck_rss['u_level']+1;
				$data['adt_time']=time();
				$uplevel->add($data);

			/*	$bians=$fck2->where('id='.$id)->setInc('u_level',1);
				$Fck->rw_bonuss($father_id,$fck_rs['user_id'],5,$money);

			*/

				$this->success('晋级申请成功');



			}

		}else{
			$this->error('数据错误!');
			exit;
		}
	}




	public function adminCompanys(){
		//=====================================后台服务中心管理
		$this->_Admin_checkUser();
		if ($_SESSION['UrlPTPass'] != 'MyssGuanXiGuaCompany'){
			$this->error('数据错误!');
			exit;
		}
		$fck = M('fck');
		$UserID = $_POST['UserID'];
		if (!empty($UserID)){
			import ( "@.ORG.KuoZhan" );  //导入扩展类
            $KuoZhan = new KuoZhan();
            if ($KuoZhan->is_utf8($UserID) == false){
                $UserID = iconv('GB2312','UTF-8',$UserID);
            }
            unset($KuoZhan);
			$where['nickname'] = array('like',"%".$UserID."%");
			$where['user_id'] = array('like',"%".$UserID."%");
			$where['_logic']    = 'or';
			$map['_complex']    = $where;
			$UserID = urlencode($UserID);
		}
		//$map['is_del'] = array('eq',0);
		$map['is_company'] = array('gt',0);
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
        $field  = '*';
        //=====================分页开始==============================================
        import ( "@.ORG.ZQPage" );  //导入分页类
        $count = $fck->where($map)->count();//总页数
   		$listrows = C('ONE_PAGE_RE');//每页显示的记录数
        $page_where = 'UserID=' . $UserID;//分页条件
        $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
        //===============(总页数,每页显示记录数,css样式 0-9)
        $show = $Page->show();//分页变量
        $this->assign('page',$show);//分页变量输出到模板
        $list = $fck->where($map)->field($field)->order('id desc')->page($Page->getPage().','.$listrows)->select();
        $this->assign('list',$list);//数据输出到模板
        //=================================================
        
        $Agent_Us_Name = C('Agent_Us_Name');
		$Aname = explode("|",$Agent_Us_Name);
		$this->assign ( 'Aname', $Aname);

		$this->display ('adminCompanys');
		return;
		
	}
	
	public function adminAgentsShow(){
		//查看详细信息
		if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGua'){
			$fck = M('fck');
			$ID = (int) $_GET['Sid'];
			$where = array();
			$where['id'] = $ID;
			$srs = $fck->where($where)->field('user_id,verify')->find();
			$this->assign('srs',$srs);
			unset($fck,$where,$srs);
			$this->display ('adminAgentsShow');
			return;
		}else{
			$this->error('数据错误!');
			exit;
		}
	}

	public function adminCompanysShow(){
		//查看详细信息
		if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGuaCompany'){
			$fck = M('fck');
			$ID = (int) $_GET['Sid'];
			$where = array();
			$where['id'] = $ID;
			$srs = $fck->where($where)->field('user_id,company_bz')->find();
			$this->assign('srs',$srs);
			unset($fck,$where,$srs);
			$this->display ('adminCompanysShow');
			return;
		}else{
			$this->error('数据错误!');
			exit;
		}
	}
	
	public function adminAgentsAC(){  //审核服务中心(服务中心)申请
		$this->_Admin_checkUser();
		//处理提交按钮
		$action = $_POST['action'];
		//获取复选框的值
		$XGid = $_POST['tabledb'];
		$fck = M ('fck');
//	    if (!$fck->autoCheckToken($_POST)){
//            $this->error('页面过期，请刷新页面！');
//            exit;
//        }
        unset($fck);
		if (!isset($XGid) || empty($XGid)){
			$bUrl = __URL__.'/adminAgents';
			$this->_box(0,'请选择会员！',$bUrl,1);
			exit;
		}
		switch ($action){
			case '确认';
				$this->_adminAgentsConfirm($XGid);
				break;
			case '删除';
				$this->_adminAgentsDel($XGid);
				break;
		default;
			$bUrl = __URL__.'/adminAgents';
			$this->_box(0,'没有该会员！',$bUrl,1);
			break;
		}
	}

	public function adminCompanysAC(){  //审核服务中心(服务中心)申请
		$this->_Admin_checkUser();
		//处理提交按钮
		$action = $_POST['action'];
		//获取复选框的值
		$XGid = $_POST['tabledb'];
		$fck = M ('fck');
//	    if (!$fck->autoCheckToken($_POST)){
//            $this->error('页面过期，请刷新页面！');
//            exit;
//        }
        unset($fck);
		if (!isset($XGid) || empty($XGid)){
			$bUrl = __URL__.'/adminCompanys';
			$this->_box(0,'请选择会员！',$bUrl,1);
			exit;
		}
		switch ($action){
			case '确认';
				$this->_adminCompanysConfirm($XGid);
				break;
			case '删除';
				$this->_adminCompanysDel($XGid);
				break;
		default;
			$bUrl = __URL__.'/adminCompanys';
			$this->_box(0,'没有该会员！',$bUrl,1);
			break;
		}
	}
	
	private function _adminCompanysConfirm($XGid=0){
		//==========================================确认申请服务中心
		if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGuaCompany'){
			$fck  = D ('Fck');
			$where['id'] = array ('in',$XGid);
			$where['is_company'] = 1;
			$rs = $fck->where($where)->field('*')->select();

			$data = array();
			$history = M ('history');
            $rewhere = array();
//          $nowdate = strtotime(date('c'));
            $nowdate = time();
            $jiesuan = 0;
			foreach($rs as $rss){

				$myreid = $rss['re_id'];
				$shoplx = $rss['shoplx'];

				$data['user_id'] = $rss['user_id'];
				$data['uid'] = $rss['uid'];
				$data['action_type'] = '申请成为分公司';
				$data['pdt'] = $nowdate;
				// $data['epoints'] = $rss['agent_no'];
				$data['bz'] = '申请成为分公司';
				$data['did'] = 0;
				$data['allp'] = 0;
				$history ->add($data);

				$fck ->query("UPDATE __TABLE__ SET is_company=2,company_pdt=$nowdate where id=".$rss['id']);  //开通
			}
			unset($fck,$where,$rs,$history,$data,$rewhere);
			$bUrl = __URL__.'/adminCompanys';
			$this->_box(1,'确认申请！',$bUrl,1);
			exit;
		}else{
			$this->error('错误！');
			exit;
		}
	}
	
	private function _adminAgentsConfirm($XGid=0){
		//==========================================确认申请服务中心
		if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGua'){
			$fck  = D ('Fck');
			$where['id'] = array ('in',$XGid);
			$where['is_agent'] = 1;
			$rs = $fck->where($where)->field('*')->select();

			$data = array();
			$history = M ('history');
            $rewhere = array();
//          $nowdate = strtotime(date('c'));
            $nowdate = time();
            $jiesuan = 0;
			foreach($rs as $rss){

				$myreid = $rss['re_id'];
				$shoplx = $rss['shoplx'];

				$data['user_id'] = $rss['user_id'];
				$data['uid'] = $rss['uid'];
				$data['action_type'] = '申请成为报单中心';
				$data['pdt'] = $nowdate;
				$data['epoints'] = $rss['agent_no'];
				$data['bz'] = '申请成为报单中心';
				$data['did'] = 0;
				$data['allp'] = 0;
				$history ->add($data);

				$fck ->query("UPDATE __TABLE__ SET is_agent=2,adt=$nowdate,agent_max=0 where id=".$rss['id']);  //开通
			}
			unset($fck,$where,$rs,$history,$data,$rewhere);
			$bUrl = __URL__.'/adminAgents';
			$this->_box(1,'确认申请！',$bUrl,1);
			exit;
		}else{
			$this->error('错误！');
			exit;
		}
	}
	public function adminAgentsCoirmAC(){
		if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGua'){
			//$this->_checkUser();
			$fck = M ('fck');
			$content  = $_POST['content'];
			$userid =trim($_POST['userid']);
			$where['user_id']=$userid;
			//$rs=$fck->where($where)->find();
			$fck_rs = $fck->where($where)->field('id,is_agent,is_pay,user_id,user_name,agent_max,is_agent')->find();
				
	
			if($fck_rs){
				if($fck_rs['is_pay']  == 0){
					$this->error ('临时会员不能授权报单中心!');
					exit;
				}
				if($fck_rs['is_agent']  == 1){
					$this->error('上次申请还没通过审核!');
					exit;
				}
				if($fck_rs['is_agent']  == 2){
					$this->error('该会员已是报单中心!');
					exit;
				}
				if(empty($content)){
					$this->error ('请输入备注!');
					exit;
				}
					
				if($fck_rs['is_agent'] == 0){
					$nowdate = time();
					$result = $fck -> query("update __TABLE__ set verify='".$content."',is_agent=2,idt=$nowdate,adt={$nowdate} where id=".$fck_rs['id']);
				}
	
				$bUrl = __URL__ .'/adminAgents';
				$this->_box(1,'授权成功！',$bUrl,2);
			}else{
				$this->error('会员不存在！');
				exit;
			}
		}else{
			$this->error('错误！');
			exit;
		}
	
	}
	private function _adminCompanysDel($XGid=0){
		//=======================================删除申请服务中心信息
		if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGuaCompany'){
			$fck = M ('fck');
			$rewhere = array();
			$where['is_company'] = array('gt',0);
			$where['id'] = array ('in',$XGid);
			$rs = $fck -> where($where) -> select();
			foreach ($rs as $rss){
				$fck ->query("UPDATE __TABLE__ SET is_company=0,company_pdt=0,company_rdt=0 where id>1 and id = ".$rss['id']);
			}
	
			//			$shop->where($where)->delete();
			unset($fck,$where,$rs,$rewhere);
			$bUrl = __URL__.'/adminCompanys';
			$this->_box('操作成功','删除申请！',$bUrl,1);
			exit;
		}else{
			$this->error('错误!');
			exit;
		}
	}
	private function _adminAgentsDel($XGid=0){
		//=======================================删除申请服务中心信息
		if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGua'){
			$fck = M ('fck');
			$rewhere = array();
			$where['is_agent'] = array('gt',0);
			$where['id'] = array ('in',$XGid);
			$rs = $fck -> where($where) -> select();
			foreach ($rs as $rss){
				$fck ->query("UPDATE __TABLE__ SET is_agent=0,idt=0,adt=0,new_agent=0,shoplx=0,shop_a='',shop_b='' where id>1 and id = ".$rss['id']);
			}
	
			//			$shop->where($where)->delete();
			unset($fck,$where,$rs,$rewhere);
			$bUrl = __URL__.'/adminAgents';
			$this->_box('操作成功','删除申请！',$bUrl,1);
			exit;
		}else{
			$this->error('错误!');
			exit;
		}
	}
	//服务中心表
	public function financeDaoChu_BD(){
		$this->_Admin_checkUser();
		//导出excel
		set_time_limit(0);
	
		header("Content-Type:   application/vnd.ms-excel");
		header("Content-Disposition:   attachment;   filename=Member-Agent.xls");
		header("Pragma:   no-cache");
		header("Content-Type:text/html; charset=utf-8");
		header("Expires:   0");
	
	
	
		$fck = M ('fck');  //奖金表
	
		$map = array();
		$map['id'] = array('gt',0);
		$map['is_agent'] = array('gt',0);
		$field   = '*';
		$list = $fck->where($map)->field($field)->order('idt asc,adt asc')->select();
	
		$title   =   "服务中心表 导出时间:".date("Y-m-d   H:i:s");
	
		echo   '<table   border="1"   cellspacing="2"   cellpadding="2"   width="50%"   align="center">';
		//   输出标题
		echo   '<tr   bgcolor="#cccccc"><td   colspan="9"   align="center">'   .   $title   .   '</td></tr>';
		//   输出字段名
		echo   '<tr  align=center>';
		echo   "<td>序号</td>";
		echo   "<td>会员编号</td>";
		echo   "<td>姓名</td>";
		echo   "<td>联系电话</td>";
		echo   "<td>申请时间</td>";
		echo   "<td>确认时间</td>";
//		echo   "<td>类型</td>";
//		echo   "<td>服务中心区域</td>";
		echo   "<td>剩余注册积分</td>";
		echo   '</tr>';
		//   输出内容
	
		//		dump($list);exit;
	
		$i = 0;
		foreach($list as $row)   {
			$i++;
			$num = strlen($i);
			if ($num == 1){
				$num = '000'.$i;
			}elseif ($num == 2){
				$num = '00'.$i;
			}elseif ($num == 3){
				$num = '0'.$i;
			}else{
				$num = $i;
			}
			if($row['shoplx']==1){
				$nnn = '服务中心';
			}elseif($row['shoplx']==2){
				$nnn = '县/区会员';
			}else{
				$nnn = '市级会员';
			}
	
	
			echo   '<tr align=center>';
			echo   '<td>'   .  chr(28).$num   .   '</td>';
			echo   "<td>"   .   $row['user_id'].  "</td>";
			echo   "<td>"   .   $row['nickname'].  "</td>";
			echo   "<td>"   .   $row['user_tel'].  "</td>";
			echo   "<td>"   .   date("Y-m-d H:i:s",$row['idt']).  "</td>";
			echo   "<td>"   .   date("Y-m-d H:i:s",$row['adt']).  "</td>";
//			echo   "<td>"   .   $nnn.  "</td>";
//			echo   "<td>"   .   $row['shop_a'].  " / " . $row['shop_b']  .   "</td>";
			echo   "<td>"   .   $row['agent_cash'].  "</td>";
			echo   '</tr>';
		}
		echo   '</table>';
	}


	
}
?>