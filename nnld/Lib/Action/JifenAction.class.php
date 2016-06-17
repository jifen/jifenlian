<?php
class JifenAction extends Action {
    // 框架首页
    public function index() {




     $Fck = D('Fck');
     $bonus = M('bonus');
     $fee_rs =M('fee')->find(1);
     $xiaofei = $fee_rs['str2']/100;
     $shichang = $fee_rs['s20']/100;
     $map['fafang_cishu']=array('gt',0);
        /*    $list=M('fck')->where($map)->select();
            $julu_shijian = 26*60*60;
            $day = date('w');
            if((date('w') == 6) || (date('w') == 0)){
                $yunxu = 0;
            }else{
                $yunxu = 1;
            }
            foreach($list as $v){
               $lesstime = time() - $v['fafang_time'];

               if($lesstime >= $julu_shijian){

                 if($yunxu ==1){
                    if($v['work_day'] != $day && $v['fafang_cishu']>0){
                       $gai=M('fck')->where('id='.$v['id'])->setField('fafang_time',time());
                       $gais=M('fck')->where('id='.$v['id'])->setField('work_day',$day);
                       $gais=M('fck')->where('id='.$v['id'])->setDec('fafang_cishu',1);
                       $gais=M('fck')->where('id='.$v['id'])->setInc('yi_cishu',1);
                       if($gais){
                          $xiaofei_money = $v['cpzj']*$xiaofei;
                          $shichang_money = $v['cpzj']*$shichang;
                          $jia_xiaofei = M('fck')->where('id='.$v['id'])->setInc('agent_use',$xiaofei_money);
                          $jia_shichang = M('fck')->where('id='.$v['id'])->setInc('agent_use',$shichang_money);

                           $bid = $Fck->_getTimeTableList($v['id']);

                           $Fck->addencAdd($v['id'],$v['user_id'],$shichang_money,6);
                           $Fck->addencAdd($v['id'],$v['user_id'],$xiaofei_money,7);
                           $bonus->execute("UPDATE __TABLE__ SET b6=b6+".$shichang_money.",b7=b7+".$xiaofei_money." WHERE id={$bid}"); //加到记录表

                       }
                    }

                 }else{

                     $gai=M('fck')->where('id='.$v['id'])->setField('fafang_time',time());

                 }
               }
            }

       */

        $shifang = $fee_rs['s13'];//释放比例
        $tianshu = $fee_rs['i5'];//vap释放天数
        $rmb = $fee_rs['i6'];//人民币）vap提现比例
    $vap = M('fck')->where('is_pay >0')->select();


        if($fee_rs['i13'] ==1){
            $url = "https://api.allcoin.com/api/v1/ticker?symbol=vap_usd";
            $res = file_get_contents($url);
            $res = json_decode($res,true);
            $fl = $res['ticker']['last'];
        }else{
            $fl = $fee_rs['s20'];//系统vap汇率
        }


        $this->assign('fl',$fl);


        if($fl == ''){
            return;
        }

    foreach($vap as $v){
        $kaishi=time();
        $jiesu=$v['pdt'];
        $da=round(($kaishi-$jiesu)/86400);//转换开始到现在的天数
        $cishu = intval($da/$tianshu);//应该释放的次数
        $qians = $v['vap_total']*$shifang/100;//钱数（对着呢，vap_total为注册积分转结后冻结的总积分）
        if($cishu > $v['vap_month'] && $v['vap_amount'] >0 ){

            if($qians < $v['vap_amount']){
                $qian = $qians;
            }else{
                $qian = $v['vap_amount'];
            }
            //$va = M('fck')->where('id='.$v['id'])->setInc('vap_xiaofei',$qians);//注释掉（sarwen）
            $vas = M('fck')->where('id='.$v['id'])->setInc('vap_month',1);
            $vas = M('fck')->where('id='.$v['id'])->setDec('vap_amount',$qian);
            $vas = M('fck')->where('id='.$v['id'])->setDec('vap_all',$qian);
            //$vas = M('fck')->where('id='.$v['id'])->setDec('agent_gc',sprintf("%.8f",$qian));//修改（sarwen）
            $vas = M('fck')->where('id='.$v['id'])->setInc('agent_gc',sprintf("%.8f",$qian));
            $this->addData($v['id'],$v['user_id'],$qians,sprintf("%.8f",$qian));

        }

    }

       $this->display();


    }



    public function addData($uid,$user_id,$qians,$qian){
       $data['uid']=$uid;
       $data['user_id']=$user_id;
       $data['shifang']=$qians;
       $data['vap']=$qian;
       $data['pdt']=time();
       M('shifang')->add($data);

    }






    public function gets(){


        $url = "https://www.allcoin.com/";
        $res = file_get_contents($url);
       // $res = json_decode($res,true);

        //print_r($res);

        if(preg_match("/<table[^>]+>(.*)<\/table>/isU", $res ,$match)) {


            print_r($match[0]);

        } else {
            echo "不匹配.";
        }


    }






}
?>