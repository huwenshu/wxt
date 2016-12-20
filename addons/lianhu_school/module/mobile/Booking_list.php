<?php 
    $id                 = $_GPC['id'];
    $class_booking      = D('booking');
    $class_bookingList  = D('bookingList');
    $cclass_bookingList = C('bookingList');
    $cclass_bookingList->bookind_id = $id;
    $info               = $class_booking->dataEdit($id);
    if(!$info){
        $this->myMessage("没有找到该活动",$this->createMobileUrl("booking",array('school_id'=>$_GPC['school_id'])),'错误');
    }
    $page_title = $info['booking_title'];
    $result             = $cclass_bookingList->getBooKingPeopleList();
    $list               = $result['list'];
    if($_GPC['submit']){
        //报名
        if($info['ask_phone'] && !$_GPC['list_phone']){
            $this->myMessage("请填写你的手机信息",$this->createMobileUrl("book_list",array('id'=>$_GPC['id'],'school_id'=>$_GPC['school_id'])),'错误');
        }
        if($info['ask_name'] && !$_GPC['list_name']){
            $this->myMessage("姓名未填写",$this->createMobileUrl("book_list",array('id'=>$_GPC['id'],'school_id'=>$_GPC['school_id'])),'错误');
        }
         if($info['ask_id'] && !$_GPC['list_people_id']){
            $this->myMessage("请填写身份证号",$this->createMobileUrl("book_list",array('id'=>$_GPC['id'],'school_id'=>$_GPC['school_id'])),'错误');
        }       
        if(!$_GPC['list_content']){
            $this->myMessage("请填写申请理由",$this->createMobileUrl("book_list",array('id'=>$_GPC['id'],'school_id'=>$_GPC['school_id'])),'错误');
        }
        $_GPC['uid']        = getMemberUid();
        $_GPC['booking_id'] = $id;
        $in = getNewUpdateData($_GPC,$class_bookingList);
        $class_bookingList->dataAdd($in);
        $this->myMessage("报名成功",$this->createMobileUrl("book",array('school_id'=>$_GPC['school_id'])),'成功');
    }
    