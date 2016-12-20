<?php 
	$this->checkAdminWeb();
	$admin_result = D('admin')->judeAdminType();
	$left_top     = 'school_hardware';
	$left_nav     = 'hardware_card';
	$title        = '进校打卡&校车';  
	$sidebar_list = array(
        array('fun_str'=>'','fun_name'=>'学校硬件'),
        array('fun_str'=>'device','fun_name'=>'进校打卡&校车'),
	);
	$top_action = array(
        array('action_name'=>'添加新的设备','action'=>'device','arr'=>array('aw'=>1,'ac'=>'new') ),
    );
    $school_id       = getSchoolId();
    $class_device    = D('device');
    $class_schoolBus = C('schoolBus');
    $device_types    = $class_device->device_type; 
    if($ac=='list'){
        $list = $class_device->dataList(false);
        $list = $list['list'];
    }
    if($ac=='new'){
        if($_GPC['submit']){
            $in['device_name']          = $_GPC['device_name'];
            $in['device_openid']        = $_GPC['device_openid'];
            $in['device_status']        = $_GPC['device_status'];
            $in['img_ad_name']          = $_GPC['img_ad_name'];
            $in['video_name']           = $_GPC['video_name'];
            $in['video_url']            = $_GPC['video_url'];
            $in['template_device']      = $_GPC['template_device'];
            $in['template_device_mac']  = $_GPC['template_device_mac'];
            $in['device_type']          = $_GPC['device_type'];
            if($_GPC['img_ads']){
                $in['img_ads']          = implode("#",$_GPC['img_ads']);
            }else{
                $in['img_ads']          = '';
            }
            $class_device->dataAdd($in);
            $this->myMessage("设备添加成功",$this->createWebUrl('device',array('aw'=>1)),'成功');
        }
    }
    if($ac=='edit'){
        $id     = $_GPC['id'];
        $result = $class_device->dataEdit($id);
        if($result['img_ads']){
            $result['img_ads'] = explode("#",$result['img_ads']);
        }
        if($_GPC['submit']){
            $in['device_name']          = $_GPC['device_name'];
            $in['device_openid']        = $_GPC['device_openid'];
            $in['device_status']        = $_GPC['device_status'];
            $in['img_ad_name']          = $_GPC['img_ad_name'];
            $in['video_name']           = $_GPC['video_name'];
            $in['video_url']            = $_GPC['video_url'];
            $in['template_device']      = $_GPC['template_device'];
            $in['template_device_mac']  = $_GPC['template_device_mac'];
            $in['device_type']          = $_GPC['device_type'];
            if($_GPC['img_ads']){
                $in['img_ads']          = implode("#",$_GPC['img_ads']);        
            }else{
                $in['img_ads']          ='';        
            }
            $result = $class_device->dataEdit($id,$in);
            $this->myMessage('修改成功',$this->createWebUrl('device',array('aw'=>1)),'成功');					
        }    
    }
    if($ac=='delete'){
        $id                 = $_GPC['id'];
        $where["device_id"] = $id;
        if($id){
            $class_device->delete($where);
        }
        $this->myMessage('删除成功',$this->createWebUrl('device',array('aw'=>1)),'成功');					
    }
	include $this->template('../admin/web_device');
    exit();
