<?php
	global $_W,$_GPC;
				$aw = 1;
				//新的后台只允许 1.站长；2.校长；3.教师；4.家校通登记在录人员
				$this->checkAdminWeb();
				$admin_result = D('admin')->judeAdminType();
				$left_top     = 'school_base_set';
				$left_nav     = 'course_set';
				$title        = '课程设置';  
				$sidebar_list = array(
					array('fun_str'=>'adminindex','fun_name'=>'系统首页'),
					array('fun_str'=>'course','fun_name'=>'课程设置'),
				);
				$top_action = array(
					array('action_name'=>'添加课程','action'=>'course','arr'=>array('ac'=>'new','aw'=>1) ),
				);

		$school_uniacid =" and ".$this->where_uniacid_school;
		if($_GPC['ac']  == 'new'){
			if($_GPC['submit']=='提交'){
				if($_GPC['course_name']){
					$result=pdo_fetch("select * from {$table_pe}lianhu_course where course_name=:course_name {$school_uniacid} ",array(':course_name'=>$_GPC['course_name']));
					if($result){
						$this->myMessage('已经存在这个课程啦！',$this->createWebUrl('course',array('aw'=>$aw)),'错误');
					}
					$in['course_name']=$_GPC['course_name'];
					$in['addtime']=TIMESTAMP;
					$in['school_id']=getSchoolId();
					$in['uniacid']=$_W['uniacid'];
					pdo_insert('lianhu_course',$in);
					$this->myMessage('新增成功',$this->createWebUrl('course',array('aw'=>$aw) ),'成功');
				}else{
					$this->myMessage('请输入课程名',$this->createWebUrl('course',array('aw'=>$aw) ),'错误');
				}				
			}
		}elseif($_GPC['ac']=='edit'){
			$result=pdo_fetch("select * from {$table_pe}lianhu_course where course_id=:course_id  {$school_uniacid}",array(':course_id'=>$_GPC['cid']));
			if($_GPC['submit']=='提交'){
				if($_GPC['course_name']){
					$result=pdo_fetch("select * from {$table_pe}lianhu_course where course_name=:course_name  and course_id !=:cid  {$school_uniacid}",array(':course_name'=>$_GPC['course_name'],':cid'=>$_GPC['cid']));
					if($result){
						$this->myMessage('已经存在这个课程啦！',$this->createWebUrl('course',array('aw'=>$aw)),'错误');
					}
					$in['course_name']=$_GPC['course_name'];
					pdo_update('lianhu_course',$in,array('course_id'=>$_GPC['cid']));
					$this->myMessage('更新成功',$this->createWebUrl('course',array('aw'=>$aw)),'成功');
				}else{
					$this->myMessage('请输入课程名',$this->createWebUrl('course',array('aw'=>$aw)),'错误');
				}				
			}
		}elseif($_GPC['ac']=='delete'){
			if($_GPC['cid']){
				pdo_delete('lianhu_course',array('course_id'=>$_GPC['cid']));
				$this->delete_course_class($_GPC['cid'],'all');
				$this->delete_course_teacher($_GPC['cid'],'all');
				$this->myMessage('删除成功',$this->createWebUrl('course',array('aw'=>$aw)),'成功');
			}
		}elseif($_GPC['ac']=='update'){
            if($_GPC['delete']==1){
                 if($_GPC['cid']){
                    pdo_update('lianhu_course',array('course_basic'=>0),array('course_id'=>$_GPC['cid']));
                    $this->add_course_class($_GPC['cid'],'all');
                    $this->myMessage('降为普通课程成功',$this->createWebUrl('course',array('aw'=>$aw)),'成功');
                }               
            }else{
                if($_GPC['cid']){
                    pdo_update('lianhu_course',array('course_basic'=>1),array('course_id'=>$_GPC['cid']));
                    $this->add_course_class($_GPC['cid'],'all');
                    $this->myMessage('设置为基础课程成功',$this->createWebUrl('course',array('aw'=>$aw)),'成功');
                }               
            }
		}else{
			$list=pdo_fetchall("select * from  {$table_pe}lianhu_course where 1=1 {$school_uniacid} ");
		}
		$ac = $_GPC['ac'] ? $_GPC['ac'] :'list';
			include $this->template('../admin/web_course');
			exit();