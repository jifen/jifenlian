<?php
class UplevelAction extends CommonAction{
	
	public function _initialize() {
		header("Content-Type:text/html; charset=utf-8");
		$this->_inject_check(0);//调用过滤函数
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
			$_SESSION['Urlszpass'] = 'Myssjinji';
			$bUrl = __URL__.'/MenberJinji';//会员晋级
			$this->_boxx($bUrl);
			break;
			case 2;
			$_SESSION['Urlszpass'] = 'Myssadminjinji';
			$bUrl = __URL__.'/adminmemberJJ';//后台充值管理
			$this->_boxx($bUrl);
			break;
			case 3;
			$_SESSION['Urlszpass'] = 'MyssadminjinjiShop';
			$bUrl = __URL__.'/shopMemberJJ';//后台充值管理
			$this->_boxx($bUrl);
			break;
			case 4:
			$_SESSION['Urlszpass'] = 'Myssadminjinji';
			$bUrl = __URL__.'/adminmemberJJList';//后台充值管理
			$this->_boxx($bUrl);
			break;
			default;
			$this->error('二级密码错误!');
			exit;
		}
	}

	//后台股东晋级
	public function adminmemberJJList(){
		if ($_SESSION['Urlszpass'] == 'Myssadminjinji'){
			$where = array();
			$fck = M('fck');
			$voo = 0;
			$this->_levelConfirm($voo);

			$level = array();
			for($i=1;$i<=count($voo) ;$i++){
				$level[$i] = $voo[$i];
			}
			$this->assign('level',$level);

			$fee = M ('fee');
			$fee_rs =$fee->field('s1,s2,s9,s4,s5')->find();
			$s1 =explode('|',$fee_rs['s1']);
			$s2 =explode('|',$fee_rs['s2']);
			$s3 =explode('|',$fee_rs['s9']);

			$this->assign('sx1',$s3);

			if (!empty($_POST['UserID'])) {
				$map['user_id'] = $_POST['UserID'];
			}

			$promo = M('promo');
			// $field  = '*';
   //          $list = $promo->where($map)->field($field)->order('id desc')->select();
   //          $this->assign('list',$list);//数据输出到模板
            $field  = '*';
            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $promo->where($map)->count();//总页数
       		$listrows = C('ONE_PAGE_RE');//每页显示的记录数
            // $page_where = 'UserID=' . $UserID . '&type=' . $ss_type. '&ulevel=' . $uulv;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $list = $promo->where($map)->field($field)->order('id desc')->page($Page->getPage().','.$listrows)->select();
            $this->assign('list',$list);//数据输出到模板
            //=================================================
            //=================================================

			$this->assign('uid',$uid);
			$this->assign('le',$voo);
			$this->assign('level',$level);
			$this->assign('frs',$frs);//数据输出到模板
			$this->display();
		}else{
			$this->error('错误！');
			exit;
		}
	}

	////////////////////////////////
	public function shopMemberJJAC()
	{
		if ($_SESSION['Urlszpass'] != 'MyssadminjinjiShop'){
			$this->error('错误！');
		}
		$fck  = D('Fck');
		$promo = M('promo');
		$shouru = M('shouru');
		if ($_POST['action'] == '删除') {
			$map['id'] = array('in',$_POST['tabledb']);
			$map['is_pay'] = 0;
			$re = $fck->where($map)->delete();
			if ($re) {
				$this->success('删除成功');
				exit;
			}
			else {
				$this->error('删除失败');
			}
		}
		// 下面这里是确认通过的
		$fee = M ('fee');
		$fee_rs =$fee->field('s2,s9')->find();
		$f4Arr =explode('|',$fee_rs['s2']);//单量
		$cpzjArr =explode('|',$fee_rs['s9']);//金额

		$map = array();
		$ids = $_POST['tabledb'];
		$map['id'] = array('in',$ids);
		$map['is_pay'] = 0;
		$rs = $promo->where($map)->field('id,uid,money,u_level,up_level')->select();
		$i = 0;
		foreach ($rs as $key => $re) {
			$loginUserId = $_SESSION[C('USER_AUTH_KEY')];
			$shop = $fck->field('id,agent_cash,user_id')->find($loginUserId);
			if ($shop['agent_cash'] < $re['money']) {
				$this->error('注册积分余额不足');
			}
			$dec = $fck->where('id='.$shop['id'])->setDec('agent_cash',$re['money']);
			if (!$dec) {
				$this->error("扣币失败");
			}
			//设置状态
			$promo->where('id='.$re['id'])->setField('is_pay',1);
			// 添加收入记录
			$data = array();
			$data['uid'] = $re['uid'];
			$data['user_id'] = $re['user_id'];
			$data['in_money'] = $re['money'];
			$data['in_time'] = time();
			$data['in_bz'] = "会员晋级";
			$shouru->add($data);
			// 会员真正升级
			$old_f4 = $f4Arr[$re['u_level']-1];
			$new_f4 = $f4Arr[$re['up_level']-1];
			$need_dl = $new_f4 - $old_f4;
			$new_m = $cpzjArr[$re['up_level']-1];
			$fck->query("update __TABLE__ set u_level=".$re['up_level'].",cpzj=".$new_m.",f4=".$new_f4." where `id`=".$re['uid']);
			$fck->xiangJiao($re['uid'],$need_dl);
			$fck->getusjj($re['uid'],1,$re['money'],$re['u_level']);
			$i++;
		}
		if ($i == 0) {
			$this->error('确认失败');
		}
		else {
			$this->success("成功确认".$i."个晋级申请");
		}

	}

	////////////////////////////////
	public function shopMemberJJ()
	{
		if ($_SESSION['Urlszpass'] != 'MyssadminjinjiShop'){
			$this->error('错误！');
		}

		$fck  = M('fck');
		$promo = M('promo');

		$shop = $fck->field('id,is_agent')->find($_SESSION[C('USER_AUTH_KEY')]);
		if ($shop['is_agent'] < 2) {
			$this->error("未知错误");
		}
		$users = $fck->where('shop_id='.$shop['id'])->field('id')->select(); 
		$ids = "";
		foreach ($users as $key => $value) {
			$ids .= $value['id'].',';
		}
		$map = array();
		$map['uid'] = array('in',$ids);
		$map['money'] = array('gt',0);
		 //=====================分页开始==============================================
        import ( "@.ORG.ZQPage" );  //导入分页类
        $count = $promo->where($map)->count();//总页数
   		$listrows = C('ONE_PAGE_RE');//每页显示的记录数
        // $page_where = 'UserID=' . $UserID . '&type=' . $ss_type. '&ulevel=' . $uulv;//分页条件
        $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
        //===============(总页数,每页显示记录数,css样式 0-9)
        $show = $Page->show();//分页变量
        $this->assign('page',$show);//分页变量输出到模板
        $list = $promo->where($map)->field($field)->order('id asc')->page($Page->getPage().','.$listrows)->select();
        // var_dump($promo->getLastSql());
        $HYJJ = '';
        $this->_levelConfirm($HYJJ,1);
        $this->assign('voo',$HYJJ);//会员级别
        $level = array();
		for($i=0;$i<count($HYJJ) ;$i++){
			$level[$i] = $HYJJ[$i+1];
		}
		$this->assign('level',$level);
        $this->assign('list',$list);//数据输出到模板
        //=================================================
        $this->display();

	}
	
	//前台会员晋级
	public function MenberJinji(){
		if ($_SESSION['Urlszpass'] == 'Myssjinji'){
			$where = array();
			$fck = M('fck');

	    	$uid = $_SESSION[C('USER_AUTH_KEY')];

			$frs = $fck->find($uid);
			$voo = 0;
			$this->_levelConfirm($voo);

			$level = array();
			for($i=1;$i<=count($voo) ;$i++){
				$level[$i] = $voo[$i];
			}
			$this->assign('level',$level);


			$fee = M ('fee');
			$fee_rs =$fee->field('s1,s2,s9,s4,s5')->find();
			$s1 =explode('|',$fee_rs['s1']);
			$s2 =explode('|',$fee_rs['s2']);
			$s3 =explode('|',$fee_rs['s9']);
			$s4 =$fee_rs['s4'];
			$this->assign('sx1',$s3);

			$promo = M('promo');
			$field  = '*';
			$map['uid'] = $uid;
            $list = $promo->where($map)->field($field)->order('id desc')->select();
            $this->assign('list',$list);//数据输出到模板
            //=================================================

            $product = M ('product');
			$pwhere = array();
			$pwhere['pro_type'] = 0;
			$prs = $product->where($pwhere)->select();
			$this->assign('plist',$prs);

			$this->assign('s4',$s4);
			$this->assign('le',$voo);
			$this->assign('level',$level);
			$this->assign('frs',$frs);//数据输出到模板
			$this->display();
		}else{
			$this->error('错误！');
			exit;
		}
	}

	//前台晋级处理
	public function MenberJinjiConfirm(){
		if ($_SESSION['Urlszpass'] == 'Myssjinji'){
			$ulevel = $_POST['uLevel'];
			$uid = $_SESSION[C('USER_AUTH_KEY')];
			$where['id'] = $uid;
			$promo = M('promo');
			$fck = D('Fck');
			$shouru = M ('shouru');
			$fck_rs = $fck->where($where)->find();
			if($fck_rs['is_pay'] == 0){
				$this->error('您是临时会员不能申请晋级，请先开通！');
				exit;
			}
			$us_money = $fck_rs['agent_cash'];
			
			
			$fee = M ('fee');
			$fee_rs =$fee->field('s1,s2,s9,s4,s5')->find();
			$s1 =explode('|',$fee_rs['s1']);
			$s2 =explode('|',$fee_rs['s2']);//单量
			$s3 =explode('|',$fee_rs['s9']);//金额
			$s4 =explode('|',$fee_rs['s4']);
			$s5 =explode('|',$fee_rs['s5']);

			$ulevel = $ulevel;
			$newlv = $ulevel-1;
			$oldlv  = $fck_rs['u_level']-1;
			
			//金额
			$new_m = $s3[$newlv];
			$old_m = $s3[$oldlv];
			$need_m = $new_m-$old_m;
			
			//单量
			$new_dl = $s2[$newlv];
			$old_dl = $s2[$oldlv];
			$need_dl = $new_dl-$old_dl;

			$ok = $us_money-$need_m;
			if($fck_rs['u_level'] >=$ulevel || $ulevel > 5){
				$this->error('升级参数不正确！');
			}

 			if($fck_rs['u_level'] ==5){
				$this->error('已经是最高级，无法再升级！');
			}

			$us_name = $_POST['us_name'];
			$us_address = $_POST['us_address'];
			$us_tel = $_POST['us_tel'];
			if(empty($us_name)){
				$this->error('请输入收货人姓名！!');
				exit;
			}
			if(empty($us_address)){
				$this->error('请输入收货地址！!');
				exit;
			}
			if(empty($us_tel)){
				$this->error('请输入收货人电话！!');
				exit;
			}

			$content = noHTML($_POST['content']);		//备注
			// if (empty($content)){
			// 	$this->error('备注不能为空!');
			// 	exit;
			// }

			if ($ok < 0){
				$this->error('您的注册积分账户余额不足!');
				exit;
			}
			$re = $promo->where('is_pay=0 and uid='.$uid)->find();
			if ($re) {
				$this->error('上次申请未审核，请先联系报单中心审核');
			}

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
			if($cpmoney != $need_m){
				$this->error('产品金额必需为'.$need_m.'，请重新选择！');
				exit;
			}

			$result = $fck->execute("UPDATE __TABLE__ set agent_cash=agent_cash-".$need_m." where `id`=".$uid." and agent_cash=".$us_money);
			if($result) {
				$time=time();
				// 写入帐号数据
				$data = array();
				$data['uid']       			= $uid;
				$data['user_id']			= $fck_rs['user_id'];
				$data['money']				= $need_m;//补差额
				$data['u_level']			= $fck_rs['u_level'];//旧的
				$data['up_level']			= $ulevel;//新的
				$data['create_time']		= time();
				$data['pdt']				= time();
				$data['danshu']				= $need_dl;
				$data['is_pay']				= 1;
				$data['user_name']			= $content;
				$data['u_bank_name']		= $fck_rs['bank_name'];
				$data['type']				= 0;
	            $promo->add($data);
				unset($data);
				
				$data = array();
				$data['uid'] = $uid;
				$data['user_id'] = $fck_rs['user_id'];
				$data['in_money'] = $need_m;
				$data['in_time'] = time();
				$data['in_bz'] = "会员升级";
				$shouru->add($data);
				unset($data);

// 				$mrs = $fck->where('id ='.$uid)->field('id,re_id,user_id,treeplace,re_path,p_path')->find();
				
//				//统计单数
//				$fck->xiangJiao($uid,$need_dl);

				$fck->query("update __TABLE__ set u_level=".$ulevel.",cpzj=".$new_m.",f4=".$new_dl." where `id`=".$uid);

				$where1['id'] = array ('in',$cpid);
				$rs1 = $product->where($where1)->select();
				$i=0;
				$p=array();
				foreach ($rs1 as $b) {
					$id = $b['id'];
					$cpid = $b['id'];
					$aa = "shu".$b['id'];
					$cc1 = $_POST[$aa];
					if ($cc1 != 0) {
						$hy1 = $b['a_money'];

						$p[$i] = $hy1 * $cc1;
						$p1 = $hy1 * $cc1;
						$i++;

						$gwd = array();
						$gwd['uid'] = $fck_rs['id'];
						$gwd['user_id'] = $fck_rs['user_id'];
						$gwd['did'] = $cpid;
						$gwd['lx'] = 1;
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

				unset($fck,$fee,$promo,$shouru);
				$bUrl = __URL__.'/MenberJinji';
				$this->_box(1,'您晋级申请成功！',$bUrl,3);
			}else{
				$this->error('晋级申请失败！');
				exit;
			}
		}else{
			$this->error('错误！');
			exit;
		}
	}

	public function MenberJinjishow(){
		//查看详细信息
		$promo = M('promo');
		$ID = (int) $_GET['Sid'];
		$where = array();
		$where['id'] = $ID;
		$srs = $promo->where($where)->field('user_name')->find();
		$this->assign('srs',$srs);
		unset($promo,$where,$srs);
		$this->display ('MenberJinjishow');
	}
	
	//会员晋级管理
	public function adminmemberJJ($GPid=0){
		$this->_Admin_checkUser();
		if ($_SESSION['Urlszpass'] == 'Myssadminjinji'){
			$fck = M('fck');
			$UserID = $_REQUEST['UserID'];
			$u_sd = $_REQUEST['u_sd'];
			$uulv = (int)$_REQUEST['ulevel'];
			$ss_type = (int) $_REQUEST['type'];
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
			if(!empty($u_sd)){
				$map['is_lock'] =1;
            }
            if(!empty($uulv)){
            	$map['u_level'] =$uulv;
            }
			$map['is_pay'] = array('egt',1);
			$renshu = $fck->where($map)->count();//总人数
            //查询字段
            $field  = '*';
            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $fck->where($map)->count();//总页数
       		$listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $page_where = 'UserID=' . $UserID . '&type=' . $ss_type. '&ulevel=' . $uulv;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $list = $fck->where($map)->field($field)->order('pdt desc,id desc')->page($Page->getPage().','.$listrows)->select();

            $HYJJ = '';
            $this->_levelConfirm($HYJJ,1);
            $this->assign('voo',$HYJJ);//会员级别
            $level = array();
			for($i=0;$i<count($HYJJ) ;$i++){
				$level[$i] = $HYJJ[$i+1];
			}
			$this->assign('level',$level);
            $this->assign('count',$renshu);
            $this->assign('list',$list);//数据输出到模板
            //=================================================
			$this->display ();
		}else{
			$this->error('数据错误!');
			exit;
		}
	}
	
	//后台会员晋级
	public function adminMenberJinji(){
		if ($_SESSION['Urlszpass'] == 'Myssadminjinji'){
			$where = array();
			$fck = M('fck');
	    	$uid = $_GET['uid'];
			$frs = $fck->find($uid);
			if(!$frs){
				$this->error('数据错误!');
				exit;
			}
			$voo = 0;
			$this->_levelConfirm($voo);

			$level = array();
			for($i=1;$i<=count($voo) ;$i++){
				$level[$i] = $voo[$i];
			}
			$this->assign('level',$level);


			$fee = M ('fee');
			$fee_rs =$fee->field('s1,s2,s9,s4,s5')->find();
			$s1 =explode('|',$fee_rs['s1']);
			$s2 =explode('|',$fee_rs['s2']);
			$s3 =explode('|',$fee_rs['s9']);

			$this->assign('sx1',$s3);

			$promo = M('promo');
			$field  = '*';
			$map['uid'] = $uid;
            $list = $promo->where($map)->field($field)->order('id desc')->select();
            $this->assign('list',$list);//数据输出到模板
            //=================================================

			$this->assign('uid',$uid);
			$this->assign('le',$voo);
			$this->assign('level',$level);
			$this->assign('frs',$frs);//数据输出到模板
			$this->display();
		}else{
			$this->error('错误！');
			exit;
		}
	}

	//后台晋级处理
	public function adminMenberJinjiConfirm(){
		$this->_Admin_checkUser();
		if ($_SESSION['Urlszpass'] == 'Myssadminjinji'){
			$ulevel = $_POST['uLevel'];
			$uid = (int)$_POST['uid'];
			
			$promo = M('promo');
			$fck = D('Fck');
			$fee = M ('fee');
			
			$where['id'] = $uid;
			$fck_rs = $fck->where($where)->find();
			if(!$fck_rs){
				$this->error('会员错误！');
				exit;
			}
			
			$fee_rs =$fee->field('s1,s2,s9,s4,s5')->find();
			$s1 =explode('|',$fee_rs['s1']);
			$s2 =explode('|',$fee_rs['s2']);//单量
			$s3 =explode('|',$fee_rs['s9']);//金额
			$s4 =explode('|',$fee_rs['s4']);
			$s5 =explode('|',$fee_rs['s5']);

			$ulevel = $ulevel;
			$newlv = $ulevel-1;
			$oldlv  = $fck_rs['u_level']-1;
			
			//金额
			$new_m = $s3[$newlv];
			$old_m = $s3[$oldlv];
			$need_m = $new_m-$old_m;
			
			//单量
			$new_dl = $s2[$newlv];
			$old_dl = $s2[$oldlv];
			$need_dl = $new_dl-$old_dl;

			if($fck_rs['u_level'] >=$ulevel){
				$this->error('升级参数不正确！');
			}

 			if($fck_rs['u_level'] ==6){
				$this->error('已经是最高级，无法再升级！');
			}

			$content = $_POST['content'];		//备注
			if (empty($content)){
// 				$this->error('备注不能为空!');
// 				exit;
			}

			// 写入帐号数据
			$data['uid']				= $uid;
			$data['user_id']			= $fck_rs['user_id'];
			$data['money']				= 0;//补差额
			$data['u_level']			= $fck_rs['u_level'];//旧的
			$data['up_level']			= $ulevel;//新的
			$data['create_time']		= time();
			$data['pdt']				= time();
			$data['danshu']				= 0;
			$data['is_pay']				= 1;
			$data['user_name']			= " <font color=red>后台晋级</font>";
			$data['u_bank_name']		= $fck_rs['bank_name'];
			$data['type']				= 0;
            $result = $promo->add($data);
			unset($data);
			if($result) {

// 				$mrs = $fck->where('id ='.$uid)->field('id,re_id,user_id,treeplace,re_path,p_path')->find();
				
				$fck->query("update __TABLE__ set u_level=".$ulevel.",cpzj=".$new_m.",f4=".$new_dl." where `id`=".$uid);
				
				unset($fck,$fee,$promo);
				$bUrl = __URL__.'/adminMenberJinji/uid/'.$uid;
				$this->_box(1,'晋级成功！',$bUrl,3);
			}else{
				$this->error('晋级失败！');
				exit;
			}
		}else{
			$this->error('错误！');
			exit;
		}
	}

}
?>