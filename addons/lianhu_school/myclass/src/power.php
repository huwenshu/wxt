<?php 
namespace myclass\src;
class power{
    public $power_list = array(
        array('name'=>'学校基本设置','key_word'=>'school_base_set',
            'low_list'=>array(
                array('name'=>'学校参数',        'key_word'=>'school_params',    'fun'=>'school'),
                array('name'=>'家长端设置',       'key_word'=>'student_mobile',    'fun'=>'student_mobile'),
                array('name'=>'教师端设置',       'key_word'=>'teacher_mobile',    'fun'=>'teacher_mobile'),
                array('name'=>'年级管理',        'key_word'=>'grade_set',        'fun'=>'grade'),
                array('name'=>'班级管理',        'key_word'=>'class_set',        'fun'=>'class'),
                array('name'=>'学生管理',        'key_word'=>'student_set',      'fun'=>'student'),
                array('name'=>'教师管理',        'key_word'=>'teacher_set',      'fun'=>'teacher'),
                array('name'=>'课程管理',        'key_word'=>'course_set',       'fun'=>'course'),
                array('name'=>'考勤时间设置',     'key_word'=>'attenceSet',       'fun'=>'attenceSet'),
                array('name'=>'考勤数据更新',     'key_word'=>'update_school_grade_class_student', 'fun'=>'update_school_grade_class_student'),
                array('name'=>'学校管理人员',     'key_word'=>'school_admin',     'fun'=>'school_admin'),
                array('name'=>'占位符管理',       'key_word'=>'adv_admin',        'fun'=>'adv_admin'),
            ),
        ),
         array('name'=>'班级事务','key_word'=>'class_manage',
            'low_list'=>array(
                array('name'=>'请假管理','key_word'=>'leave','fun'=>'leave'),
                array('name'=>'作业管理','key_word'=>'homework','fun'=>'homework'),
                array('name'=>'课程表','key_word'=>'syllabus','fun'=>'syllabus'),
                array('name'=>'班级公告','key_word'=>'class_notice','fun'=>'line'),
                array('name'=>'班级圈','key_word'=>'class_line','fun'=>'class_line'),
                array('name'=>'学生记录','key_word'=>'student_record','fun'=>'student_record'),
                array('name'=>'成绩发布','key_word'=>'score_out','fun'=>'score_list'),
                array('name'=>'消息发送','key_word'=>'class_msg','fun'=>'msg'),
                array('name'=>'考勤管理','key_word'=>'attence','fun'=>'attence'),
            ),
        ),
         array('name'=>'校务管理','key_word'=>'school_msg',
            'low_list'=>array(
                array('name'=>'学校部门','key_word'=>'department','fun'=>'department'),
                array('name'=>'校长信箱','key_word'=>'schoolMessage','fun'=>'schoolMessage'),
                array('name'=>'报修管理','key_word'=>'repairFix','fun'=>'repairFix'),
                array('name'=>'活动预约','key_word'=>'appointment','fun'=>'appointment'),
                array('name'=>'校外报名','key_word'=>'booking','fun'=>'booking'),
                array('name'=>'收费管理','key_word'=>'money','fun'=>'money'),
                array('name'=>'数据导入','key_word'=>'data_in','fun'=>'data_in'),
                array('name'=>'数据统计','key_word'=>'data_out','fun'=>'data_out'),
                array('name'=>'学生食谱','key_word'=>'student_cookbook','fun'=>'cookbook'),
                array('name'=>'学校公告','key_word'=>'school_notice','fun'=>'student_record'),
                array('name'=>'成绩发布','key_word'=>'score_out','fun'=>'neimsg'),
                array('name'=>'通知教师','key_word'=>'teacher_msg','fun'=>'teacherMsg'),
            ),
        ),
         array('name'=>'官网管理','key_word'=>'wap_admin',
            'low_list'=>array(
                array('name'=>'wap管理','key_word'=>'wap_index','fun'=>'wap_index'),
                array('name'=>'web管理','key_word'=>'web_index','fun'=>'web_index'),
                array('name'=>'文章分类','key_word'=>'article_class','fun'=>'article_class'),
                array('name'=>'文章列表','key_word'=>'article_list','fun'=>'article_list'),
            ),
        ),
         array('name'=>'在线课堂','key_word'=>'line_edu',
            'low_list'=>array(
                array('name'=>'视频分类','key_word'=>'edu_video_class','fun'=>'edu_video_class'),
                array('name'=>'视频管理','key_word'=>'edu_video_list','fun'=>'edu_video_list'),
            ),
        ),
           array('name'=>'学校硬件','key_word'=>'school_hardware',
            'low_list'=>array(
                array('name'=>'教室监控','key_word'=>'class_video','fun'=>'video'),
                array('name'=>'考勤&校车','key_word'=>'hardware_card','fun'=>'device'),
            ),
        ),
          array('name'=>'系统数据','key_word'=>'system_data',
            'low_list'=>array(
                array('name'=>'系统数据','key_word'=>'school_data','fun'=>'school_data'),
                array('name'=>'学校数据','key_word'=>'teacher_his_data','fun'=>'teacher_his_data'),
                array('name'=>'报修数据','key_word'=>'repairData','fun'=>'repairData'),
            ),
        ),
         array('name'=>'系统设置','key_word'=>'system_set',
            'low_list'=>array(
                array('name'=>'切换公众号','key_word'=>'change_weixin','fun'=>'adminloginCheck'),
                array('name'=>'学校管理','key_word'=>'schoolManage','fun'=>'school_new'),
                array('name'=>'系统设置','key_word'=>'systemParams','fun'=>'systemParams'),
                array('name'=>'插件商城','key_word'=>'ourShop','fun'=>'ourShop'),
                array('name'=>'系统参数','key_word'=>'system_parameter','fun'=>'system_parameter'),
                array('name'=>'系统维护','key_word'=>'system_update','fun'=>'systemfix'),
                array('name'=>'用户组','key_word'=>'user_group','fun'=>'group'),
                array('name'=>'用户管理','key_word'=>'user_manage','fun'=>'user'),
            ),
        ),

    );
    public $group_type = array(
        array('name'=>'公众号','key'=>'mp'),
        array('name'=>'学校','key'=>'school'),
        array('name'=>'年级','key'=>'grade'),
    );
    //根据关键词识别
    public function distinguishGroupType($key){
        if($key=='all')
            $name = '全局';
        else{
            $type_list = $this->group_type;
            foreach($type_list as $row){
                if($key==$row['key']){
                    $name = $row['name'];
                    break;
                }
            }
        }
        return $name;
    }
    //识别一个具体权限的上级
    public function validUpKeyWord($low){
        $power_list = $this->power_list;
        foreach ($power_list as $key => $value) {
             foreach ($value['low_list'] as $k => $v) {
                 if($v['fun']==$low)
                    return $value['key_word'];
             }   
        }
    }
    //更新权限
    public function updateDbGroup($gid,$action_list){
        pdo_delete("lianhu_db_action",array("group_id"=>$gid));
        foreach ($action_list as $key => $value) {
            $in['group_id'] = $gid;
            $in['low_list'] = $value;
            $in['top_key']  = $this->validUpKeyWord($value);
            $in['add_time'] = time();     
            pdo_insert("lianhu_db_action",$in);
        }
    }
    //获取权限
    public function getDbGroup($gid){
        $list = pdo_fetchall("select * from ".tablename('lianhu_db_action')." where group_id = :gid ",array(":gid"=>$gid) );
        return $list;
    }
    //获取数据组可以管理的公众号，类别，学校，年级
    public function getDataInfo($group_id){
        global $_GPC;
        $class_classes = D('classes');
        $class_teacher = D('teacher');
        if($group_id!="N"){
            $params[":group_id"] = $group_id;
            $where               = S("fun",'composeParamsToWhere',array($params));
            $result              = pdo_fetch("select * from ".tablename('lianhu_data_group')." where ".$where." ",$params);
            $out['platform']     = explode(',',$result['data']);
            if($result['school_data']){
                $out['school']         = explode(',',$result['school_data']);
            }
            if($result['grade_data']){
                $out['grade']          = explode(',',$result['grade_data']);
            }
            $out['type']        = $result['type'];
            $out['group_name']  = $result['group_name'];
        }else{
            $admin_id           = $_GPC['_admin_id']; 
            $result             = D('admin')->getAdminInfo($admin_id);
            if($result['school_admin_id']){
                    $school_re = pdo_fetch("select * from ".tablename('lianhu_school_admin')." where admin_id=:admin_id ",array(":admin_id"=>$result['school_admin_id'])); 
                    $out['platform'][0]    = $school_re['uniacid'];
                    $out['school'][0]      = $school_re['school_id'];
            }elseif($result['teacher_id']){
                    $teacher_re = D('teacher')->getTeacherInfo($result['teacher_id']);
                    $out['platform'][0]    = $teacher_re['uniacid'];
                    $out['school'][0]      = $teacher_re['school_id']; 
                    if($teacher_re['teacher_other_power']){
                        $class_ids             = explode(',',$teacher_re['teacher_other_power']);
                        foreach ($class_ids as $key => $value) {
                            $group_ids[] = $class_classes->getClassGradeId($value);
                        }
                    }else{
                        $group_ids[] = 'N';
                    }
                    $class_list             = $class_teacher->getTeacherClass($result['teacher_id']);
                    $out['grade']           = $group_ids;
                    $out['class']           = $class_ids;
                    $out['class_main']      = $class_list['list'];
            }            
        }
        return $out;
    }
    //获取功能组可以用的功能
    public function getFunInfo($group_id){
        $params[":group_id"] = $group_id;
        $where               = S("fun",'composeParamsToWhere',array($params));        
        $list                = pdo_fetchall("select * from ".tablename('lianhu_db_action')." where ".$where." ",$params);
        foreach($list as $row){
            $top_list[] = $row['top_key'];
            $low_list[] = $row['low_list'];
        }
        return array('top'=>$top_list,'low'=>$low_list);
    }


}