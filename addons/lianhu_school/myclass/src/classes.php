<?php 
namespace myclass\src;

class classes extends common{
    public $grade_id;

    public function __construct(){
        $this->setGlobal();
        $this->setTable("lianhu_class");       
    }
    public function className($class_id){
        if(empty($class_id)){
			return false;
		} 
        $result = $this->edit(array('class_id'=>$class_id));
        return $result['class_name'];
    }
    public function getClassCount($school_id=false){
        if($school_id){
            $this->school_id  = $school_id; 
        }
        $params[':status']    = 1;
        $this->each_page      = 100000;
        $result               = $this->getList($params);
        $count                = $result['count'];
        return $count;
    }
    public function getClassList(){
        $params[":grade_id"] = $this->grade_id;
        $params[':status']   = 1;
        $this->each_page     = 100000;
        $result              = $this->getList($params);
        $list                = $result['list'];
        return $list;
    }
    //查找班级
    public function findClassByInfo($grade_id,$class_name){
        $params[":grade_id"]     = $grade_id;
        $params[':class_name']   = $class_name;
        $where                   = S("fun","composeParamsToWhere",array($params) );
        $result                  = pdo_fetch("select * from  ".$this->table." where ".$where." ",$params);
        return $result;      
    }
    //获取班级的年级名id
    public function getClassGradeId($class_id){
        $params[":class_id"] = $class_id;
        $where               = S("fun","composeParamsToWhere",array($params) );
        $result              = pdo_fetch("select * from  ".$this->table." where ".$where." ",$params);
        return $result['grade_id'];
    }
    //处理超过年限
    public function resoveEndClass(){
        $where['grade_id'] = $this->grade_id;
        $up['status']     = 2;
        pdo_update('lianhu_class',$up,$where);       
    }
    //班级课程表
    public function classSyllabus($class_id){
        $old_result = pdo_fetch("select * from ".tablename('lianhu_syllabus')." where class_id=:cid order by addtime desc ",array(':cid'=>$class_id ));
        return $old_result;
    }
    //该用户可以查看的班级
    public function getThisAdminClassList($all=false,$params=false){
        global $_GPC;
        if($_GPC['_data_group_id']){
            $data_group = D('power')->getDataInfo($_GPC['_data_group_id']);
            $grade_list = D('grade')->getThisAdminGradeList();
        }
        if(!$all){
            $params[":status"] = 1; 
        }
        $params[":school_id"]  = getSchoolId();
        $where                 = S("fun","composeParamsToWhere",array($params) );
        if($grade_list){
            foreach ($grade_list as $key => $value) {
                $grade_ids[] = $value['grade_id'];
            }
            $grade_id_str = implode(',',$grade_ids);
            $where       .= " and grade_id in (".$grade_id_str.") ";
        }
        $list   = pdo_fetchall("select * from ".$this->table." where ".$where." order by class_id desc  ",$params);
        if($data_group['class']){
            foreach ($list as $key => $value) {
                if(!in_array($value['class_id'],$data_group['class']) ){
                    unset($list[$key]);
                }              
            }
        }
        return $list;
    }   

}

