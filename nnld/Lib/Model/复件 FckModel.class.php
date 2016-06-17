<?php
class FckModel extends CommonModel {
	//数据库名称

   public function xiangJiao($Pid=0,$DanShu=1){
        //========================================== 往上统计单数
        $where = array();
        $where['id'] = $Pid;
        $field = 'treeplace,father_id';
        $vo = $this ->where($where)->field($field)->find();
        if ($vo){
            $Fid = $vo['father_id'];
            $TPe = $vo['treeplace'];
            $table = $this->tablePrefix.'fck';
            if ($TPe == 0 && $Fid > 0){
                $this->execute("update ". $table ." Set `l`=l+$DanShu, `benqi_l`=benqi_l+$DanShu  where `id`=".$Fid);
            }elseif($TPe == 1 && $Fid > 0){
                $this->execute("update ". $table ." Set `r`=r+$DanShu, `benqi_r`=benqi_r+$DanShu  where `id`=".$Fid);
            }elseif($TPe == 2 && $Fid > 0){
                $this->execute("update ". $table ." Set `lr`=lr+$DanShu, `benqi_lr`=benqi_lr+$DanShu  where `id`=".$Fid);
            }
            if ($Fid > 0) $this->xiangJiao($Fid,$DanShu);
        }
        unset($where,$field,$vo);
    }


    public function addencAdd($ID=0,$inUserID=0,$money=0,$name=null,$UID=0,$time=0,$acttime=0,$bz=""){
        //添加 到数据表
        if ($UID > 0) {
            $where = array();
            $where['id'] = $UID;
            $frs = $this->where($where)->field('nickname')->find();
            $name_two = $name;
            $name = $frs['nickname'] . ' 开通会员 ' . $inUserID ;
            $inUserID = $frs['nickname'];
        }else{
            $name_two = $name;
        }

        $data = array();
        $history = M ('history');

        $data['user_id']		= $inUserID;
        $data['uid']			= $ID;
        $data['action_type']	= $name;
        if($time >0){
        	$data['pdt']		= $time;
        }else{
        	$data['pdt']		= mktime();
        }
        $data['epoints']		= $money;
        if(!empty($bz)){
        	$data['bz']			= $bz;
        }else{
        	$data['bz']			= $name;
        }
        $data['did']			= 0;
        $data['type']			= 1;
        $data['allp']			= 0;
        if($acttime>0){
        	$data['act_pdt']	= $acttime;
        }
        $history ->add($data);
        unset($data,$history);
    }

    public function huikuiAdd($ID=0,$tz=0,$zk,$money=0,$nowdate=null){
        //添加 到数据表

        $data                   = array();
        $huikui                = M ('huikui');
        $data['uid']            = $ID;
        $data['touzi']    = $tz;
        $data['zhuangkuang']            = $zk;
        $data['hk']        = $money;
        $data['time_hk']             = $nowdate;
        $huikui ->add($data);
        unset($data,$huikui);
    }


    //对碰1：1
    public function touch1to1(&$Encash,$xL=0,$xR=0,&$NumS=0){
        $xL = floor($xL);
        $xR = floor($xR);

        if ($xL > 0 && $xR > 0){
            if ($xL > $xR){
                $NumS = $xR;
                $xL = $xL - $NumS;
                $xR = $xR - $NumS;
                $Encash['0'] = $Encash['0'] + $NumS;
                $Encash['1'] = $Encash['1'] + $NumS;
            }
            if ($xL < $xR){
                $NumS = $xL;
                $xL   = $xL - $NumS;
                $xR   = $xR - $NumS;
                $Encash['0'] = $Encash['0'] + $NumS;
                $Encash['1'] = $Encash['1'] + $NumS;
            }
            if ($xL == $xR){
                $NumS = $xL;
                $xL   = 0;
                $xR   = 0;
                $Encash['0'] = $Encash['0'] + $NumS;
                $Encash['1'] = $Encash['1'] + $NumS;
            }
            $Encash['2'] = $NumS;
        }else{
            $NumS = 0;
            $Encash['0'] = 0;
            $Encash['1'] = 0;
        }
    }
    //对碰奖
    public function duipeng(){
		$fee = M ('fee');
        $bonus = M('bonus');
        $fee_rs = $fee->field('s2,s5,s9,s7,s12,s4,s6,str2')->find(1);
        $s4 = explode("|",$fee_rs['s4']);		//各级对碰比例(回本前)
        $s6 = explode("|",$fee_rs['s6']);       //各级对碰比例（回本后）
		$s7 = explode("|",$fee_rs['s7']);		//封顶
        $s2 = explode("|",$fee_rs['s2']);  //各级pv
        $str2 = $fee_rs['str2']/100;
    	$fck_array = 'is_pay>=1 and ((shangqi_l+benqi_l)>0 or (shangqi_r+benqi_r)>0)';
        $field = 'id,user_id,shangqi_l,shangqi_r,benqi_l,benqi_r,re_path,re_level,re_nums,nickname,u_level,re_id,day_feng,re_path,peng_num,zjj,cpzj';
        $frs = $this->where($fck_array)->field($field)->select();
        //BenQiL  BenQiR  ShangQiL  ShangQiR
        $p1 = 3;$p2=1;
        $h1 = 2;$h2= 1;
        $a1 = 1;$a2= 1;
        foreach ($frs as $vo){
            $n1=0;$n2=0;$n3=0;
        	$L = 0;
        	$R = 0;
        	$L = $vo['shangqi_l'] + $vo['benqi_l'];
        	$R = $vo['shangqi_r'] + $vo['benqi_r'];
            $Encash    = array();
            $NumS      = 0;//碰数
            $money     = 0;//对碰奖金额
            $Ls        = 0;//左剩余
            $Rs        = 0;//右剩余
            $Encash['0'] = 0;
            $Encash['1'] = 0;
            if ($L > 0 && $R > 0){ 
                $ttt=0; 
                if($L > $R){
                    $b=$L;
                    $s=$R;
                    $ttt=0;
                }else{
                    $b=$R;
                    $s=$L;
                    $ttt=1;
                }
                for($NumS=0;$b>0&&$s>0;$NumS++){
                    if($b >= 3 && $s >= 1){
                        $b = $b -  $p1;
                        $s = $s -  $p2;
                        $n1 +=1; 
                        $Great = $p1;
                        $Samll = $p2;
                    }elseif ($b >= 2 && $s >= 1) {
                        $b = $b -  $h1;
                        $s = $s -  $h2;
                        $n2 +=1; 
                        $Great = $h1;
                        $Samll = $h2;
                    }elseif ($b >= 1 && $s >= 1) {
                        $b = $b -  $a1;
                        $s = $s -  $a2;
                        $n3 +=1; 
                        $Great = $a1;
                        $Samll = $a2;
                    }

                    if($ttt==0){
                        $Encash['0'] = $Encash['0'] + $Great;
                        $Encash['1'] = $Encash['1'] + $Samll;
                    }else{
                        $Encash['0'] = $Encash['0'] + $Samll;
                        $Encash['1'] = $Encash['1'] + $Great;
                    }

                    if($b <= $s){
                        $temp = $b;
                        $b=$s;
                        $s=$temp;
                        if($ttt==1){
                            $ttt = 0;
                        }else{
                            $ttt = 1;
                        }
                    }
                }
            }

           

        	$Ls = $L - $Encash['0'];
        	$Rs = $R - $Encash['1'];
        	$ss = $vo['u_level']-1;
        	$feng = $vo['day_feng'];
      
           	$money1 =$s2[0] * $n1 * $s4[2]/100;//对碰奖 奖金
            $money2 =$s2[0] * $n2 * $s4[1]/100;
            $money3 =$s2[0] * $n3 * $s4[0]/100;
            if($vo['zjj'] >= $vo['cpzj']){
                $money1 =$s2[0] * $n1 * $s6[2]/100;//对碰奖 奖金
                $money2 =$s2[0] * $n2 * $s6[1]/100;
                $money3 =$s2[0] * $n3 * $s6[0]/100;
            }

            $money = $money1+$money2+$money3;
            

        	if ($feng>=$s7[$ss]){
        		$money=0;
        	}else{
        		$jfeng=$feng+$money;
        		if ($jfeng>$s7[$ss]){
        			$money=$s7[$ss]-$feng;
        		}
        	}

            $glf = $money * $str2;
            $get_money = $money - $glf;

        	$this->query('UPDATE __TABLE__ SET `shangqi_l`='. $Ls .',`shangqi_r`='. $Rs .',`benqi_l`=0,`benqi_r`=0,peng_num=peng_num+'.$NumS.' where `id`='. $vo['id']);

        	if ($money > 0){
                $bid = $this->_getTimeTableList($vo['id']);
                $bonus->execute("UPDATE __TABLE__ SET b0=b0+{$get_money},b3=b3+{$money},b6=b6-{$glf} WHERE id={$bid}"); //加到记录表
                $this->execute("update __TABLE__ set agent_use=agent_use+{$get_money},zjj=zjj+{$money},day_feng=day_feng+".$money." where id=".$vo['id']);//加到fck,agent_cf重复消费
                $this->addencAdd($vo['id'], $vo['user_id'], $money,3); //添加奖金和记录
                $this->addencAdd($vo['id'],$vo['user_id'], -$glf,6);
        	}
        }

    }

    //计算奖金
    public function getusjj($uid,$type=0){
    	$mrs = $this->where('id='.$uid)->find();
    	if($mrs){
			//推荐奖
			$this->tuijj($mrs['id'],$mrs['user_id'],$mrs['cpzj'],$mrs['u_level'],$mrs['re_id']);
			
    		//见点奖
    		$this->jiandianjiang($mrs['p_path'],$mrs['user_id']);
    		
            $this->duipeng();
    		if($type==1){
  			//报单奖
   			 $this->baodanfei($mrs['shop_id'],$mrs['user_id'],$mrs['cpzj']);
    		}
    	}
		unset($mrs);
    }
    
	//直推奖
    public function tuijj($ID=0,$inUserID=0,$cpzj=0,$u_level,$re_id){
        $bonus = M('bonus');
    	$fee = M('fee');
    	$fee_rs = $fee->field('s3,str2')->find(1);
    	$s3 =explode("|", $fee_rs['s3']);
        $str2 = $fee_rs['str2']/100;

    	$where = array();
    	$where['id'] = $re_id;
		$field = 'id,user_id';
    	$frs = $this->where($where)->field($field)->find();
		if ($frs){
			$money = $s3[$u_level-1] * $cpzj /100;
            $glf = $money * $str2;
            $get_money = $money - $glf;
			if($get_money > 0){
				$bid = $this->_getTimeTableList($re_id);
                $bonus->execute("UPDATE __TABLE__ SET b0=b0+{$get_money},b2=b2+{$money},b6=b6-{$glf} WHERE id={$bid}"); //加到记录表
                $this->execute("update __TABLE__ set agent_use=agent_use+{$get_money},zjj=zjj+{$money} where id=".$re_id);//加到fck,agent_cf重复消费
                $this->addencAdd($re_id, $inUserID, $money,2); //添加奖金和记录
                $this->addencAdd($re_id, $inUserID, -$glf,6);
			}
		}
		unset($fee,$fee_rs,$frs,$where);
    }
   
	//见点奖
    public function jiandianjiang($ppath,$inUserID=0){
    	$fee = M('fee');
        $bonus = M('bonus');
    	$fee_rs = $fee->field('s1,s5,str2')->find(1);
    	$s1 = $fee_rs['s1'];
    	$s5 = explode("|", $fee_rs['s5']);
        $str2 = $fee_rs['str2']/100;

		
    
    	$lirs = $this->where('id in (0'.$ppath.'0)')->field('id,l,r,treeplace,re_nums,u_level')->order('p_level desc')->limit($s5[3])->select();
    	
		$i = 0;
		foreach($lirs as $lrs){
            $i++;
            // if($lrs['re_nums'] == 0){
            //     continue;

            // }
            $lev = $lrs['u_level'];
            if($lev > 4){
                $lev = 4;
            }
            // if($lrs['re_nums'] >=3 && $lrs['re_nums']<5){
            //     $lev = 3;
            // }else if($lrs['re_nums'] >= 10){
            //     $lev = 4;
            // }

            $money = $s1;

            if($i>$s5[0] && $lev==1){
                $money = 0;
            }
            if($i>$s5[1] && $lev==2){
                $money = 0;
            }
            if($i>$s5[2] && $lev==3){
                $money = 0;
            }

            $glf = $money * $str2;
		    $get_money = $money - $glf;

            if($get_money > 0){
                $bid = $this->_getTimeTableList($lrs['id']);
                $bonus->execute("UPDATE __TABLE__ SET b0=b0+{$get_money},b4=b4+{$money},b6=b6-{$glf} WHERE id={$bid}"); //加到记录表
                $this->execute("update __TABLE__ set agent_use=agent_use+{$get_money},zjj=zjj+{$money} where id=".$lrs['id']);//加到fck,agent_cf重复消费
                $this->addencAdd($lrs['id'], $inUserID, $money,4); //添加奖金和记录
                $this->addencAdd($lrs['id'], $inUserID, -$glf,6);
            }
			
			
		}
        unset($fee,$fee_rs,$lirs,$lrs);
    }
	

    //报单费
    public function baodanfei($shop_id,$inUserID,$cpzj=0){
		$fee = M('fee');
        $bonus = M('bonus');
    	$fee_rs = $fee->field('s14,str2')->find();
		$s14 = $fee_rs['s14'];
		
        $str2 = $fee_rs['str2']/100;

        $money = $s14 * $cpzj /100;
        $glf = $money * $str2;
        $get_money = $money - $glf;
		
		$frs = $this->where('id='.$shop_id.' and is_pay>0 and is_agent=2')->field('id,u_level')->find();
		if($frs){
			if($money>0){
		    	$bid = $this->_getTimeTableList($shop_id);
                $bonus->execute("UPDATE __TABLE__ SET b0=b0+{$get_money},b5=b5+{$money},b6=b6-{$glf} WHERE id={$bid}"); //加到记录表
                $this->execute("update __TABLE__ set agent_use=agent_use+{$get_money},zjj=zjj+{$money} where id=".$shop_id);//加到fck,agent_cf重复消费
                $this->addencAdd($shop_id, $inUserID, $money,5); //添加奖金和记录
                $this->addencAdd($shop_id, $inUserID, -$glf,6);
		    }
		}
	    unset($fee,$fee_rs,$frs,$s14);
    }
    

	//日分红
	public function ri_fenhong(){
		$bonus = M('bonus');
        $fh = M('fh');
		$nowtime = time();
		$nowday = strtotime(date('Y-m-d'));
		$nowtime = time();
		
		$fee = M('fee');
		$fee_rs = $fee->field('s6,str4,f_time,s12,str2,s11,str5')->find();
		$s6 = explode("|",$fee_rs['s12']);
		$s11 = explode("|",$fee_rs['s11']);
		$f_time = $fee_rs['f_time'];
        $str2 = $fee_rs['str2']/100;
        $str5 =  $fee_rs['str5']/100;
		
		// if($f_time<$nowday){  //正式
		// 	$result = $fee->execute("update __TABLE__ set f_time=".$nowday." where id=1");//正式
        if($f_time<$nowtime){  //测试
         $result = $fee->execute("update __TABLE__ set f_time=".$nowtime." where id=1");//测试
			if($result){
				set_time_limit(0);
				$where = array();
				//$where['f_time'] = array('lt',$nowday);//正式
				
				$rfck = $fh->where($where)->field("*")->select();
				
                foreach($rfck as $vov){
					$id = $vov['id'];
					$usid = $vov['user_id'];
					$fanli_money = $vov['fenh_money'];//已得
                    $mylv = $vov['u_level']-1;
					$max_g = $s11[$mylv];//封顶
					$money = $s6[$mylv] +  $vov['addfh'];//钱
					$fanli_time = $vov['f_time'];//上次分红时间
                   
                    $cha_t = $nowday-$fanli_time;
                    $cha_d = $cha_t/(3600*24);
                    $cha_d = floor($cha_d);
                   // $cha_d = (int)$cha_d; //正式
                    $cha_d = 1;//测试
                    if($cha_d>0){
                       //$result2 = $this->execute("update __TABLE__ set f_time=".$nowday." where f_time=".$fanli_time." and id=".$id); //正式
                       $result2 = $fh->execute("update __TABLE__ set f_time=".$nowtime." where id=".$id);//测试
                       if($result2){
                            $ooo = $cha_d;
                             for($j=1;$j<=$ooo;$j++){
                                $get_money = $money;
                                $all_get = $fanli_money+$get_money;
                                    
                                if($all_get>=$max_g){
                                    $get_money = $max_g-$fanli_money;
                                }

                                $glf = $get_money * $str2;
                                $ft =  $get_money * $str5;
                                $get_money_t = $get_money - $glf - $ft ;
                                $end_money = $get_money_t;

                                if($get_money>0){

                                    //$check_w = $fanli_time+3600*24*$j;//每日分红时间 正式
                                    $check_w = $nowtime;//测试
                                    $bid = $this->_getTimeTableList($vov['uid']);
                                    $bonus->execute("UPDATE __TABLE__ SET b0=b0+{$end_money},b1=b1+{$get_money},b6=b6-{$glf},b7=b7-{$ft} WHERE id={$bid}"); //加到记录表
                                    $fh ->execute("UPDATE __TABLE__ set fenh_money=fenh_money+{$get_money} where id=".$vov['id']); 
                                    $this->execute("update __TABLE__ set agent_use=agent_use+{$end_money},zjj=zjj+{$get_money},`agent_xf`=agent_xf+".$ft." where id=".$vov['uid']);//加到fck,agent_cf重复消费
                                    $this->addencAdd($vov['uid'], $vov['user_id'], $get_money,1,0,0,$check_w); //添加奖金和记录
                                    $this->addencAdd($vov['uid'], $vov['user_id'], -$glf,6,0,0,$check_w);
                                    $this->addencAdd($vov['uid'], $vov['user_id'], -$ft,7,0,0,$check_w);
                                    $this->addfh($vov['uid'],$get_money,$vov['id'],$check_w);
                                }
                            }
                        }

                    }
				
				}
				unset($rfck,$vov,$where);
			}
		}
		unset($fee,$fee_rs,$s6);
	}

    public function addfh($uid,$money,$fhid,$pdt){
        $fehlist = M('fehlist');
        $data = array();
        $data['uid'] = $uid;
        $data['bankid'] = $fhid;
        $data['money'] = $money;
        $data['pdt'] = $pdt;

        $fehlist->add($data);
        unset($data,$fehlist);
    }
    

    //清空时间
	public function emptyTime(){

		$nowdate = strtotime(date('Y-m-d'));

		$this->query("UPDATE `nnld_fck` SET `day_feng`=0,xy_money=0,_times=".$nowdate." WHERE _times !=".$nowdate."");

	}

    public  function _getTimeTableList($uid)
    {
        $times = M ('times');
        $bonus = M ('bonus');
        $boid = 0;
        $nowdate = strtotime(date('Y-m-d'));
        $settime_two['benqi'] = $nowdate;
        $settime_two['type']  = 0;
        $trs = $times->where($settime_two)->find();
        if (!$trs){
            $rs3 = $times->where('type=0')->order('id desc')->find();
            if ($rs3){
                $data['shangqi']  = $rs3['benqi'];
                $data['benqi']    = $nowdate;
                $data['is_count'] = 0;
                $data['type']     = 0;
            }else{
                $data['shangqi']  = strtotime('2010-01-01');
                $data['benqi']    = $nowdate;
                $data['is_count'] = 0;
                $data['type']     = 0;
            }
            $shangqi = $data['shangqi'];
            $benqi   = $data['benqi'];
            unset($rs3);
            $boid = $times->add($data);
            unset($data);
        }else{
            $shangqi = $trs['shangqi'];
            $benqi   = $trs['benqi'];
            $boid = $trs['id'];
        }
        $_SESSION['BONUSDID'] = $boid;
        $brs = $bonus->where("uid={$uid} AND did={$boid}")->find();
        if ($brs){
            $bid = $brs['id'];
        }else{
            $frs = $this->where("id={$uid}")->field('id,user_id')->find();
            $data = array();
            $data['did'] = $boid;
            $data['uid'] = $frs['id'];
            $data['user_id'] = $frs['user_id'];
            $data['e_date'] = $benqi;
            $data['s_date'] = $shangqi;
            $bid = $bonus->add($data);
        }
        return $bid;
    }





}
?>