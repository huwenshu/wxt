<?php 
					$aw = 1;
					//新的后台只允许 1.站长；2.校长；3.教师；4.家校通登记在录人员
					$this->checkAdminWeb();
					$admin_result = D('admin')->judeAdminType();
					$left_top     = 'class_manage';
					$left_nav     = 'homework';
					$title        = '作业管理';  
					$sidebar_list = array(
						array('fun_str'=>'','fun_name'=>'班级管理'),
						array('fun_str'=>'homework','fun_name'=>'作业管理'),
					);
                    $teacher        = $this->teacher_qx('no');
                    $school_uniacid = " and ".$this->where_uniacid_school;
                    $model          = $_GPC['model'] ? $_GPC['model'] :"class";
                    $cid            = $_GPC['cid'];
                    $class_teacher  = D('teacher');
                    if($teacher=='teacher'){
                                $t_id    = getTeacherId();
                                $t_name  = $class_teacher->teacherName($t_id);
                                $list_re = $class_teacher->getTeacherClass($t_id,true);
                                $list    = $list_re['list_all'];
                                $course_list = $this->teacherCourse($t_id);
                    }else{
                                $list   =  D('classes')->getThisAdminClassList();
                                $t_name = "管理员";
                                $course_list=$this->returnAllEfficeCourse();
                    }
                    if($cid){
                        $class = D('classes')->edit(array('class_id'=>$cid));
                        if(!$class) 
                            $this->myMessage('没有找到此班级',$this->createWebUrl('line',array('aw'=>$aw) ),'错误');
                    }
                    //发布作业
                    if($ac=='new'){
                        if($_GPC['submit'] && $_GPC['class_ids'] ){
                        if($_GPC['img']){
                            $in['img']     = serialize($_GPC['img']);
                        }
                        $in['content']   = $_GPC['content'];
                        $in['uniacid']   = $_W['uniacid'];
                        $in['school_id'] = getSchoolId();
                        $in['course_id'] = $_GPC['course_id'];
                        $in['teacher_id']= $t_id;
                        $in['add_time']  = time();
                        $que_num=false;
                        foreach ($_GPC['class_ids'] as $key => $value) {
                            if($value){
                                $in['class_id'] = $value;
                                pdo_insert('lianhu_homework',$in);
                                $hid            = pdo_insertid();
                                $que_num        = $this->sendClassMsg($hid,$que_num);
                            }
                        }
                        $this->myMessage("作业发布成功，进入消息发布通道请勿关闭网页",$this->createWebUrl('sendToMsg',array('que_num'=>$que_num,'aw'=>$aw )),'成功');        
                     }
                        $ac ='list';
                    }
                    if($ac=='old'){
                        if($t_id){
                            $where          = " teacher_id = :tid and ";
                            $params[":tid"] = $t_id;
                        }
                        $where            .= "class_id=:cid";
                        $params[":cid"]    = $cid;
                        $list              = pdo_fetchall("select * from {$table_pe}lianhu_homework where {$where}  order by  homework_id desc ",$params);
                    }
                    if($ac=='edit'){
                        $result = pdo_fetch("select * from {$table_pe}lianhu_homework where homework_id=:hid ",array(":hid"=>$_GPC['hid']) );
                        if($result['img']) 
                                $images = unserialize($result['img']);
                        if($_GPC['submit'] && $_GPC['hid'] ){
                            if($_GPC['img'])
                                    $in['img']    =serialize($_GPC['img']);
                            $in['content']  =$_GPC['content'];
                            $in['status']   =$_GPC['status'];
                            $in['course_id']=$_GPC['course_id'];
                            pdo_update('lianhu_homework',$in,array('homework_id'=>$_GPC['hid']));
                            $this->myMessage("编辑",$this->createWebUrl('homework',array('aw'=>$aw)),'成功');        
                            }
                    }
                    include $this->template('../admin/web_homework');
                    exit();