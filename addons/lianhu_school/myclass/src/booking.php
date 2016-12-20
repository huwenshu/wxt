<?php 
namespace myclass\src;

class booking extends common{
    public $booking_id      = 'booking_id';
    public $booking_title   = 'booking_title';
    public $booking_img     = 'booking_img';
    public $booking_intro   = 'booking_intro';
    public $booking_content = 'booking_content';
    public $limit_num       = 'limit_num';
    public $begin_time      = 'begin_time';
    public $end_time        = 'end_time';
    public $ask_phone       = 'ask_phone';
    public $ask_name        = 'ask_name';
    public $ask_id          = 'ask_id';
    
    public function __construct(){
        $this->setTable('lianhu_booking');
        $this->setGlobal();        
    }
    public function dataAdd($arr){
        return parent::add($arr);
    }
    public function dataEdit($id,$up=false){
        $where["booking_id"] = $id;
        $result              = parent::edit($where,$up);
        return $result;
    }
    public function dataList($params){
      $this->_set('each_page',100000);
      return parent::getList($params);
    }

}
 