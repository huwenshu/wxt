<?php 
    $this->checkAdminWeb();
    $admin_result = D('admin')->judeAdminType();
    $left_top     = 'school_msg';
    $left_nav     = 'booking';
    $title        = '校外活动报名';  
    $sidebar_list = array(
            array('fun_str'=>'','fun_name'=>'校务管理'),
            array('fun_str'=>'booking','fun_name'=>'校外报名'),
    );
    $top_action = array(
            array('action_name'=>'活动列表','action'=>'booking' ),
    );
    $cclass_bookinglist = C('bookingList');
    $class_bookinglist  = D('bookingList');
    $class_booking      = D('booking');
    if($ac == 'list' && $_GPC['id']){
        $booking_re = $class_booking->dataEdit($_GPC['id']);
        $cclass_bookinglist->booking_id = $_GPC['id'];
        $result     = $cclass_bookinglist->getBooKingPeopleList();
        $count      = $result['count'];
        $list       = $result['list'];
        foreach ($list as $key => $value) {
            $list[$key]['nickname'] = $this->class_base->mobileGetNicknameByUid($value['uid']);
        }
        if($_GPC['have'] && $_GPC['content']){
            //后台处理
            $up['re_time']      = time();
            $up['re_content']   = $_GPC['content'];
            foreach ($_GPC['have'] as  $value) {
                $class_bookinglist->dataEdit($value,$up);
                //发送通知

            }
            $this->myMessage("回复成功",$this->createWebUrl('booking_list',array("id"=>$_GPC['id'])),'成功');
        }
    }
    include $this->template('../admin/booking_list');
    exit();