<?php
class HuichaoAction extends Action{
	
    /**
     * 汇潮第三方
     * str17 商户号参数
     * str18 密钥参数
     * **/
    public function pay($orderid,$amount)
    {
    	
    	$fee = M('fee');
    	$fee_rs = $fee->field('str17,str18')->find();
    	$fee_rs17 = $fee_rs['str17'];//商户号
    	$fee_rs18 = $fee_rs['str18'];//密钥
    	unset($fee,$fee_rs);
    	
		$MD5key = $fee_rs18;		//MD5私钥
		$MerNo = $fee_rs17;					//商户号
		$BillNo = $orderid;		//[必填]订单号(商户自己产生：要求不重复)
		$Amount = $amount;				//[必填]订单金额

		$ReturnURL = "http://www.fudass.com/phpPay/onlineRechargeResult1.php"; 			//[必填]返回数据给商户的地址(商户自己填写):::注意请在测试前将该地址告诉我方人员;否则测试通不过
		$Remark = "";  //[选填]升级。


		$md5src = $MerNo."&".$BillNo."&".$Amount."&".$ReturnURL."&".$MD5key;		//校验源字符串
		$SignInfo = strtoupper(md5($md5src));		//MD5检验结果


		$AdviceURL = "http://www.fudass.com/phpPay/onlineRechargeResult.php";   //[必填]支付完成后，后台接收支付结果，可用来更新数据库值
		$orderTime = date("YMDHIS");   //[必填]交易时间YYYYMMDDHHMMSS
		// $defaultBankNumber ="BOCSH";   //[选填]银行代码s 
		$defaultBankNumber ="";

		//送货信息(方便维护，请尽量收集！如果没有以下信息提供，请传空值:'')
		//因为关系到风险问题和以后商户升级的需要，如果有相应或相似的内容的一定要收集，实在没有的才赋空值,谢谢。

		$products="在线充值";// '------------------物品信息

		$this->assign('MD5key',$MD5key);
		$this->assign('MerNo',$MerNo);
		$this->assign('BillNo',$BillNo);
		$this->assign('Amount',$Amount);
		$this->assign('ReturnURL',$ReturnURL);
		$this->assign('Remark',$Remark);
		$this->assign('md5src',$md5src);
		$this->assign('SignInfo',$SignInfo);
		$this->assign('AdviceURL',$AdviceURL);
		$this->assign('orderTime',$orderTime);
		$this->assign('defaultBankNumber',$defaultBankNumber);
		$this->assign('products',$products);
    }
	

	
}


?>