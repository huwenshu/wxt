<?php 
namespace myclass\src;

class grade{
    public $school_id;

    //一个学校下面的年级数
    public static function gradeCount($school_id){
        $params[":school_id"] = $school_id;
        $params[":status"]    = 1;
        $where  = S("fun","composeParamsToWhere",array($params) );
        $count  = pdo_fetchcolumn( "select count(*)  num from ".tablename("lianhu_grade")." where ".$where." ",$params );
        return $count;
    }
    public function getSchoolList(){
        $where  = " status=:status and school_id=:school_id";
        $params[":status"]      = 1;
        $params[":school_id"]   = $this->school_id;
        $list   = pdo_fetchall("select * from ".tablename('lianhu_grade')." where ".$where." ",$params); 
        return $list;
    }
    //更新年级展示名
    public function updateGradeName($grade_id,$new_name){   
        $where['grade_id'] = $grade_id;
        $up['grade_name']  = $new_name;
        pdo_update('lianhu_grade',$up,$where);
    }
    //处理超过年限
    public function resoveEndGrade($grade_id){
        $class_classes = D("classes");
        $class_classes->grade_id = $grade_id;
        $where['grade_id'] = $grade_id;
        $up['grade_name']  = '毕业';
        $up['status' ]     = 2;
        pdo_update('lianhu_grade',$up,$where);
        unset($up['grade_name']);
        pdo_update('lianhu_scorejilv',$up,$where);
        $class_classes -> resoveEndClass();
        D('student')->resoveEndStudent($grade_id);
    }
    //新增
    public function addGrade($in_school_year,$grade_name){
        $class_school = D('school');
        $class_school ->school_id = $this->school_id;
        $school_info  = $class_school-> getSchoolInfo();
        $in['grade_name']     = $grade_name;
        $in['in_school_year'] = $in_school_year;
        $in['uniacid']        = $school_info['uniacid'];
        $in['school_id']      = $school_info['school_id'];
        pdo_insert('lianhu_grade',$in);
    }
    //获取一个年级的信息
    public function getGradeInfo($grade_id){
        $params[':grade_id'] = $grade_id;
        $result = pdo_fetch("select * from ".tablename('lianhu_grade')." where grade_id=:grade_id ",$params);
        return $result;
    }
    //该用户可以查看到的年级
    public function getThisAdminGradeList($all=false){
        global $_GPC;
        if(!$all){
            $params[":status"] = 1;
        }
        $params[":school_id"]  = getSchoolId();
        $where  = S("fun","composeParamsToWhere",array($params) );
        $list   = pdo_fetchall("select * from ".tablename('lianhu_grade')." where ".$where." order by in_school_year desc ",$params);
        if($_GPC['_data_group_id']){
            $data_group = D('power')->getDataInfo($_GPC['_data_group_id']);
            if($data_group['grade']){
                foreach ($list as $key => $value) {
                    if(!in_array($value['grade_id'],$data_group['grade']) ){
                        unset($list[$key]);
                    }
                }
            }
        }
        return $list;
    }
    //联动
	public function gradeClass(){
		global $_W,$_GPC;
        $grades = $this->getThisAdminGradeList();
        foreach ($grades as $key => $value) {
            $grades[$key]['second'] = pdo_fetchall("select * from ".tablename('lianhu_class')." where grade_id={$value['grade_id']} and status=1 ");
        }
		return $grades;
	}    
}