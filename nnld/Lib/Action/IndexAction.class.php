<?php
class IndexAction extends CommonAction {
	// 框架首页
	public function index() {
		ob_clean();
		$this->_checkUser();
		$this->_Config_name();//调用参数
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		$fck = D ('Fck');

		$fck2=M('fck2');

		$id = $_SESSION[C('USER_AUTH_KEY')];
		$field = '*';
		$fck_rs = $fck -> field($field) -> find($id);

		$fck_rss = $fck2 -> field($field)->where('uid='.$id) -> find();

		$HYJJ="";
		$this->_levelConfirm($HYJJ,1);
		$this->assign('voo',$HYJJ);//会员级别

		$this -> assign('fck_rs',$fck_rs);
		$this -> assign('fck_rss',$fck_rss);

		$fck->emptyTime();
		// $fck->fenhong();

		$ydate = strtotime(date('Y-m-d'));//当天时间
		$end_date =$ydate + (24*3600);//当天结束时间

		$fee_rs = M('fee')->find();

		$fee_i4 = $fee_rs['i4'];

		$gg = $fee_rs['str29'];

		$this -> assign('gg',$gg);

		$this -> assign('fee_i4',$fee_i4);


		$this -> assign('fee_i10',$fee_rs['i10']);
		$this -> assign('fee_i11',$fee_rs['i11']);
		$this -> assign('fee_i12',$fee_rs['i12']);
		$arss = $this->_cheakPrem();
        $this->assign('arss',$arss);

        $map = array();
		$map['s_uid']   = $id;   //会员ID
		$map['s_read'] = 0;     // 0 为未读
		$map['s_del'] = 0;     // 0 为未删除
        $info_count = M ('msg') -> where($map) -> count(); //总记录数
		$this -> assign('info_count',$info_count);
		
//		$this->aotu_clearings();


		$this->display('index');

/*
        $fcksheng=M('fck2')->where('uid='.$id)->find();
		if($fcksheng['u_level']<3){
			if($fcksheng['u_level']<$fcksheng['sheng']){
				$this->checkInfos($fcksheng['sheng']);
			}
		}



		$fuck['get_uid']=array('eq',$id);
		$fuck['is_ok']=array('eq',0);
		$sheng=M('uplevel')->where($fuck)->select();
		foreach($sheng as $v){
			$fcks=M('fck')->where('id='.$v['pay_uid'])->find();
			$this->Upevel($v['up_level'],$fcks['user_id']);

		}
*/






	}


	public function Upevel($up_level,$user_id){

		$content  = '==温馨提示您==';
		$content .= '\n\n';
		$content .= '您的下级会员'.$user_id.'已经申请晋级'.$up_level.'级,请进入[晋级管理]审核';
		$content .= '\n\n';
		echo "<script>alert('". $content ."');</script>";

	}




	public function checkInfos($ceng){
		    $sheng = $ceng;
			$content  = '==温馨提示您==';
			$content .= '\n\n';
			$content .= '您的'.$ceng.'层会员已经快排满,请您尽快[我要晋级]升'.$sheng.'级,请注意B网倒计时,超时会被锁定';
			$content .= '\n\n';
			echo "<script>alert('". $content ."');</script>";

	}


	public function checkInfo(){
        if (empty($_SESSION['LoginCheck'])){
            $content  = '=============================告示====================================';
            $content .= '\n\n';
            $content .= '本系统是测试系统,只供测试使用,不得做任何商业用途,';
            $content .= '\n\n';
            $content .= '在测试过程中,数据丢失或者系统有变动,所造成的损失,公司概不负责。';
            $content .= '\n\n';
            $content .= '如要正式使用系统，请尽快测试完善系统，';
            $content .= '\n\n';
            $content .= '测试完成后在通知负责人给您转成正式的使用。谢谢合作。';
            $content .= '\n\n';
            $content .= '=====================================================================';
            $url = __APP__.'/';
            $_SESSION['LoginCheck'] = '2';
            echo "<script>alert('". $content ."');location.href='". $url ."';</script>";
        }
    }


    //每日自动结算
	public function aotu_clearings(){

		$fck = D ('Fck');
		$fee = M ('fee');
		$now_dtime = strtotime(date("Y-m-d"));
		if(empty($_SESSION['auto_cl_ok'])||$_SESSION['auto_cl_ok']!=$now_dtime){
			$js_c = $fee->where('id=1 and f_time<'.$now_dtime)->count();
			if($js_c>0){
//                            $fck->wlf();
				//日分红
//				$fck->ri_fenhong();
				//全部奖金结算
//				$this->_clearing();
			}
			$_SESSION['auto_cl_ok'] = $now_dtime;
		}
		if(empty($_SESSION['auto_cl_bbok'])||$_SESSION['auto_cl_bbok']!=$now_dtime){
			$js_ctt = $fck->where('is_pay>0 and is_lock=0 and b0!=0')->count();
			if($js_ctt>0){
//				$this->_clearing();//全部奖金结算
			}
			$_SESSION['auto_cl_bbok'] = $now_dtime;
		}
	}

}
?>