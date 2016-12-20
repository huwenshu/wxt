<?php 
namespace myclass\src;
 
class teacher extends common{ 
    public $tablename;

    public function __construct(){
        $this->tablename = tablename('lianhu_teacher');
        $this->setTable('lianhu_teacher');
        $this->setGlobal();      
    }
    //兼容以前的账户系统
    // 系统uid=>教师信息
    public function uidGet($uid){
        $params[':fanid'] = $uid;
        $result         = pdo_fetch("select * from ".$this->tablename." where fanid =:fanid ",$params);
        return  $result;        
    }
    //微信uid 
    public function wechatUidGet($uid){
        $result = pdo_fetch("select * from ".$this->tablename." where uid=:uid",array(":uid"=>$uid));
        return $result;
    }
    //获取教师的头像
    public function teacherImg($t_id){
        global $_W;
        $school_id = getSchoolId();
        if($t_id){
            $img       =  pdo_fetchcolumn("select teacher_img from ".$this->tablename." where teacher_id=:tid ",array(":tid"=>$t_id));
        }
        if(!$img){
           $img =  S("system",'getSetContent',array('school_logo',$school_id));
        }
        return $_W['attachurl'].$img;
    }
    //获取教师名字
    public function teacherName($t_id){
       $t_name= pdo_fetchcolumn("select teacher_realname from ".$this->tablename." where teacher_id={$t_id} ");
       return $t_name;
    }
    //teacher_id获取用户信息
    public function getTeacherInfo($teacher_id){
        $params[':tid'] = $teacher_id;
        $result         = pdo_fetch("select * from ".$this->tablename." where teacher_id =:tid ",$params);
        return  $result;
    }
    //获取教师的数量
    public function getTeacherCount($school_id){
        $params[":school_id"] = $school_id;
        $params[':status']    = 1;
        $where                = S("fun","composeParamsToWhere",array($params) );        
        $count                = pdo_fetchcolumn("select count(teacher_id) num from ".$this->tablename." where ".$where." ",$params);
        return $count;       
    }
    //获取教师列表
    public function getTeacherList($school_id){
        $params[":school_id"] = $school_id;
        $params[':status']    = 1;
        $where                = S("fun","composeParamsToWhere",array($params) );        
        $list                = pdo_fetchall("select *  from ".$this->tablename." where ".$where." ",$params);
        return $list;       
    }
    //获取教师绑定人数
    public function getBdTeacherCount($teacher_list){
        $num = 0;
        foreach ($teacher_list as $key => $value) {
            if( $value['uid']>0 ){
                $num++;
            }
        }
        return $num;       
    }
    //teacher_id获取绑定的openid
    public function getTeacherOpenid($teacher_id){
        $result = $this->getTeacherInfo($teacher_id);
        if($result['uid']){
            $fans = pdo_fetch("select openid from ".tablename("mc_mapping_fans")." where uid=:uid ",array(":uid"=>$result['uid']));
            return $fans['openid'];
        }
        return false;
    }
    //教师移动端验证
    public function teacherMobile(){
        global $_GPC,$_W;
		$uid    = getMemberUid();
		$result = pdo_fetch("select * from ".tablename('lianhu_teacher')." where uid={$uid} and uniacid = {$_W['uniacid']} ");
        if(!$result || $result['status']==0) {
           return false;            
        }else{
            return $result;
        }
    }
    #获取教师授课的详情
     public function getTeacherClass($teacher_id,$get_all=false){
        if(empty($teacher_id)) 
            return false;
        #是班主任的列表
        $list=pdo_fetchall("select class.*,grade.grade_name from ".tablename('lianhu_class')." class 
                            left join ".tablename('lianhu_grade')." grade on grade.grade_id=class.grade_id  
                            where class.status=1 and class.teacher_id=:tid",array(':tid'=>$teacher_id));
		#返回所有的班级
        if($get_all){
                $class_ids=pdo_fetchcolumn("select teacher_other_power from  ".tablename('lianhu_teacher')." where teacher_id=:tid ",array(':tid'=>$teacher_id) );
                if($class_ids){
                    $cid_arr   =explode(',',$class_ids);
                    $class_ids =implode(',',$cid_arr);
                    $list_all=pdo_fetchall("select class.*, grade.grade_name from ".tablename('lianhu_class')." class 
                                        left join ".tablename('lianhu_grade')." grade on grade.grade_id=class.grade_id  
                                        where class.status=1 and class.class_id in ({$class_ids})" );
                  }
            }
        return array('list'=>$list,'list_all'=>$list_all);    
    }   

}