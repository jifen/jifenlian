<?php
// 本类由系统自动生成，仅供测试用途
class CallbackAction extends Action {
	
	//接收
    public function receive()
    {
    	$fee = M('fee');
    	$fee_rs = $fee->field('str17,str18')->find();
    	$fee_rs17 = $fee_rs['str17'];//商户号
    	$fee_rs18 = $fee_rs['str18'];//密钥
    	unset($fee,$fee_rs);
		//MD5私钥
		$MD5key = $fee_rs18;

		//订单号
		$BillNo = $_POST["BillNo"];
		$order_no = $BillNo;
		//金额
		$Amount = $_POST["Amount"];
		$order_amount = $Amount;
		//支付状态
		$Succeed = $_POST["Succeed"];
		//支付结果
		$Result = $_POST["Result"];
		//取得的MD5校验信息
		$SignMD5info = $_POST["SignMD5info"]; 
		//备注
		$Remark = $_POST["Remark"];

		//校验源字符串
	  	$md5src = $BillNo."&".$Amount."&".$Succeed."&".$MD5key;
	  	//MD5检验结果
		$md5sign = strtoupper(md5($md5src));
		

 	// <!-- MD5验证成功 -->
 	if ($SignMD5info==$md5sign){
		if ($Succeed=="88") { 
			$remit = M('remit');
			$chongzhi = M('chongzhi');
			$history = M('history');
			$fck = M('fck');
			$where = array();
			$where['orderid'] = array('eq',$order_no);
			$where['is_pay'] = array('eq',0);
			$ors = $remit->where($where)->find();

						if($ors){
					$tid = $ors['id'];
					$uid = $ors['uid'];
					$usid = $ors['user_id'];
					$money = $ors['amount'];

					$oresult = $remit->execute("update __TABLE__ set is_pay=1,ok_time=".mktime()." where is_pay=0 and id=".$tid);
					if($oresult){

						$data = array();
						$data['uid']			= $uid;
						$data['user_id']		= $usid;
						$data['action_type']	= 21;
						$data['pdt']			= mktime();
						$data['epoints']		= $money;
						$data['did']			= 0;
						$data['allp']			= 0;
						$data['bz']				= '21';
						$history->add($data);
						unset($data);
						
						$data = array();
						$data['uid']	= $uid;
						$data['user_id']= $usid;
						$data['rdt']	= time();
						$data['pdt']	= time();
						$data['epoint']	= $money;
						$data['is_pay']	= 1;
						$data['stype']	= 0;
						$data['on_line']= 1;
						$chongzhi->add($data);
						unset($data);

						$fck->query("update __TABLE__ set agent_cash=agent_cash+".$money." where id=".$uid);
					}
				}else{
					$errStr = '';
					switch ($Succeed) {
						case '1':
							$errStr = "高风险卡";
							break;
						case '2':
							$errStr = "黑卡";
							break;
						case '3':
							$errStr = "交易金额超过单笔限额";
							break;
						case '4':
							$errStr = "本月交易金额超过月限额";
							break;
						case '5':
							$errStr = "同一Ip发生多次交易";
							break;
						case '6':
							$errStr = "同一邮箱发生多次交易";
							break;
						case '7':
							$errStr = "同一卡号发生多次交易";
							break;
						case '8':
							$errStr = "同一Cookies发生多次交易";
							break;
						case '9':
							$errStr = "Maxmind分值过高。";
							break;
						case '10':
							$errStr = "高风险卡";
							break;
						case '16':
							$errStr = "通道未开通";
							break;
						case '17':
							$errStr = "黑卡bean";
							break;
						case '18':
							$errStr = "系统出现异常";
							break;
						case '23':
							$errStr = "商户交易卡种不正确";
							break;
						case '26':
							$errStr = "金额超过限定值（50000）";
							break;
						default:
							$errStr = "未知";
							break;
					}

					$whe = array();
					$whe['orderid'] = array('eq',$order_no);
					$urs = $remit->where($whe)->field('id')->find();
					if(!$urs){
						$ctdir = "./ErrorLog";
						$ctname = "pay_".date("Y").date("m").date("d");
						$daytime = date("Y-m-d H:i:s");
						$errdata = "时间：".$daytime."。订单号：".$order_no."支付成功，支付金额：".$order_amount."，但充值失败。原因：".$errStr;

						$this->create_txt($ctdir,$ctname,$errdata);
					}
					unset($urs);
				}
				unset($remit,$fck,$history,$chongzhi,$where,$ors);

				$zf_ok = 1;
				$zf_re = "充值支付成功。";
				$zf_or = "订单号：".$order_no;
				$zf_am = "支付金额：".$order_amount;
	    }
		else 
		{
			$zf_re = "支付失败。";
	 	} 
 		$this->assign('zf_re',$zf_re);
		$this->assign('zf_or',$zf_or);
		$this->assign('zf_am',$zf_am);
		if($notify_type=="offline_notify"){
			echo "SUCCESS";
		}
		$this->display();
 	}

 }

    
	//建立文件
	private function create_txt($ctdir="./ErrorLog",$ctname="",$data="",$err){

		$hz = "txt";
		$dir = $ctdir."/".$ctname.".".$hz;
		$data = $data."\r\n";
		$sql=mb_convert_encoding($data, "UTF-8", "auto");//自动转码
		if(!is_dir($ctdir)){
			mkdir($ctdir, 0777);//创建文件夹
		}
		$oldsql = file_get_contents($dir);
		$newsql = $oldsql.$sql;
		$handle = fopen($dir, "w");
		if (!$handle){
			$err .= "<li>打开文件".$dir."失败!</li>";
		}
		if (!fwrite($handle, $newsql)){
			$err .= "<li>写入文件".$dir."失败!</li>";
		}
		fclose($handle);
	}
}
?>