<?php 
			$aw = 1;
			//新的后台只允许 1.站长；2.校长；3.教师；4.家校通登记在录人员
			$this->checkAdminWeb();
			$admin_result = D('admin')->judeAdminType();
			$left_top     = 'school_base_set';
			$left_nav     = 'class_set';
			$title        = '班级设置';  
			$sidebar_list = array(
				array('fun_str'=>'adminindex','fun_name'=>'系统首页'),
				array('fun_str'=>'class','fun_name'=>'班级设置'),
			);
			$top_action = array(
				array('action_name'=>'新增班级','action'=>'class','arr'=>array('ac'=>'new','aw'=>1) ),
			);

			$school_uniacid = " and ".$this->where_uniacid_school;
			$class_grade 	= D('grade');
			$class_grade->school_id = getSchoolId();
			$grade_list  = $class_grade->getThisAdminGradeList();
			$course_list = pdo_fetchall("select * from {$table_pe}lianhu_course where 1=1 {$school_uniacid} ");
			$video_list  = pdo_fetchall("select * from {$table_pe}lianhu_video where status=1 {$school_uniacid} ");
			if($ac=='list'){
				if($_GPC['grade_id']){
				    $params[':grade_id']=$_GPC['grade_id'];
                }
				if($_GPC['status']){
                    $params[':status']=$_GPC['status'];
				}
				$list  = D('classes')->getThisAdminClassList(true,$params);
				foreach ($list as $key => $value) {
					$list[$key]['grade_name']   	= $this->gradeName($value['grade_id']);	
					$list[$key]['teacher_realname'] = $this->teacherName($value['teacher_id']);	
				}
				$num = count($list);
			}
			if($ac=='new'){
                #获取基本课程
                $base_class=pdo_fetchall("select course_id from {$table_pe}lianhu_course where course_basic=1 ");
                foreach ($base_class as $key => $value) {
                    $course_ids[$key]=$value['course_id'];
                }
				if($_GPC['submit']){
                    $where[':class_name']=$_GPC['class_name'];
                    $where[':gid']       =$_GPC['grade_id'];
                    $result=pdo_fetch("select * from {$table_pe}lianhu_class where class_name=:class_name and grade_id=:gid {$school_uniacid}",$where);
                    if($result){
                        $this->myMessage('此班级名已经存在',$this->createWebUrl('class',array('aw'=>$aw) ),'错误');
                    }
					$in['class_name']  = $_GPC['class_name'];
					$in['grade_id']    = $_GPC['grade_id'];
					$in['line_img']    = $_GPC['line_img'];
					$in['course_ids']  = serialize($_GPC['course_s']);
					$in['video_ids']   = serialize($_GPC['video_s']);
					$in['uniacid'] 	   = $_W['uniacid'];
					$in['school_id']   = getSchoolId();
					pdo_insert('lianhu_class',$in);
					$this->myMessage('新增成功',$this->createWebUrl('class',array('aw'=>$aw) ),'成功');
				}
			}
			if($ac=='edit'){
				$id=(int)$_GPC['id'];
				if(empty($id))
					$this->myMessage('非法传输','','错误');

				$result  		= pdo_fetch("select * from {$table_pe}lianhu_class where class_id={$id}");					
				$list_teacher   = pdo_fetchall("select * from {$table_pe}lianhu_teacher where teacher_other_power like '%{$id}%' and status=1 {$school_uniacid} ");
				if($_GPC['submit']){                  
					$in['class_name'] 	= $_GPC['class_name'];
					$in['grade_id'] 	= $_GPC['grade_id'];
					$in['line_img']     = $_GPC['line_img'];
					$in['teacher_id']   = $_GPC['teacher_id'];
					$in['status'] 	    = $_GPC['status'];
					$in['course_ids']   = serialize($_GPC['course_s']);
                    $in['video_ids']    = serialize($_GPC['video_s']);
					pdo_update('lianhu_class',$in,array('class_id'=>$id));
					$this->myMessage('修改成功',$this->createWebUrl('class',array('aw'=>$aw)),'成功');					
				}
            }
			if($ac=='delete'){
				$id=(int)$_GPC['id'];
				if(pdo_fetch("select * from {$table_pe}lianhu_student where class_id=:class_id",array(':class_id'=>$id) )){
					$this->myMessage('无法删除,该班级下已有学生','','错误');
				}else{
					pdo_delete('lianhu_class',array('class_id'=>$id));
					$this->myMessage('删除成功',$this->createWebUrl('class',array('aw'=>$aw)),'成功');		
				}
			}	
//测试后台
	include $this->template('../admin/web_class');
	exit();