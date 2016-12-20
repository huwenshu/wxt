<?php 
$result       = $this->mobile_from_find_student();
$student_name = $result['student_name'];
$page_title   = '发送给校长';
$do_in        = 1;
if($_GPC['token'] != $_COOKIE['form_token'] && $_GPC['message_title']){
    $do_in = 0;
}
$token                  = $this->class_base->tokenForm();
if($_GPC['message_title'] && $do_in==1 ){
    $title             = $_GPC['message_title'];
    $content           = $_GPC['message_content'];
    $student_id        = $result['student_id'];
    $arr['title']      = $title;
    $arr['student_id'] = $result['student_id'];
    $arr['send_uid']   = $uid;
    $arr['msg_content']= $content;
    D("message")->addMessage($arr);
    $this->myMessage("留言成功，请耐心等待学校的回复",$this->createMobileUrl('message'),'成功' );
}
