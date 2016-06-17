<?php
//注册模块
class TimeAction extends Action{

   public function index(){


       $fck2=M('fck2')->where('is_time=1')->select();
       foreach($fck2 as $v){
           $lesstime= $v['time']-time();
           if($lesstime <=0){
               if($v['uid'] == 1){
                   $data['is_time']=0;
                   $data['is_suo']=0;
                   $data['time']=0;
                   $suo=M('fck2')->where('id=1')->setField($data);
                   $suo1=M('fck')->where('id=1')->setField('is_suo',0);
               }else{
                   $data['is_time']=0;
                   $data['is_suo']=1;
                   $data['time']=0;
                   $suo=M('fck2')->where('id='.$v['id'])->setField($data);
                   $suo1=M('fck')->where('id='.$v['uid'])->setField('is_suo',1);
               }
           }
       }

       $this->display();


   }



}

?>