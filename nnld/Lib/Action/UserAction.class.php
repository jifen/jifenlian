<?php
class UserAction extends CommonAction{
	
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
			$_SESSION['Urlszpass'] = 'MyssHuoLongGuo';
			$bUrl = __URL__.'/relations';
			$this->_boxx($bUrl);
			break;
			case 2;
			$_SESSION['Urlszpass'] = 'Myssmemberx';
			$bUrl = __URL__.'/member_x';
			$this->_boxx($bUrl);
			break;
			case 3;
			$_SESSION['Urlszpass'] = 'Myssmemberz';
			$bUrl = __URL__.'/member_z';
			$this->_boxx($bUrl);
			break;
			case 4;
				$_SESSION['Urlszpass'] = 'MyssHuoLongGuo';
				$bUrl = __URL__.'/benzhou';
				$this->_boxx($bUrl);
				break;
			case 5;
				$_SESSION['Urlszpass'] = 'MyssGuanShuiPuTao';
				$bUrl = __URL__.'/sheng';
				$this->_boxx($bUrl);
				break;
			default;
			$this->error('二级密码错误!');
			exit;
		}
	}
	
	//推荐表
	public function relations($Urlsz=0){
		//推荐关系
		if ($_SESSION['Urlszpass'] == 'MyssHuoLongGuo'){
			$fck = M('fck');
			$UserID = $_REQUEST['UserID'];
			if (!empty($UserID)){
				$map['user_id'] = array('like',"%".$UserID."%");
			}
			$map['re_id'] = $_SESSION[C('USER_AUTH_KEY')];
			$map['is_pay'] = 1;

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

			$this->display ('relations');
			return;
		}else{
			$this->error('数据错误2!');
			exit;
		}
	}



	public function benzhou($Urlsz=0){
		//推荐关系
		if ($_SESSION['Urlszpass'] == 'MyssHuoLongGuo'){

    if($_REQUEST['start'] && $_REQUEST['end']){

		$less =  strtotime($_REQUEST['start']);
		$more =  strtotime($_REQUEST['end']);
		$where['adt'] = array(array('EGT',$less),array('ELT',$more),'AND');
	}

	$id = $_SESSION[C('USER_AUTH_KEY')];
	$benqi =M('benqi');

	$where['shop_id'] = array('eq',$id);

	import ( "@.ORG.ZQPage" );  //导入分页类
	$count = $benqi->where($where)->count();//总页数
	$money = $benqi->where($where)->sum('money');//总页数
	$listrows = 15;//每页显示的记录数
	$page_where = 'start='.$_REQUEST['start'].'&'.'end='.$_REQUEST['end'];//分页条件
	$Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
	//===============(总页数,每页显示记录数,css样式 0-9)
	$show = $Page->show();//分页变量
	$this->assign('page',$show);//分页变量输出到模板
	$list = $benqi->where($where)->order('adt desc')->page($Page->getPage().','.$listrows)->select();
	$this->assign('list',$list);
			$this->assign('money',$money);
     $this->display();

			return;
		}else{
			$this->error('数据错误!');
			exit;
		}
	}

	public function sheng($Urlsz=0){
		//推荐关系
		if ($_SESSION['Urlszpass'] == 'MyssGuanShuiPuTao'){

			$fck =M('fck');

			$where['id']=array('gt',1);
			$where['is_pay']=array('gt',0);
			if($_POST['province'] !="请选择" && !empty($_POST['province'])){
				$where['province']=array('eq',$_POST['province']);
			}
			import ( "@.ORG.ZQPage" );  //导入分页类
			$count = $fck->where($where)->group('province')->count();//总页数
			$money = $fck->where($where)->sum('money');//总页数
			$listrows = 15;//每页显示的记录数
			$page_where = 'start='.$_REQUEST['start'].'&'.'end='.$_REQUEST['end'];//分页条件
			$Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
			//===============(总页数,每页显示记录数,css样式 0-9)
			$show = $Page->show();//分页变量
			$this->assign('page',$show);//分页变量输出到模板
			$list = $fck->where($where)->order('pdt desc')->group('province')->page($Page->getPage().','.$listrows)->select();
			$this->assign('list',$list);
			$this->assign('money',$money);
			$this->display();

			return;
		}else{
			$this->error('数据错误!');
			exit;
		}
	}



	public function member($GPid=0){
		//列表过滤器，生成查询Map对像
			$fee=M('fee')->find(1);
			$str28 = explode('|',$fee['str28']);
			$this->assign('level',$str28);


			$fck = M('fck');

		    $map['id']=array('eq',$_REQUEST['province']);

		    $f= $fck->where($map)->find();



		    $this->assign('province',$f['province']);

		    $maps['province']=array('eq',$f['province']);
			$field  = '*';
			//=====================分页开始==============================================
			import ( "@.ORG.ZQPage" );  //导入分页类
			$count = $fck->where($maps)->count();//总页数
			$listrows = C('ONE_PAGE_RE');//每页显示的记录数
			$listrows = 25;//每页显示的记录数
			$page_where = 'province='.$f['province'];//分页条件
			$Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
			//===============(总页数,每页显示记录数,css样式 0-9)
			$show = $Page->show();//分页变量
			$this->assign('page',$show);//分页变量输出到模板
			$list = $fck->where($maps)->field($field)->order('pdt desc')->page($Page->getPage().','.$listrows)->select();

			$f4_count =  $fck->where($map)->sum('cpzj');
			$this->assign('f4_count',$count);

			$HYJJ = '';
			$this->_levelConfirm($HYJJ,1);
			$this->assign('voo',$HYJJ);//会员级别

			$shoplx = "";
			$this->_levelShopConfirm($shoplx);
			$this->assign('shoplx',$shoplx);

			$this->_getLevelConfirm($getLevel);
			$this->assign('getLevel',$getLevel);


			$this->assign('list',$list);//数据输出到模板
			//=================================================

			$fee = M ('fee');
			$fee_s = $fee->field('s9')->find();
			$s9 = explode('|',$fee_s['s9']);
			$this->assign('s9',$s9);

			$this->assign('id',$_SESSION[C('USER_AUTH_KEY')]);
			$title = '会员管理';
			$this->assign('title',$title);
			$this->_levelShopConfirm($lvArr);
			$this->assign('lvArr',$lvArr);
			$this->display ();
			return;
	}


	//前后5人
	public function member_x(){
		if ($_SESSION['Urlszpass'] == 'Myssmemberx'){
			$fck = M('fck');
			$id = $_SESSION[C('USER_AUTH_KEY')];
			$myrs = $fck->where('id='.$id)->field('id,user_id,n_pai')->find();
			$n_pai = $myrs['n_pai'];
			
			$field  = 'id,user_id,n_pai,pdt,user_tel,qq';
			//前面5个
    		$wherea = "is_pay>0 and n_pai<".$n_pai;
            $alist = $fck->where($wherea)->field($field)->order('n_pai desc')->limit(5)->select();
            $this->assign('alist',$alist);
            
            //后5个
    		$whereb = "is_pay>0 and n_pai>".$n_pai;
            $blist = $fck->where($whereb)->field($field)->order('n_pai asc')->limit(5)->select();
            $this->assign('blist',$blist);
//            dump($blist);exit;

			$this->display ('member_x');
			return;
		}else{
			$this->error('数据错误!');
			exit;
		}
	}
	
	//一线排网
	public function member_z(){
		if ($_SESSION['Urlszpass'] == 'Myssmemberz'){
			$fck = M('fck');
			$id = $_SESSION[C('USER_AUTH_KEY')];
			$myrs = $fck->where('id='.$id)->field('id,user_id,x_pai')->find();
			$x_pai = $myrs['x_pai'];
			
			$field  = 'id,user_id,x_pai,pdt,user_tel,qq,x_num,x_out';

    		$wherea = "is_pay>0 and x_pai>=".$x_pai;
    		//=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $fck->where($wherea)->count();//总页数
       		$listrows = 20;//每页显示的记录数
            $page_where = '';//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $list = $fck->where($wherea)->field($field)->order('x_pai asc,id asc')->page($Page->getPage().','.$listrows)->select();
            $this->assign('list',$list);//数据输出到模板
            //=================================================
            
            $nn = $fck->where("is_pay>0 and x_pai<".$x_pai." and x_out=0")->count();
            $this->assign('nn',$nn);

			$this->display ('member_z');
			return;
		}else{
			$this->error('数据错误!');
			exit;
		}
	}
	

}
?>