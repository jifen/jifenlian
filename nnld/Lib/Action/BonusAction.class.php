<?php
class BonusAction extends CommonAction{
	
	public function _initialize() {
		header("Content-Type:text/html; charset=utf-8");
		$this->_Config_name();//调用参数
		$this->_checkUser();
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
			$_SESSION['Urlszpass'] = 'MyssfinanceTable';
			$bUrl = __URL__.'/financeTable';//货币充值
			$this->_boxx($bUrl);
			break;
			case 2;
			$_SESSION['UrlPTPass'] = 'MyssMiHouTao';
			$bUrl = __URL__.'/adminFinance';//后台充值管理
			$this->_boxx($bUrl);
			break;
			
			default;
			$this->error('二级密码错误!');
			exit;
		}
	}
	
	//会员资金查询(显示会员每一期的各奖奖金)
	public function financeTable($cs=0){
		$fck = M('fck');
		$bonus = M ('bonus');  //奖金表
		$where = array();
		$ID = $_SESSION[C('USER_AUTH_KEY')];
		
		$user_id = trim($_REQUEST['UserID']);
		if(!empty($user_id) && $ID==1){
			$fck_rs = $fck->where("user_id='$user_id'")->field('id')->find();
			if(!$fck_rs){
				$this->error("该会员不存在");
				exit;
			}else{
				$this->assign('user_id',$user_id);
				$where['uid'] = $fck_rs['id'];
			}
		}else{
			$where['uid'] = $ID; //登录AutoId
		}
	
		
		if(!empty($_REQUEST['FanNowDate'])){  //日期查询
			$time1 = strtotime($_REQUEST['FanNowDate']);                // 这天 00:00:00
			$time2 = strtotime($_REQUEST['FanNowDate']) + 3600*24 -1;   // 这天 23:59:59
			$where['e_date'] = array(array('egt',$time1),array('elt',$time2));
			//$where['e_date'] = array('eq',$time1);
		}

        $field  = '*';
        //=====================分页开始==============================================
        import ( "@.ORG.ZQPage" );  //导入分页类
        $count = $bonus->where($where)->count();//总页数
        $listrows = 2;//每页显示的记录数
        $page_where = 'FanNowDate=' . $_REQUEST['FanNowDate'].'&UserID='.$user_id;//分页条件
        $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
        //===============(总页数,每页显示记录数,css样式 0-9)
        $show = $Page->show();//分页变量
        $this->assign('page', $show);//分页变量输出到模板
        $list = $bonus->where($where)->field($field)->order('id desc')->page($Page->getPage().','.$listrows)->select();
        $this->assign('list',$list);//数据输出到模板
        //=================================================

        //各项奖每页汇总
		$count = array();
		foreach($list as $vo){
			for($b=0;$b<=12;$b++){
				$count[$b] += $vo['b'.$b];
				$count[$b] = $this->_2Mal($count[$b],2);
			}
		}

		//奖项名称与显示
		$b_b = array();
		$c_b = array();
		$b_b[1]  = C('Bonus_B1');
		$c_b[1]  = C('Bonus_B1c');
		$b_b[2]  = C('Bonus_B2');
		$c_b[2]  = C('Bonus_B2c');
		$b_b[3]  = C('Bonus_B3');
		$c_b[3]  = C('Bonus_B3c');
		$b_b[4]  = C('Bonus_B4');
		$c_b[4]  = C('Bonus_B4c');
		$b_b[5]  = C('Bonus_B5');
		$c_b[5]  = C('Bonus_B5c');
		$b_b[6]  = C('Bonus_B6');
		$c_b[6]  = C('Bonus_B6c');
		$b_b[7]  = C('Bonus_B7');
		$c_b[7]  = C('Bonus_B7c');
		$b_b[8]  = C('Bonus_B8');
		$c_b[8]  = C('Bonus_B8c');
		$b_b[9]  = C('Bonus_B9');
		$c_b[9]  = C('Bonus_B9c');
		$b_b[10] = C('Bonus_B10');
		$c_b[10] = C('Bonus_B10c');
		$b_b[11] = C('Bonus_B11');
		$c_b[11] = C('Bonus_B11c');
		$b_b[12] = C('Bonus_B12');
		$c_b[12] = C('Bonus_B12c');
		$b_b[13] = C('Bonus_HJ');   //合计
		$c_b[13] = C('Bonus_HJc');
		$b_b[0]  = C('Bonus_B0');   //实发
		$c_b[0]  = C('Bonus_B0c');
		$b_b[14] = C('Bonus_XX');   //详细
		$c_b[14] = C('Bonus_XXc');

		$fee   = M ('fee');    //参数表
		$fee_rs = $fee->field('s18')->find();
		$fee_s7 = explode('|',$fee_rs['s18']);
		$this->assign('fee_s7',$fee_s7);        //输出奖项名称数组

		$this -> assign('b_b',$b_b);
		$this -> assign('c_b',$c_b);
		$this->assign('count',$count);
		$this->display('financeTable');
	}
	
	
	public function financeShow(){
		//奖金明细
		$history = M('history');
		$fck = M ('fck');
		$fee = M ('fee');
		$fee_rs = $fee->field('s13')->find();
		$date = $fee_rs['s13'];
		$UID = $_SESSION[C('USER_AUTH_KEY')];
		
		$RDT = (int) $_REQUEST['RDT'];
		$PDT = (int)$_REQUEST['PDT'];
		$cPDT = $PDT + 24 * 3600 - 1;
		$lastdate = mktime(0, 0, 0, date("m"), date("d")-$date,   date("Y"));
		//$map['pdt'] = array(array('egt',$PDT),array('elt',$cPDT));
		//$map['uid'] = $UID;
		//$map['allp'] = 0;
		
		$user_id = trim($_REQUEST['UserID']);
		if(!empty($user_id) && $UID==1){
			$fck_rs = $fck->where("user_id='$user_id'")->field('id')->find();
			if(!$fck_rs){
				$this->error("该会员不存在");
				exit;
			}else{
				$UID = $fck_rs['id'];
			}
		}
		$ddt =  $PDT +24*3600-1;
		$map = "pdt >={$PDT} and pdt <={$ddt} and uid={$UID} and action_type+0>0 and action_type+0<=12";

		$field  = '*';
		//=====================分页开始==============================================
		import ( "@.ORG.ZQPage" );  //导入分页类
		$count = $history->where($map)->count();//总页数
		$listrows = C('PAGE_LISTROWS')  ;//每页显示的记录数
		$page_where = 'PDT/' . $PDT;//分页条件
		$Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
		//===============(总页数,每页显示记录数,css样式 0-9)
		$show = $Page->show();//分页变量
		$this->assign('page',$show);//分页变量输出到模板
		$list = $history->where($map)->field($field)->order('id desc')->page($Page->getPage().','.$listrows)->select();
	
		$this->assign('list',$list);//数据输出到模板
		//=================================================

		$fee   = M ('fee');    //参数表
		$fee_rs = $fee->field('s18')->find();
		$fee_s7 = explode('|',$fee_rs['s18']);
		$this->assign('fee_s7',$fee_s7);        //输出奖项名称数组

		$this->display ('financeShow');
	}
	
	
	//========================================出纳管理
	public function adminFinance(){
		$this->_Admin_checkUser();
		if ($_SESSION['UrlPTPass'] == 'MyssMiHouTao'){
			$times = M ('times');
			$field = '*';
			$where = 'is_count=0';
			$Numso = array();
			$Numss = array();

			$rs = $times->where($where)->field($field)->order(' id desc')->find();
			$Numso['0'] = 0;
			$Numso['1'] = 0;
			$Numso['2'] = 0;
			if ($rs){
				$eDate = strtotime(date('c'));  //time()
				$sDate = $rs['benqi'] ;//时间

				$this->MiHouTaoBenQi($eDate, $sDate, $Numso, 0);
				$this->assign('list3', $Numso);   //本期收入
				$this->assign('list4', $sDate);   //本期时间截
			}else{
				$this->assign('list3', $Numso);
			}

			$fee = M('fee');
			$fee_rs = $fee->field('s18')->find();
			$fee_s7 = explode('|',$fee_rs['s18']);
			$this->assign('fee_s7',$fee_s7);        //输出奖项名称数组

            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $times->where($where)->count();//总页数
            $listrows = C('PAGE_LISTROWS')  ;//每页显示的记录数
            $Page = new ZQPage($count, $listrows, 1);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $rs = $times->where($where)->field($field)->order('id desc')->page($Page->getPage().','.$listrows)->select();
            $this->assign('list',$rs);//数据输出到模板

			if ($rs){
				$occ = 1;
				$Numso['1'] = $Numso['1']+$Numso['0'];
				$Numso['3'] = $Numso['3']+$Numso['0'];
				foreach ($rs as $Roo){
					$eDate          = $Roo['benqi'];//本期时间
                    $sDate          = $Roo['shangqi'];//上期时间
					$Numsd          = array();
					$Numsd[$occ][0] = $eDate;
					$Numsd[$occ][1] = $sDate;

					$this->MiHouTaoBenQi($eDate,$sDate,$Numss,1);
					//$Numoo = $Numss['0'];   //当期收入
					$Numss[$occ]['0'] = $Numss['0'];
					$Dopp  = M ('bonus');
					$field = '*';
					$where = " s_date>= '".$sDate."' And e_date<= '".$eDate."' ";
					$rsc   = $Dopp->where($where)->field($field)->select();
					$Numss[$occ]['1'] = 0;

					foreach ($rsc as $Roc){
						$Numss[$occ]['1'] += $Roc['b0'] ;  //当期支出
						$Numb2[$occ]['1'] += $Roc['b1'];
						$Numb3[$occ]['1'] += $Roc['b2'];
						$Numb4[$occ]['1'] += $Roc['b3'];
						//$Numoo          += $Roc['b9'];//当期收入
					}
					$Numoo              = $Numss['0'];//当期收入
					$Numss[$occ]['2']   = $Numoo - $Numss[$occ]['1'];   //本期赢利
					$Numss[$occ]['3']   = substr( floor(($Numss[$occ]['1'] / $Numoo) * 100) , 0 ,3);  //本期拔比
					$Numso['1']        += $Numoo;  //收入合计
					$Numso['2']        += $Numss[$occ]['1'];           //支出合计
					$Numso['3']        += $Numss[$occ]['2'];           //赢利合计
					$Numso['4']         = substr( floor(($Numso['2'] / $Numso['1']) * 100) , 0 ,3);  //总拔比
					$Numss[$occ]['4']   = substr( ($Numb2[$occ]['1'] / $Numoo) * 100 , 0 ,4);  //小区奖金拔比
					$Numss[$occ]['5']   = substr( ($Numb3[$occ]['1'] / $Numoo) * 100 , 0 ,4);  //互助基金拔比
					$Numss[$occ]['6']   = substr( ($Numb4[$occ]['1'] / $Numoo) * 100 , 0 ,4); //管理基金拔比
					$Numss[$occ]['7']	= $Numb2[$occ]['1'];//小区奖金
					$Numss[$occ]['8'] 	= $Numb3[$occ]['1'] ;  //互助基金
					$Numss[$occ]['9'] 	= $Numb4[$occ]['1'];//管理基金
					$Numso['5']        += $Numb2[$occ]['1'];  //小区奖金合计
					$Numso['6']        += $Numb3[$occ]['1'];  //互助基金合计
					$Numso['7']        += $Numb4[$occ]['1'];  //管理基金合计
					$Numso['8']         = substr( ($Numso['5'] / $Numso['1']) * 100 , 0 ,4);  //小区奖金总拔比
					$Numso['9']         = substr( ($Numso['6'] / $Numso['1']) * 100 , 0 ,4);  //互助基金总拔比
					$Numso['10']         = substr( ($Numso['7'] / $Numso['1']) * 100 , 0 ,4);  //管理基金总拔比
					$occ++;
				}
			}

			$PP = $_GET['p'];
			$this->assign('PP',$PP);
			$this->assign('list1',$Numss);
			$this->assign('list2',$Numso);
			$this->assign('list5',$Numsd);
			$this->display('adminFinance');
		}else{
			$this->error('错误!');
			exit;
		}
	}


    public function adminFinanceList(){
        //当期收入会员列表
        if ($_SESSION['UrlPTPass'] == 'MyssMiHouTao'){
            $fck = M('fck');
            $eDate  = $_REQUEST['eDate'];
            $sDate  = $_REQUEST['sDate'];
            $UserID = $_REQUEST['UserID'];
            $ss_type = (int) $_REQUEST['type'];
            if (!empty($UserID)){
            	import ( "@.ORG.KuoZhan" );  //导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($UserID) == false){
                    $UserID = iconv('GB2312','UTF-8',$UserID);
                }
				unset($KuoZhan);
				$where['user_id'] = array('like',"%".$UserID."%");
            	$where['nickname'] = array('like',"%".$UserID."%");
				$where['user_name'] = array('like',"%".$UserID."%");
				$where['_logic']    = 'or';
				$map['_complex']    = $where;
				$UserID = urlencode($UserID);
			}
            $map['pdt'] = array(array('gt',$sDate),array('elt',$eDate));
            $map['is_pay'] = array('egt',1);
            //查询字段
            $field  = 'id,user_id,nickname,bank_name,bank_card,user_name,user_address,user_tel,rdt,cpzj,pdt,u_level,zjj,agent_use,is_lock,open,re_name';
            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $fck->where($map)->count();//总页数
            $listrows = C('PAGE_LISTROWS')  ;//每页显示的记录数
            $page_where = 'UserID=' . $UserID . '&type=' . $ss_type .'&eDate='. $eDate .'&sDate='. $sDate ;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $list = $fck->where($map)->field($field)->order('pdt desc')->page($Page->getPage().','.$listrows)->select();
            //dump( $fck->getLastSql() );
			//exit;
            $HYJJ = '';
            $this->_levelConfirm($HYJJ,1);
            $this->assign('voo',$HYJJ);//商户级别
            $this->assign('list',$list);//数据输出到模板
            //=================================================


            $title = '当期收入';
            $this->assign('title',$title);
			$this->assign('sDate',$sDate);
			$this->assign('eDate',$eDate);
            $this->display ('adminFinanceList');
        }else{
            $this->error('数据错误!');
            exit;
        }
    }
	

}
?>