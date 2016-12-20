<?php 
$title = '管理员登录';
//登录操作  
if($_GPC['username']){
    $result = D('admin')->systemLogin($_GPC['username'],$_GPC['password']);    
    if($result['errcode']==1)
        $this->myMessage($result['msg'],referer(),'错误');
    elseif($result['errcode']==0) {
        $admin_info = D('admin')->judeAdminType($result['uid']);
        $this->myMessage('登录成功', $_W['siteroot'].'web/'.$this->createWebUrl('adminloginCheck'),'成功');
    }
}
