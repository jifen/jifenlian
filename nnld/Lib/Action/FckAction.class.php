<?php
class FckAction extends CommonAction {

	public function _initialize() {
		header("Content-Type:text/html; charset=utf-8");
		$this->_Config_name();//调用参数
		$this->_checkUser();
//		$this->_inject_check(1);//调用过滤函数


	}

	//检测报单中心是否存在
	public function check_shopid() {
		$fck = M('fck');
        $mapp               = array();
		$mapp['user_id']	= trim($_POST['shopid']);
		$mapp['is_agent']	= array('gt',1);
		$rs  = $fck->where($mapp)  -> field('id')->find();
		if($rs) {
			$this->success(' ');
			exit;
		}else{
			$this->error('没有此报单中心！');
			exit;
		}

    }
	//检测推荐人是否存在
	public function check_reid() {
		$fck = M('fck');
        $mapp               = array();
		$mapp['user_id']	= trim($_POST['reid']);
		$rs  = $fck->where($mapp)  -> field('id')->find();
		if($rs) {
			$this->success(' ');
			exit;
		}else{
			$this->error('没有此推荐人！');
			exit;
		}

    }
	//检测接点人是否存在
	public function check_fid() {
		$fck = M('fck');
        $mapp               = array();
		$mapp['user_id']	= trim($_POST['fid']);
		$rs  = $fck->where($mapp)  -> field('id')->find();
		if($rs) {
			$this->success(' ');
			exit;
		}else{
			$this->error('没有此接点人！');
			exit;
		}

    }

	//检测用户名(会员名)是否已经存在
	public function check_userid() {
		$fck = M('fck');
        $mapp               = array();
		$mapp['user_id']	= trim($_POST['userid']);
		$rs  = $fck->where($mapp)  -> field('id')->find();
		if($rs) {
			$this->error('会员编号已被使用！');
			exit;
		}else{
			$this->success('会员编号可使用！');
			exit;
		}

    }

	//检测用户名(会员名)是否已经存在
	public function check_CCuser() {
		$fck = M('fck');
        $mapp= array();
		$mapp['user_id']	= trim($_GET['user_id']);
		$rs  = $fck->where($mapp)->find();
		if($rs) {
			$this->success('会员正确');
			exit;
		}else{
			$this->error('会员编号输入错');
			exit;
		}

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
				$_SESSION['Urlszpass'] = 'MyssShuiPuTao';
				$bUrl = __URL__.'/Repeatfh';
				$this->_boxx($bUrl);
				break;
			
			case 2;
				$_SESSION['Urlszpass'] = 'MyssHuoLongGuo';
				$bUrl = __URL__.'/buyList';
				$this->_boxx($bUrl);
				break;
			default;
				$this->error('二级密码错误!');
				exit;
		}
	}

	


	//推荐列表
	public function frontMenber($Urlsz=0){
		//列表过滤器，生成查询Map对像
		if ($_SESSION['Urlszpass'] == 'MyssDaShuiPuTao'){
			$fck = M('fck');
			$id = $_SESSION[C('USER_AUTH_KEY')];
			$map = array();
			$map['re_id'] = $id;
			//$map['is_pay'] = array('egt',0);
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

			//if (! empty ( $fck )) {
			//	$this->_list ( $fck, $map,'id',0 );
			//}

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

	
	public function relations($Urlsz=0){
		//推荐关系
		if ($_SESSION['Urlszpass'] == 'MyssHuoLongGuo'){
			$fck = M('fck');
			$UserID = $_REQUEST['UserID'];
			if (!empty($UserID)){
				$map['user_id'] = array('like',"%".$UserID."%");
			}
//			if (!empty($_GET['bj_id'])){
//				$map['re_id'] = (int) $_GET['bj_id'];
//			}else{
//				$map['re_id'] = $_SESSION[C('USER_AUTH_KEY')];//自身推荐
//			}
			$map['re_id'] = $_SESSION[C('USER_AUTH_KEY')];//自身推荐
			$map['is_pay'] = 1;

            $field  = '*';
            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $fck->where($map)->count();//总页数
    	    $listrows = C('ONE_PAGE_RE');//每页显示的记录数
			$page_where = 'UserID='.$UserID;//分页条件
//            $page_where ='';
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

			$this->display ('relations');
			return;
		}else{
			$this->error('数据错误2!');
			exit;
		}
	}

	
	


	
	
	
public function gTotle(){
		$pora = M('product');

		$gid = (int)$_GET['GID'];
		$bnum = (int)$_GET['bnum'];
		$p_rs = $pora->where('id ='.$gid)->find();

		if($bnum<1){
			$num = 1;
		}else{
			$num = $bnum;
		}
		$shopping_id ='';
		if(empty($_SESSION["shopping"])){
			$_SESSION["shopping"] = $gid.",".$num;
		}else{
			$arr = $_SESSION["shopping"];
			$rs = explode('|',$arr);
			$tong = 0;
			foreach ($rs as $key=>$vo){
				$str = explode(',',$vo);
				if($str[0] == $gid){
					$str[1] = $str[1]+$num;
					if(empty($shopping_id)){
						$shopping_id = $str[0].",".$str[1];
					}else{
						$shopping_id .= '|'.$str[0].",".$str[1];
					}
					$tong = 1;
				}else{
					if(empty($shopping_id)){
						$shopping_id = $vo;
					}else{
						$shopping_id .= '|'.$vo;
					}
				}
			}
			if($tong==0){
				if(empty($shopping_id)){
					$shopping_id = $gid.",".$num;
				}else{
					$shopping_id .= '|'.$gid.",".$num;
				}
			}
			$_SESSION["shopping"] = $shopping_id;
		}
	}

	public function Repeatfh(){
		$fck = M('fck');
		$fee = M('fee');

		$fee_rs = $fee->find();
		$s9 = explode("|", $fee_rs['s9']);
		$s10 = explode("|", $fee_rs['s10']);

		$uid = $_SESSION[C('USER_AUTH_KEY')];
		$fck_rs = $fck->where("id=".$uid)->field('id,user_id,agent_xf')->find();

		$this->assign("s9",$s9);
		$this->assign('s10',$s10);
		$this->assign('fck_rs',$fck_rs);
		$this->display();

	}

	public function RepeatfhAc(){
		$fck = M('fck');
		$fee = M('fee');
		$fee_rs = $fee->find();
		$s9 = explode("|", $fee_rs['s9']);
		$s10 = explode("|", $fee_rs['s10']);

		$u_level = $_POST['u_level'];

		$money = $s9[$u_level];


		$uid = $_SESSION[C('USER_AUTH_KEY')];
		$fck_rs = $fck->where("id=".$uid)->field('id,user_id,agent_xf')->find();
		dump($money);
		if($fck_rs['agent_xf'] < $money){
			$this->error("您的复投账户余额不足");
			exit;
		}

		$res = $fck->execute("update __TABLE__ set agent_xf =agent_xf-".$money." where id=".$uid);
	
		if($res){
			$lev = $u_level+1;
			$this->addList($uid,$fck_rs['user_id'],$lev,$money,0); //添加记录到分红列表
		}

		$burl = __URL__."/buyList";
		$this->_box(1,'复投成功！',$burl,3);
		exit;
	
	}


	public function buyList(){
		$fh = M('fh');
		$fee = M('fee');

		$get_uid = $_GET['id'];
		if(empty($get_uid)){
			$uid = $_SESSION[C('USER_AUTH_KEY')];
		}else{
			$uid = $get_uid;
		}


		$map['uid'] = $uid;
		$field = "*";

		import ( "@.ORG.ZQPage" );  //导入分页类
        $count = $fh->where($map)->count();//总页数
   		$listrows = C('ONE_PAGE_RE');//每页显示的记录数
        $page_where = 'UserID=' . $UserID . '&type=' . $ss_type. '&ulevel=' . $uulv;//分页条件
        $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
        //===============(总页数,每页显示记录数,css样式 0-9)
        $show = $Page->show();//分页变量
        $this->assign('page',$show);//分页变量输出到模板
        $list = $fh->where($map)->field($field)->order('pdt desc,id desc')->page($Page->getPage().','.$listrows)->select();

        $this->assign("list",$list);

        $HYJJ = "";
        $this->_levelConfirm($HYJJ,1);
        $this->assign('lev',$HYJJ);

        $fee_rs = $fee->find();
        $s12 = explode("|", $fee_rs['s12']); 
		$this->assign("s12",$s12);

		$this->display('buyList');
	}

	public function fenhList(){
		$fehlist = M('fehlist');
		$fee = M('fee');

		$uid = $_SESSION[C('USER_AUTH_KEY')];
		$bankid = $_GET['bid'];

		$map['uid'] = $uid;
		$map['bankid'] = $bankid;

		$field = "*";

		import ( "@.ORG.ZQPage" );  //导入分页类
        $count = $fehlist->where($map)->count();//总页数
   		$listrows = C('ONE_PAGE_RE');//每页显示的记录数
        $page_where = 'UserID=' . $UserID . '&type=' . $ss_type. '&ulevel=' . $uulv;//分页条件
        $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
        //===============(总页数,每页显示记录数,css样式 0-9)
        $show = $Page->show();//分页变量
        $this->assign('page',$show);//分页变量输出到模板
        $list = $fehlist->where($map)->field($field)->order('pdt desc,id desc')->page($Page->getPage().','.$listrows)->select();
        
        $this->assign("list",$list);

        $HYJJ = "";
        $this->_levelConfirm($HYJJ,1);
        $this->assign('lev',$HYJJ);
       


		$this->display('fenhList');
	}


}
?>