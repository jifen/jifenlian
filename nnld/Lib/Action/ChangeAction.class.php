<?php
class ChangeAction extends CommonAction {
	public function _initialize() {
		header("Content-Type:text/html; charset=utf-8");
		$this->_inject_check(1);//调用过滤函数
		$this->_checkUser();
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
			$this->display('../Public/cody');
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
				$_SESSION['DLTZURL02'] = 'changedata';
				$bUrl = __URL__.'/changedata';//修改资料
				$this->_boxx($bUrl);
				break;
			case 2:
				$_SESSION['DLTZURL01'] = 'changepassword';
				$bUrl = __URL__.'/changepassword';//修改密码
				$this->_boxx($bUrl);
				break;
			case 3:
				$_SESSION['DLTZURL01'] = 'pprofile';
				$bUrl = __URL__.'/pprofile';//修改密码
				$this->_boxx($bUrl);
				break;
			case 4:
				$_SESSION['DLTZURL01'] = 'pprofile';
				$bUrl = __URL__.'/jifen';//修改密码
				$this->_boxx($bUrl);
				break;
			default;
				$this->error('二级密码错误!');
				break;
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
			case 1:
				$_SESSION['DLTZURL02'] = 'changedata';
				$bUrl = __URL__.'/changedata';//修改资料
				$this->_boxx($bUrl);
				break;
			case 2:
				$_SESSION['DLTZURL01'] = 'changepassword';
				$bUrl = __URL__.'/changepassword';//修改密码
				$this->_boxx($bUrl);
				break;
			case 3:
				$_SESSION['DLTZURL01'] = 'pprofile';
				$bUrl = __URL__.'/pprofile';//修改密码
				$this->_boxx($bUrl);
				break;
			default;
				$this->error('三级密码错误!');
				break;
		}
	}

	/* ---------------显示用户修改资料界面---------------- */


	public function data(){

			$fck	 =	 M('fck');
			$id   = $_GET['id'];
		    $this->assin('id',$id);
			//输出登录用户资料记录
			$vo	= $fck -> getById($id);  //该登录会员记录
			if(empty($vo['us_img'])){
				$vo['us_img'] = "__PUBLIC__/Images/tirns.jpg";
			}
			$this->assign('vo',$vo);
			unset($vo);

			//输出银行
			$b_bank = $fck -> where('id='.$id) -> field("bank_name") -> find();
			$this->assign('b_bank',$b_bank);

			$fee = M ('fee');
			$fee_s = $fee->field('s2,s9,i4,str29,str99')->find();
			$wentilist = explode('|',$fee_s['str99']);
			$this->assign('wentilist',$wentilist);
			$bank = explode('|',$fee_s['str29']);
			$this->assign('bank',$bank);

			unset($bank,$b_bank);

			$this->display();

	}






	public function changedata(){
		if ($_SESSION['DLTZURL02'] == 'changedata'){
			$fck	 =	 M('fck');
			$id   = $_SESSION[C('USER_AUTH_KEY')];
			$this->assign('id',$id);
			//输出登录用户资料记录
			$vo	= $fck -> getById($id);  //该登录会员记录
			if(empty($vo['us_img'])){
				$vo['us_img'] = "__PUBLIC__/Images/tirns.jpg";
			}
			$this->assign('vo',$vo);
			unset($vo);

			//输出银行
			$b_bank = $fck -> where('id='.$id) -> field("bank_name") -> find();
			$this->assign('b_bank',$b_bank);

			$fee = M ('fee');
			$fee_s = $fee->field('s2,s9,i4,str29,str99')->find();
			$wentilist = explode('|',$fee_s['str99']);
			$this->assign('wentilist',$wentilist);
			$bank = explode('|',$fee_s['str29']);
			$this->assign('bank',$bank);

			unset($bank,$b_bank);

			$this->display('changedata');

		}else{
			$this->error('操作错误!');
			exit;
		}
	}


	/* --------------- 修改保存会员信息 ---------------- */
	public function changedataSave(){


			$fck = M('fck');

			$myw = array();
			$myw['id'] = $_SESSION[C('USER_AUTH_KEY')];
			$mrs = $fck->where($myw)->field('id,wenti_dan')->find();

			if($_POST['yanzhengmas'] != $_SESSION['ziliao'] || $_POST['yanzhengmas']==''){

				$this->error("您的验证码不正确");
			}


			if(!$mrs){
				$this->error('非法提交数据!');
				exit;
			}else{
				$mydaan = $mrs['wenti_dan'];
			}

//			$huida = trim($_POST['wenti_dan']);
//			if(empty($huida)){
//				$this->error('请输入底部的密保答案！');
//				exit;
//			}
//			if($huida!=$mydaan){
//				$this->error('密保答案验证不正确！');
//				exit;
//			}

			$data = array();
//			$data['nickname']         = $_POST['NickName'];        //会员昵称
			$data['bank_name']        = $_POST['BankName'];        //银行名称
			$data['bank_card']        = $_POST['BankCard'];        //银行卡号
//			$data['user_name']        = $_POST['UserName'];        //开户姓名

			$data['bank_province']    = $_POST['BankProvince'];    //省份
			$data['bank_city']        = $_POST['BankCity'];        //城市
			$data['bank_address']     = $_POST['BankAddress'];     //开户地址
			$data['user_code']        = $_POST['UserCode'];        //身份证号码
 			$data['user_address']     = $_POST['UserAddress'];     //联系地址
// 			$data['email']            = $_POST['UserEmail'];       //电子邮箱
			$data['user_tel']         = $_POST['UserTel'];         //联系电话
			$data['get_address']         = $_POST['get_address'];

			$data['province']         = $_POST['province'];
			$data['city']         = $_POST['city'];
			$data['address']         = $_POST['address'];

			$data['qq']         = $_POST['qq'];         //qq
			$usimg = trim($_POST['image']);
			if(!empty($usimg)){
				$data['us_img']		  = $usimg;
			}

			$xg_wenti = trim($_POST['xg_wenti']);
			$xg_wenti_dan = trim($_POST['xg_wenti_dan']);
			if(!empty($xg_wenti)){
				$data['wenti']			= $xg_wenti;//问题
			}
			if(!empty($xg_wenti_dan)||strlen($xg_wenti_dan)>0){
				$data['wenti_dan']		= $xg_wenti_dan;//答案
			}


			$data['id']               = $_SESSION[C('USER_AUTH_KEY')];//要修改资料的AutoId

			$rs = $fck->save($data);
			if($rs){
				$bUrl = __URL__.'/changedata';
				$this->_box(1,'资料修改成功！',$bUrl,1);
			}else{
				$this->error('操作错误!');
				exit;
			}

	}
	
	/* ********************** 修改密码 ********************* */
	public function changepassword(){
		if ($_SESSION['DLTZURL01'] == 'changepassword'){
			$fck = M('fck');

			$id   = $_SESSION[C('USER_AUTH_KEY')];
			$this->assign('id',$id);
			//输出登录用户资料记录
			$where = array();
			$where['id'] = array('eq',$id);
			$vo	= $fck ->where($where)->find();
			$this->assign('vo',$vo);
			unset($vo);

			$this->display('changepassword');
		}else{
			$this->error('操作错误!');
			exit;
		}
	}


    /* ********************** 修改密码 ********************* */
    public function changepasswordSave(){
    	if ($_SESSION['DLTZURL01'] == 'changepassword'){
			$fck    =   M('fck');

            if($_POST['yanzhengmas'] =='') {
				$this->error('验证码不能为空！');
				exit;
			}

			if($_POST['yanzhengmas'] != $_SESSION['mima']) {
				$this->error('验证码错误！');
				exit;
			}
	
			$myw = array();
			$myw['id'] = $_SESSION[C('USER_AUTH_KEY')];
			$mrs = $fck->where($myw)->field('id,wenti_dan')->find();
			if(!$mrs){
				$this->error('非法提交数据!');
				exit;
			}else{
				$mydaan = $mrs['wenti_dan'];
			}
	
//			$huida = trim($_POST['wenti_dan']);
//			if(empty($huida)){
//				$this->error('请输入底部的密保答案！');
//				exit;
//			}
//			if($huida!=$mydaan){
//				$this->error('密保答案验证不正确！');
//				exit;
//			}
	
			$map	=	array();
	
			//检测密码级别及获取旧密码
			if ($_POST['type'] == 1){
				$map['Password']  = pwdHash($_POST['oldpassword']);
			}elseif($_POST['type'] == 2){
				$map['passopen']  = pwdHash($_POST['oldpassword']);
			}elseif($_POST['type'] == 3){
				$map['passopentwo'] = pwdHash($_POST['oldpassword']);
			}else{
				$this->error('请选择修改密码级别！');
				exit;
			}
	
			//检查两次密码是否相等
			if($_POST['password'] != $_POST['repassword']){
				$this->error('两次输入的密码不相等！');
				exit;
			}
	
	        if(isset($_POST['account'])){
	            $map['user_id']	 =	 $_POST['account'];
	        }elseif(isset($_SESSION[C('USER_AUTH_KEY')])){
	            $map['id']	     =	 $_SESSION[C('USER_AUTH_KEY')];
	        }
	
	        //检查用户
			$result = $fck->where($map)->field('id')->find();
	        if(!$result){
	            $this->error('旧密码错误！');
	        }else {
				//修改密码
				$pwds = pwdHash($_POST['password']);
				if ($_POST['type'] == 1){
					$fck->where($map)->setField('pwd1',$_POST['password']);  //一级密码不加密
					$fck->where($map)->setField('password',$pwds);           //一级密码加密
				}elseif($_POST['type'] == 2){
					$fck->where($map)->setField('pwd2',$_POST['password']);  //二级密码不加密
					$fck->where($map)->setField('passopen',$pwds);           //二级密码加密
				}elseif($_POST['type'] == 3){
					$fck->where($map)->setField('pwd3',$_POST['password']);  //三级密码不加密
					$fck->where($map)->setField('passopentwo',$pwds);          //三级密码加密
				}
				//9260729
				//$fck->save();
			//生成认证条件
	        $mapp            =   array();
			// 支持使用绑定帐号登录
			$mapp['id']    = $_SESSION[C('USER_AUTH_KEY')];
			$mapp['user_id']	= $_SESSION['loginUseracc'];
			import ( '@.ORG.RBAC' );
	        $authInfoo = RBAC::authenticate($mapp);
	        if(false === $authInfoo) {
	            $this->LinkOut();
				$this->error('帐号不存在！');
				exit;
	        }else {
				//更新session
				$_SESSION['login_sf_list_u'] = md5($authInfoo['user_id'].'wodetp_new_1012!@#'.$authInfoo['password'].$_SERVER['HTTP_USER_AGENT']);
			}
				$bUrl = __URL__.'/changepassword';
				$this->_box(1,'修改密码成功！',$bUrl,1);
				exit;
	        }
    	}else{
			$this->error('操作错误!');
			exit;
		}
    }

    public function pprofile() {
		//列表过滤器，生成查询Map对像
		$id  = $_SESSION[C('USER_AUTH_KEY')];
		$fck = M ('fck');
		//会员
        $u_all = $fck -> where('id='.$id)->field('*') -> find();

		$u_alls = M('fck2') -> where('uid='.$id)->field('*') -> find();

        $qk = $u_all['cpzj'] - $u_all['cpzj_pay'];
        $this->assign('qk',$qk);
		$lev = $u_all['u_level']-1;
		$levs = $u_all['u_level'];

		$fee = M('fee');
		$fee_rs = $fee->field('s4,s10')->find();
		$s4 = explode('|',$fee_rs['s4']);


		$this->_levelConfirm($Level,1);


			$fee = M('fee');
			$fee_rs = $fee->field('s4,s10,str28')->find();
			$str28 = explode('|',$fee_rs['str28']);
			$this -> assign('mycg',$str28[$levs]);//会员级别




		$this -> assign('rs',$u_all);
		$this -> assign('rss',$u_alls);
        $this->display();
    }



	public function jifen() {
		if($_POST['start'] && $_POST['end']){
			$map['pdt'] = array(array('egt',strtotime($_POST["start"])),array('elt',strtotime($_POST["end"])));

			$this->assign('start',strtotime($_REQUEST["start"]));
			$this->assign('end',strtotime($_REQUEST["end"]));
		}


		if($_REQUEST['user_id']){

			$map['fromusername'] = array('eq',$_REQUEST['user_id']);
			$this->assign('user_id',$_REQUEST["user_id"]);
		}


		if($_REQUEST['uniqueid']){
			$map['uniqueid'] = array('eq',$_REQUEST['uniqueid']);
			$this->assign('uniqueid',$_REQUEST["uniqueid"]);
		}


		$map['tousername']=array('eq',$_SESSION['loginUseracc']);
		$trans=M('trans');
		import ( "@.ORG.ZQPage" );  //导入分页类
		$count = $trans->where($map)->count();//总页数
		$listrows = C('ONE_PAGE_RE');//每页显示的记录数
		$listrows = 15;//每页显示的记录数
		$page_where ='start='.$_REQUEST["start"].'&end='.$_REQUEST["end"].'&user_id='.$_REQUEST['user_id'];//分页条件
		$Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
		//===============(总页数,每页显示记录数,css样式 0-9)
		$show = $Page->show();//分页变量
		$this->assign('page',$show);//分页变量输出到模板
		$list = $trans->order('pdt desc')->where($map)->page($Page->getPage().','.$listrows)->select();
		$this->assign('list',$list);//数据输出到模板

		$this->display();
	}


    
	/* 上传图片 */
	public function uploadImg(){
		import('@.ORG.UploadFile');
		$fileName = date("Y").date("m").date("d").date("H").date("i").date("s").rand(1,100);
		$upload = new UploadFile();						// 实例化上传类
		$upload->maxSize = 1*1024*1024;					//设置上传图片的大小
		$upload->allowExts = array('jpg','png','gif');	//设置上传图片的后缀
		$upload->uploadReplace = true;					//同名则替换
		$upload->saveRule = 'temp';					//设置上传头像命名规则(临时图片),修改了UploadFile上 传类
//		$upload->saveRule = $fileName;
		//完整的头像路径
		$path = './Public/Uploads/';
		$upload->savePath = $path;
		if(!$upload->upload()) {						// 上传错误提示错误信息
			$this->ajaxReturn('',$upload->getErrorMsg(),0,'json');
		}else{											// 上传成功 获取上传文件信息
			$info =  $upload->getUploadFileInfo();
			$temp_size = getimagesize($path.'temp.jpg');
			if($temp_size[0] < 100 || $temp_size[1] < 100){//判断宽和高是否符合头像要求
				$this->ajaxReturn(0,'图片宽或高不得小于100px!',0,'json');
			}
			$this->ajaxReturn(__ROOT__.'/Public/Uploads/'.$user_path.'temp.jpg',$info,1,'json');
		}
	}
    
	//裁剪并保存图像
	public function cropImg(){
		//图片裁剪数据
//		$params = $this->_post();				//裁剪参数
		$params = $_POST;						//裁剪参数
//		dump($_POST);
		if(!isset($params) && empty($params)){
			return;
		}
		//随时间生成文件名
		$randPath = date("Y").date("m").date("d").date("H").date("i").date("s").rand(1,100);
		//头像目录地址
		$path = './Public/Uploads/';
		//要保存的图片
		$real_path = $path.$randPath.'.jpg';
		//临时图片地址
		$pic_path = $path.'temp.jpg';
		import('@.ORG.ThinkImage.ThinkImage');
		$Think_img = new ThinkImage(THINKIMAGE_GD); 
		//裁剪原图
		$Think_img->open($pic_path)->crop($params['w'],$params['h'],$params['x'],$params['y'])->save($real_path);
		//生成缩略图
//		$Think_img->open($real_path)->thumb(220,150, 1)->save($path.'avatar_220_150.jpg');
//		$Think_img->open($real_path)->thumb(60,60, 1)->save($path.'avatar_60.jpg');
//		$Think_img->open($real_path)->thumb(30,30, 1)->save($path.'avatar_30.jpg');
		
		echo "<script>window.parent.form1.imageShow.src='".__ROOT__.$real_path."';</script>";
		$real_path=(str_replace('./Public/','__PUBLIC__/',$real_path));
		echo "<script>window.parent.form1.image.value='".$real_path."';</script>";
		$this->success('图像保存成功');
	}





	public function sendmessage(){
		set_time_limit(0);//是页面不过期
		$host = '115.28.156.19:8055';
		$path = '/jk.aspx';
		$uid = $_GET['uid'];
		$type = $_GET['type'];

		$rs = M('fck')->where('id='.$uid)->find();

		$intarr	= 0;
		$request = '';

		if($type==1){
           $ms = "积分转账";
		}

		if($type==2){
			$ms = "修改资料";
		}

		if($type==3){
			$ms = "修改密码";
		}

		if($type==4){
			$ms = "vap转换";
		}

		$tel = $rs['user_tel'];
		if($tel == ''){
			echo '手机号码未完整';exit;
		}

		$result = array();
		$password = rand(100000,999999);
		$nr = '【积分联盟】您的'.$ms.'验证码为:'.$password;
		$data_string = "zh=wh333&mm=123321&sms_type=50&hm=$tel&nr=$nr";

		$request = "POST $path  HTTP/1.1\r\n";
		$request .= "Host:$host\r\n";
		$request .= "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:22.0) Gecko/20100101 Firefox/22.0 \r\n";
		$request .= "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8 \r\n";
		$request .= "Accept-Language: zh-cn,zh;q=0.8,en-us;q=0.5,en;q=0.3 \r\n";
		$request .= "Accept-Encoding: gzip, deflate \r\n";
		$request .= "Connection: keep-alive \r\n";

		$request .= "Content-Type: application/x-www-form-urlencoded \r\n";
		$request .=	"Content-length: ".strlen($data_string)." \r\n";
		$request .= "Connection: close \r\n\r\n";
		$request .= $data_string;

		//$open = fsockopen($host, 80, $errno, $errstr, 60);
		$open = stream_socket_client($host.':80',$errno, $errstr, 30);

		if ( !$open ){
			$result = '连接短信服务器失败！';
		}else{

			fwrite($open,$request);

			$str = fread($open,8192);
			$arr = explode(':',$str);
			$intarr = intval($arr[0]);

			if ( $intarr == 0 ) {
				$result = true;
			}else if ( $intarr == 1 ) {
				$result = '服务器异常';
			}else if ( $intarr == -2 || $intarr == -3 ) {
				$result = '余额不足';
			}else if ( $intarr == -1 ) {
				$result = '缺少参数';
			}
		}

		fclose($open);
		if($result){
			if($type==1){
				$_SESSION['jifen'] = $password;
			}

			if($type==2){
				$_SESSION['ziliao'] = $password;
			}

			if($type==3){
				$_SESSION['mima'] = $password;
			}

			if($type==4){
				$_SESSION['vap'] = $password;
			}

			echo "验证码已经发送,请注意查收";
		}
	}



	public function yanzhengma(){
		set_time_limit(0);//是页面不过期
		$tel = $_GET['yanzhen'];
		$type = $_GET['type'];

		if($tel == ''){
			echo "验证码不能为空";exit;
		}


		if($type==1) {
			if ($tel == $_SESSION['jifen']) {

				echo "验证码正确";exit;

			} else {
				echo "验证码不正确";exit;
			}
		}

		if($type==2) {


			if ($tel == $_SESSION['ziliao']) {

				echo "验证码正确";exit;

			} else {
				echo "验证码不正确";exit;
			}
		}

		if($type==3) {
			if ($tel == $_SESSION['mima']) {

				echo "验证码正确";exit;

			} else {
				echo "验证码不正确";exit;
			}
		}

		if($type==4) {
			if ($tel == $_SESSION['vap']) {

				echo "验证码正确";exit;

			} else {
				echo "验证码不正确";exit;
			}
		}


	}






}
?>