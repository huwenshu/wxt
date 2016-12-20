<?php 
			$aw = 1;
			//新的后台只允许 1.站长；2.校长；3.教师；4.家校通登记在录人员
			$this->checkAdminWeb();
			$admin_result = D('admin')->judeAdminType();
			$left_top     = 'class_manage';
			$left_nav     = 'syllabus';
			$title        = '课程表';  
			$sidebar_list = array(
				array('fun_str'=>'','fun_name'=>'班级管理'),
				array('fun_str'=>'syllabus','fun_name'=>'课程表'),
			);
			$top_action = array(
				array('action_name'=>'课程表','action'=>'syllabus','arr'=>array('aw'=>1) ),
				array('action_name'=>'课程时间','action'=>'syllabus','arr'=>array('ac'=>'edit_course_time','aw'=>1) ),
			);
		$teacher 	= $this->teacher_qx('no');
		$school_id  = getSchoolId();
		if($teacher == 'teacher'){
			$uid  = $_W['uid'];
			$t_id = getTeacherId();
			$list = pdo_fetchall("select class.*, sylla.syllabus_id from {$table_pe}lianhu_class class 
                left join {$table_pe}lianhu_syllabus sylla on sylla.class_id=class.class_id 
                left join {$table_pe}lianhu_grade grade on class.grade_id =grade.grade_id
                where class.status=1 and class.teacher_id={$t_id} order by grade_name desc , grade_id desc ");
		}else{
			$school_uniacid_class = " and class.uniacid={$_W['uniacid']} and class.school_id={$school_id} ";
			$list 				  = D('classes')->getThisAdminClassList();
			foreach ($list as $key => $value) {
				$list[$key]['syllabus_id'] = pdo_fetchcolumn("select syllabus_id from ".tablename('lianhu_syllabus')." where class_id=:class_id ",array(":class_id"=>$value['class_id']) );
			}
		}
		$quanxian_class_id_arr = array();
		if($list){
			foreach ($list as $key => $value) {
				if(in_array($value['class_id'], $quanxian_class_id_arr)){
					unset($list[$key]);
					continue;
				}
				$quanxian_class_id_arr[]=$value['class_id'];
			}
		}else{
			$this->myMessage("只有班主任和管理员能够访问，或者暂未设置年级班级");
		}
		for ($i=0; $i <100 ; $i++) { 
			$loop[$i]=1;
		}
		$school_info  = $this->school_info;
		$on_school    = $school_info['on_school'];
		$begin_course = $school_info['begin_day'];
		$am_much      = $school_info['am_much'];
		$pm_much      = $school_info['pm_much'];
		$ye_much      = $school_info['ye_much'];
        
		if($ac=='new'){
			if(in_array($_GPC['cid'],$quanxian_class_id_arr)){
				$class_result=pdo_fetch("select * from {$table_pe}lianhu_class where class_id=:cid",array(':cid'=>$_GPC['cid']));
				$course_ids=unserialize($class_result['course_ids']);
				if($course_ids){
					foreach ($course_ids as $key => $value) {
						$courses[$key]['id']=$value;
						$courses[$key]['name']=pdo_fetchcolumn("select course_name from {$table_pe}lianhu_course where course_id={$value}" );
					}
				}
				$old_result=pdo_fetch("select * from {$table_pe}lianhu_syllabus where class_id=:cid order by addtime desc ",array(':cid'=>$_GPC['cid']));
				if($old_result){
					$data=unserialize($old_result['content']);
				}
			}else{
				$this->myMessage("非法访问1");
			}
		}
		if($ac=='save'){
			if(in_array($_GPC['cid'],$quanxian_class_id_arr)){
				$class_result=pdo_fetch("select * from {$table_pe}lianhu_class where class_id=:cid",array(':cid'=>$_GPC['cid']));
				$in['addtime']=TIMESTAMP;
				$in['teacher_uid']=$_W['uid'];
				$in['class_id']=$_GPC['cid'];
				$in['grade_id']=$class_result['grade_id'];
				$in['on_school']=$on_school;
				$in['am_much']=$am_much;
				$in['pm_much']=$pm_much;
				$in['ye_much']=$ye_much;
				$in['uniacid']=$_W['uniacid'];
				$in['school_id']=$school_id;
				$content['am']=$_GPC['am'];
				$content['pm']=$_GPC['pm'];
				$content['ye']=$_GPC['ye'];
                $content['teacher_am']=$_GPC['teacher_am'];
                $content['teacher_pm']=$_GPC['teacher_pm'];
                $content['teacher_ye']=$_GPC['teacher_ye'];
				$in['content']=serialize($content);
				$in['url']    =$_GPC['url'];
				pdo_insert('lianhu_syllabus',$in);
				$this->myMessage("编辑成功",$this->createWebUrl('syllabus',array('ac'=>'new','cid'=>$_GPC['cid'] ,'aw'=>1)),'success');
			}else{
				$this->myMessage("非法访问2");
			}
		}
        if($ac=='edit_course_time'){
            if($_GPC['submit']=='提交'){
 				$in['uniacid']=$_W['uniacid'];
				$in['school_id']=$school_id;
                $in['keyword']  ='course_time';
                $content['begin_time']=$_GPC['begin_time'];
                $content['end_time']=$_GPC['end_time'];   
                $in['content']=serialize($content);
                pdo_insert('lianhu_set',$in);               
				$this->myMessage("新增成功",$this->createWebUrl('syllabus',array('ac'=>'edit_course_time','aw'=>1)),'success');
            }
            $result=pdo_fetch("select * from {$table_pe}lianhu_set where keyword='course_time' and school_id=:school_id order by set_id  desc ",array(":school_id"=>$school_id));
            $result['content']=unserialize($result['content']);
            $result['begin_time']=$result['content']['begin_time'];
            $result['end_time']=$result['content']['end_time'];
        }
			#组合list
			if($list){
				$grade_ids = array();
				$new_list  = ''; 
				foreach ($list as $key => $value) {
					if(in_array($value['grade_id'],$grade_ids)){
						array_push($new_list[$value['grade_id']],$value);
					}else{
						$new_list[$value['grade_id']][0] = $value;
						$grade_ids[] = $value['grade_id'];
					}
				}
				$list = $new_list;
			}
			include $this->template('../admin/web_syllabus');
			exit();
        