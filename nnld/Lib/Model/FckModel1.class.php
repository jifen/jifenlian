<?php
class FckModel extends CommonModel {
	//数据库名称
    //静态变量，$fee表
    protected static $fee = false;
    private function _getFee() {
        if (!self::$fee) {
           self::$fee = M('fee')->field('*')->find();
       }
       return self::$fee;
    }

    public function xiangJiao($Pid=0,$DanShu=1,$fromUserId=0,$op=1){
        //========================================== 往上统计单数【有层碰奖】
        if ($op == 1) {
            $fromUserId = $Pid;
        }
        $pvDan = $DanShu;
        $vo = $this ->where('id='.$Pid)->field('id,treeplace,father_id,p_level')->find();
        if ($vo){
            $Fid = $vo['father_id'];
            $TPe = $vo['treeplace'];
            if ($Fid == 0) {
                return;
            }
            if ($TPe == 0 && $op>1){
                $this->execute("UPDATE __TABLE__ SET `l`=l+{$pvDan}, `shangqi_l`=`shangqi_l`+{$pvDan}  WHERE `id`=".$Fid);
            }elseif($TPe == 1 && $op>1){
                $this->execute("UPDATE __TABLE__ SET `r`=r+{$pvDan},`shangqi_r`=`shangqi_r`+{$pvDan}  WHERE `id`=".$Fid);
            }

            if($op>1){
                $this->addCengPengData($Fid,$op,$pvDan,$TPe,$fromUserId); // 添加对碰记录
            }


            $op++;
            unset($p_rs);
            if ($Fid > 0) $this->xiangJiao($Fid,$DanShu,$fromUserId,$op);
        }
        unset($vo);
    }

    // 层碰记录
    public function addCengPengData($uid,$ceng,$DanShu,$treeplace,$fromUserId)
    {
        $duipeng = M('peng');
        $where['uid'] = $uid;
        $where['ceng'] = $ceng;
        $re = $duipeng->where($where)->find();
        if ($re) {
            if ($re['is_peng']!=0) return;
            switch ($treeplace) {
                case '0':
                    if ($re['l_from_id'] == 0 || $re['l_from_id'] == $fromUserId) {
                        $re['l'] += $DanShu;
                        $re['l_from_id'] = $fromUserId;
                    }
                    break;
                case '1':
                    if ($re['r_from_id'] == 0 || $re['r_from_id'] == $fromUserId) {
                        $re['r'] += $DanShu;
                        $re['r_from_id'] = $fromUserId;
                    }
                    break;
                default:
                    break;
            }
            $duipeng->save($re);
        }
        else {
            $data['uid'] = $uid;
            $data['ceng'] = $ceng;
            switch ($treeplace) {
                case '0':
                    $data['l'] = $DanShu;
                    $data['l_from_id'] = $fromUserId;
                    break;
                case '1':
                    $data['r'] = $DanShu;
                    $data['r_from_id'] = $fromUserId;
                    break;
                default:
                    break;
            }
            $duipeng->add($data);
        }
    }




    // 层碰奖
    public function cengpeng($pPath,$inUserID){
        $fee_rs = self::_getFee();
        $fengding = explode('|', $fee_rs['str17']);
        $prii = $fee_rs['str3']/100;  //层碰比例
        $lingdao = $fee_rs['s15']/100;  //领导比例
        $cpzjArr = explode('|', $fee_rs['s9']); //    6000:6000
        $oneMoney=$cpzjArr[0];

        $duipeng = M('peng');
        $where['l'] = array('gt',0);
        $where['r'] = array('gt',0);
        $where['uid'] = array('in',$pPath);
        $where['is_peng'] = array('eq',0);

        $rs = $duipeng->where($where)->select();

        foreach ($rs as $re) {
           $duipeng->where('id='.$re['id'])->setField('is_peng',1);
           $user = $this->field('u_level,re_nums,cpzj,day_feng')->find($re['uid']);

           $day_feng=$fengding[$user['u_level']-1];

           if($user['re_nums']==0){
              if($re['ceng']<=5){
               $minF4 = $re['l'] > $re['r'] ? $re['r'] : $re['l'];
               if($minF4==1){
                   $money = $minF4 * $oneMoney * $prii;
               }

              }

           }


            if($user['re_nums']==1 ){
                if($re['ceng']<=15){
                    $minF4 = $re['l'] > $re['r'] ? $re['r'] : $re['l'];
                    if($minF4==1){
                        $money = $minF4 * $oneMoney * $prii;
                    }

                }

            }


            if($user['re_nums']>=2){
                    $minF4 = $re['l'] > $re['r'] ? $re['r'] : $re['l'];
                    if($minF4==1){
                        $money = $minF4 * $oneMoney * $prii;
                    }

            }



            if ($money > 0) {
                $this->rw_bonus($re['uid'],$inUserID,3,$money);
               // $this->addencAdd($re['uid'],$inUserID,$money,3);
              //  $fcks=M('fck')->where('id='.$re['uid'])->setInc('day_feng',$money);

/*
                $tui['id']=array('eq',$re['uid']);
                $tuijian = M('fck')->where($tui)->field('re_id')->find();





               if($tuijian['re_id'] !=''){

                   $this->rw_bonus($tuijian['re_id'],$inUserID,5,$money*$lingdao);
               }

*/


                //  $this->addencAdd($tuijian['re_id'],$re['uid'],$money*$lingdao,5);



            }
        }
    }


//万能对碰
    public function touchNtoN(&$Encash,$xL=0,$xR=0,&$NumS=0,$p1=1,$p2=1){
        if($p1 > $p2){
            $Great=$p1;
            $Samll=$p2;
        }else{
            $Great=$p2;
            $Samll=$p1;
        }
        $ttt=0;
        if ($xL > 0 && $xR > 0){
            if($xL > $xR){
                $L=$xL;
                $S=$xR;
                $ttt=0;
            }else{
                $L=$xR;
                $S=$xL;
                $ttt=1;
            }
            for($NumS=0;$S-$Samll>=0&&$L-$Great>=0;$NumS++){
                if($ttt==0){
                    $Encash['0'] = $Encash['0'] + $Great;
                    $Encash['1'] = $Encash['1'] + $Samll;
                }else{
                    $Encash['0'] = $Encash['0'] + $Samll;
                    $Encash['1'] = $Encash['1'] + $Great;
                }
                $L=$L-$Great;
                $S=$S-$Samll;
                if($L <= $S){
                    $temp = $L;
                    $L=$S;
                    $S=$temp;
                    if($ttt==1){
                        $ttt = 0;
                    }else{
                        $ttt = 1;
                    }
                }
            }
        }else{
            $NumS = 0;
            $Encash['0'] = 0;
            $Encash['1'] = 0;
        }
    }




    // public function xiangJiao($Pid=0,$DanShu=1,$pvDan=1,$plv=0,$op=1){
   //      //========================================== 往上统计单数【有层碰奖】
   //      $pvDan = $DanShu;
   //      $peng = M ('peng');
   //      $vo = $this ->where('id='.$Pid)->field('treeplace,father_id,p_level')->find();
   //      // var_dump($vo);
   //      if ($vo){
   //          $Fid = $vo['father_id'];
   //          $TPe = $vo['treeplace'];
   //          if ($TPe == 0 && $Fid > 0){
   //              // if($op>5){
   //                  $p_rs = $peng ->where("uid=$Fid and ceng = $op") ->find();
   //                  if($p_rs){
   //                      $peng->execute("UPDATE __TABLE__ SET `l`=l+{$pvDan}  WHERE uid=$Fid and ceng = $op");
   //                  }else{
   //                      $peng->execute("INSERT INTO __TABLE__ (uid,ceng,l) VALUES ($Fid ,$op,$pvDan) ");
   //                  }
   //                  $this->execute("UPDATE __TABLE__ SET `l`=l+{$pvDan}, `shangqi_l`=`shangqi_l`+{$pvDan}, `benqi_l`={$pvDan}  WHERE `id`=".$Fid);
   //              // }
   //          }elseif($TPe == 1 && $Fid > 0){
   //              // if($op>5){
   //                  $p_rs = $peng ->where("uid=$Fid and ceng = $op") ->find();
   //                  if($p_rs){
   //                      $peng->execute("UPDATE __TABLE__ SET `r`=r+{$pvDan}  WHERE uid=$Fid and ceng = $op");
   //                  }else{
   //                      $peng->execute("INSERT INTO __TABLE__ (uid,ceng,r) VALUES ($Fid,$op,$pvDan) ");
   //                  }
   //                  $this->execute("UPDATE __TABLE__ SET `r`=r+{$pvDan},`shangqi_r`=`shangqi_r`+{$pvDan}, `benqi_r`={$pvDan}  WHERE `id`=".$Fid);
   //              // }
   //          }
   //          $op++;
   //          unset($p_rs,$peng);
   //          if ($Fid > 0) $this->xiangJiao($Fid,$DanShu,$pvDan,$plv,$op);
   //     }
   //     unset($vo);
   // }

    // //层碰奖

/*
     public function duipeng(){
    
         $peng = M ('peng');
         $fee = M ('fee');
         $fee_rs = $fee->field('s1,s9,s5,s14,str8')->find(1);
         $s1 = explode("|",$fee_rs['s1']);       //各级对碰比例
         $s9 = explode("|",$fee_rs['s9']);       //会员级别费用
          $s5 = explode("|",$fee_rs['s5']);       //封顶
         $s15 = explode("|", $fee_rs['s14']);    //层封顶 单数
         $pengMoney = $fee_rs['str8'];

         $max_ac = $s15;
         sort($max_ac);
         $ceng = $max_ac[count($max_ac)-1];
         $pwhere['r1']=array('lt',$ceng);
         $pwhere['r']=array('gt','r1');
         $a_rs = $peng ->where($pwhere)->order('uid asc,ceng asc')->select();
         foreach($a_rs as $a){
             $where = array();
             $where['id'] = $a['uid'];
             $rs = $this ->where($where)->select();//找出产生对碰的人
             foreach($rs as $a1){
                 $urs = $a1['u_level'] - 1;
                 $ceng1 = floor($s15[$urs]);//每个级别的层封
             }
             $tceng = $a['ceng'];
             $R = floor($a['r']);
             $R1 = floor($a['r1']);
             $zR = $R-$R1;//可碰50
             $zR1=$ceng1-$R1;//还能碰30
             $xYou =0;
             if($zR>$zR1){
                 $cR=$zR1;
             }else{
                 $cR=$zR;
             }
             $cR1=$cR;
             if($cR>0){
                 $where = array();
                 $where['uid'] = $a['uid'];
                 $where['l'] = array('gt','l1');
                 $where['l1'] = array('lt',$ceng1);
                 $where['ceng'] = array('eq',$tceng);
                 $rs = $peng ->where($where)->order('ceng asc')->select();
                 if($rs && $cR1>0){
                     foreach($rs as $k=>$a2){
                         $L = floor($a2['l']);
                         $L1 = floor($a2['l1']);
                         $zL =$L-$L1;
                         $zL1 = $ceng1-$L1;
                         if($zL>$zL1){
                             $cL=$zL1;
                         }else{
                             $cL=$zL;
                         }
                         if($cR>$cL){
                             $xYou=$cL;
                         }else{
                             $xYou=$cR;
                         }
                         if($cR1>=$xYou){
                             $cR1=$cR1-$xYou;
                             $xLd=$xYou;
                         }else{
                             $xLd=$cR1;
                             $cR1=0;
                         }
                         $peng->execute("UPDATE __TABLE__ SET `l1`=l1+{$xLd}  WHERE id=".$a2['id']);
                     }
                 }
             }
             $cR2=$cR-$cR1;
             $peng->execute("UPDATE __TABLE__ SET `r1`=r1+{$cR2}  WHERE id=$a[id]");
             if($cR2>0){
                 $c_info = $this->where("id=".$a['uid']." and is_fenh=0")->field('id,u_level,user_id,re_id,re_path,re_level,day_feng')->find();
                 $this->execute("UPDATE __TABLE__ SET `shangqi_r`=shangqi_r-{$cR2},`shangqi_l`=shangqi_l-{$cR2}  WHERE id=".$a['uid']);
                 $tYou=$cR2*$s3[0]*($s12[$urs]/100);
                  $tYou=$s1[$urs] / 100 * $s9[1] * $cR2;//$s2[0]这是一碰的钱
                 $tYou = $pengMoney * $cR2;//$s2[0]这是一碰的钱
                  $my_wm = $c_info['day_feng'];
                  $all_get = $my_wm+$tYou;
                  $mmylv = $c_info['u_level']-1;
                  $myff = $s5[$mmylv];
                  if($all_get>$myff){
                      $tYou = $myff-$my_wm;
                  }
                 if($tYou>0){
                     $this->rw_bonus($c_info['id'],$c_info['user_id'],2,$tYou);
                  //  领导奖
                   //  $this->lingdaojiang($c_info['user_id'],$c_info['re_id'],$tYou);
                      $this->lingdaojiang($c_info['re_path'],$c_info['id'],$c_info['user_id'],$c_info['re_level'],$tYou);
                 }
                 unset($c_info);
             }
         }
         unset($fee,$peng);
     }
*/




    //对碰奖
    public function duipeng(){
    	$fee = M ('fee');
    	$fee_rs = $fee->field('s17,s21,s9,s15')->find(1);
    	$s17 = explode("|",$fee_rs['s17']);		//直推一位对碰奖金封顶
        $s21 = explode("|",$fee_rs['s21']);		//直推两位对碰奖金封顶
        $s9 = explode("|",$fee_rs['s9']);		//一单子为3000
        $one_mm=$s9[0];
        $lingdao = $fee_rs['s15']/100;  //领导比例
    	 // 1:2   银卡的 3000:6000 为150  6000:12000为300  金卡:  3000:6000=300  6000:12000=600
    	$fck_array = 'is_pay>=1 and ((shangqi_l+benqi_l)>0 or (shangqi_r+benqi_r)>0)';
    	$field = 'id,user_id,shangqi_l,shangqi_r,benqi_l,benqi_r,is_fenh,p_path,re_nums,nickname,u_level,re_id,day_feng,re_path,re_level,peng_num';
    	$frs = $this->where($fck_array)->field($field)->select();

    	//BenQiL  BenQiR  ShangQiL  ShangQiR
    	foreach ($frs as $vo){
    		$L = 0;
    		$R = 0;
    		$L = $vo['shangqi_l'] + $vo['benqi_l'];
    		$R = $vo['shangqi_r'] + $vo['benqi_r'];
    		$Encash    = array();
    		$NumS      = 0;//碰数
    		$money     = 0;//对碰奖金额
    		$Ls        = 0;//左剩余
    		$Rs        = 0;//右剩余
    		//$this->touch1to1($Encash, $L, $R, $NumS); // 调用 1：1对碰
            $this->touchNtoN($Encash, $L, $R, $NumS,1,2); // 调用 2：1和 1:2对碰
    		$Ls = $L - $Encash['0'];
    		$Rs = $R - $Encash['1'];
    		$myid = $vo['id'];
    		$myusid = $vo['user_id'];
            $re_id = $vo['re_id'];
    		$ss = $vo['u_level']-1;
            $u_level=$vo['u_level'];
    		$liang_feng = $vo['liang_feng'];
    		$re_nums = $vo['re_nums'];
    		$re_path = $vo['re_path'];
    		$re_level = $vo['re_level'];
            $ppath = $vo['p_path'];
    		$is_fenh = $vo['is_fenh'];


            if($re_nums ==0){
                $money=0;
            }
            if($re_nums ==1){
                $money = $one_mm* $NumS *0.05;//对碰奖 奖金


            /*   if($money > $s17[$u_level-1]){
                  $money=$s17[$u_level-1];

               }
                if($liang_feng >= $s17[$u_level-1]){
                   $money=0;
                }else{
                    $jfeng=$liang_feng+$money;
                    if ($jfeng>$s17[$u_level-1]){
                        $money=$s17[$u_level-1]-$liang_feng;
                    }
                }
*/

            }
            if($re_nums >= 2){
                $money = $one_mm* $NumS *0.1;//对碰奖 奖金

                /*
                if($money > $s21[$u_level-1]){
                    $money=$s21[$u_level-1];

                }
                if($liang_feng >= $s21[$u_level-1]){
                    $money=0;
                }else{
                    $jfeng=$liang_feng+$money;
                    if ($jfeng>$s21[$u_level-1]){
                        $money=$s21[$u_level-1]-$liang_feng;
                    }
                }

                */
            }


    		$this->query('UPDATE __TABLE__ SET `shangqi_l`='. $Ls .',`shangqi_r`='. $Rs .',`benqi_l`=0,`benqi_r`=0,peng_num=peng_num+'.$NumS.' where `id`='. $vo['id']);



    		if($money>0){

    			$this->rw_bonus($myid,$myusid,4,$money); // 写奖金
                //$this->lingdaojiang($re_path,$money_count,$myusid); // 调用领导奖
              //  $this->addencAdd($myid,$myusid,$money,4);
              //  $fcks=M('fck')->where('id='.$re_id)->setInc('liang_feng',$money);

        /*        if($vo['re_id'] !='') {
                    $this->rw_bonus($vo['re_id'], $myusid, 5, $money * $lingdao);
                    // $this->addencAdd($re_id,$myusid,$money*$lingdao,5);
                }
			*/	
				
    		}
    	}
    	unset($fee,$fee_rs,$frs,$vo);
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

        if($name==19){
            $data['type']= 1;
        }else{
            $data['type']= 0;
        }



        $data['allp']			= 0;
        if($acttime>0){
        	$data['act_pdt']	= $acttime;
        }


        $history ->add($data);
        unset($data,$history);
    }


    public function addencAdds($ID=0,$inUserID=0,$money=0,$name=null,$UID=0,$time=0,$acttime=0,$bz=""){
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
        $data['did']			= 2;


            $data['type']= 0;
        



        $data['allp']			= 0;
        if($acttime>0){
        	$data['act_pdt']	= $acttime;
        }


        $history ->add($data);
        unset($data,$history);
    }



    public function addencAddss($ID=0,$inUserID=0,$money=0,$name=null,$UID=0,$time=0,$acttime=0,$bz=""){
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


            $data['type']= 1;
        



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

    /*
     * $l_rs = $this->where('father_id='.$ttid.' and treeplace=0')->field('id')->find();
     *
     */


   /*********************基础回本奖**************************/
    public function jichujiang($user_id,$father_id){
         $fck=M('fck');
         $zuobian=$fck->where('father_id='.$father_id.' and treeplace=0 and is_pay>0')->find();
         $youbian=$fck->where('father_id='.$father_id.' and treeplace=1 and is_pay>0')->find();


        $fuqin=$fck->where('id='.$father_id)->find();

        if($zuobian && $youbian){

            if($zuobian['gaihuiben'] < $youbian['gaihuiben']){
                if($fuqin['gaihuiben']<$zuobian['gaihuiben']){
                    $this->rw_bonus($father_id,$fuqin['user_id'],2,$fuqin['gaihuiben']);

                }
                if($fuqin['gaihuiben']> $zuobian['gaihuiben']){
                    $this->rw_bonus($father_id,$fuqin['user_id'],2,$zuobian['gaihuiben']);

                    $data['huiben_id']=','.$zuobian['id'].',';
                    $data['huiben_money']=$fuqin['gaihuiben'] - $zuobian['gaihuiben'];
                    $benqian=$fck->where('id='.$father_id)->setField($data);
                }

                if($fuqin['gaihuiben'] == $zuobian['gaihuiben']){
                    $this->rw_bonus($father_id,$fuqin['user_id'],2,$fuqin['gaihuiben']);

                }
            }

            if($zuobian['gaihuiben'] > $youbian['gaihuiben']){
                if($fuqin['gaihuiben']<$youbian['gaihuiben']){
                    $this->rw_bonus($father_id,$fuqin['user_id'],2,$fuqin['gaihuiben']);

                }

                if($fuqin['gaihuiben']> $youbian['gaihuiben']){
                    $this->rw_bonus($father_id,$fuqin['user_id'],2,$youbian['gaihuiben']);

                    $data['huiben_id']=','.$youbian['id'].',';
                    $data['huiben_money']=$fuqin['gaihuiben']- $youbian['gaihuiben'];
                    $benqian=$fck->where('id='.$father_id)->setField($data);
                }
                if($fuqin['gaihuiben'] == $youbian['gaihuiben']){
                    $this->rw_bonus($father_id,$fuqin['user_id'],2,$fuqin['gaihuiben']);

                }
            }

            if($zuobian['gaihuiben'] == $youbian['gaihuiben']){
                if($fuqin['gaihuiben']<$youbian['gaihuiben']){
                    $this->rw_bonus($father_id,$fuqin['user_id'],2,$fuqin['gaihuiben']);

                }

                if($fuqin['gaihuiben']>$youbian['gaihuiben']){
                    $this->rw_bonus($father_id,$fuqin['user_id'],2,$youbian['gaihuiben']);

                    $data['huiben_id']=','.$youbian['id'].','.$zuobian['id'].',';
                    $qian1=$fuqin['gaihuiben']- $youbian['gaihuiben'];
                    $qian2=$fuqin['gaihuiben']- $zuobian['gaihuiben'];
                    $data['huiben_money']=$qian1.','.$qian2;
                    $benqian=$fck->where('id='.$father_id)->setField($data);

                }

                if($fuqin['gaihuiben'] == $zuobian['gaihuiben'] && $fuqin['gaihuiben'] == $youbian['gaihuiben']){
                    $this->rw_bonus($father_id,$fuqin['user_id'],2,$fuqin['gaihuiben']);
                   // $this->addencAdd($father_id,$father_id,$fuqin['gaihuiben'],2);
                }

            }


         }

    }

    /*********************基础回本奖**************************/


   
    //计算奖金
    public function getusjj($uid,$type=0){
        set_time_limit(0);
    	$mrs = $this->where('id='.$uid)->find();
    	if($mrs && $mrs['cpzj'] > 0){






            $this->jiandianjiang($mrs['p_path'],$mrs['user_id'],$mrs['cpzj'],$mrs['u_level']);
           $this->cengpeng($mrs['p_path'],$mrs['user_id']);
            $this->jichujiang($mrs['user_id'],$mrs['father_id']);


          //  $this->duipeng();  //对碰就是量碰

          /******/



          //  $this->zhucefei($mrs['shop_id'],$mrs['user_id'],$mrs['cpzj']);
            // $this->tuijj($mrs['re_id'],$mrs['user_id'],$mrs['cpzj']);  //推荐奖
            //  $this->duipeng();  //对碰
          //  $this->yejijiang($mrs['re_path'],$mrs['user_id'],$mrs['cpzj']);
			
			
        //    $this->lingdaojiang($rePath, $inUserID, $money);
             // $this->pingji($mrs['shop_id'],$mrs['user_id'],$mrs['cpzj']);

    		//见点奖
	       // $this->jiandianjiang($mrs['p_path'],$mrs['user_id'],$mrs['u_level'],$mrs['cpzj']);
		   
		   
        //    $this->ldj($mrs['id'],$mrs['re_path'],$mrs['user_id'],$mrs['u_level'],$mrs['cpzj']);
			
			
   		//    $this->fhj($mrs['user_id'],$mrs['p_path'],$mrs['treeplace'],$mrs['cpzj']);
			
			
    		// if($type==1){
  			 //   //报单奖
      //          $this->baodanfei($mrs['shop_id'],$mrs['user_id']);
    		// }
    	}
		unset($mrs);
    }

    //推荐奖
//    private function tuijj($re_id,$inUserID,$cpzj){
//        $fee_rs = self::_getFee();
//        $prii = $fee_rs['str4']; //奖金
//        $user = $this->field('is_fenh')->find($re_id);
//        if (!$user || $user['is_fenh'] != 0) {
//            return; // 查无此人 或者被关闭奖金了，就不用往下执行分奖了
//        }
//        $money = $cpzj * $prii / 100; // 百分比，所以要记得除以100
//         if ($money>0){
//            $this->rw_bonus($re_id,$inUserID,1,$money);
//         }
//    }
//    


//业绩奖

    public function yejijiang($re_path,$inUserID,$cpzj)
    {
    	$fee_rs = self::_getFee();
    	$shi = $fee_rs['s6']/100;
		$sheng=$fee_rs['s12']/100;
    	$money1 = $shi * $cpzj; // 市级
    	$money2 = $sheng * $cpzj; // 省级
    	$map['id'] = array('in',$re_path);
    	$fck_rs = M('fck')->where($map)->order('re_level desc')->select();
    	foreach ($fck_rs as $re){
			if($re['is_agent'] == 3){
					if($money1 > 0){
						$this->rw_bonus($re['id'],$inUserID,5,$money1);
                        $this->addencAdd($re['id'],$inUserID,$money1,5);
						$this->koushui($re['id'],$inUserID,$money1);
						$this->jiazjj($re['id'],$money1);
                        $this->gouwubi($re['id'],$inUserID,$money1);
                        $this->xinxifei($re['id'],$inUserID,$money1);
					}
			}
			if($re['is_agent'] == 4){
					if($money2 > 0){
						$this->rw_bonus($re['id'],$inUserID,5,$money2);
                        $this->addencAdd($re['id'],$inUserID,$money2,5);
						$this->koushui($re['id'],$inUserID,$money2);
						$this->jiazjj($re['id'],$money2);
                        $this->gouwubi($re['id'],$inUserID,$money2);    
                        $this->xinxifei($re['id'],$inUserID,$money2);
					}
			}
			
		}
    }


//会员卡信息费


    public function xinxifei($re_id,$inUserID,$cpzj)
    {
    	$fee_rs = self::_getFee();
    	$tjjj = $fee_rs['s5'] / 100;
    	$money = $tjjj * $cpzj;
    	if($money > 0)
    	{
        $bonus = M('bonus');
        $bb=$bonus->where('uid='.$re_id)->setDec('b7',$money);     	
		// $this->rw_bonus($re_id,$inUserID,7,$money);
        $this->addencAdd($re_id,$inUserID,-$money,7);
		$this->jianzjj($re_id,$money);
    	}
    	
    }




//会员卡注册费


    public function zhucefei($re_id,$inUserID,$cpzj)
    {
    	$fee_rs = self::_getFee();
    	$tjjj = $fee_rs['s1'] / 100;
    	$money = $tjjj * $cpzj;
    	if($money > 0)
    	{
        $bonus = M('bonus');
        $bb=$bonus->where('uid='.$re_id)->setInc('b4',$money);     	
	   // $this->rw_bonus($re_id,$inUserID,7,$money);
        $this->addencAdd($re_id,$inUserID,$money,4);
		$this->gouwubi($re_id,$inUserID,$money);
		$this->koushui($re_id,$inUserID,$money);
		$this->jiazjj($re_id,$money);
        $this->xinxifei($re_id,$inUserID,$money);
		
    	}
    	
    }





    //推荐奖
	
	
	
	
    
    public function tuijj($re_id,$inUserID,$cpzj)
    {
    	$fee_rs = self::_getFee();
    	$tjjj = $fee_rs['str4'] / 100;
    	$money = $tjjj * $cpzj;
    	if($money<0)
    	{
    		return ;
    	}else {
    	   $this->rw_bonus($re_id,$inUserID,1,$money);
            $this->addencAdd($re_id,$inUserID,$money,1);
            $this->gouwubi($re_id,$inUserID,$money);     
		    $this->jiazjj($re_id,$money);
		    $this->koushui($re_id,$inUserID,$money);
            $this->xinxifei($re_id,$inUserID,$money);
    	}
    	
    }
    
    //见点奖
    
	
	
    public function jiandianjiang($ppath,$inUserID,$cpzj,$u_level){
    	$fee_rs = self::_getFee();
		$bili = $fee_rs['s6']; //见点比例
        $s9 = $fee_rs['s9']; //
        $qian=explode('|',$s9);
        $cpzjs=$qian[1];
        $ceng = $fee_rs['str8']; //见点层数
        $limit_money = $fee_rs['str9']; //见点钱限制

        $moneyArr = ($cpzj*$bili)/100;


        $newstr = substr($ppath,0,strlen($ppath)-1);
        $newstr1 = substr($newstr,1,strlen($newstr )-1);
        $renren=explode(',',$newstr1);
        $arr = array_reverse($renren);

        if(count($arr)<$ceng-1){
            $shu=count($arr);
        }else{
            $shu=$ceng-1;
        }
        for($i=0;$i<=$shu;$i++){
            if($arr[$i] !=''){
                $fck=M('fck')->where('id='.$arr[$i])->select();

                foreach($fck as $v){

                    $liqian=$limit_money[$v['u_level']-1];
                    if($v['b1'] >=$liqian){
                      $xianzho =1;
                    }else{
                        $xianzho =0;
                    }


                    if($v['is_pay']==1 && $xianzho==0)
                        $fck=M('fck')->where('id='.$v['id'])->setInc('b1',$moneyArr);
                        $this->rw_bonus($v['id'],$inUserID,1,$moneyArr);

                    }

                }
            }



		/*	if($re['p_level'] <= $ceng && $moneyArr >0 && $re['is_pay']==1){
                $fck=M('fck')->where('id='.$re['id'])->setInc('b1',$moneyArr);
               $fck=M('fck')->where('id='.$re['id'])->setInc('b1',$moneyArr);
               // $this->addencAdd($re['id'],$inUserID,$moneyArr,1);
			}
		*/

    }
    
	
	
	
//会员购买的给提成
/*

    public function chongxiao($re_path,$inUserID,$cpzj)
    {
    	$fee_rs = self::_getFee();
    	$tjjj = $fee_rs['s14']/100;
		$ceng=$fee_rs['s13'];
    	$money = $tjjj * $cpzj;
		
      $fcks=M('fck')->where('id='.$inUserID)->find();
	  $maa['id'] =array('in',$fcks['re_path']);
      $fck_rsss = M('fck')->where($maa)->order('re_level desc')->select();
    	foreach ($fck_rsss as $re){
		  	if($fcks['re_level'] <= $ceng){
    		if($money > 0){
    			$this->rw_bonus($re['id'],$inUserID,3,$money);
				$this->gouwubi($re['id'],$inUserID,$money);     
    		}
			}
		}
		
    	$lilvzong = explode('|',$fee_rs['str2']);
    	$lilv1 = $lilvzong[0]/100;
    	$lilv2 = $lilvzong[1]/100;
    	$lilv3 = $lilvzong[2]/100;
		$money1=$lilv1*$cpzj; // 县级重销奖
		$money2=$lilv2*$cpzj; // 市级重销奖
		$money3=$lilv3*$cpzj; // 省级重销奖
		
    	$map['id'] = array('in',$re_path);
    	$fck_rs = M('fck')->where($map)->order('re_level desc')->select();
    	foreach ($fck_rs as $re){
			if($re['is_agent'] == 2){
                        $this->addencAdd($re['id'],$inUserID,$money1,5);
						$this->koushui($re['id'],$inUserID,$money1);
						$this->jiazjj($re['id'],$money1);
                        $this->gouwubi($re['id'],$inUserID,$money1); 
						$yjj =M('fck')->where('id='.$re['id'])->setInc('cpzj_pay',$money); 
						$yy =M('bonus')->where('uid='.$re['id'])->setInc('b5',$money);   
						$zjjs=M('fck')->where('id='.$re['id'])->setInc('zjj',$money);  
						$uses=M('fck')->where('id='.$re['id'])->setInc('agent_use',$money);  
						
						
			}

			
			if($re['is_agent'] == 3){
                        $this->addencAdd($re['id'],$inUserID,$money2,5);
						$this->koushui($re['id'],$inUserID,$money2);
						$this->jiazjj($re['id'],$money2);
                        $this->gouwubi($re['id'],$inUserID,$money2);     
						$yjj =M('fck')->where('id='.$re['id'])->setInc('cpzj_pay',$money); 
						$yy =M('bonus')->where('uid='.$re['id'])->setInc('b5',$money);  
						$zjjs=M('fck')->where('id='.$re['id'])->setInc('zjj',$money);  
						$uses=M('fck')->where('id='.$re['id'])->setInc('agent_use',$money);  
			}
			
			
			
			if($re['is_agent'] == 4){
                        $this->addencAdd($re['id'],$inUserID,$money3,5);
						$this->koushui($re['id'],$inUserID,$money3);
						$this->jiazjj($re['id'],$money3);
                        $this->gouwubi($re['id'],$inUserID,$money3);     
						$yjj =M('fck')->where('id='.$re['id'])->setInc('cpzj_pay',$money);
						$yy =M('bonus')->where('uid='.$re['id'])->setInc('b5',$money);   
						$zjjs=M('fck')->where('id='.$re['id'])->setInc('zjj',$money);  
						$uses=M('fck')->where('id='.$re['id'])->setInc('agent_use',$money);  
			}
						
		}
    }
	
*/
    /*************************购物积分******************************/
  /*

	public function gouwubi($uid,$inUserID,$money1){
		
    	$fee_rs = self::_getFee();
    	$tjjj = $fee_rs['str31'] / 100;
    	$money = $tjjj * $money1;
    	if($money > 0)
    	{
        $bonus = M('bonus');
        $bb=$bonus->where('uid='.$uid)->setInc('b3',$money);     			
		// $this->rw_bonus($re_id,$inUserID,7,$money);
        $this->addencAdd($uid,$inUserID,$money,3);
        $b0=M('bonus')->where('uid='.$uid)->setDec('b0',$money);  
       // $use=M('fck')->where('id='.$uid)->setDec('agent_use',$money);  
        $xf=M('fck')->where('id='.$uid)->setInc('agent_xf',$money);  
    //    $use1=M('fck')->where('id='.$uid)->setInc('zjj',$money);  
       // $use2=M('fck')->where('id='.$uid)->setInc('agent_use',$money);  
    	}
    	
	}

  */
	
    /*************************扣税******************************/
	
	
/*	public function koushui($uid,$inUserID,$money1){
		
    	$fee_rs = self::_getFee();
    	$shui = $fee_rs['s19'] / 100;
    	$money = $shui * $money1;
    	if($money > 0)
    	{
        $bonus = M('bonus');
        $bb=$bonus->where('uid='.$uid)->setDec('b6',$money);  
		// $this->rw_bonus($re_id,$inUserID,7,$money);
        $this->addencAdd($uid,$inUserID,-$money,6);
		
        $this->jianzjj($uid,$money);
		
    	}
    	
	}*/
	
	
    /*************************扣税1******************************/
	
	
/*	public function koushui1($uid,$money1){
		
    	$fee_rs = self::_getFee();
    	$shui = $fee_rs['s19'] / 100;
    	$money = $shui * $money1;
    	if($money > 0)
    	{
        $this->jianzjj($uid,$money);
		
    	}
    	
	}
	*/
	
	
	
	
    /*************************总奖金******************************/



/*	public function jiazjj($uid,$money){
        $zjj=M('fck')->where('id='.$uid)->setInc('zjj',$money);  
        $use=M('fck')->where('id='.$uid)->setInc('agent_use',$money);  
        $b0=M('bonus')->where('uid='.$uid)->setInc('b0',$money);  
	}
	
 	public function jianzjj($uid,$money){

        $use=M('fck')->where('id='.$uid)->setDec('agent_use',$money);  
        $b0=M('bonus')->where('uid='.$uid)->setDec('b0',$money);  
	}*/

   
    //对碰奖
//    private function duipeng(){
//    	$fee = M ('fee');
//    	$fee_rs = $fee->field('s2,s9,s4,str5')->find(1);
//    	$s19 = explode("|",$fee_rs['s4']);		//各级对碰奖金比例
//    	$s9 = explode("|",$fee_rs['s9']);		//代理级别费用
//        $f4Arr = explode('|', $fee_rs['s2']);   // 各级别单数
//    	// $s5 = explode("|",$fee_rs['s1']);		//封顶
//    	$one_mm = $s9[0] / $f4Arr[0]; // 算出一单的费用
//    	$fck_array = 'is_pay>=1 and ((shangqi_l+benqi_l)>0 or (shangqi_r+benqi_r)>0)';
//    	$field = 'id,user_id,shangqi_l,shangqi_r,benqi_l,benqi_r,is_fenh,p_path,re_nums,nickname,u_level,re_id,day_feng,re_path,re_level,peng_num';
//    	$frs = $this->where($fck_array)->field($field)->select();
//    	//BenQiL  BenQiR  ShangQiL  ShangQiR
//    	foreach ($frs as $vo){
//    		$L = 0;
//    		$R = 0;
//    		$L = $vo['shangqi_l'] + $vo['benqi_l'];
//    		$R = $vo['shangqi_r'] + $vo['benqi_r'];
//    		$Encash    = array();
//    		$NumS      = 0;//碰数
//    		$money     = 0;//对碰奖金额 
//    		$Ls        = 0;//左剩余
//    		$Rs        = 0;//右剩余
//    		$this->touch1to1($Encash, $L, $R, $NumS); // 调用 1：1对碰
//    		$Ls = $L - $Encash['0'];
//    		$Rs = $R - $Encash['1'];
//    		$myid = $vo['id'];
//    		$myusid = $vo['user_id'];
//    		$ss = $vo['u_level']-1;
//    		$feng = $vo['day_feng'];
//    		$re_nums = $vo['re_nums'];
//    		$re_path = $vo['re_path'];
//    		$re_level = $vo['re_level'];
//            $ppath = $vo['p_path'];
//    		$is_fenh = $vo['is_fenh'];
//    
//    		$ul =  $s19[$ss]/100;
//    		$money = $one_mm* $NumS *$ul;//对碰奖 奖金
//            //封顶
//    		// if($money>$s5[$ss]){  
//    		// 	$money = $s5[$ss];
//    		// }
//    
//    		// if ($feng>=$s5[$ss]){
//    		// 	$money=0;
//    		// }else{
//    		// 	$jfeng=$feng+$money;
//    		// 	if ($jfeng>$s5[$ss]){
//    		// 		$money=$s5[$ss]-$feng;
//    		// 	}
//    		// }
//    		$this->query('UPDATE __TABLE__ SET `shangqi_l`='. $Ls .',`shangqi_r`='. $Rs .',`benqi_l`=0,`benqi_r`=0,peng_num=peng_num+'.$NumS.' where `id`='. $vo['id']);
//    		$money_count = $money;
//    		if($money_count>0&&$is_fenh==0){
//    			$this->rw_bonus($myid,$myusid,2,$money_count); // 写奖金
//                $this->lingdaojiang($re_path,$money_count,$myusid); // 调用领导奖
//    		}
//    	}
//    	unset($fee,$fee_rs,$frs,$vo);
//    }
    
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

//    // 领导奖
//    public function lingdaojiang($rePath,$money,$inUserID)
//    {
//        $fee_rs = self::_getFee();
//        $priiArr = explode("|", $fee_rs['str8']); 
//        $daiArr = explode('|', $fee_rs['s14']);// 领导奖参数转数组 array('第1代','第2代','第3代'……)
//
//        $limit = count($priiArr); // 不同的代得不同的比例，所以有几个比例就拿多少层
//        $map['id'] = array('in',$rePath);
//        $fck_rs = $this->where($map)->field('id,is_fenh,u_level')->order('re_level desc')->limit($limit)->select();
//        foreach ($fck_rs as $key => $re) {
//            if ($re['is_fenh'] != 0) {  //$re['is_fenh'] != 0  表示会员奖金被关闭     ==0  表示开着
//                continue; // 此会员奖金被禁
//            }
//            $uLevel = $re['u_level'];
//            $dai = $daiArr[$uLevel - 1]; // 当前会员可拿代数,从数组的下标方面进行考虑 ，
//            if ($dai <= $key) {
//                continue; // 当前代数超出可拿代数，跳出，执行下次循环
//            }
//            $prii = $priiArr[$key] / 100;
//            $money_count = $money * $prii;
//            if ($money_count > 0) {
//                $this->rw_bonus($re['id'],$inUserID,3,$money_count);
//            }
//        }
//    }

    //领导奖
	/*
        public function lingdaojiang($rePath,$money,$inUserID){
    	$fee_rs = self::_getFee();
    	$ldjjjArr = explode("|", $fee_rs['str8']);
    	$daishuArr = explode('|', $fee_rs['s14']);
    	$limit = count($ldjjjArr);
    	$map['id'] = array('in',$rePath);
    	$fck_rs = $this->where($map)->field('id,is_fenh,u_level')->order('re_level desc')->limit($limit)->select();
    	foreach ($fck_rs as $key => $re){
    		if($re['is_fenh'] != 0){
    			continue;
    		}
    		$uLevel = $re['u_level'];
    		$dai = $daishuArr[$uLevel - 1];
    		if($dai <= $key){
    			continue;
    		}
    		$jj = $ldjjjArr[$key] / 100;
    		$money_count = $money * $jj;
    		if($money_count > 0){
    			$this->rw_bonus($re['id'],$inUserID,3,$money_count);
    		}
    	}
    }
    
    */
    

//    //见点奖
//   public function jiandianjiang($ppath,$inUserID=0){
//        $fee_rs = self::_getFee();
//        $moneyArr = explode('|', $fee_rs['s13']); // 转数组 不同级别的金额,  1级u_level就是1，但数组的下标是从0开始,所以要减一
//        $limit = $fee_rs['s1']; //最大层
//        $map['id'] = array('in',$ppath);
//        $fck_rs = $this->where($map)->field('id,is_fenh,u_level')->order('p_level desc')->limit($limit)->select();
//        foreach ($fck_rs as $re) {
//            if ($re['is_fenh'] != 0) {
//                continue;
//            }
//            $money = $moneyArr[$re['u_level']-1]; // 不同级别得不同金额
//            if ($money > 0) {
//                $this->rw_bonus($re['id'],$inUserID,4,$money);
//            }
//        }
//       unset($fee_rs,$fck_rs);
//   }

    public function getBonus(){
        $bonus = M('bonus');
        return $bonus;
    }

    //报单中心平级奖
    private function pingji($shop_id,$inUserID,$cpzj){
        $fee_rs = $this->getFee();
        $blArr = explode("|", $fee_rs['s6']);
        $shop = $this->where('id='.$shop_id)->field('shop_id')->find();
        $shop_id = $shop['shop_id'];
        foreach ($blArr as $bl) {
            $shop = $this->where('id='.$shop_id)->field('shop_id')->find();
            if($shop){
                $money = $cpzj * $bl / 100;
                if($money > 0){
                    $this->rw_bonus($shop_id,$inUserID,3,$money);   
                }
                $shop_id = $shop['shop_id'];
            }
            else{
                return;
            }
        }    
        
    }
    
    //网络费
    public function wlf($uid,$inUserID) {
        $bonus = $this->getBonus();
         $fee_rs = $this->getFee();
         $money = $fee_rs['s5']; //金额
         $zhouqi = $fee_rs['s3'] * 86400; //收费周期，秒数
         $nowday = strtotime(date('Y-m-d'));
         $lt_time = $nowday - $zhouqi;
         
         if($uid>0){    //开通成功时单收
             $bid = $this->_getTimeTableList($uid);
            $bonus->execute("UPDATE __TABLE__ SET b0=b0-".$money.",b4=b4-".$money." WHERE id={$bid}"); //加到记录表
            $this->execute("update __TABLE__ set agent_use=agent_use-".$money.",`wlf`=".$nowday." where id=".$uid);//加到fck
            $this->addencAdd($uid,$inUserID,-$money,4,0,0,$wlf + $zhouqi);
            return;
         }
         
         $where = array();
         $where['is_pay'] = array('gt',0);
         $where['wlf'] = array('elt',$lt_time);
         
         $rs = $this->where($where)->field('id,user_id,wlf')->select();
         
         foreach ($rs as $re) {
             $myid = $re['id'];
             $inUserID = $myid['user_id'];
             $wlf = $re['wlf'];
             $bid = $this->_getTimeTableList($myid);
             while($nowday - $wlf >= $zhouqi) {
                 if($money > 0){
                    $bonus->execute("UPDATE __TABLE__ SET b0=b0-".$money.",b4=b4-".$money." WHERE id={$bid}"); //加到记录表
                    $this->execute("update __TABLE__ set agent_use=agent_use-".$money.",`wlf`=wlf+".$zhouqi." where id=".$myid);//加到fck
                    $this->addencAdd($myid,$inUserID,-$money,4,0,0,$wlf + $zhouqi);
                }
                $wlf += $zhouqi;
                if($zhouqi <=0) break;
             }
         }
    }

    public function jiangjin()
    {



        $fck=M('fck');
        $bonus=M('bonus');
        $his=M('histroy');

        $fee_rs = self::_getFee();
        $benting=explode('|',$fee_rs['str9']);

        $tuiyi=explode('|',$fee_rs['s17']);
        $tuier=explode('|',$fee_rs['s21']);
        $cengding=explode('|',$fee_rs['str17']);
        $fengshou=explode('|',$fee_rs['str12']);
        $k=explode('|',$fee_rs['s5']);
        $lingdao = $fee_rs['s15']/100;  //领导比例
        $guanlifeilv = $fee_rs['s1']/100; //管理比例
        $chongxiaolv = $fee_rs['s13']/100; //重消比例
		
		

 /*       $jiance=$fck->where('id='.$v['id'])->select();
        foreach($jiance as $v){
            if($v['ri_feng'] < $fengshou[$v['u_level']-1]){

                continue;
            }

            if($v['ri_feng'] >= $fengshou[$v['u_level']-1]){

                exit;

            }


        }


 */
 
     $wew['type']=array('eq',0);
     $wew['did']=array('eq',0);
     $history=M('history')->where($wew)->select();
        /*      echo '<pre>';
             print_r($history);
              echo '<pre>';

      */

      foreach($history as $v){

         if($v['bz']==1){

            $banben=M('fck')->where('id='.$v['uid'])->find();
            $banbens=M('bonus')->where('uid='.$v['uid'])->find();
            if($banbens['b1']+$v['epoints']<=$benting[$banben['u_level']-1]){
                $money = $v['epoints'];
            }
            if($banbens['b1']+$v['epoints']>$benting[$banben['u_level']-1]){
                 $moneys = $benting[$banben['u_level']-1]-$banbens['b1'];
                if($moneys+$banbens['b1'] == $benting[$banben['u_level']-1]){

                    $money = $moneys;

                }

             }

             if($banbens['b1'] == $benting[$banben['u_level']-1]){
                 return;
             }
            if($money >0){


             $jia=M('fck')->where('id='.$v['uid'])->setInc('agent_use',$money);
             $jia1=M('bonus')->where('uid='.$v['uid'])->setInc('b1',$money);
			  $k1=M('fck')->where('id='.$v['uid'])->setInc('k1',$money);
        $gai=M('bonus')->where('uid='.$v['uid'])->order('id desc')->limit(1)->setField('e_date',time());
             $gai1=M('history')->where('id='.$v['id'])->setField('type',1);
             $gai3=M('bonus')->where('uid='.$v['uid'])->setField('type',1);


             $jias=M('fck')->where('id='.$v['uid'])->setInc('ri_feng',$money);
            }

         }


          if($v['bz']==2){


              $banben=M('fck')->where('id='.$v['uid'])->find();

              if($banben['b2']+$v['epoints']<= $banben['gaihuiben']){
                  $money = $v['epoints'];
              }
              if($banben['b2']+$v['epoints']>$banben['gaihuiben']){
                  $moneys = $banben['gaihuiben']-$banben['b2'];
                  if($moneys+$banben['b2'] == $banben['gaihuiben']){

                      $money = $moneys;

                  }
              }

              if($banben['b2'] == $banben['gaihuiben']){
                  return;
              }

             if($money >0){
              $jia=M('fck')->where('id='.$v['uid'])->setInc('agent_use',$money);
              $jia1=M('fck')->where('id='.$v['uid'])->setInc('b2',$money);
              $jia11=M('bonus')->where('uid='.$v['uid'])->setInc('b2',$money);
          $gai=M('bonus')->where('uid='.$v['uid'])->order('id desc')->limit(1)->setField('e_date',time());
              $gai1=M('history')->where('id='.$v['id'])->setField('type',1);
              $gai3=M('bonus')->where('uid='.$v['uid'])->setField('type',1);
              $jias=M('fck')->where('id='.$v['uid'])->setInc('ri_feng',$money);
			  
			  $k2=M('fck')->where('id='.$v['uid'])->setInc('k2',$money);
             }

          }


          if($v['bz']==3){
              $banben=M('fck')->where('id='.$v['uid'])->find();
              $banbens=M('bonus')->where('uid='.$v['uid'])->find();

              $dings=$cengding[0];

              if($banben['ceng_feng']+$v['epoints']<=$dings){
                  $money = $v['epoints'];
              }
              if($banben['ceng_feng']+$v['epoints']>$dings){
                  $moneys = $dings-$banben['ceng_feng'];
                  if($moneys+$banben['ceng_feng'] == $dings){
                    $money=$moneys;

                  }else{

                      $money=0;
                  }

              }

             if($banben['ceng_feng'] == $dings){

                 $money=0;

             }


           if($money >0){
           $jia=M('fck')->where('id='.$v['uid'])->setInc('agent_use',$money);
           $jia1=M('bonus')->where('uid='.$v['uid'])->setInc('b3',$money);
           $gai=M('bonus')->where('uid='.$v['uid'])->order('id desc')->limit(1)->setField('e_date',time());
           $gai1=M('history')->where('id='.$v['id'])->setField('type',1);
           $jias=M('fck')->where('id='.$v['uid'])->setInc('ri_feng',$money);
           $jias=M('fck')->where('id='.$v['uid'])->setInc('ceng_feng',$money);
           $gai3=M('bonus')->where('uid='.$v['uid'])->setField('type',1);
		   
			$benren_use_guan=M('fck')->where('id='.$v['uid'])->setDec('agent_use',$money*$guanlifeilv);
			$benren_ri_guan=M('fck')->where('id='.$v['uid'])->setDec('ri_feng',$money*$guanlifeilv);
			
			$benren_agent_xf=M('fck')->where('id='.$v['uid'])->setInc('agent_xf',$money*$chongxiaolv);
			$benren_use_chongxiao=M('fck')->where('id='.$v['uid'])->setDec('agent_use',$money*$chongxiaolv);
			$benren_use_chongxiao=M('fck')->where('id='.$v['uid'])->setDec('ri_feng',$money*$chongxiaolv);
						 
			 $banren_b7=M('bonus')->where('uid='.$v['uid'])->setDec('b7',$money*$guanlifeilv);
			 $banren_b8=M('bonus')->where('uid='.$v['uid'])->setInc('b8',$money*$chongxiaolv);
			 
			 
			$this->addencAddss($v['uid'],$v['user_id'],-$money*$guanlifeilv,7);
			$this->addencAddss($v['uid'],$v['user_id'],$money*$chongxiaolv,8);
			
				
			$k7=M('fck')->where('id='.$v['uid'])->setDec('k7',$money*$guanlifeilv);
			$k8=M('fck')->where('id='.$v['uid'])->setInc('k8',$money*$chongxiaolv);
						 
	   
		   
	    if($banben['re_id'] !=''){
			
			           $lingjiang=$money*$lingdao;
			
			            $jia_re=M('fck')->where('id='.$banben['re_id'])->setInc('agent_use',$lingjiang);
                        $jia_re_feng=M('fck')->where('id='.$banben['re_id'])->setInc('ri_feng',$lingjiang);

                        $xiaofen=M('fck')->where('id='.$banben['re_id'])->setInc('agent_xf',$lingjiang*$chongxiaolv);
						
						 $jia_re1=M('fck')->where('id='.$banben['re_id'])->setDec('agent_use',$lingjiang*$guanlifeilv);
						 $jia_re_feng1=M('fck')->where('id='.$banben['re_id'])->setDec('ri_feng',$lingjiang*$guanlifeilv);
						 
						 
						 $jia_re2=M('fck')->where('id='.$banben['re_id'])->setDec('agent_use',$lingjiang*$chongxiaolv);
						 $jia_re_feng2=M('fck')->where('id='.$banben['re_id'])->setDec('ri_feng',$lingjiang*$chongxiaolv);
						 
						 $jia_jj=M('bonus')->where('uid='.$banben['re_id'])->setInc('b5',$lingjiang);
						 $jia_jj1=M('bonus')->where('uid='.$banben['re_id'])->setDec('b7',$lingjiang*$guanlifeilv);
						 $jia_jj2=M('bonus')->where('uid='.$banben['re_id'])->setInc('b8',$lingjiang*$chongxiaolv);
						
						
						  $benren_k7=M('fck')->where('id='.$v['uid'])->setDec('k7',$money*$guanlifeilv);
						  $benren_k8=M('fck')->where('id='.$v['uid'])->setInc('k8',$money*$chongxiaolv);
						  
						  $benren_b7=M('bonus')->where('uid='.$v['uid'])->setDec('b7',$money*$guanlifeilv);
						  $benren_b8=M('bonus')->where('uid='.$v['uid'])->setInc('b8',$money*$chongxiaolv);
						  
						  $benren_b71=M('bonus')->where('uid='.$v['uid'])->setInc('b7',$money*$guanlifeilv);
						  $benren_b81=M('bonus')->where('uid='.$v['uid'])->setDec('b8',$money*$chongxiaolv);
						  
						 
				         $this->addencAddss($banben['re_id'],$v['user_id'],$lingjiang,5);
				         $this->addencAddss($banben['re_id'],$v['user_id'],-$lingjiang*$guanlifeilv,7);
				         $this->addencAddss($banben['re_id'],$v['user_id'],$lingjiang*$chongxiaolv,8);
						  
			
      
			}
	  
		   
		   
			  $k3=M('fck')->where('id='.$v['uid'])->setInc('k3',$money);
		   
           }

          }



          if($v['bz']==4){



              $banben=M('fck')->where('id='.$v['uid'])->find();
              $banbens=M('bonus')->where('uid='.$v['uid'])->find();
              if($banben['re_nums'==1]){

                  $dings=$tuiyi[$banben['u_level']-1];
              }
              if($banben['re_nums'] >= 2){
                  $dings=$tuier[$banben['u_level']-1];


              }

              if($banben['liang_feng']+$v['epoints']<=$dings){
                  $money = $v['epoints'];



              }
              if($banben['liang_feng']+$v['epoints']>$dings){
                  $moneys = $dings-$banben['liang_feng'];
                  if($moneys+$banben['liang_feng'] == $dings){
                      $money=$moneys;

                  }else{

                      $money=0;
                  }
              }


              if($banben['liang_feng'] == $dings){

                  $money=0;

              }



              if($money>0){

              $jia=M('fck')->where('id='.$v['uid'])->setInc('agent_use',$money);
              $jia1=M('bonus')->where('uid='.$v['uid'])->setInc('b4',$money);
          $gai=M('bonus')->where('uid='.$v['uid'])->order('id desc')->limit(1)->setField('e_date',time());
              $gai1=M('history')->where('id='.$v['id'])->setField('type',1);
              $gai3=M('bonus')->where('uid='.$v['uid'])->setField('type',1);
              $jias=M('fck')->where('id='.$v['uid'])->setInc('ri_feng',$money);
              $jias=M('fck')->where('id='.$v['uid'])->setInc('liang_feng',$money);
			  
			  
			  
			$benren_use_guan=M('fck')->where('id='.$v['uid'])->setDec('agent_use',$money*$guanlifeilv);
			$benren_ri_guan=M('fck')->where('id='.$v['uid'])->setDec('ri_feng',$money*$guanlifeilv);
			
			$benren_agent_xf=M('fck')->where('id='.$v['uid'])->setInc('agent_xf',$money*$chongxiaolv);
						 
			$benren_use_chongxiao=M('fck')->where('id='.$v['uid'])->setDec('agent_use',$money*$chongxiaolv);
			$benren_use_chongxiao=M('fck')->where('id='.$v['uid'])->setDec('ri_feng',$money*$chongxiaolv);
						 
			 $banren_b7=M('bonus')->where('uid='.$v['uid'])->setDec('b7',$money*$guanlifeilv);
			 $banren_b8=M('bonus')->where('uid='.$v['uid'])->setInc('b8',$money*$chongxiaolv);
			 
			 
			$this->addencAddss($v['uid'],$v['user_id'],-$money*$guanlifeilv,7);
			$this->addencAddss($v['uid'],$v['user_id'],$money*$chongxiaolv,8);
			  
			  
			  
/*			  $benren_k7=M('fck')->where('id='.$v['uid'])->setDec('k7',$money*$guanlifeilv);
			  $benren_k8=M('fck')->where('id='.$v['uid'])->setInc('k8',$money*$chongxiaolv);
			  
			  $benren_b7=M('bonus')->where('uid='.$v['uid'])->setDec('b7',$money*$guanlifeilv);
			  $benren_b8=M('bonus')->where('uid='.$v['uid'])->setInc('b8',$money*$chongxiaolv);
*/			  
			  
			  $k4=M('fck')->where('id='.$v['uid'])->setInc('k4',$money);
		  
		    if($banben['re_id'] !=''){
				   
				          			           $lingjiang=$money*$lingdao;

						  $k5=M('fck')->where('id='.$banben['re_id'])->setInc('k5',$lingjiang);
						  $k7=M('fck')->where('id='.$banben['re_id'])->setDec('k7',$lingjiang*$guanlifeilv);
						  $k8=M('fck')->where('id='.$banben['re_id'])->setInc('k8',$lingjiang*$chongxiaolv);
						  
						  
			            $jia_re=M('fck')->where('id='.$banben['re_id'])->setInc('agent_use',$lingjiang);
                        $jia_re_feng=M('fck')->where('id='.$banben['re_id'])->setInc('ri_feng',$lingjiang);
						
                        $xiaofen=M('fck')->where('id='.$banben['re_id'])->setInc('agent_xf',$lingjiang*$chongxiaolv);

						 $jia_re1=M('fck')->where('id='.$banben['re_id'])->setDec('agent_use',$lingjiang*$guanlifeilv);
						 $jia_re_feng1=M('fck')->where('id='.$banben['re_id'])->setDec('ri_feng',$lingjiang*$guanlifeilv);
						 
						 
						 $jia_re2=M('fck')->where('id='.$banben['re_id'])->setDec('agent_use',$lingjiang*$chongxiaolv);
						 $jia_re_feng2=M('fck')->where('id='.$banben['re_id'])->setDec('ri_feng',$lingjiang*$chongxiaolv);
						 
						 $jia_jj=M('bonus')->where('uid='.$banben['re_id'])->setInc('b5',$lingjiang);
						 $jia_jj1=M('bonus')->where('uid='.$banben['re_id'])->setDec('b7',$lingjiang*$guanlifeilv);
						 $jia_jj2=M('bonus')->where('uid='.$banben['re_id'])->setInc('b8',$lingjiang*$chongxiaolv);
						  
						  
						  
				         $this->addencAddss($banben['re_id'],$v['user_id'],$lingjiang,5);
				         $this->addencAddss($banben['re_id'],$v['user_id'],-$lingjiang*$guanlifeilv,7);
				         $this->addencAddss($banben['re_id'],$v['user_id'],$lingjiang*$chongxiaolv,8);
						 
						 
          /*	       $jia_re=M('fck')->where('id='.$banben['re_id'])->setInc('agent_use',$money*$lingdao);
                 $jia_re_feng=M('fck')->where('id='.$banben['re_id'])->setInc('ri_feng',$money*$lingdao);
                 $jia_re1=M('fck')->where('id='.$banben['re_id'])->setDec('agent_use',$money*$guanlifeilv);
                 $jia_re_feng1=M('fck')->where('id='.$banben['re_id'])->setDec('ri_feng',$money*$guanlifeilv);
                 $jia_re2=M('fck')->where('id='.$banben['re_id'])->setDec('agent_use',$money*$chongxiaolv);
                 $jia_re_feng2=M('fck')->where('id='.$banben['re_id'])->setDec('ri_feng',$money*$chongxiaolv);
			     $k5=M('fck')->where('id='.$banben['re_id'])->setInc('k5',$money*$lingdao);
                 $jia_jj=M('bonus')->where('uid='.$banben['re_id'])->setInc('b5',$money*$lingdao);
                 $jia_jj1=M('bonus')->where('uid='.$banben['re_id'])->setDec('b7',$money*$guanlifeilv);
                 $jia_jj2=M('bonus')->where('uid='.$banben['re_id'])->setInc('b8',$money*$chongxiaolv);
                 $this->addencAddss($banben['re_id'],$v['user_id'],$money*$lingdao,5);
                 $this->addencAddss($banben['re_id'],$v['user_id'],-$money*$guanlifeilv,7);
                 $this->addencAddss($banben['re_id'],$v['user_id'],$money*$chongxiaolv,8);   */	 
			}
			  
		 
			  
              }
          }


/*

          if($v['bz']==5){
              $jia=M('fck')->where('id='.$v['uid'])->setInc('agent_use',$v['epoints']);
              $jia1=M('bonus')->where('uid='.$v['uid'])->setInc('b5',$v['epoints']);
              $gai=M('bonus')->where('uid='.$v['uid'])->order('id desc')->limit(1)->setField('e_date',time());
              $gai1=M('history')->where('id='.$v['id'])->setField('type',1);
              $gai3=M('bonus')->where('uid='.$v['uid'])->setField('type',1);
              $jias=M('fck')->where('id='.$v['uid'])->setInc('ri_feng',$money);
			  
			  $k5=M('fck')->where('id='.$v['uid'])->setInc('k5',$money);
          }

*/





          if($v['bz']==7){
              $jia1=M('bonus')->where('uid='.$v['uid'])->setInc('b7',$v['epoints']);
              $jiaqq=M('fck')->where('id='.$v['uid'])->setDec('agent_use',$v['epoints']);
              $jias=M('fck')->where('id='.$v['uid'])->setDec('ri_feng',$v['epoints']);
              $gai=M('bonus')->where('uid='.$v['uid'])->order('id desc')->limit(1)->setField('e_date',time());
              $gai1=M('history')->where('id='.$v['id'])->setField('type',1);
              $gai3=M('bonus')->where('uid='.$v['uid'])->setField('type',1);
          }




          if($v['bz']==8){
              $jia=M('fck')->where('id='.$v['uid'])->setInc('agent_xf',$v['epoints']);
            //  $jiajd=M('fck')->where('id='.$v['uid'])->setInc('b8',$v['epoints']);

              $jiass=M('bonus')->where('uid='.$v['uid'])->setInc('b8',$v['epoints']);

             $jia_shao=M('fck')->where('id='.$v['uid'])->setDec('agent_use',$v['epoints']);
             $jia_shao=M('fck')->where('id='.$v['uid'])->setDec('agent_use',$v['epoints']);
              $jia_shao2=M('fck')->where('id='.$v['uid'])->setDec('ri_feng',$v['epoints']);
              $jia_shao2=M('fck')->where('id='.$v['uid'])->setDec('ri_feng',$v['epoints']);

              $gai=M('bonus')->where('uid='.$v['uid'])->order('id desc')->limit(1)->setField('e_date',time());
              
              $gai3=M('bonus')->where('uid='.$v['uid'])->setField('type',1);

			   $dats['type']=1;
              $gai1=M('history')->where('id='.$v['id'])->setField($dats);

           // $this->zaijian();
			
          }





      }


   //  $this->jiansuo();
       $this->fanhuan();
        $this->jiance();


    }

/*
    public function zaijian(){
		
		  $yici=M('history')->where('did=2')->select();
		  foreach($yici as $v){
              $jia_shao=M('fck')->where('id='.$v['uid'])->setDec('agent_use',$v['epoints']);
              $jia_shao=M('fck')->where('id='.$v['uid'])->setDec('agent_use',$v['epoints']);
              $jia_shao2=M('fck')->where('id='.$v['uid'])->setDec('ri_feng',$v['epoints']);		
              $jia_shao2=M('fck')->where('id='.$v['uid'])->setDec('ri_feng',$v['epoints']);		
              $gai1=M('history')->where('id='.$v['id'])->setField('did',0);
		  }
		
	}


*/









/*
    public function jiansuo($id){





        $where['b8']=array('gt',0);
        $where['is_pay']=array('gt',0);
        $ji=M('fck')->where($where)->field('id,user_id,b8')->select();



        foreach($ji as $v){
          $fc['id']=array('eq',$v['id']);
          $jiass=M('fck')->where($fc)->setDec('agent_use',$v['b8']);
          $jias=M('fck')->where($fc)->setDec('ri_feng',$v['b8']);

          $gai=M('fck')->where($fc)->setField('b8',0);



        }



    }


*/


   public function fanhuan(){

       $fee_rs = self::_getFee();
       $guanlifeilv = $fee_rs['s1']/100; //管理比例
       $chongxiaolv = $fee_rs['s13']/100; //重消比例
     $wew['type']=array('eq',0);
     $wew['did']=array('eq',0);      
	  $history=M('history')->where($wew)->select();

       foreach($history as $v){
		   
		if($v['bz']==3){
			$shanchu=M('history')->where('id='.$v['id'])->delete();   
		}
		
		if($v['bz']==4){
			$shanchu=M('history')->where('id='.$v['id'])->delete();   
		}
		   
/*           $guanqian=$v['epoints']*$guanlifeilv;
           $chongxiao=$v['epoints']*$chongxiaolv;

           $jia1=M('bonus')->where('uid='.$v['uid'])->setInc('b7',$guanqian);
           $jia2=M('bonus')->where('uid='.$v['uid'])->setDec('b8',$chongxiao);		   
           if($jia1 && $jia2){

              
           }
*/       }



   }



 public function jiance(){


     $fee_rs = self::_getFee();

     $kting=explode('|',$fee_rs['str12']);
     $k=$fee_rs['s5']/100;
     $fck=M('fck')->where($where)->field('id,user_id,ri_feng')->select();


     foreach($fck as $v){
		 
         if($v['ri_feng'] >=$kting[0]){

           /* $jian=M('fck')->where('id='.$v['id'])->setDec('agent_use',$v['ri_feng']*$k);
            $jians=M('bonus')->where('uid='.$v['id'])->setDec('b11',-$v['ri_feng']*$k);  */
         $fengzhi=$v['ri_feng']*$k;
         $bonus=M('bonus')->execute("UPDATE __TABLE__ SET b11=b11-".$fengzhi." WHERE uid=".$v['id']); //加到记录表


         $fc=M('fck')->execute("update __TABLE__ set agent_use=agent_use-".$fengzhi." where id=".$v['id']);//加到




         }

     }



 }


    public function jiesuan()
    {
        $fck=M('fck');
        $bonus=M('bonus');
        $his=M('histroy');
        $where['did']=array('eq',2);
        $where['type']=array('eq',0);
        $history=M('history')->where($where)->select();

        foreach($history as $v) {
            if ($v['bz'] == 6) {
                $jia = M('fck')->where('id=' . $v['uid'])->setInc('agent_use', $v['epoints']);
                $jias=M('fck')->where('id='.$v['uid'])->setInc('ri_feng',$v['epoints']);
                $jiass=M('bonus')->where('id='.$v['uid'])->setInc('b6',$v['epoints']);
				$datas['type']=1;
				$datas['e_date']=time();				
                $gai = M('bonus')->where('uid=' . $v['uid'])->setField($datas );
				$data['type']=1;
				$data['did']=0;				
                $gai1 = M('history')->where('id=' . $v['id'])->setField($data);
				
							  $k6=M('fck')->where('id='.$v['uid'])->setInc('k6',$v['epoints']);


            }
			
            if ($v['bz'] == 7) {
                $jia = M('fck')->where('id=' . $v['uid'])->setInc('agent_use', $v['epoints']);
                $jias=M('fck')->where('id='.$v['uid'])->setInc('ri_feng',$v['epoints']);
                $jiass=M('bonus')->where('id='.$v['uid'])->setInc('b7',$v['epoints']);
                $gai = M('bonus')->where('uid=' . $v['uid'])->setField('e_date', time());
				$data['type']=1;
				$data['did']=0;				
                $gai1 = M('history')->where('id=' . $v['id'])->setField($data);

            }
			

            if ($v['bz'] == 8) {
                $jia = M('fck')->where('id=' . $v['uid'])->setDec('agent_use', $v['epoints']);
                $jias=M('fck')->where('id='.$v['uid'])->setDec('ri_feng',$v['epoints']);
                $jiass=M('bonus')->where('id='.$v['uid'])->setInc('b8',$v['epoints']);
                $gai = M('bonus')->where('uid=' . $v['uid'])->setField('e_date', time());
				$data['type']=1;
				$data['did']=0;				
                $gai1 = M('history')->where('id=' . $v['id'])->setField($data);

            }

			
        }



    }








    public function gouxiao($re_path,$user_id,$money)
    {



        $fee_rs = self::_getFee();
        $xiaofeilv=$fee_rs['str32']/100;

        $y=date("Y",time());
        $m=date("m",time());
        $d=date("d",time());
        $t0=date('t');           // 本月一共有几天
        $time_start=mktime(0,0,0,$m,1,$y);        // 创建本月开始时间
        $time_end=mktime(23,59,59,$m,$t0,$y);       // 创建本月结束时间



        $newstr = substr($re_path,0,strlen($re_path)-1);
        $newstr1 = substr($newstr,1,strlen($newstr )-1);
        $renren=explode(',',$newstr1);
        $arr = array_reverse($renren);

        if(count($arr)<14){
            $shu=count($arr);
        }else{
            $shu=14;
        }
        for($i=0;$i<=$shu;$i++){
            if($arr[$i] !=''){
               $fck=M('fck')->where('id='.$arr[$i])->select();

               foreach($fck as $v){
                   if($v['is_xf']>=1 && $v['xf_time'] !=''  && $v['xf_time']>= $time_start && $v['xf_time']<= $time_end && $v['mypv'] >= 480){
                       $money_count=$money*$xiaofeilv;
                       $this->rw_bonus($v['id'],$user_id,6,$money_count);

                   }

               }
            }

        }


    }



    //层碰(回本奖)
    /*   private function cengpeng($user_id,$father_id){
         $fee_rs = self::_getFee();










         $lirs = $this->where('id in (0'.$ppath.'0)')->order('p_level desc')->field('id,user_id,u_level,is_fenh,cpzj')->select();

         $i = 0;
         foreach($lirs as $lrs){
             $ttid = $lrs['id'];
             $ttlv = $lrs['u_level'];
             $ssss = $ttlv-1;
           //  $is_fenh = $lrs['is_fenh'];
             $l_nn = 0;
             $r_nn = 0;
             $l_rs = $this->where('father_id='.$ttid.' and treeplace=0')->field('id')->find();

             if($l_rs){
                 $l_id = $l_rs['id'];
                 $l_ss = $this->where('(p_path like "%,'.$l_id.',%" or id='.$l_id.') and p_level='.$plevel.' and is_pay>0')->select();


                 // $l_nn = (int)$l_ss['mypv'];
             }
             unset($l_rs);
             $r_rs = $this->where('father_id='.$ttid.' and treeplace=1')->field('id')->find();

             if($r_rs){
                 $r_id = $r_rs['id'];
                 $r_ss = $this->where('(p_path like "%,'.$r_id.',%" or id='.$r_id.') and p_level='.$plevel.' and is_pay>0')->select();


                 // $r_nn = (int)$r_ss['mypv'];
             }
             unset($r_rs);

             if($l_ss>0&&$r_ss>0){



                 // if($l_nn>$r_nn){
                 //     $money_count = $s1*$r_nn;
                 // }else{
                 //     $money_count = $s1*$l_nn;
                 // }
                 // $maxc = $s5[$ssss];
                 // if($money_count>$maxc){
                     $money_count = $s13[$i];
                 // }
                 if($money_count>0){
                    // $this->rw_bonus($ttid,$inUserID,2,$money_count);
                 }
                 break;
             }
             $i++;
         }
         unset($fee,$fee_rs,$lirs,$lrs,$r_ss,$l_ss);



    } */




   //重消见点奖
   
 /*  
   public function gwJiandianjiang($ppath,$inUserID=0){
        $fee_rs = self::_getFee();
        $money = $fee_rs['s15']; //见点奖百分比
        if($money <= 0) return;
        $limit = $fee_rs['str5']; //最大层

        $fck_rs = $this->where('id in (0'.$ppath.'0)')->field('id,is_xf')->order('p_level desc')->limit($limit)->select();
        foreach ($fck_rs as $re) {
            if ($re['is_xf'] == 0) {
                continue;
            }
            $this->rw_bonus($re['id'],$inUserID,5,$money);
        }
       unset($fee_rs,$fck_rs);
   }
   
  */ 

   
    //领导奖
//    public function ldj($uid,$re_path,$inUserID,$cpzj){
//
//        $bonus = $this->getBonus();
//        $fee_rs = $this->getFee();
//
//        $s6 = explode ( "|", $fee_rs ['s6'] ); //代数
//        $s3 = $fee_rs ['s3'] /100; //金额
//
//        $where = "id in (0".$re_path."0)";
//        $list = $this->where($where)->field('id,user_id,u_level,re_nums')->order('re_level desc')->limit($s6[2])->select();
//   
//        $i = 0;
//        foreach ($list as $vo) {
//            $i++;
//            $money = $s3*$cpzj;
//            
//            $re_nums = $vo['re_nums'];
//            if($re_nums == 0){
//                continue;
//            }
//
//            $lev = 0;
//            if($re_nums == 1 or $re_nums == 2){
//                $lev = 1;
//            }elseif($re_nums>=3 && $re_nums<5){
//                $lev = 2;
//            }elseif($re_nums>=5){
//                $lev = 3;
//            }
//
//            if($i > $s6[$lev-1]){
//                $money = 0;
//            }
//
//            if ($money > 0) {
//                $this->rw_bonus($vo['id'],$inUserID,3,$money);
//            }  
//        }
//
//        unset($fee_rs,$bonus,$frs,$vo,$money,$list);
//
//    }

    //分红奖
    public function fhj($inUserID,$p_path,$treeplace=0,$cpzj=0){
        $this->emptyTime();

         $fee = M ('fee');
         $fee_rs = $fee->find(1);
		
		
        $s12 = $fee_rs['s12']; //分红奖百分比
        $s11 = $fee_rs['s11'];//分红奖封顶

        $s15 = $fee_rs['s15']+0;   //层数
        $str5 = $fee_rs['str5']+0; //收入值
        $str1 = $fee_rs['str1']+0; //人数

        // $where = "id in (0".$p_path."0) and re_nums>=".$str1." and xy_money>=".$str5;
        $where = "id in (0".$p_path."0)";
        $list = $this->where($where)->field('id,user_id,p_level,l,r,treeplace,re_nums,xy_money')->order('p_level desc')->select();
       
        foreach ($list as $vaoo) {

            $man  = 0;
            $l = $vaoo['l'];
            $r = $vaoo['r'];
            $man = $this->chenkMan($vaoo['id'],$vaoo['p_level'],$s15);

            if($man == 1 && $vaoo['re_nums']>=$str1 && $vaoo['xy_money']>= $str5){
                $tt = 0;
                if($l > $r){
                    $tt = 1;
                }

                if($treeplace == $tt){
                    $money_count = $s12 * $cpzj/100;
                    $money_count = $this->zfd_jj($vaoo['id'],$money_count );
                    if($money_count > 0){
                        $this->rw_bonus($vaoo['id'],$inUserID,4,$money_count);
                    }  
                }
            }
            
            $treeplace =  $vaoo['treeplace'];
        }

        unset($fee_rs, $list,$where,$vaoo,$treeplace);
    }

    //检测第n层是否排满
    public function chenkMan($uid,$p_level,$ceng){
        $get_level = $p_level + $ceng;
        $man = 0;

        $where = "p_path like '%".$uid."%' and p_level=".$get_level." and is_pay>0";
        $menber_nums = $this->where($where)->count();

        $nums = pow(2,$ceng);
        if($menber_nums == $nums){
            $man = 1;
        }

        return $man;

    }

    //封顶
//    public function zfd_jj($uid,$money=0){
//        $fee_rs = $this->getFee();
//        $s11 = $fee_rs['s11'];//分红奖封顶      
//
//        $rs = $this->where('id='.$uid)->field('day_feng')->find();
//        if($rs){
//            $day_feng = $rs['day_feng'];
//            if($money > $s11){
//                $money = $s11;
//            }
//
//            if($day_feng >= $s11){
//                $money = 0;
//            }else{
//                $tt_money = $money + $day_feng;
//                if( $tt_money > $s11){
//                    $money = $s11-$day_feng;
//                }
//            }
//        }
//
//        return $money;
//    } 


    //报单费
    public function baodanfei($shop_id,$inUserID){
        $fee_rs = self::_getFee();
        $money = $fee_rs['s1'];
        if($money > 0){
             $this->rw_bonus($shop_id,$inUserID,6,$money);       
        }
    }



    //报单费 分公司所得
    public function baodanfei2($company_id,$inUserID,$cpzj=0,$cp_time){
        $fee_rs = $this->getFee();

        $levelArr = explode("|", $fee_rs['s9']); //投资时间级别
        $i=0;   //对应级别
        for(;$i<count($levelArr); $i++){
            if($levelArr[$i] == $cp_time) break;
        }
        if($i == count($levelArr)) return;
        
        $s14Arr = explode("|", $fee_rs ['str2']);
        $s14 = $s14Arr[$i];
        $money = $s14 * $cpzj /100;
        // $uid = $_SESSION[C('USER_AUTH_KEY')];
        
        if($money > 0){
             $this->rw_bonus($company_id,$inUserID,3,$money);       
        }
        unset($fee,$fee_rs,$frs,$s14,$list,$bonus);
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


    //各种扣税
    public function rw_bonus($myid,$inUserID=0,$bnum=0,$money_count=0){
		
        $fee_rs = self::_getFee();


        $lingdao = $fee_rs['s15']/100;  //领导比例
        $guanlifeilv = $fee_rs['s1']/100; //管理比例
        $chongxiaolv = $fee_rs['s13']/100; //重消比例

        $bonus = M('bonus');
        $bid = $this->_getTimeTableList($myid);
        $inbb = "b".$bnum;
        $usqla = "";

        if($bnum==1){
            $chongxiao=$chongxiaolv*$money_count; //扣消费
            $guanlifei=$money_count*$guanlifeilv;  // 扣管理
             //总奖金-扣消费-扣管理
            if($chongxiao>0){
                $this->addencAdd($myid,$inUserID,$chongxiao,8);
            }


            if($guanlifei>0){
                $this->addencAdd($myid,$inUserID,-$guanlifei,7);
            }

            if($money_count>0){

                $this->addencAdd($myid,$inUserID,$money_count,1);
            }
        }
        if($bnum==2){
            $chongxiao=$chongxiaolv*$money_count; //扣消费
            $guanlifei=$money_count*$guanlifeilv;  // 扣管理



            //总奖金-扣消费-扣管理


            if($chongxiao>0){
                $this->addencAdd($myid,$inUserID,$chongxiao,8);
            }

            if($guanlifei>0){
                $this->addencAdd($myid,$inUserID,-$guanlifei,7);
            }

            if($money_count>0){
                $this->addencAdd($myid,$inUserID,$money_count,2);
            }

        }

        if($bnum==3){



            //总奖金-扣消费-扣管理


  /*     
  
            $chongxiao=$chongxiaolv*$money_count; //扣消费
            $guanlifei=$money_count*$guanlifeilv;  // 扣管理
       if($chongxiao>0){
                $this->addencAdd($myid,$inUserID,$chongxiao,8);
            }


            if($guanlifei>0){
                $this->addencAdd($myid,$inUserID,-$guanlifei,7);
            } */

            if($money_count>0){
                $this->addencAdd($myid,$inUserID,$money_count,3);
            }

        }

        if($bnum==4){



             //总奖金-扣消费-扣管理


 /*       
 
            $chongxiao=$chongxiaolv*$money_count; //扣消费
            $guanlifei=$money_count*$guanlifeilv;  // 扣管理
 
     if($chongxiao>0){
                $this->addencAdd($myid,$inUserID,$chongxiao,8);
            }


            if($guanlifei>0){
                $this->addencAdd($myid,$inUserID,-$guanlifei,7);
            }
			
			*/

            if($money_count>0){
                $this->addencAdd($myid,$inUserID,$money_count,4);
            }

        }

/*
        if($bnum==5){
            $chongxiao=$chongxiaolv*$money_count; //扣消费
            $guanlifei=$money_count*$guanlifeilv;  // 扣管理

             //总奖金-扣消费-扣管理


            if($chongxiao>0){
                $this->addencAdd($myid,$inUserID,$chongxiao,8);
            }


            if($guanlifei>0){
                $this->addencAdd($myid,$inUserID,-$guanlifei,7);
            }

            if($money_count>0){
                $this->addencAdd($myid,$inUserID,$money_count,5);
            }

        }
		
		
	*/	
		

        if($bnum==6){
            $chongxiao=$chongxiaolv*$money_count; //扣消费
            $guanlifei=$money_count*$guanlifeilv;  // 扣管理

           $money_counts =$money_count -  $chongxiao-$guanlifei;
             //总奖金-扣消费-扣管理


            if($chongxiao>0){
                $this->addencAdds($myid,$inUserID,$chongxiao,8);
            }

            if($guanlifei>0){
                $this->addencAdds($myid,$inUserID,-$guanlifei,7);
            }

            if($money_counts>0){
                $this->addencAdds($myid,$inUserID,$money_counts,6);
            }

        }








      //  $money_counts=$money_count-$guanlifeilv-$chongxiao; // 总的得钱

       // if($bnum==2){
           // $usqla = ",day_feng=day_feng+".$money_count."";
       // }
        // if ($money_huankuan>0) {
        //     $usqlb = ",cpzj_pay=cpzj_pay+".$money_huankuan."";  //还款金额  ,b6=b6-".$kou_shui."


      //  $bonus->execute("UPDATE __TABLE__ SET b7=b7+".$guanlifei.",b6=b6+".$chongxiao.",".$inbb."=".$inbb."+".$money_counts." WHERE id={$bid}"); //加到记录表
	 
 // $this->execute("update __TABLE__ set agent_use=agent_use+".$money_counts.",agent_xf=agent_xf+".$chongxiao." where id=".$myid);//加到fck




    //    unset($bonus);
		
		
/*
        if($money_count>0){
            $this->addencAdd($myid,$inUserID,$money_count,$bnum);
        }



       if($kou_shui > 0){
           $this->addencAdd($myid,$inUserID,-$kou_shui,6);
       }
	   	
       if($gouwubi > 0){
           $this->addencAdd($myid,$inUserID,$gouwubi,3);
       }
	   
	   
	   */
	   
       // if($kou_gr>0){
       //     $this->addencAdd($myid,$inUserID,-$kou_gr,8);
       // }
       // if($kou_net>0){
       //     $this->addencAdd($myid,$inUserID,-$kou_net,9);
       // }
       // if($money_huankuan>0){
       //     $this->addencAdd($myid,$inUserID,-$money_huankuan,10);
       // }
//        if($money_kb>0){
//            //$fee->query("update __TABLE__ set b_money=b_money+".$money_kb."");
//            $this->addencAdd($myid,$inUserID,-$money_kb,8);
//        }

//         if($bnum!=3){
//            $rss = $this->where('id='.$myid)->field('id,user_id,re_path')->find();
//
//            $this->ldj($myid,$rss['re_path'],$rss['user_id'],$money_count); //领导奖
//           
//        }
     //   unset($fee,$fee_rs,$s9,$mrs,$rss);
    }
    

    //清空时间
	public function emptyTime(){

		$nowdate = strtotime(date('Y-m-d'));

        /*
            liangf_feng是量碰封顶
            ceng_feng 是层碰封顶
        K值日封顶  ri_feng

        gaihuiben




         */
		$this->query("UPDATE `nnld_fck` SET `day_feng`=0,`liang_feng`=0,`ceng_feng`=0,`ri_feng`=0,_times=".$nowdate." WHERE _times !=".$nowdate."");



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