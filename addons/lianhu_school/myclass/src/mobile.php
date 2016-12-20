<?php 
namespace myclass\src;
class mobile{
    public $table;
    public $student_nav;
    public $student_index_nav;
    public $teacher_nav;
    public $teacher_index_nav;

    public function __construct(){
      $this->table = tablename('lianhu_mobile_display');

      $student_nav = array(
            array(
                'desc'      =>  10,
                'name'      =>  '学校',
                'img'       => MODULE_URL.'style/images/icon_nav_button.png',
                'xiaoyeimg' => MODULE_URL.'template/xiaoye/img/D1-l.png',
                'keyword'   => 'school_home'
            ),
            array(
                'desc'      =>8,
                'name'      =>'通讯录',
                'img'       => MODULE_URL.'style/images/icon_nav_msg.png',
                'xiaoyeimg' => MODULE_URL.'template/xiaoye/img/D2-l.png',
                'keyword'   => 'Personer_list',
            ),
            array(
                'desc'      =>7,
                'name'      =>'班级圈',
                'img'       => MODULE_URL.'style/images/icon_nav_article.png',
                'xiaoyeimg' => MODULE_URL.'template/xiaoye/img/D3-l.png',
                'keyword'   => 'line',
            ),
            array(
                'desc'      =>6,
                'name'      =>'我',
                'img'       => MODULE_URL.'style/images/icon_nav_cell.png',
                'xiaoyeimg' => MODULE_URL.'template/xiaoye/img/D4.png',
                'keyword'   =>'home',
            ),
         );  
        
      $teacher_nav = array(
            array(
                'desc'=>10,
                'name'=>'学校',
                'img'=> MODULE_URL.'style/images/icon_nav_button.png',
                'keyword'=> 'school_home'
            ),
            array(
                'desc'=>8,
                'name'=>'消息发送',
                'img'=> MODULE_URL.'style/images/icon_nav_msg.png',
                'keyword'=> 'tea_msg',
            ),
            array(
                'desc'=>7,
                'name'=>'班级圈',
                'img'=> MODULE_URL.'style/images/icon_nav_article.png',
                'keyword'=> 'tea_to_line',
            ),
            array(
                'desc'=>6,
                'name'=>'我',
                'img'=> MODULE_URL.'style/images/icon_nav_cell.png',
                'keyword'=>'teain',
            ),
         );  
              
        $student_index_nav = array(
            array(
                'color'=>'f-red',
                'name'=>'',
                'display'=>1,
                'list'=>array(
                    array(
                        'desc'       => 10,
                        'name'       =>'点评录',
                        'font'       => 'fa fa-hand-o-up',
                        'img'        => MODULE_URL.'template/xiaoye/img/19.png',
                        'keyword'    => 'record',                      
                        'params'     => array('op'=>'1'),
                    ),
                    array(
                        'desc'       =>9,
                        'name'       =>'课程表',
                        'font'       =>'icon icon-25',
                        'img'        => MODULE_URL.'template/xiaoye/img/20.png',
                        'keyword'    =>'syllabus'
                    ),
                    array(
                        'desc'          =>8,
                        'name'          =>'考试成绩',
                        'font'          =>'fa fa-line-chart',
                        'img'           => MODULE_URL.'template/xiaoye/img/3.png',
                        'keyword'       =>'score',
                        'xiaoyekeyword' =>'myscore',
                    ),
                    array(
                        'desc'          =>7,
                        'name'          =>'请假申请',
                        'font'          =>'fa fa-send-o',
                        'img'           => MODULE_URL.'template/xiaoye/img/4.png',
                        'keyword'       =>'leave',
                    ),
                    array(
                        'desc'          =>6,
                        'name'          =>'家庭作业',
                        'font'          =>'fa fa-pencil',
                        'img'           => MODULE_URL.'template/xiaoye/img/5.png',
                        'keyword'       =>'line_other',
                        'xiaoyekeyword' =>'homeWork',
                        'params'        =>array('op'=>'home_work'),
                    ),
                    array(
                        'desc'          =>5,
                        'name'          =>'班级圈',
                        'font'          =>'fa fa-circle-o-notch',
                        'img'           => MODULE_URL.'template/xiaoye/img/CY-6.png',
                        'keyword'       =>'line',
                    )
                )
            ),
          array(
              'color'=>'',
              'name'=>'学习',
              'display'=>1,
              'style'=>'color: #029D77;',
              'list'=>array(
                  array(
                      'desc'            =>10,
                      'name'            =>'预约课程&活动',
                      'font'            =>'fa fa-flag-o',
                      'img'             => MODULE_URL.'template/xiaoye/img/11.png',
                      'keyword'         =>'applist',
                  ),
                  array(
                      'desc'            =>9,
                      'name'            =>'预约结果',
                      'font'            =>'fa fa-file-text ',
                      'img'             => MODULE_URL.'template/xiaoye/img/11.png',
                      'keyword'         =>'applist_result',
                  ),
                //   array(
                //       'desc'=>8,
                //       'name'=>'在线图书馆',
                //       'font'=>'fa fa-book',
                //       'keyword'=>'',
                //   ),                  
              )
          ),
          array(
              'color'=>'',
              'name'=>'常用',
              'display'=>1,
              'style'=>'color: #801A88;',
              'list'=>array(
                  array(
                      'desc'            =>10,
                      'name'            =>'学校公告',
                      'font'            =>'icon icon-53',
                      'img'             => MODULE_URL.'template/xiaoye/img/13.png',
                      'keyword'         =>'neimsg',
                  ),
                  array(
                      'desc'            =>9,
                      'name'            =>'校园直播',
                      'font'            =>'fa fa-file-video-o',
                      'img'             => MODULE_URL.'template/xiaoye/img/CY-7.png',
                      'keyword'         =>'video',
                  ),
                  array(
                      'desc'            =>8,
                      'name'            =>'打卡记录',
                      'font'            =>'fa fa-list-alt',
                      'img'             => MODULE_URL.'template/xiaoye/img/9.png',
                      'keyword'         =>'card_record',
                  ),                  
                  array(
                      'desc'            =>7,
                      'name'            =>'校长信箱',
                      'font'            =>'fa fa-envelope-o',
                      'img'             => MODULE_URL.'template/xiaoye/img/18.png',
                      'keyword'         =>'message',
                  ),
                  array(
                      'desc'            =>6,
                      'name'            =>'校园食谱',
                      'font'            =>'icon icon-106',
                      'img'             => MODULE_URL.'template/xiaoye/img/7.png',
                      'keyword'         =>'cookbook',
                  ),
                  array(
                      'desc'            =>5,
                      'name'            =>'任课教师',
                      'font'            =>'fa fa-clipboard',
                      'img'             => MODULE_URL.'template/xiaoye/img/CY-8.png',
                      'keyword'         =>'Personer_list',
                  ),  

              )
          ),
          array(
              'color'=>'f-orange',
              'name'=>'其他',
              'display'=>1,
              'style'=>'color: teal;',
              'list'=>array(
                  array(
                      'desc'        =>10,
                      'name'        =>'我的资料',
                      'font'        =>'fa fa-info-circle',
                      'img'         => MODULE_URL.'template/xiaoye/img/15.png',
                      'keyword'     =>'myInfo',
                  ),
                  array(
                      'desc'        =>9,
                      'name'        =>'学生资料',
                      'font'        =>'fa fa-tasks',
                      'img'         => MODULE_URL.'template/xiaoye/img/16.png',
                      'keyword'     =>'real_xiangxi',
                  ),
                  array(
                      'desc'        =>8,
                      'name'        =>'缴费管理',
                      'font'        =>'fa fa-money',
                      'img'         => MODULE_URL.'template/xiaoye/img/17.png',
                      'keyword'     =>'give_money',
                  ),         
                   array(
                      'desc'        =>8,
                      'name'        =>'课堂在线',
                      'font'        =>'fa fa-university',
                      'img'         => MODULE_URL.'template/xiaoye/img/13.png',
                      'keyword'     =>'edu_video_class',
                  ),                           
                   array(
                      'desc'        => 7,
                      'name'        =>'报修',
                      'font'        =>'fa fa-bug',
                      'img'         => MODULE_URL.'template/xiaoye/img/8.png',
                      'keyword'     =>'repairUp',
                  ),    
                   array(
                      'desc'        => 9,
                      'name'        =>'校车',
                      'font'        =>'fa fa-road',
                      'img'         => MODULE_URL.'template/xiaoye/img/14.png',
                      'keyword'     =>'schoolBus',
                  ),                                  
              )
          ),
        );

        $teacher_index_nav = array(
            array(
                'color'=>'f-red',
                'name'=>'',
                'display'=>1,
                'list'=>array(
                    array(
                        'desc'=>10,
                        'name'=>'教师资料',
                        'font'=> 'fa fa-user',
                        'keyword'=> 'tea_data',                      
                    ),
                    array(
                        'desc'=>9,
                        'name'=>'今日课程',
                        'font'=>'fa fa-puzzle-piece',
                        'keyword'=>'tea_today_course'
                    ),
                    array(
                        'desc'=>8,
                        'name'=>'学生记录',
                        'font'=>'fa fa-navicon',
                        'keyword'=>'tea_work_record',
                    ),
                    array(
                        'desc'=>7,
                        'name'=>'发布作业',
                        'font'=>'fa fa-magic',
                        'keyword'=>'tea_homeWork',
                    ),
                    array(
                        'desc'=>6,
                        'name'=>'成绩登记',
                        'font'=>'fa fa-pencil',
                        'keyword'=>'tea_score_in',
                    ),
                    array(
                        'desc'=>5,
                        'name'=>'消息发送',
                        'font'=>'fa fa-send-o',
                        'keyword'=>'tea_msg',
                    )
                )
            ),
          array(
              'color'=>'',
              'name'=>'常用',
              'display'=>1,
              'style'=>'color: #029D77;',
              'list'=>array(
                  array(
                      'desc'=>10,
                      'name'=>'一键放学',
                      'font'=>'fa fa-paper-plane-o',
                      'keyword'=>'tea_school_free',
                      'params'=>array(),
                  ),
                  array(
                      'desc'=>9,
                      'name'=>'班级公告',
                      'font'=>'fa fa-star',
                      'keyword'=>'tea_line',
                      'params'=>array('line'=>'no')
                  ),
                  array(
                      'desc'=>8,
                      'name'=>'请假管理',
                      'font'=>'fa fa-info-circle',
                      'keyword'=>'tea_leave',
                  ),                  
              )
          ),
          array(
              'color'=>'',
              'name'=>'其他',
              'display'=>1,
              'style'=>'color: #801A88;',
              'list'=>array(
                  array(
                      'desc'=>10,
                      'name'=>'学校公告',
                      'font'=>'icon icon-53',
                      'keyword'=>'Neimsg_tea',
                  ),
                  array(
                      'desc'=>9,
                      'name'=>'报修',
                      'font'=>'fa fa-bug',
                      'keyword'=>'repairUp',
                  ),
                  array(
                      'desc'=>8,
                      'name'=>'教室直播',
                      'font'=>'fa fa-shield',
                      'keyword'=>'video',
                  ),
                   array(
                      'desc'=>7,
                      'name'=>'班级考勤',
                      'font'=>'fa fa-child',
                      'keyword'=>'tea_attence',
                  ),                 
              )
          ),
        );
        $this->teacher_nav       = $teacher_nav;
        $this->teacher_index_nav = $teacher_index_nav;
        $this->student_nav       = $student_nav;
        $this->student_index_nav = $student_index_nav;
    }
    //获取学生端的功能
    public function getStudentFunc(){
        $student_index_nav = $this->student_index_nav;
        $g =0;
        foreach ($student_index_nav as $key => $value) {
            $this_list = $value['list'];
            foreach ($this_list as  $val) {
                $out_list[$g]['name'] = $val['name'];
                $out_list[$g]['key'] = $val['keyword'];
                $g++;
            }
        }
        return $out_list;
    }
    public function add($arr){
        global $_W;
        $in['uniacid']      = $_W['uniacid'];
        $in['school_id']    =  getSchoolId();
        $in['type']         = $arr['type'];
        $in['name']         = $arr['name'];
        $in['img']          = $arr['img'];
        $in['sort']         = $arr['sort'];
        $in['url']          = $arr['url'];
        $in['keyword']      = $arr['keyword'];
        $in['dis_one']      = $arr['dis_one'];
        $in['dis_two']      = $arr['dis_two'];
        $in['dis_three']    = $arr['dis_three'];
        $in['add_time']     = time();
        pdo_insert('lianhu_mobile_display',$in);
        return pdo_insertid();
    }
    //删除
    public function delete($display_id){
        pdo_delete('lianhu_mobile_display',array("display_id"=>$display_id));
    }
    //初始化导航
    public function addMobileNav($student=true){
        if($student){
            $nav_list    = $this->student_nav;
            $in['type']  = 1;
        }else{
             $nav_list    = $this->teacher_nav;
             $in['type']  = 10;           
        }
        foreach ($nav_list as $key => $value) {
            $in['name']     = $value['name'];
            $in['img']      = $value['img'];
            $in['xiaoyeimg']= $value['xiaoyeimg'];
            $in['sort']     = $value['desc'];
            $in['keyword']  = $value['keyword'];
            $in['dis_one']  = $value['font'];
            if($value['params']){
                $in['dis_two'] = json_encode($value['params']);
            }
            $this->add($in);
        }
    }
    //初始化首页界面
    public function addMobileIndex($student=true){
        if($student){
            $nav_list = $this->student_index_nav;
            $up_type  = 3;
            $botton   = 2;
        }else{
            $nav_list = $this->teacher_index_nav;
            $up_type  = 13;
            $botton   = 12;
        }
        foreach ($nav_list as $key => $value) {
            $in['type']    = $up_type;
            $in['dis_one'] = $value['color'];          
            $in['dis_two'] = $value['style'];
            $in['sort']    = $value['display'];
            $in['name']    = $value['name'];
            $in_id         = $this->add($in);
            foreach ($value['list'] as $k => $v ) {
                $two_in             = array();
                $two_in['type']     = $botton;
                $two_in['dis_one']  = $in_id;
                $two_in['sort']     = $v['desc'];
                $two_in['name']     = $v['name'];
                $two_in['keyword']  = $v['keyword'];
                $two_in['dis_two']  = $v['font'];
                $two_in['img']      = $v['img'];
                if($v['params']){
                    $two_in['dis_three'] = json_encode($v['params']);
                }
                $this->add($two_in);
            } 
        }
    }
    //获取底部导航栏
    public function getButtonNav($student=true,$all=false){
        global $_W;
        $params[":uniacid"]     = $_W['uniacid'];
        $params[":school_id"]   =  getSchoolId();
        if($student){
            $params[":type"]        = 1;
        }else{
            $params[":type"]        = 10;
        }
        if(!$all){
            $params[":status"]  = 1;
            $limit = 4;
        }else{
            $limit = 2000;
        }
        $where                  = S("fun","composeParamsToWhere",array($params) );
        $list                   = pdo_fetchall("select * from ".$this->table." where ".$where." order by status desc,sort desc limit  ".$limit,$params);
        if(!$list && $all){
            $this->addMobileNav($student);
            $this->getButtonNav($student);
        }
        return $list;
    }
    //获取首页导航按钮
    public function getIndexNav($student=true,$all=false){
        global $_W;
        $params[":uniacid"]     = $_W['uniacid'];
        $params[":school_id"]   =  getSchoolId();
        if($student){
            $params[":type"]        = 3;
        }else{
            $params[":type"]        = 13;
        }
        if(!$all)
            $params[":status"]  = 1;
        $where                  = S("fun","composeParamsToWhere",array($params) );
        $list                   = pdo_fetchall("select * from ".$this->table." where ".$where." order by sort desc limit 4 ",$params);
        if(!$list && $all ){
            $this->addMobileIndex($student);
            $this->getIndexNav($student);
        }else{
            foreach ($list as $key => $value) {
                $out_list[$key]['top'] = $value;
                if($student){
                    $params[":type"]       = 2;
                }else{
                    $params[":type"]       = 12;
                }
                $params[":dis_one"]    = $value['display_id'];
                $where                 = S("fun","composeParamsToWhere",array($params) );
                $this_list             = pdo_fetchall("select * from ".$this->table." where ".$where." order by sort desc  ",$params);
                $out_list[$key]['list']= $this_list;
            }
        }
        return $out_list;
    }
    //根据id 获取信息
    public function get($id){
        $params[":display_id"]  = $id;
        $where                  = S("fun","composeParamsToWhere",array($params) );
        $result                 = pdo_fetch("select * from ".$this->table." where ".$where."  ",$params);    
        return $result;
    }
    //更新
    public function update($id,$data){
        $where['display_id'] = $id;
        pdo_update('lianhu_mobile_display',$data,$where);
    }

}