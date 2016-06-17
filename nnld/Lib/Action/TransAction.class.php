<?php
class TransAction extends Action
{
    // 框架首页
    public function index()
    {

      /*
       *


        toUserName=ldrj1688&pointAmount=10000&fromUserName=kaka@163.com&uniqueId=4ce8b3c4-2636-11e6-8809-80fa5b1e5c98&dataSource=aita1.com&key=dda@123


       */


      $Fck = D('Fck');

      $ip = $Fck->get_real_ip();


      $tousername=$_POST['toUserName'];
      $fromusername=$_POST['fromUserName'];
      $uniqueid=$_POST['uniqueId'];
      $pointamount=$_POST['pointAmount'];
      $datasource=$_POST['dataSource'];
      $key=C('Key');
      $sign=$_POST['sign'];

      $str = 'dataSource='.$datasource.'&fromUserName='.$fromusername.'&pointAmount='.$pointamount.'&toUserName='.$tousername.'&uniqueId='.$uniqueid.'&key='.$key;



      $owner = strtoupper(md5($str));


        $da = array(
            'status'=>0,
            'message'=>'不能访问',
            'data'=>null
        );
        $da_jifen = array(
            'status'=>2,
            'message'=>'积分错误',
            'data'=>null
        );
        $da_IP = array(
            'status'=>2,
            'message'=>$ip,
            'data'=>null
        );
        $da_user = array(
            'status'=>2,
            'message'=>'用户错误',
            'data'=>null
        );
        $da_ok = array(
            'status'=>1,
            'message'=>'处理成功',
            'data'=>null
        );
        if($owner != $sign){
           // $this->error("授权失败,请联系管理员");

            echo  json_encode($da);

            exit;
        }

      if($pointamount < 0){
          echo  json_encode($da_jifen);
          exit;
      }

      $res = $this->xianzhi($ip);
        if($res == false){
            echo json_encode($da_IP);exit;
        }

     $map['user_id'] = array('eq',$tousername);
     $fck=M('fck')->where($map)->find();
     if($fck == false){
         echo json_encode($da_user);exit;
     }else{
       $jiafen=M('fck')->where('id='.$fck['id'])->setInc('agent_cash',$pointamount);
         $data['uniqueid']=$uniqueid;
         $data['tousername']=$tousername;
         $data['fromusername']=$fromusername;
         $data['pointamount']=$pointamount;
         $data['datasource']=$datasource;
         $data['type']=1;
         $data['status']=1;
         $data['pdt']=time();
         $data['ip']=$ip;
         M('trans')->add($data);
         echo json_encode($da_ok);
     }

    }
 
 

    public function xianzhi($ip){


        $iplist = M('ip')->select();

        for($i=0;$i<count($iplist);$i++){
            $list[$i] = $iplist[$i]['ip_address'];
        }

        if(in_array($ip,$list)){
            return true;
        }else{
            return false;
        }

    }





    // 框架首页
    public function check()
    {
        /*
         *
         dataSource=aita1.com&userName=ldrj1688&sign=CF1B02C33E5BDCD3487D22A84378EDA9
         */
        $Fck = D('Fck');
        $ip = $Fck->get_real_ip();
        $user_id=$_POST['userName'];
        $datasource=$_POST['dataSource'];
        $key=C('Key');
        $sign=$_POST['sign'];
        $str = 'dataSource='.$datasource.'&userName='.$user_id.'&key='.$key;
        $owner = strtoupper(md5($str));
        $da = array(
            'status'=>2,
            'message'=>'不能访问',
            'data'=>null
        );

        $da_error = array(
            'status'=>1,
            'message'=>'',
            'data'=>null
        );


        $da_IP = array(
            'status'=>2,
            'message'=>$ip,
            'data'=>null
        );

        if($owner != $sign){
            // $this->error("授权失败,请联系管理员");
            echo  json_encode($da);
            exit;
        }


        $res = $this->xianzhi($ip);
        if($res == false){
            echo json_encode($da_IP);exit;
        }

        $map['user_id'] = array('eq',$user_id);
        $fck=M('fck')->where($map)->find();
        if($fck == false){
            echo json_encode($da_error);exit;
        }else{

            $da_success = array(
                'status'=>1,
                'message'=>'用户存在',
                'data'=>array(
                    'id'=>$fck['id'],
                    'user_id'=>$fck['user_id'],
                    'user_name'=>$fck['user_name'],
                    'user_tel'=>$fck['user_tel']
                )
            );
            echo json_encode($da_success);
        }

    }







}


?>