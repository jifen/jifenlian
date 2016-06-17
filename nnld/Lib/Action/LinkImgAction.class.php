<?php
class LinkImgAction extends CommonAction{

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
				$bUrl = __URL__ . '/index';
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
			case 5;
				$_SESSION['UrlszUserpass'] = 'MyssGuanIMG';//求购股票
				$bUrl = __URL__ . '/linkImg';
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
			case 1;
				$_SESSION['UrlszUserpass'] = 'MyssGuanChanPin';
				$bUrl = __URL__ . '/index';
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
			case 5;
				$_SESSION['UrlszUserpass'] = 'MyssGuanIMG';//求购股票
				$bUrl = __URL__ . '/linkImg';
				$this->_boxx($bUrl);
				break;
			default;
				$this->error('三级密码错误!');
				break;
		}
	}

	//前台显示
	public function linkImg(){
		if ($_SESSION['UrlszUserpass'] == 'MyssGuanIMG'){
			$product = M('img');
			$map = array();
			
			$map['id'] = array('gt',0);
			$orderBy = 'id desc';
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


	public function index(){
		$this->_Admin_checkUser();
		if ($_SESSION['UrlszUserpass'] == 'MyssGuanChanPin'){
			$product = M('img');
			$title = $_REQUEST['stitle'];
			$map = array();
			if(strlen($title)>0){
				$map['name'] = array('like','%'. $title .'%');
			}
			$map['id'] = array('gt',0);
			$orderBy = 'id desc';
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
	public function linkedit(){
		$this->_Admin_checkUser();
		$EDid = $_GET['EDid'];
		$field = '*';
		$product = M ('img');
		$where = array();
		$where['id'] = 14;
		$rs = $product->where($where)->field($field)->find();
		if ($rs){
			$this->assign('rs',$rs);
			$this->us_fckeditor('content',$rs['content'],400,"96%");

			$cptype = M('cptype');
			$list = $cptype->where('status=0')->order('id asc')->select();
			$this->assign('list',$list);
                        
			$this->display('linkedit');
		}else{
			$this->error('没有该信息！');
			exit;
		}
	}

	//产品表修改保存
	public function link_edit_save(){
		$this->_Admin_checkUser();
		$product = M ('img');
		$data = array();
		//h 函数转换成安全html
		//$money = trim($_POST['money']);
		//$a_money = $_POST['a_money'];
		//$b_money = $_POST['b_money'];
		//$content = stripslashes($_POST['content']);
		$title = trim($_POST['title']);
		$cid = trim($_POST['cid']);
		$image = $_POST['image'];
		$ctime = trim($_POST['ctime']);
		//$ccname = $_POST['ccname'];
		//$xhname = $_POST['xhname'];
		//$cptype = trim($_POST['cptype']);
		//$cptype = (int)$cptype;
		$ctime = strtotime($ctime);
		if (empty($title)){
			$this->error('标题不能为空!');
			exit;
		}
		if (empty($cid)){
			$this->error('跳转地址不能为空!');
			exit;
		}

		if(!empty($ctime)){
			$data['create_time'] = $ctime;
		}
		$data['cid'] = $cid;
		//$data['ccname'] = $ccname;
		//$data['xhname'] = $xhname;
		//$data['money'] = $money;
		//$data['a_money'] = $a_money;
		//$data['b_money'] = $b_money;
		$data['name'] = $title;
		//$data['content'] = $content;
		//$data['cptype'] = $cptype;

		$data['img'] = $image;

		$data['id'] = 14;
                
		$rs = $product->save($data);
		if (!$rs){
			$this->error('编辑失败！');
			exit;
		}
		$bUrl = __URL__.'/index';
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

			$this->display('linkadd');
			exit;
		}
		$product = M ('img');
		switch ($action){
			case '删除';
				$wherea=array();
				$wherea['id'] = array('in',$PTid);
				$rs = $product->where($wherea)->delete();
				if ($rs){
					$bUrl = __URL__.'/index';
					$this->_box(1,'操作成功',$bUrl,1);
					exit;
				}else{
					$bUrl = __URL__.'/index';
					$this->_box(0,'操作失败',$bUrl,1);
				}
				break;
			case '屏蔽';
				$wherea=array();
				$wherea['id'] = array('in',$PTid);
				$rs = $product->where($wherea)->setField('yc_cp',1);
				if ($rs){
					$bUrl = __URL__.'/index';
					$this->_box(1,'屏蔽成功',$bUrl,1);
					exit;
				}else{
					$bUrl = __URL__.'/index';
					$this->_box(0,'屏蔽失败',$bUrl,1);
				}
				break;
			case '解除屏蔽';
				$wherea=array();
				$wherea['id'] = array('in',$PTid);
				$rs = $product->where($wherea)->setField('yc_cp',0);
				if ($rs){
					$bUrl = __URL__.'/index';
					$this->_box(1,'解除屏蔽成功',$bUrl,1);
					exit;
				}else{
					$bUrl = __URL__.'/index';
					$this->_box(0,'解除屏蔽失败',$bUrl,1);
				}
				break;
			default;
				$bUrl = __URL__.'/index';
				$this->_box(0,'操作失败',$bUrl,1);
				break;
		}
	}

	//产品表添加保存
	public function link_inserts(){
		$this->_Admin_checkUser();
		$product = M('img');

		$data = array();
		//h 函数转换成安全html
		//$content = trim($_POST['content']);
		$title = trim($_POST['title']);
		$cid = trim($_POST['cid']);
		$image = trim($_POST['image']);
		//$money = $_POST['money'];
		//$a_money = $_POST['a_money'];
		//$b_money = $_POST['b_money'];
		//$ccname = $_POST['ccname'];
		//$xhname = $_POST['xhname'];
		//$cptype = (int)$_POST['cptype'];
		if (empty($title)){
			$this->error('标题不能为空!');
			exit;
		}
		if (empty($cid)){
			$this->error('跳转地址不能为空!');
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
		

		$data['name'] = $title;
		$data['cid'] = $cid;
		//$data['content'] = stripslashes($content);
		$data['img'] = $image;
		$data['create_time'] = mktime();
		//$data['money'] = $money;
		//$data['a_money'] = $a_money;
		//$data['b_money'] = $b_money;
		//$data['ccname'] = $ccname;
		//$data['xhname'] = $xhname;
		//$data['cptype'] = $cptype;
		$form_rs = $product->add($data);
		if (!$form_rs){
			$this->error('添加失败');
			exit;
		}
		$bUrl = __URL__.'/index';
		$this->_box(1,'操作成功',$bUrl,1);
		exit;
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