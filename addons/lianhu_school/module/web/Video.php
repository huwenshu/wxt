<?php 
    $this->checkAdminWeb();
    $admin_result = D('admin')->judeAdminType();
    $left_top     = 'school_hardware';
    $left_nav     = 'class_video';
    $title        = '教室监控';  
    $sidebar_list = array(
        array('fun_str'=>'','fun_name'=>'学校硬件'),
        array('fun_str'=>'video','fun_name'=>'教室监控'),
    );
    $top_action = array(
        array('action_name'=>'添加新的监控','action'=>'video','arr'=>array('aw'=>1,'ac'=>'new') ),
    );
    $school_id   = getSchoolId();
    $class_video = C('video'); 
    if($ac == 'list'){
        $list = $class_video->getVideoList();
    }
    if($ac == 'new'){
        if($_GPC['submit']){
            $in['video_name']  = $_GPC['video_name'];
            $in['video_url']   = $_GPC['video_url'];
            $in['begin_time']  = $_GPC['begin_time'];
            $in['end_time']    = $_GPC['end_time'];
            $in['video_img']   = $_GPC['video_img'];
            $in['status']      = $_GPC['status'];
            $in['video_type']  = $_GPC['video_type'];
            $in['html_content']= $_GPC['html_content'];
            $in['passport']    = $_GPC['passport'];
            $in['password']    = $_GPC['password'];
            $in['ip_addr']     = $_GPC['ip_addr'];
            $class_video->use_class->add($in);
            $this->myMessage("视频添加成功",$this->createWebUrl('video',array('aw'=>$aw)),'成功');
        }
    }
    if($ac=='edit'){
        $id = $_GPC['id'];
        if(empty($id)){
            $this->myMessage('非法传输','','错误');
        }
        $result = $class_video->use_class->edit(array('video_id'=>$id));
        if($_GPC['submit']){
            $in['video_name']   = $_GPC['video_name'];
            $in['video_url']    = $_GPC['video_url'];
            $in['begin_time']   = $_GPC['begin_time'];
            $in['end_time']     = $_GPC['end_time'];
            $in['video_img']    = $_GPC['video_img'];
            $in['status']       = $_GPC['status'];
            $in['video_type']   = $_GPC['video_type'];
            $in['html_content'] = $_GPC['html_content'];
            $in['passport']     = $_GPC['passport'];
            $in['password']     = $_GPC['password'];
            $in['ip_addr']      = $_GPC['ip_addr'];
            $class_video->use_class->edit(array('video_id'=>$id),$in);
            $this->myMessage('修改成功',$this->createWebUrl('video'),'成功');					
        }    
    }
    if($ac == 'delete'){
        $id = $_GPC['id'];
        if($id){
            $class_video->use_class->delete(array('video_id'=>$id));
            $this->myMessage('删除成功',$this->createWebUrl('video'),'成功');					
        }
    }
    include $this->template('../admin/web_video');
    exit();
