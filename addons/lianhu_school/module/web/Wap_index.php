<?php 
		$aw = 1;
		//新的后台只允许 1.站长；2.校长；3.教师；4.家校通登记在录人员
		$this->checkAdminWeb();
		$admin_result = D('admin')->judeAdminType();
		$left_top     = 'wap_admin';
		$left_nav     = 'wap_index';
		$title        = '首页管理';  
		$sidebar_list = array(
				array('fun_str'=>'','fun_name'=>'官网管理'),
				array('fun_str'=>'wap_index','fun_name'=>'首页管理'),
		);
		$top_action = array(
			array('action_name'=>'添加新的信息','action'=>'wap_index','arr'=>array('ac'=>'new') ),
		);		
		$class_wap = D("wap");
        $list      = $class_wap->getAll(); 
		if($ac=='new'){
			if($_GPC['submit']){
				$in['key_word'] 	= $_GPC['key_word']?$_GPC['key_word'] :$_GPC['sys_key'];
				$in['content']  	= $_GPC['text_content']  ? $_GPC['text_content'] : $_GPC['img_content'];
				$in['sort'] 		= $_GPC['sort'];
				$in['status'] 		= $_GPC['status'];
				$in['info_name'] 	= $_GPC['info_name'];
				$in['fun_name'] 	= $_GPC['fun_name'];
				$in['info_url'] 	= $_GPC['info_url'];
				$class_wap->addInfo($in);
				$this->myMessage('新增成功',$this->createWebUrl('wap_index'),'成功');
			}
		}
		if($ac=='edit'){
			$id 	= $_GPC['id']; 
			$result = $class_wap->editInfo($id,false);
			if(stristr($result['content'],'images')){
				$img_content = $result['content'];
			}else{
				$text_content = $result['content'];
			}
			if($_GPC['submit']){
				$in['key_word'] 	= $_GPC['key_word']?$_GPC['key_word'] :$_GPC['sys_key'];
				$in['content']  	= $_GPC['text_content']  ? $_GPC['text_content'] : $_GPC['img_content'];
				$in['sort'] 		= $_GPC['sort'];
				$in['status'] 		= $_GPC['status'];
				$in['info_name'] 	= $_GPC['info_name'];
				$in['fun_name'] 	= $_GPC['fun_name'];
				$in['info_url'] 	= $_GPC['info_url'];	
				$result = $class_wap->editInfo($id,$in);
				$this->myMessage('编辑成功',$this->createWebUrl('wap_index'),'成功');
								
			}
		}
		include $this->template('../admin/wap_index');
		exit();
