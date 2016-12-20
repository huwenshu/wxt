<?php
$aw = 1;
//新的后台只允许 1.站长；2.校长；3.教师；4.家校通登记在录人员
$this->checkAdminWeb();
$admin_result = D('admin')->judeAdminType();
$left_top     = 'school_base_set';
$left_nav     = 'teacher_mobile';
$title        = '教师端设置';  
$sidebar_list = array(
    array('fun_str'=>'adminindex','fun_name'=>'系统首页'),
    array('fun_str'=>'teacher_mobile','fun_name'=>'教师端设置'),
);
$class_mobile = D('mobile');
$button_list  = $class_mobile->getButtonNav(false,true);
$index_list   = $class_mobile->getIndexNav(false,true);

if ($op=='edit' ){
    $result = $class_mobile->get($_GPC['id']);
    if($_GPC['submit']){
        $up['name']     = $_GPC['name'];
        $up['keyword']  = $_GPC['keyword'];
        $up['url']      = $_GPC['url'];
        if(stristr($_GPC['img'],'http'))
            $up['img']      = $_GPC['img'];
        else 
            $up['img']      = $_W['attachurl'].$_GPC['img'];
        
        $up['status']   = $_GPC['status'];
        $up['sort']     = $_GPC['sort'];
        if($_GPC['dis_one'])
         $up['dis_one']  = $_GPC['dis_one'];
        if($_GPC['dis_two'])
            $up['dis_two']   = $_GPC['dis_two'];
        $class_mobile->update($_GPC['id'],$up);
        $this->myMessage('修改成功',$this->createWebUrl('teacher_mobile'),'成功');
    }
}
if($op=='new'){
    if($_GPC['submit']){
        $up['name']     = $_GPC['name'];
        $up['keyword']  = $_GPC['keyword'];
        $up['url']      = $_GPC['url'];
        $up['status']   = $_GPC['status'];
        $up['sort']     = $_GPC['sort'];
        $up['dis_one']  = $_GPC['id'];
        $up['dis_two']  = $_GPC['dis_two'];
        $up['type']     = 12 ;
        $class_mobile->add($up);
        $this->myMessage('修改成功',$this->createWebUrl('teacher_mobile'),'成功');
    }
}
include $this->template('../admin/web_teacher_mobile');
exit();
