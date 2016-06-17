<?php
class PublicAction extends CommonAction {
	public function _initialize() {
		header("Content-Type:text/html; charset=utf-8");
		$this->_inject_check(1);//调用过滤函数
		$this->_Config_name();//调用参数
	}

	
	public function xz()
	{
	}

	//过滤查询字段
	function _filter(&$map){
		$map['title'] = array('like',"%".$_POST['name']."%");
	}
	// 顶部页面
	public function top() {
		C('SHOW_RUN_TIME',false);			// 运行时间显示
		C('SHOW_PAGE_TRACE',false);
		$this->display();
	}
	// 尾部页面
	public function footer() {
		C('SHOW_RUN_TIME',false);			// 运行时间显示
		C('SHOW_PAGE_TRACE',false);
		$this->display();
	}
	// 菜单页面
	public function menu() {
        $this->_checkUser();
		$map = array();
		$id = $_SESSION[C('USER_AUTH_KEY')];
		$field = '*';

		$map = array();
		$map['s_uid']   = $id;   //会员ID
		$map['s_read'] = 0;     // 0 为未读
        $info_count = M ('msg') -> where($map) -> count(); //总记录数
		$this -> assign('info_count',$info_count);

		$fck = M('fck');
		$fwhere = array();
		$fwhere['ID'] = $_SESSION[C('USER_AUTH_KEY')];
		$frs = $fck->where($fwhere)->field('*')->find();
		//dump($frs);
		$HYJJ = '';
		$this->_levelConfirm($HYJJ,1);
		$this->assign('voo',$HYJJ);

		$this->assign('fck_rs',$frs);
		$this->display('menu');
	}

    // 后台首页 查看系统信息
    public function main() {
        $this->_checkUser();
        $id = $_SESSION[C('USER_AUTH_KEY')];  //登录AutoId

        $bonus = M ('bonus');  //奖金表
		$where = array();
		$where['uid'] = $id;
        $field  = '*';
        $list = $bonus->where($where)->field($field)->order('id desc')->limit(10)->select();
        $this->assign('list',$list);

		$form = M ('form');
		$map = array();
		$map['status'] = array('eq',1);
        $field  = '*';
        $nlist = $form->where($map)->field($field)->order('baile desc,id desc')->limit(12)->select();
        $this->assign('top_new',$nlist[0]);
        $this->assign('f_list',$nlist);//数据输出到模板

		//推荐人数
		$fck = M ('fck');
		$map = array();
		$map['re_id']    = $id;
		$map['is_pay']   = 1;
        $re_count = $fck -> where($map) -> count();
		$this -> assign('re_count',$re_count);

		$map = array();
		$map['s_uid']   = $id;   //会员ID
		$map['s_read'] = 0;     // 0 为未读
        $info_count = M ('msg') -> where($map) -> count(); //总记录数
		$this -> assign('info_count',$info_count);

		//会员级别
        $urs = $fck -> where('id='.$id)->field('*') -> find();
		$urss = M('fck2') -> where('uid='.$id)->field('*') -> select();

		foreach($urss  as $key=>$v){
			$info=array();
			$info['id']=$v['id'];
			$info['uid']=$v['uid'];
			$info['u_level']=$v['u_level'];
			$info['sheng']=$v['sheng'];
			$info['is_suo']=$v['is_suo'];
			$info['is_time']=$v['is_time'];
			$info['time']=$v['time']-time();
			$urss[$key]['info']=$info;
		}

		$this -> assign('fck_rss',$urss);//总奖金



		$lev = $urs['u_level'];
		$Level = '';
		$this->_levelConfirm($Level,1);




			$fee = M('fee');
			$fee_rs = $fee->field('s4,s10,str28')->find();
			$str28 = explode('|',$fee_rs['str28']);
			$u_level_str = $str28[$lev];

	/*	if ($urs['is_company']==2) {
			$u_level_str .= " / 分公司";
		}
		elseif ($urs['is_agent'] == 2) {
			$u_level_str .= " / 报单中心";
		}
	*/


		$this -> assign('u_level',$u_level_str);//会员级别


		$this -> assign('fck_rs',$urs);//总奖金

		$fee = M('fee');
	    $fee_rs = $fee->field('str7,str21,str22,str23,b_money')->find();
		$str21 = $fee_rs['str21'];
		$str22 = $fee_rs['str22'];
		$str23 = $fee_rs['str23'];
		$all_img = array($str21,$str22,$str23);
		$this->assign('all_img',$all_img);


		
		$a_money = $fee_rs['b_money'];
		$this->assign('b_money',$a_money);
		
		$str5 = explode("|",$fee_rs['str7']);
	    $maxqq = 4;
	    if(count($str5)>$maxqq){
	    	$lenn = $maxqq;
	    }else{
	    	$lenn = count($str5);
	    }
	    for($i=0;$i<$lenn;$i++){
	    	$qqlist[$i] = $str5[$i];
	    }
	    $this->assign('qlist',$qqlist);
		
		$plan = M ('plan');
		$svo = $plan->find(2);
		$this->assign ( 'svo', $svo );
		$fvo = $plan->find(3);
		$this->assign ( 'fvo', $fvo );
		
		
		$see = $_SERVER['HTTP_HOST'].__APP__;
		$see = str_replace("//","/",$see);
        $this->assign ( 'server', $see );

        $pr = M('product');
        $p_rs = $pr->where('yc_cp=0')->order('id desc')->limit(3)->select();
        $this->assign('p_rs',$p_rs);
        
        //首页图片
        $tupian = M('tupian');
        $map = array();
        $map['ptype'] = array('eq',0);
        $imgList = $tupian->where($map)->field('image')->order('create_time asc')->select();
        $this->assign('imgList',$imgList);
        
        //推广连接
        $img = M ('img');
        $link = $img->order('id desc')->find();
        $this->assign('link',$link);

        $this->_loadProduct(); //加载产品
        $this->display();
    }

	//产品
    private function _loadProduct() {
    	$products = M('product')->select();
        $this->assign('products',$products);
    }
    

	// 用户登录页面
	public function login() {
		$fee = M('fee');
		$fee_rs = $fee->field('str21')->find();
		$this->assign('fflv',$fee_rs['str21']);
		unset($fee,$fee_rs);
		$this->display('login');
	}

	public function index()
	{
		//如果通过认证跳转到首页
		redirect(__APP__);
	}

	// 用户登出
    public function LogOut(){
		$_SESSION = array();
		//unset($_SESSION);
        $this->assign('jumpUrl',__URL__.'/login/');
        $this->success('退出成功！');
    }

	// 登录检测
	public function checkLogin() {
		if(empty($_POST['account'])) {
			$this->error('请输入帐号！');
		}elseif (empty($_POST['password'])){
			$this->error('请输入密码！');
		}elseif (empty($_POST['verify'])){
			$this->error('请输入验证码！');
		}
		$fee = M ('fee');
//		$sel = (int) $_POST['radio'];
//		if($sel <=0 or $sel >=3){
//			$this->error('非法操作！');
//			exit;
//		}
//		if($sel != 1){
//			$this->error('暂时不支持英文版登录！');
//			exit;
//		}

        //生成认证条件
        $map            =   array();
		// 支持使用绑定帐号登录
		$map['user_id']	   = $_POST['account'];
//		$map['nickname'] = $_POST['account'];   //用户名也可以登录
//		$map['_logic']    = 'or';
		//$map['_complex']    = $where;
	    //$map["status"]	=	array('gt',0);
		if($_SESSION['verify'] != md5($_POST['verify'])) {
			$this->error('验证码错误！');
		}

		import ( '@.ORG.RBAC' );
		$fck = M('fck');
		$field = 'id,user_id,password,is_pay,is_lock,nickname,user_name,is_agent,user_type,last_login_time,login_count,is_boss';
		$authInfo = $fck->where($map)->field($field)->find();
        //使用用户名、密码和状态的方式进行认证
        if(false == $authInfo) {
            $this->error('帐号不存在或已禁用！');
        }else {
            if($authInfo['password'] != md5($_POST['password'])) {
				$this->error('密码错误！');
				exit;
            }
			if ($authInfo['is_pay'] <1){
				$this->error('用户尚未开通，暂时不能登录系统！');
				exit;
			}
			if ($authInfo['is_lock']!=0){
				$this->error('用户已锁定，请与管理员联系！');
				exit;
			}

			//前后台分离，如果定义了后台网关，必须验证是管理员才可以登录
            // if(__ADMIN_GATE__ === true && $authInfo['is_boss'] <= 0)
            // {
            //     $this->error(L('没有登录权限'));
            //     exit;
            // } elseif (__ADMIN_GATE__ !== true && $authInfo['is_boss'] > 0){
            //     $this->error(L('管理员必须在后台登录'));
            //     exit;
            // }
            
            $_SESSION[C('USER_AUTH_KEY')]	=	$authInfo['id'];
            $_SESSION['loginUseracc']		=	$authInfo['user_id'];//用户名
			$_SESSION['loginNickName']		=	$authInfo['nickname'];//会员名
			$_SESSION['loginUserName']		=	$authInfo['user_name'];//开户名
            $_SESSION['lastLoginTime']	=	$authInfo['last_login_time'];
			//$_SESSION['login_count']	    =	$authInfo['login_count'];
			$_SESSION['login_isAgent']	    =	$authInfo['is_agent'];//是否报单中心
			$_SESSION['UserMktimes']        = mktime();
            //身份确认 = 用户名+识别字符+密码
			$_SESSION['login_sf_list_u']    = md5($authInfo['user_id'].'wodetp_new_1012!@#'.$authInfo['password'].$_SERVER['HTTP_USER_AGENT']);

			//登录状态
			$user_type = md5($_SERVER['HTTP_USER_AGENT'].'wtp'.rand(0,999999));
			$_SESSION['login_user_type'] = $user_type;
			$where['id'] = $authInfo['id'];
			$fck->where($where)->setField('user_type',$user_type);
//			$fck->where($where)->setField('last_login_time',mktime());
			//管理员

			$parmd = $this->_cheakPrem();
			if($authInfo['id'] == 1||$parmd[11]==1) {
            	$_SESSION['administrator']		=	1;
            }else{
				$_SESSION['administrator']		=	2;
			}

//			//管理员
//			if($authInfo['is_boss'] == 1) {
//            	$_SESSION['administrator'] =	1;
//            }elseif($authInfo['is_boss'] == 2){
//            	$_SESSION['administrator'] = 3;
//            }elseif($authInfo['is_boss'] == 3){
//                $_SESSION['administrator']  = 4;
//            }elseif($authInfo['is_boss'] == 4){
//                $_SESSION['administrator'] = 5;
//            }elseif($authInfo['is_boss'] == 5){
//                $_SESSION['administrator'] =   6;
//            }elseif($authInfo['is_boss'] == 6){
//                $_SESSION['administrator'] =   7;
//            }else{
//				$_SESSION['administrator'] = 2;
//			}

			$fck->execute("update __TABLE__ set last_login_time=new_login_time,last_login_ip=new_login_ip,new_login_time=".time().",new_login_ip='".$_SERVER['REMOTE_ADDR']."' where id=".$authInfo['id']);

			// 缓存访问权限
            RBAC::saveAccessList();
			$this->success('登录成功！');
		}
	}
	//二级密码验证
	public function cody(){
		$UrlID = (int)$_GET['c_id'];
		if (empty($UrlID)){
			$this->error('二级密码错误!');
			exit;
		}
		if(!empty($_SESSION['user_pwd2'])){
			$url = __URL__."/codys/Urlsz/$UrlID";
			$this->_boxx($url);
			exit;
		}
		$fck   =  M ('cody');
        $list	=  $fck->where("c_id=$UrlID")->getField('c_id');
		if (!empty($list)){
			$this->assign('vo',$list);
			$this->display('cody');
			exit;
		}else{
			$this->error('二级密码错误!');
			exit;
		}
	}
	//二级验证后调转页面
	public function codys(){
		$Urlsz = $_POST['Urlsz'];
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

			$where =array();
			$where['id'] = $_SESSION[C('USER_AUTH_KEY')];
			$where['passopen'] = md5($pass);
			$list = $fck->where($where)->field('id')->find();
			if($list == false){
				$this->error('二级密码错误!');
				exit();
			}
			$_SESSION['user_pwd2'] = 1;
		}else{
			$Urlsz = $_GET['Urlsz'];
		}
		switch ($Urlsz){
			case 1:
				$_SESSION['DLTZURL02'] = 'updateUserInfo';
				$bUrl = __URL__.'/updateUserInfo';//修改资料
				$this->_boxx($bUrl);
				break;
			case 2:
				$_SESSION['DLTZURL01'] = 'password';
				$bUrl = __URL__.'/password';//修改密码
				$this->_boxx($bUrl);
				break;
			case 3:
				$_SESSION['DLTZURL01'] = 'pprofile';
				$bUrl = __URL__.'/pprofile';//修改密码
				$this->_boxx($bUrl);
				break;
			case 4:
				$_SESSION['DLTZURL01'] = 'OURNEWS';
				$bUrl = __URL__.'/News';//修改密码
				$this->_boxx($bUrl);
				break;
			default;
				$this->error('二级密码错误!');
				break;
		}
	}

	 public function verify()
    {
    	ob_clean();
		$type	 =	 isset($_GET['type'])?$_GET['type']:'gif';
        import("@.ORG.Image");
        Image::buildImageVerify();
    }

	

}
?>