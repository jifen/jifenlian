<?php
class Gouwu1Action extends CommonAction{

    function _initialize() {
		$this->_inject_check(0); //调用过滤函数
		$this->_checkUser();
		header("Content-Type:text/html; charset=utf-8");
	}

    //二级验证
    public function Cody(){
        //$this->_checkUser();
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
		$list   =  $cody->where("c_id=$UrlID")->field('c_id')->find();
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
	public function Codys() {
		$Urlsz = $_POST['Urlsz'];
		if(empty($_SESSION['user_pwd2'])){
			$pass = $_POST['oldpassword'];
			$fck = M('fck');
			if (!$fck->autoCheckToken($_POST)) {
				$this->error('页面过期请刷新页面!');
				exit ();
			}
			if (empty ($pass)) {
				$this->error('二级密码错误!');
				exit ();
			}
			$where = array ();
			$where['id'] = $_SESSION[C('USER_AUTH_KEY')];
			$where['passopen'] = md5($pass);
			$list = $fck->where($where)->field('id')->find();
			if ($list == false) {
				$this->error('二级密码错误!');
				exit ();
			}
			$_SESSION['user_pwd2'] = 1;
		}else{
			$Urlsz = $_GET['Urlsz'];
		}
		switch ($Urlsz) {
			case 1;
				$_SESSION['UrlszUserpass'] = 'MyssGuanChanPin';
				$bUrl = __URL__ . '/pro_index';
				$this->_boxx($bUrl);
				break;
			case 2;
				$_SESSION['UrlszUserpass'] = 'MyssWuliuList';
				$bUrl = __URL__ . '/adminLogistics';
				$this->_boxx($bUrl);
				break;
			case 3;
				$_SESSION['UrlszUserpass'] = 'ACmilan';
				$bUrl = __URL__ . '/Buycp';
				$this->_boxx($bUrl);
				break;
			case 4;
				$_SESSION['UrlszUserpass'] = 'manlian';//求购股票
				$bUrl = __URL__ . '/BuycpInfo';
				$this->_boxx($bUrl);
				break;
			default;
				$this->error('二级密码错误!');
				break;
		}
	}

	//显示产品信息
    public function Cpcontent() {

		$cp = M('shangpin');
		$fck = M('fck');
		$product = M ('shangpin');
		$PID = (int) $_GET['id'];
		if (empty($PID)){
			$this->error('错误!');
			exit;
		}
		$fck = M('fck');
		$map['id'] = $_SESSION[C('USER_AUTH_KEY')];
		$f_rs = $fck->where($map)->find();

		$where = array();
		$where['id'] = $PID;
		$where['yc_cp'] = array('eq',0);
		$prs = $product->where($where)->field('*')->find();
		if ($prs){
			$this->assign('prs',$prs);
        	$w_money = $prs['a_money'];
			$cc[$prs['id']] = $w_money;
	        $this->assign('cc',$cc);

			$this->assign('f_rs', $f_rs);
			$this->display('Cpcontent');
		}
	}



    public function Buycp() { //购买产品页
		$cp = M('shangpin');
		$fck = M('fck');
		$map['id'] = $_SESSION[C('USER_AUTH_KEY')];
		$f_rs = $fck->where($map)->find();

		$where = array();
		$ss_type = (int) $_REQUEST['tp'];
		if($ss_type>0){
			$where['cptype'] = array('eq',$ss_type);
		}
		$this->assign('tp',$ss_type);

		$where['yc_cp'] = array('eq',0);


		$cptype = M('cptype');
		$types['status'] =0;

		$tplist = $cptype->where($types)->order('id asc')->select();
		$this->assign('tplist',$tplist);
		

		$order = 'id asc';
	    $field   = '*';
        //=====================分页开始==============================================
        import ( "@.ORG.ZQPage" );  //导入分页类
        $count = $cp->where($where)->count();//总页数
   		$listrows = 20;//每页显示的记录数
        $page_where = 'tp='.$ss_type;//分页条件
        $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
        //===============(总页数,每页显示记录数,css样式 0-9)
        $show = $Page->show();//分页变量
        $this->assign('page',$show);//分页变量输出到模板
        $list = $cp->where($where)->field($field)->order('id asc')->page($Page->getPage().','.$listrows)->select();


		
        //=================================================
        foreach($list as $voo){
			$w_money = $voo['a_money'];
			$cc[$voo['id']] = $w_money;
        }
        $this->assign('cc',$cc);
		$this->assign('list',$list);//数据输出到模板

		$this->assign('f_rs', $f_rs);
		$this->display('Buycp');
	}
	
	

	public function shopCar(){
		$pora = M('shangpin');
		$fck = M('fck');

		$map['id'] = $_SESSION[C('USER_AUTH_KEY')];
		$f_rs = $fck->where($map)->find();

		$id = $_REQUEST['id'];

		$arr = $_SESSION["shopping"];


		if(empty($arr)){
			$url = __URL__.'/Buycp';
			$this->_box(0,'您的购物车里没有商品！',$url,1);
			exit;
		}
		$rs = explode('|',$arr);
		$path = ',';
		foreach ($rs as $vo){
			$str = explode(',',$vo);
			$path .= $str[0].',';
			$ids[$str[0]] = $str[1];
		}

		$where['id'] = array('in','0'. $path .'0');
	//	$where['type'] = array('eq',2);
		$list = $pora -> where($where) ->select();
		foreach ($list as $lvo){
			$w_money = $lvo['a_money'];
			//物品总价

			$ep[$lvo['id']] = $ids[$lvo['id']] * $w_money;
			$num[$lvo['id']] = $ids[$lvo['id']];

			//所有商品总价
			$eps += $ids[$lvo['id']] * $w_money;
			$sum += $ids[$lvo['id']];

			$cc[$lvo['id']] = $w_money;
		}

		$bza = $_SESSION["shopping_bz"];
		$blrs = explode("|",$bza);
		$bzz = array();
		foreach($blrs as $vvv){
			$vava = explode(",",$vvv);
			$bzz[$vava[0]] = $vava[1];
		}
		$this->assign('bzz',$bzz);
		$this->assign('cc',$cc);
		$this->assign('list',$list);
		$this->assign('path',$path);
		$this->assign('ids',$ids);
		$this->assign('num',$num);
		$this->assign('sum',$sum);
		$this->assign('eps',$eps);
		$this->assign('ep',$ep);

		$this->display('shopCar');

	}

	public function delBuyList(){
		$ID = $_REQUEST['id'];
		$shopping_id ='';
		$arr = $_SESSION["shopping"];

		$rs = explode('|',$arr);
		$path = ',';
		foreach ($rs as $key=>$vo){
			$str = explode(',',$vo);
			if($str[0] == $ID){
				unset($rs[$key]);
			}else{
				if(empty($shopping_id)){
					$shopping_id = $vo;
				}else{
					$shopping_id .= '|'.$vo;
				}
			}
		}
		$_SESSION["shopping"] = $shopping_id;
		$this->success("删除成功！");
	}
	public function reset(){
		//清空购物车
		$_SESSION["shopping"] = array();
		$_SESSION["shopping_bz"] = array();
		$url = __URL__.'/Buycp';
		$this->success("清空完成！");
	}
	public function chang(){
		$ID = $_GET['DID'];
		$nums = $_GET['nums'];
		$arr = $_SESSION["shopping"];
		$rs = explode('|',$arr);
		$shopping_id = '';
		foreach ($rs as $key=>$vo){
			$str = explode(',',$vo);
			if($str[0] == $ID){
				$str[1] = $nums;
			}
			$s_id = $str[0].','.$str[1];
			if(empty($shopping_id)){
				$shopping_id = $s_id;
			}else{
				$shopping_id .= '|'.$s_id;
			}
		}
		$_SESSION["shopping"] = $shopping_id;
	}

	public function chang_bz(){
		$ID = $_GET['DID'];
		$nums = trim($_GET['bzz']);

		if (!empty($nums)){
			import ( "@.ORG.KuoZhan" );  //导入扩展类
            $KuoZhan = new KuoZhan();
            if ($KuoZhan->is_utf8($nums) == false){
                $nums = iconv('GB2312','UTF-8',$nums);
            }
            unset($KuoZhan);
		}
		if(empty($_SESSION["shopping_bz"])){
			$_SESSION["shopping_bz"] = $ID.",".$nums;
		}
		$arr = $_SESSION["shopping_bz"];

		$rs = explode('|',$arr);
		$shopping_id = '';
		$tong = 0;
		foreach ($rs as $key=>$vo){
			$str = explode(',',$vo);
			if($str[0] == $ID){
				$tong = 1;
				$str[1] = $nums;
			}
			$s_id = $str[0].','.$str[1];
			if(empty($shopping_id)){
				$shopping_id = $s_id;
			}else{
				$shopping_id .= '|'.$s_id;
			}
		}
		if($tong==0){
			$shopping_id .= "|".$ID.",".$nums;
		}
		$_SESSION["shopping_bz"] = $shopping_id;
	}

	public function ShoppingListAdd(){
		$address = M('address');

		$id = $_SESSION[C('USER_AUTH_KEY')];
		$aList = $address->where('uid='.$id)->select();
		$this->assign('aList',$aList);

		$fee = M('fee');
		$fee_rs = $fee->find();
		$s2 =  $fee_rs['s2'];
		
		$str9 = explode("|", $fee_rs['str9']);

		$fck = M('fck');
		$fck_rs = $fck->where('id='.$id)->find();
		$this->assign('fck_rs',$fck_rs);

		// if($fck_rs['shoplx'] == 0){
	//		$zk = 0.9;
		// }else{
			// $zk = $str9[$fck_rs['shoplx']-1]/10;
		// }
		
	/*	 if($fck_rs['is_xf'] >= 1){
           $zk = $s2/10;
		 }else{
			$zk= 1; 
		 }

*/
			$zk= 1; 
		$pora = M('shangpin');
		$arr = $_SESSION["shopping"];
		$rs = explode('|',$arr);
		$path = ',';
		foreach ($rs as $vo){
			$str = explode(',',$vo);
			$ids[$str[0]] = $str[1];
			$path .= $str[0].',';
		}

		$where['id'] = array('in','0'. $path .'0');
		$list = $pora -> where($where) ->select();
		foreach ($list as $lvo){
			$w_money = $lvo['a_money'];
			$z_money = $lvo['a_money'] * $zk;
			//物品总价
			$ep[$lvo['id']] = $ids[$lvo['id']] * $w_money;
			$z_ep[$lvo['id']] = $ids[$lvo['id']] * $z_money;

			//所有商品总价
			$eps += $ids[$lvo['id']] * $w_money;
			$z_eps += $ids[$lvo['id']] * $z_money;
			$sum += $ids[$lvo['id']];

			$cc[$lvo['id']] = $w_money;
		}
		$bza = $_SESSION["shopping_bz"];
		$blrs = explode("|",$bza);
		$bzz = array();
		foreach($blrs as $vvv){
			$vava = explode(",",$vvv);
			$bzz[$vava[0]] = $vava[1];
		}
		$this->assign('bzz',$bzz);

		$this->assign('cc',$cc);

		$this->assign('list',$list);
		$this->assign('path',$path);
		$this->assign('ids',$ids);
		$this->assign('sum',$sum);
		$this->assign('eps',$eps);
		$this->assign('ep',$ep);

		$this->assign('z_eps',$z_eps);
		$this->assign('z_ep',$z_ep);

		$this -> display('ShoppingListAdd');

	}

	public function addAddress(){
		$address = M('address');
		$id =  $_SESSION[C('USER_AUTH_KEY')];
		$did = $_POST['ID'];

		$name = $_POST['s_name'];
		$are = $_POST['s_address'];
		$tel= $_POST['s_tel'];

		$data['uid'] = $id;
		$data['name'] = $name;
		$data['address'] = $are;
		$data['tel'] = $tel;
		$data['moren'] = 0;

		if(empty($did)){
			$result = $address->add($data);
		}else{
			$result = $address->where('id='.$did)->save($data);
		}

		if($result){
			$url = __URL__.'/ShoppingListAdd';
			$this->_box(0,'添加成功！',$url,1);
			exit;
		}else{
			$this->error('添加失败');
		}

	}

	public function moren(){
		$address = M('address');
		$id =  $_SESSION[C('USER_AUTH_KEY')];
		$id = $_GET['ID'];
		$rs  = $address->where('id='.$id)->setField('moren',1);
		$rs2 = $address->where('id !='.$id.' and moren=1')->setField('moren',0);
		if($rs && $rs2){
			echo $id;
		}else{
			echo '0';
		}
	}

	public function addadr(){
		$address = M('address');
		$id = $_GET['ID'];
		$rs  = $address->where('id='.$id)->find();
		$this->assign('rs',$rs);
		$this->assign('did',$id);
		$this -> display('addadr');
	}

	public function delAdr(){
		$address = M('address');
		$id = $_GET['ID'];
		$rs  = $address->where('id='.$id)->delete();
		if($rs){
			$url = __URL__.'/ShoppingListAdd';
			$this->_box(1,'删除地址成功！',$url,1);
			exit;
		}else{
			$this->error('删除失败');
		}
	}

	public function  ShopingSave(){
		$Id = (int) $_SESSION[C('USER_AUTH_KEY')];
		$pora = M('shangpin');
		$address = M('address');
		
		$fck = D('Fck');

		$fee = M('fee');
		$fee_rs = $fee->find();
		$str9 = explode("|", $fee_rs['str9']);
		$s2 =  $fee_rs['s2'];

		$prices = $_POST['prices'];

		$arr = $_SESSION["shopping"];
		if(empty($arr)){
			$this->error("您的购物车里面没有商品！");
			exit;
		}

		$rs = explode('|',$arr);
		$path = ',';
		foreach ($rs as $vo){
			$str = explode(',',$vo);
			$p_rs = $pora->where('id='.$str[0].'')->find();
			if(!$p_rs){
				$this->error("您所购买的产品暂时没货！");
				exit;
			}
		}
		$rs = explode('|',$arr);
		$path = ',';
		foreach ($rs as $vo){
			$str = explode(',',$vo);
			$path .= $str[0].',';
			$ids[$str[0]] = $str[1];
		}

		$fck_rs = $fck->where('id='.$Id) ->find();

		$pw = md5(trim($_POST['Password']));
		if($fck_rs['passopen'] != $pw){
			$this->error('二级密码输入错误!!');
			exit;
		}
//		$USerID =trim($_POST['UserID']) ;
//		$fck_rs1 = $fck->where("user_id='$USerID' and  >= 1")->field('id,user_id')->find();
//
//		if(!$fck_rs1){
//			$this->error('专卖店不存在!!');
//			exit;
//		}

		$aid = $_POST['adid'];
		$ars = $address->where('id='.$aid)->find();
		if(!$ars){
			$this->error('该地址不存在!!');
			exit;
		}

		

		$id = $_SESSION[C('USER_AUTH_KEY')];

		$data = array();
		$data['address']     = $ars['address'];
		$data['username']    = $ars['name'];;
		$data['tel']         = $ars['tel'];;
		$data['uid']         = $id;
		$data['adt']         = strtotime(date('c'));
		$data['is_pay']      = 0;
		$data['p_type']      = 0;//提货类型

		$gwd = array();
		$gwd['uid'] = $id;
		$gwd['user_id'] = $fck_rs['user_id'];
		$gwd['lx'] = 1;
		$gwd['ispay'] = 0;
		$gwd['pdt'] = mktime();
		$gwd['us_name'] = $ars['name'];;
		$gwd['us_address'] = $ars['address'];
		$gwd['us_tel'] = $ars['tel'];;



		$where = array();
		$where['id'] = array('in','0'. $path .'0');
		$prs = $pora->where($where)->select();
		
		$gouwu = M('gouwu');

		// if($fck_rs['shoplx'] == 0){
		//	$zk = 1;
		// }else{
			// $zk = $str9[$fck_rs['shoplx']-1]/10;
		// }
		
	/*	
	 if($fck_rs['is_xf'] >= 1){
           $zk = $s2/10;
		 }else{
			$zk= 1; 
		 }
*/

			$zk= 1; 

		
		
		$have_price = $prices * $zk;
		

		if($fck_rs['agent_gp'] < $have_price){
			$this->error("您的消费基金余额不足，请先充值！");
			exit;
		}

		foreach ($prs as $vo){
			$w_money = $vo['a_money'];
			$z_money = $vo['a_money']*$zk;


			$gwd['did'] = $vo['id'];
			$gwd['money'] = $w_money;
			$gwd['shu'] = $ids[$vo['id']];
			$gwd['cprice'] = $ids[$vo['id']]*$w_money;
			$gwd['pvzhi'] = $ids[$vo['id']]*$z_money;
			//$gwd['type'] = 2;
			$gouwu->add($gwd);

		//	echo $gouwu=M()->getLastSql();die;

		}
		$rs = $fck->query("update __TABLE__ set agent_gp=agent_gp-".$have_price." where id=".$id);
//		$fck->addencAdd($fck_rs['id'],$fck_rs['user_id'], -$prices,22);


		if($rs !== false){
            
		//	$fck->chongxiao($fck_rs['re_path'],$fck_rs['user_id'],$have_price);
			$_SESSION["shopping"]='';
			$_SESSION["shopping_bz"]='';
			$url = __URL__.'/BuycpInfo/';
			$this->_box(1,'购买成功！',$url,1);
			exit;
		}else{
			$this->error("购买失败！");
			exit;
		}
	}

	public function BuycpInfo() {//购买信息
		$cp = M('shangpin');
		$fck = M('fck');
		$gouwu = M('gouwu');
		$id = $_SESSION[C('USER_AUTH_KEY')];
		$map['uid'] = $id;
		$map['guquan'] = array('neq',1);
      //  $map['type'] = array('eq',2);
			 //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $gouwu->where($map)->count();//总页数
       		$listrows = C('ONE_PAGE_RE');//每页显示的记录数
//            $page_where = 'UserID=' . $UserID;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
			
		$where = 'nnld_gouwu.ID>0 and nnld_gouwu.guquan=0  and nnld_gouwu.shu>0 and nnld_gouwu.uid ='.$id;
		
		$field = 'nnld_fck.user_id,nnld_fck.nickname,nnld_product.name,nnld_gouwu.*';
		$join = 'left join nnld_fck ON nnld_gouwu.UID=nnld_fck.id'; //连表查询
		$join1 = 'left join nnld_product ON nnld_gouwu.DID=nnld_product.id'; //连表查询
		$list = $gouwu->where($where)->field($field)->join($join)->join($join1)->order('PDT desc')->page($Page->getPage().','.$listrows)->select();
		
		$rs1 = $gouwu->where($map)->sum('Cprice');
		
		
		$rs2 = $gouwu->where($map)->sum('pvzhi');
		
		$this->assign('count', $rs1);
		$this->assign('count2', $rs2);
		
		$this->assign('list', $list);

		
		
		
		
		$this->display('BuycpInfo');
	}
	
	//产品表查询
	public function pro_index(){
		$this->_Admin_checkUser();
		if ($_SESSION['UrlszUserpass'] == 'MyssGuanChanPin'){
			$product = M('shangpin');
			$title = $_REQUEST['stitle'];
			$map = array();
			if(strlen($title)>0){
				$map['name'] = array('like','%'. $title .'%');
			}
			$map['id'] = array('gt',0);
			$orderBy = 'create_time desc,id desc';
			$field  = '*';
	        //=====================分页开始==============================================
	        import ( "@.ORG.ZQPage" );  //导入分页类
	        $count = $product->where($map)->count();//总页数
	   		$listrows = C('ONE_PAGE_RE');//每页显示的记录数
	   		$listrows = 10;//每页显示的记录数
	        $page_where = 'stitle=' . $title ;//分页条件
	        $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
	        //===============(总页数,每页显示记录数,css样式 0-9)
	        $show = $Page->show();//分页变量
	        $this->assign('page',$show);//分页变量输出到模板
	        $list = $product->where($map)->field($field)->order($orderBy)->page($Page->getPage().','.$listrows)->select();
	        $this->assign('list',$list);//数据输出到模板
	        //=================================================

	        $this->display();
		}else{
            $this->error('错误!');
        }
	}

	//产品表显示修改
	public function pro_edit(){
		$this->_Admin_checkUser();
		$EDid = $_GET['EDid'];
		$field = '*';
		$product = M ('product');
		$where = array();
		$where['id'] = $EDid;
		$rs = $product->where($where)->field($field)->find();
		if ($rs){
			$this->assign('rs',$rs);
			$this->us_fckeditor('content',$rs['content'],400,"96%");

			$cptype = M('cptype');
			$list = $cptype->where('status=0')->order('id asc')->select();
			$this->assign('list',$list);

			$this->display();
		}else{
			$this->error('没有该信息！');
			exit;
		}
	}

	//产品表修改保存
	public function pro_edit_save(){
		$this->_Admin_checkUser();
		$product = M ('product');
		$data = array();
		//h 函数转换成安全html
		$money = trim($_POST['money']);
		$a_money = $_POST['a_money'];
		$b_money = $_POST['b_money'];
		$content = stripslashes($_POST['content']);
		$title = trim($_POST['title']);
		$cid = trim($_POST['cid']);
		$image = $_POST['image'];
		$ctime = trim($_POST['ctime']);
		$ccname = $_POST['ccname'];
		$xhname = $_POST['xhname'];
		$cptype = trim($_POST['cptype']);
		$cptype = (int)$cptype;
		$ctime = strtotime($ctime);
		if (empty($title)){
			$this->error('标题不能为空!');
			exit;
		}
		if (empty($cid)){
			$this->error('商品编号不能为空!');
			exit;
		}
//		if (empty($ccname)){
//			$this->error('商品尺寸不能为空!');
//			exit;
//		}
//		if (empty($xhname)){
//			$this->error('商品型号不能为空!');
//			exit;
//		}
		if (empty($money)||!is_numeric($money)||empty($a_money)||!is_numeric($a_money)){
			$this->error('价格不能为空!');
			exit;
		}
		if($money <= 0||$a_money <= 0){
			$this->error('输入的价格有误!');
			exit;
		}

		if(!empty($ctime)){
			$data['create_time'] = $ctime;
		}
		$data['cid'] = $cid;
		$data['ccname'] = $ccname;
		$data['xhname'] = $xhname;
		$data['money'] = $money;
		$data['a_money'] = $a_money;
		$data['b_money'] = $b_money;
		$data['name'] = $title;
		$data['content'] = $content;
		$data['cptype'] = $cptype;

		$data['img'] = $image;

		$data['id'] = $_POST['ID'];

		$rs = $product->save($data);
		if (!$rs){
			$this->error('编辑失败！');
			exit;
		}
		$bUrl = __URL__.'/pro_index';
		$this->_box(1,'操作成功',$bUrl,1);
		exit;
	}

	//产品表操作（启用禁用删除）
	public function pro_zz(){
		$this->_Admin_checkUser();
		//处理提交按钮
		$action = $_POST['action'];
		//获取复选框的值
		$PTid = $_POST["checkbox"];
		if ($action=='添加'){

			$cptype = M('cptype');
			$list = $cptype->where('status=0')->order('id asc')->select();
			$this->assign('list',$list);

			$this->us_fckeditor('content',"",400,"96%");

			$this->display('pro_add');
			exit;
		}

		$product = M ('shangpin');


		switch ($action){
			case '删除';
				$wherea=array();
				$wherea['id'] = array('in',$PTid);
				$rs = $product->where($wherea)->delete();
				if ($rs){
					$bUrl = __URL__.'/pro_index';
					$this->_box(1,'操作成功',$bUrl,1);
					exit;
				}else{
					$bUrl = __URL__.'/pro_index';
					$this->_box(0,'操作失败',$bUrl,1);
				}
				break;
			case '屏蔽产品';
				$wherea=array();
				$wherea['id'] = array('in',$PTid);
				$rs = $product->where($wherea)->setField('yc_cp',1);
				if ($rs){
					$bUrl = __URL__.'/pro_index';
					$this->_box(1,'屏蔽产品成功',$bUrl,1);
					exit;
				}else{
					$bUrl = __URL__.'/pro_index';
					$this->_box(0,'屏蔽产品失败',$bUrl,1);
				}
				break;
			case '解除屏蔽';
				$wherea=array();
				$wherea['id'] = array('in',$PTid);
				$rs = $product->where($wherea)->setField('yc_cp',0);
				if ($rs){
					$bUrl = __URL__.'/pro_index';
					$this->_box(1,'解除屏蔽成功',$bUrl,1);
					exit;
				}else{
					$bUrl = __URL__.'/pro_index';
					$this->_box(0,'解除屏蔽失败',$bUrl,1);
				}
				break;
			default;
				$bUrl = __URL__.'/pro_index';
				$this->_box(0,'操作失败',$bUrl,1);
				break;
		}
	}

	//产品表添加保存
	public function pro_inserts(){
		$this->_Admin_checkUser();
		$product = M('shangpin');

		$data = array();
		//h 函数转换成安全html
		$content = trim($_POST['content']);
		$title = trim($_POST['title']);
		$cid = trim($_POST['cid']);
		$image = trim($_POST['image']);
		$money = $_POST['money'];
		$a_money = $_POST['a_money'];
		$b_money = $_POST['b_money'];
		$ccname = $_POST['ccname'];
		$xhname = $_POST['xhname'];
		$cptype = (int)$_POST['cptype'];
		if (empty($title)){
			$this->error('商品名称不能为空!');
			exit;
		}
		if (empty($cid)){
			$this->error('商品编号不能为空!');
			exit;
		}
//		if (empty($ccname)){
//			$this->error('商品尺寸不能为空!');
//			exit;
//		}
//		if (empty($xhname)){
//			$this->error('商品型号不能为空!');
//			exit;
//		}
		if (empty($money)||!is_numeric($money)||empty($a_money)||!is_numeric($a_money)){
			$this->error('价格不能为空!');
			exit;
		}
		if($money <= 0||$a_money <= 0){
			$this->error('输入的价格有误!');
			exit;
		}

		$data['name'] = $title;
		$data['cid'] = $cid;
		$data['content'] = stripslashes($content);
		$data['img'] = $image;
		$data['create_time'] = mktime();
		$data['money'] = $money;
		$data['a_money'] = $a_money;
		$data['b_money'] = $b_money;
		$data['ccname'] = $ccname;
		$data['xhname'] = $xhname;
		$data['cptype'] = $cptype;
		$form_rs = $product->add($data);
		if (!$form_rs){
			$this->error('添加失败');
			exit;
		}
		$bUrl = __URL__.'/pro_index';
		$this->_box(1,'操作成功',$bUrl,1);
		exit;
	}

	public function cptype_index(){
		$this->_Admin_checkUser();
		if ($_SESSION['UrlszUserpass'] == 'MyssGuanChanPin'){
			$product = M('cptype');
			$map = array();
			$map['id'] = array('gt',0);
			$orderBy = 'id asc';
			$field  = '*';
	        //=====================分页开始==============================================
	        import ( "@.ORG.ZQPage" );  //导入分页类
	        $count = $product->where($map)->count();//总页数
	   		$listrows = 20;//每页显示的记录数
	        $page_where = "" ;//分页条件
	        $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
	        //===============(总页数,每页显示记录数,css样式 0-9)
	        $show = $Page->show();//分页变量
	        $this->assign('page',$show);//分页变量输出到模板
	        $list = $product->where($map)->field($field)->order($orderBy)->page($Page->getPage().','.$listrows)->select();
	        $this->assign('list',$list);//数据输出到模板
	        //=================================================

	        $this->display();
		}else{
            $this->error('错误!');
        }
	}

	public function cptype_edit(){
		$this->_Admin_checkUser();
		$EDid = $_GET['EDid'];
		$field = '*';
		$product = M ('cptype');
		$where = array();
		$where['id'] = $EDid;
		$rs = $product->where($where)->field($field)->find();
		if ($rs){
			$this->assign('rs',$rs);
			$this->display();
		}else{
			$this->error('没有该信息！');
			exit;
		}
	}

	public function cptype_edit_save(){
		$this->_Admin_checkUser();
		$cptype = M ('cptype');
		$title = trim($_POST['title']);
		if (empty($title)){
			$this->error('分类名不能为空!');
			exit;
		}
		$data = array();
		$data['tpname'] = $title;
		$data['id'] = $_POST['id'];
		$rs = $cptype->save($data);
		if (!$rs){
			$this->error('编辑失败！');
			exit;
		}
		$bUrl = __URL__.'/cptype_index';
		$this->_box(1,'操作成功',$bUrl,1);
		exit;
	}

	//处理
	public function cptype_zz(){
		$this->_Admin_checkUser();
		//处理提交按钮
		$action = $_POST['action'];
		//获取复选框的值
		$PTid = $_POST["checkbox"];
		if ($action=='添加'){
			$this->display('cptype_add');
			exit;
		}
		$product = M ('cptype');
		switch ($action){
			case '删除';
				$wherea=array();
				$wherea['id'] = array('in',$PTid);
				$rs = $product->where($wherea)->delete();
				if ($rs){
					$bUrl = __URL__.'/cptype_index';
					$this->_box(1,'操作成功',$bUrl,1);
					exit;
				}else{
					$bUrl = __URL__.'/cptype_index';
					$this->_box(0,'操作失败',$bUrl,1);
				}
				break;
			default;
			$bUrl = __URL__.'/cptype_index';
			$this->_box(0,'操作失败',$bUrl,1);
			break;
		}
	}
	
	//产品表添加保存
	public function cptype_inserts(){
		$this->_Admin_checkUser();
		$product = M('cptype');
		$title = trim($_POST['title']);
		if (empty($title)){
			$this->error('分类名不能为空!');
			exit;
		}
		$data = array();
		$data['tpname'] = $title;
		$form_rs = $product->add($data);
		if (!$form_rs){
			$this->error('添加失败');
			exit;
		}
		$bUrl = __URL__.'/cptype_index';
		$this->_box(1,'操作成功',$bUrl,1);
		exit;
	}

	public function adminLogistics(){
		$this->_Admin_checkUser();//后台权限检测
		//物流管理
		if ($_SESSION['UrlszUserpass'] == 'MyssWuliuList'){
			$shopping = M ('gouwu');
			$product = M('product');
            $UserID = $_REQUEST['UserID'];
            $ss_type = (int) $_REQUEST['type'];
            $map = array();
			if (!empty($UserID)){
				import ( "@.ORG.KuoZhan" );  //导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($UserID) == false){
                    $UserID = iconv('GB2312','UTF-8',$UserID);
                }
                unset($KuoZhan);
				$map['user_id'] = array('like',"%".$UserID."%");
				$UserID = urlencode($UserID);
			}
			if($ss_type==0){
				$map['ispay'] = array('egt',0);
			}elseif($ss_type==1){
				$map['ispay'] = array('eq',0);
				$map['isfh'] = array('eq',0);
			}elseif($ss_type==2){
				$map['ispay'] = array('eq',0);
				$map['isfh'] = array('eq',1);
			}elseif($ss_type==3){
				$map['ispay'] = array('eq',1);
			}
            //查询字段
            $field   = '*';
            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $shopping->where($map)->count();//总页数
            $listrows = C('PAGE_LISTROWS')  ;//每页显示的记录数
		    $page_where = 'UserID='.$UserID.'&type='.$ss_type;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $list = $shopping ->where($map)->field($field)->page($Page->getPage().','.$listrows)->select();
            $this->assign('list',$list);//数据输出到模板
            //=================================================
            foreach($list as $vv){
            	$ttid = $vv['did'];
            	$trs = $product->where('id='.$ttid)->find();
            	$voo[$ttid] = $trs['name'];
            }
            $this->assign('voo',$voo);
            $title = '物流管理';
            $this->assign('title',$title);
            $this->display('adminLogistics');
		}else{
			$this->error('错误!');
			exit;
		}
	}

    public function adminLogisticsAC(){
        //处理提交按钮
        $action = $_POST['action'];
        //获取复选框的值
        $XGid = $_POST['tabledb'];
        if (!isset($XGid) || empty($XGid)){
            $bUrl = __URL__.'/adminLogistics';
            $this->_box(0,'请选择货物！',$bUrl,1);
            exit;
        }
        switch ($action){
            case '确认发货';
                $this->_adminLogisticsOK($XGid);
                break;
            case '确定收货';
                $this->_adminLogisticsDone($XGid);
                break;
            case '删除';
                $this->_adminLogisticsDel($XGid);
                break;
	        default;
	            $bUrl = __URL__.'/adminLogistics';
	            $this->_box(0,'没有该货物！',$bUrl,1);
	            break;
        }
    }

    private function _adminLogisticsOK($XGid){
    	//确定发货
        if ($_SESSION['UrlszUserpass'] == 'MyssWuliuList'){
            $shopping = M ('gouwu');
            $where = array();
            $where['id'] = array ('in',$XGid);
            $where['isfh'] = array ('eq',0);

            $valuearray = array(
            	'isfh' => '1',
            	'fhdt' => mktime()
            );
            $shopping->where($where)->setField($valuearray);
            unset($shopping,$where);

            $bUrl = __URL__.'/adminLogistics';
            $this->_box(1,'发货成功！',$bUrl,1);
            exit;
        }else{
            $this->error('错误!');
        }
    }

    private function _adminLogisticsDone($XGid){
    	//确定发货
        if ($_SESSION['UrlszUserpass'] == 'MyssWuliuList'){
            $shopping = M ('gouwu');

            $where1 = array();
			$where1['id'] = array ('in',$XGid);
            $where1['isfh'] = array ('eq',0);

            $where = array();
            $where['id'] = array ('in',$XGid);
            $where['ispay'] = array ('eq',0);



            $valuearray1 = array(
            	'isfh' => '1',
            	'fhdt' => mktime()
            );

            $valuearray = array(
            	'ispay' => '1',
            	'okdt' => mktime()
            );

            $shopping->where($where1)->setField($valuearray1);
            $shopping->where($where)->setField($valuearray);
            unset($shopping,$where1,$where);

            $bUrl = __URL__.'/adminLogistics';
            $this->_box(1,'确认收货成功！',$bUrl,1);
            exit;
        }else{
            $this->error('错误!');
            exit;
        }
    }

    private function _adminLogisticsDel($XGid){
    	//确定发货
        if ($_SESSION['UrlszUserpass'] == 'MyssWuliuList'){
            $shopping = M ('gouwu');
            $where = array();
            $where['id'] = array ('in',$XGid);
            $shopping->where($where)->delete();
            unset($shopping,$where);

            $bUrl = __URL__.'/adminLogistics';
            $this->_box(1,'删除成功！',$bUrl,1);
            exit;
        }else{
            $this->error('错误!');
        }
    }

    
    /**
     * 上传图片
     * **/
	public function upload_fengcai_pp() {
		$this->_Admin_checkUser();//后台权限检测
        if(!empty($_FILES)) {
            //如果有文件上传 上传附件
            $this->_upload_fengcai_pp();
        }
    }

    protected function _upload_fengcai_pp()
    {
        header("content-type:text/html;charset=utf-8");
        $this->_Admin_checkUser();//后台权限检测
        // 文件上传处理函数

        //载入文件上传类
        import("@.ORG.UploadFile");
        $upload = new UploadFile();

        //设置上传文件大小
        $upload->maxSize  = 1048576 * 2 ;// TODO 50M   3M 3292200 1M 1048576

        //设置上传文件类型
        $upload->allowExts  = explode(',','jpg,gif,png,jpeg');

        //设置附件上传目录
        $upload->savePath =  './Public/Uploads/image/';

        //设置需要生成缩略图，仅对图像文件有效
       $upload->thumb =  false;

       //设置需要生成缩略图的文件前缀
        $upload->thumbPrefix   =  'm_';  //生产2张缩略图

       //设置缩略图最大宽度
        $upload->thumbMaxWidth =  '800';

       //设置缩略图最大高度
        $upload->thumbMaxHeight = '600';

       //设置上传文件规则
//		$upload->saveRule = uniqid;
		$upload->saveRule = date("Y").date("m").date("d").date("H").date("i").date("s").rand(1,100);

       //删除原图
       $upload->thumbRemoveOrigin = true;

        if(!$upload->upload()) {
            //捕获上传异常
            $error_p=$upload->getErrorMsg();
            echo "<script>alert('".$error_p."');history.back();</script>";
        }else {
            //取得成功上传的文件信息
            $uploadList = $upload->getUploadFileInfo();
            $U_path=$uploadList[0]['savepath'];
            $U_nname=$uploadList[0]['savename'];
            $U_inpath=(str_replace('./Public/','__PUBLIC__/',$U_path)).$U_nname;

            echo "<script>window.parent.form1.image.value='".$U_inpath."';</script>";
            echo "<span style='font-size:12px;'>上传完成！</span>";
            exit;

        }
    }

}
?>