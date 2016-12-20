<?php 
		$aw = 1;
		//新的后台只允许 1.站长；2.校长；3.教师；4.家校通登记在录人员
		$this->checkAdminWeb();
		$admin_result = D('admin')->judeAdminType();
		$left_top     = 'school_msg';
		$left_nav     = 'school_notice';
		$title  = $page_title      = '学校公告';  
		$sidebar_list = array(
			array('fun_str'=>'','fun_name'=>'学校消息'),
			array('fun_str'=>'neimsg','fun_name'=>'学校公告'),
		);
		$top_action = array(
			array('action_name'=>'添加新公告','action'=>'neimsg','arr'=>array('aw'=>1,'op'=>'new') ),
		);

		$this->teacher_qx();#管理员可进入
		$school_uniacid = " and ".$this->where_uniacid_school;
		$class_student  = D('student');	
		$class_neiMsg   = D('neiMsg');
		$op 		    = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		if($op=='display'){
			if($_GPC['status']){
				if($_GPC['status']==2){
					$params[":status"] = 0;
				}else{
					$params[":status"] = 1;
				}
			}
			$result = $class_neiMsg->getList($params);
			$list   = $result['list'];
			$num 	= $result['count'];
		}	
		if($op=='edit'){
			$id     = intval($_GPC['id']);
			$result = $class_neiMsg->edit(array("msg_id"=>$id));
		 if($_GPC['submit']){
			$in['msg_title'] 	= $_GPC['msg_title'];
			$in['msg_content'] 	= $_GPC['msg_content'];
			$in['status'] 		= $_GPC['status'];
			$in['img'] 		    = $_GPC['img'];
			$in['db_admin_id']  = getDbAdminId();
			$data_up 			= getNewUpdateData($in,$class_neiMsg);
			$class_neiMsg->edit(array('msg_id'=>$_GPC['id']),$data_up);
			$this->myMessage('修改成功',$this->createWebUrl('neimsg',array('aw'=>$aw) ),'成功');
		 }
		}
		if($op=='new'){
		 if($_GPC['submit']){

			$in['msg_title'] 	= $_GPC['msg_title'];
			$in['msg_content'] 	= $_GPC['msg_content'];
			$in['addtime'] 		= TIMESTAMP;
			$in['uniacid']      = $_W['uniacid'];
			$in['img'] 	 		= $_GPC['img'];
			$in['school_id']    = getSchoolId();
			$in['db_admin_id']  = getDbAdminId();
			$data_in 			= getNewUpdateData($in,$class_neiMsg);
			$msg_id 			= $class_neiMsg->add($data_in);
			//发送模板消息
			$class_msg   		= D("msg");
			$student_list 		= $class_student->getStudentlist();
			$admin_name     	= $this->getWebAdminName();
			foreach ($student_list as $key => $value) {
				  $openids   = $class_student->returnEfficeOpenid($value,3);
			      $title     = "学校通知";
				  $key2 	 = $admin_name; 
				  $key4   	 = $_GPC['msg_title'];
				  $remark 	 = "点击查看详情";
				  $class_msg->msg_student_id = $value['student_id'];
                    foreach ($openids as $key => $v) {
                        if($v){
                           $mu_info = $this->decodeMsg($title,$key2,$key4,$remark);   
						   $url     = $_W['siteroot'].'app/'.$this->createMobileUrl("msg_content",array('id'=>$msg_id ) );
                           $que_num = $class_msg->insertMsgQueueMu($v,$mu_info['data'],$mu_info['mu_id'],$url,$que_num);
                        }
                    }
			}
			$this->myMessage('添加成功，跳转往发送页面，请勿关闭',$this->createWebUrl('sendToMsg',array('que_num'=>$que_num,'aw'=>1)),'成功');
		 }	
		}
		if($op=='delete'){
			$id=intval($_GPC['id']);
			pdo_delete('lianhu_msg',array('msg_id'=>$id));
			$this->myMessage('删除成功',$this->createWebUrl('neimsg',array('aw'=>$aw)),'成功');		
		}
	include $this->template('../admin/web_neimsg');
	exit();
