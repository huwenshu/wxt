<?php 
namespace myclass\src;
/*
*   用来处理打卡方面的东西
*   zhuhuan 18587190225 / 821880927
*/
class card{
    private $table;
    private $table_no;
    private $uniacid;
    private $school_id;
    private $where;
    private $in_time;

    public function __construct(){
        global $_W;
        $this->table    = tablename("lianhu_card_record");
        $this->table_no ='lianhu_card_record';
        $this->uniacid  = $_W['uniacid'];
        $this->school_id= getSchoolId();
    }
    public function _set($name,$value){
        $this->$name = $value; 
    }
    //设备
    public function deviceInfo($device_id){
        $params[":did"] = $device_id;
        $where          = "device_id =:did";
        $info           = pdo_fetch("select * from ".tablename('lianhu_device')." where ".$where." ",$params);
        return $info;
    }
    //解析打卡时间的上午，下午，异常
    public function decodeCardTimeModel($time){
        $class_attenceTime       = D('attenceTime');
        //in 
        $params[":time_type"]    = 1;
        $in_result               = $class_attenceTime->dataList($params);
        $in_list                 = $in_result['list'];
        $params[":time_type"]    = 2;
        $out_result              = $class_attenceTime->dataList($params);
        $out_list                = $out_result['list'];
        $hour_min                = date("H:i",$time);
        foreach ($in_list as $key => $value) {
            $in_result = compareHourMin($hour_min,$value['begin_time'],$value['end_time']);
            if($in_result){
                return 1;
            }
        }
         foreach ($out_list as $key => $value) {
            $in_result = compareHourMin($hour_min,$value['begin_time'],$value['end_time']);
            if($in_result){
                return 2;
            }
        }       
        return 3;
    }
    //添加打卡记录
    public function addCardRecord($arr){
        $class_student   = D('student'); 
        $date_arr        = fun::decodeTimeToSlice($arr['play_card_time']);
        $student_info    = $class_student->getStudentInfo($arr['student_id']);
        $in['school_id'] = $student_info['school_id'];
        $in['uniacid']   = $this->uniacid;
        $in['year']      = $date_arr['year'];
        $in['month']     = $date_arr['month'];
        $in['day']       = $date_arr['day'];
        if(!$arr['up_low']){
            $in['up_low']    = $this->decodeCardTimeModel($arr['play_card_time']); 
        }
        $in['add_time']  = time();
        $in['device_id'] = $arr['device_id'];
        $in['rfid_value']= $arr['rfid_value'];
        $in['student_id']= $arr['student_id'];
        $in['img_url']   = $arr['img_url'];
        if($arr['img_url2']){
            $in['img_url2'] = $arr['img_url2'];
        }
        $in['grade_id']  = $student_info['grade_id'];
        $in['class_id']  = $student_info['class_id'];
        $in['signTemp']  = $arr['signTemp'];
        $in['play_card_time']  = $arr['play_card_time'];
        $in['device_list']     = $arr['device_list'] ?  $arr['device_list']:'';
        $in['add_time_str']    = $arr['add_time_str'] ?  $arr['add_time_str']:'';
        $in['type']            = $arr['type'] ?  $arr['type']:1;
        pdo_insert($this->table_no,$in);
        return pdo_insertid();
    }
    //统计打卡人数
    //time_type = [all|morning|afternoon|other]
    public function countStudentPlayCard($time_type){
        if($this->in_time){
            list($time['year'],$time['month'],$time['day']) = explode('-',date('Y-m-d',$this->in_time ) ); 
        }else{
            list($time['year'],$time['month'],$time['day']) = explode('-',date('Y-m-d',time() ) ); 
        }
        $params[':year']        = $time['year'];
        $params[':month']       = $time['month'];
        $params[':day']         = $time['day'];       
        $params[':school_id']   = $this->school_id;
        $where  = S("fun",'composeParamsToWhere',array($params) );
        if($time_type == 'morning'){
            $where .= " and up_low = 1";    
        }elseif($time_type =='afternoon'){
            $where .= " and up_low = 2 ";    
        }elseif($time_type == 'other'){
            $where .= " and up_low = 3 ";    
        }
        if($this->where){
            $where .= " and ".$this->where;  
        }
        $count = pdo_fetchall("select *  from  ".$this->table." where ".$where." group by student_id ",$params); 
        $count = count($count);
        return $count;
    }
    //获取打卡list 
    public function studentCardList($student_id,$begin_time,$end_time){
        $where        = " student_id =:student_id  ";
        $params[':student_id'] = $student_id;  
        $where .= " and add_time > ".$begin_time." and add_time <= ".$end_time." ";    
        $list   = pdo_fetchall(" select * from ".$this->table." where ".$where." order by record_id desc ",$params);
        return $list;
    }
    //筛选
    public function getAllCardList($where,$params,$pager,$all=false){
        $every_page = 20;
  		$pager  = $pager ? $pager :1;
		$start  = ($pager-1)*$every_page;
		$limit  = $start.",".$every_page;      
        $count  = pdo_fetchcolumn(" select count(record_id) num  from ".$this->table." where ".$where." order by record_id desc ",$params);
        if($all){
            $list   = pdo_fetchall(" select * from ".$this->table." where ".$where." order by record_id desc   " ,$params);
        }else{
            $list   = pdo_fetchall(" select * from ".$this->table." where ".$where." order by record_id desc limit ".$limit ,$params);
        }
        return array('count'=>$count,'list'=>$list);
    }
    //一个学生的上下午是否打卡
    public function studentRecord($time_list,$student_id,$time_type){
        $params[':year']     = $time_list['year'];
        $params[':month']    = $time_list['month'];
        $params[':day']      = $time_list['day'];
        $params[':student_id'] = $student_id;
        if($time_type=='in'){
            $params[":up_low"] = 1;
        }elseif($time_type=='out'){
            $params[":up_low"] = 2;
        }elseif($time_type=='other'){
            $params[":up_low"] = 3;
        }
        $where  = S("fun",'composeParamsToWhere',array($params) );
        $list   = pdo_fetchall("select * from ".$this->table."  where ".$where." order by record_id desc ",$params); 
        return $list;
    }

}