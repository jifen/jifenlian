<?php
class TestAction extends Action
{
    // 框架首页
    public function index()
    {
      $fee=M("fee");
        $fee_rs = $fee -> find();
        $s5 = explode('|',$fee_rs['s5']);
        echo $s5[1];exit;
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