<?php 
namespace myclass\src;

class base{
    public $web_w;      //微擎 $_W;
    public $web_gpc;    //微擎 $_GPC;
    public $web_config; //微擎 $this->module[config];
    public $uniacid;
    public $school_id;
    public $school_name;
    public $table_pe;
    public $every_page ;
    //file_list
    public $file_list;
    public $file_g=0;
    public $class_accobj;
    public $student_id;
    //遍历文件树
    //不显示静态包
    public  function listDir($dir){
                if(is_dir($dir)){
                    if ($dh = opendir($dir)) {
                        while (($file = readdir($dh)) !== false){
                            if((is_dir($dir."/".$file)) && $file!="." && $file!=".." && $file!='assets' && $file!='file'){
                                $this->listDir($dir.$file."/");
                            }else{
                                if($file!="." && $file!=".." && $file!="assets.zip"){
                                    $local_dir = str_replace(MODULE_ROOT,'',$dir); 
                                    $this->file_list[$this->file_g]['local']=$local_dir;
                                    $this->file_list[$this->file_g]['file_name']=$file;                                    
                                    $this->file_g++;
                                }
                            }
                        }
                        closedir($dh);
                    }
                }
    }
    //获取特定关键字的内容
    public static function getKeywordContent($keyword){
         global $_W;
         $params[':uniacid'] = $_W['uniacid'];
         $params[':keyword'] = $keyword;
         $where              = S("fun","composeParamsToWhere",array($params) );   
         $content            = pdo_fetchcolumn("select content from ".tablename('lianhu_set')." where ".$where." ",$params);
         return $content;
    }
    //存储内容
    public static function saveKeywordContent($params=true,$data){
         global $_W;
         if($params){
             foreach ($params as $key => $value) {
                 $where .= " ".$key." = '".$value."' and"; 
             }
             $where      = trim($where,'and');
             $result     = pdo_fetch("select * from ".tablename('lianhu_set')." where ".$where."  "); 
             if($result)
                pdo_update("lianhu_set",$data,$params);
             else{
                 $data = array_merge($params,$data);
                 pdo_insert("lianhu_set",$data);
             }
         }else{
             pdo_insert("lianhu_set",$data);
         }
    }   
    //把openid 转化uid 
    public static function openid2uid($openid){
        global $_W;
        $where[':openid']  = $openid;
        $where[':uniacid'] = $_W['uniacid'];
        $uid = pdo_fetchcolumn(" select uid from ".tablename('mc_mapping_fans')."  where 
                                 openid=:openid and uniacid=:uniacid " ,$where );
        return $uid;
    }
    //openid to fanid 
    public static function openi2fanid($openid){
        global $_W;
        $where[':openid']  = $openid;
        $where[':uniacid'] = $_W['uniacid'];
        $fanid = pdo_fetchcolumn(" select fanid from ".tablename('mc_mapping_fans')."  where 
                                 openid=:openid and uniacid=:uniacid " ,$where );
        return $fanid;
    }    
    //fanid to uid 
    public static function fanid2openid($fanid){
        $openid  = pdo_fetchcolumn("select openid from ".tablename('mc_mapping_fans')." where fanid={$fanid} ");
        return $openid;
    }
    //uid to openid 
    public static function uid2openid(){
        global $_W;
        $where[':uid']     = $uid;
        $where[':uniacid'] = $_W['uniacid'];
        $openid = pdo_fetchcolumn(" select openid from ".tablename('mc_mapping_fans')."  where 
                                 uid=:uid and uniacid=:uniacid " ,$where );
        return $openid;      
    }
    //获取文件版本
    public function getFileVersionList($start){
        $table_pe   = $this->table_pe;
        $every_page = $this->every_page;
        $list     = pdo_fetchall("select * from ".$table_pe."lianhu_file order by id asc limit ".$start.",".$every_page." ");
        return $list;
    }
    //更新文件
    public function updateFileVersion($file_name,$file_local,$version){
        $where[':file_name'] = $file_name;
        $where[':file_local'] = $file_local;
        $result = pdo_fetch("select * from  ".$this->table_pe."lianhu_file where file_name=:file_name and file_local=:file_local ",$where);
        if($result){
            $up['last_up_time'] = time();
            $up['file_version'] = $version;
            pdo_update("lianhu_file",$up,array("id"=>$result['id']) );
        }else{
            $in['file_name'] = $file_name;
            $in['file_local'] = $file_local;
            $in['file_version'] = $version;
            $in['last_up_time'] = time();
            pdo_insert("lianhu_file",$in);
        }
    }
    //读取用户学校结构
    public function  getSchoolList($all=false){
           $table_pe          = $this->table_pe;
           if(!$all){
              $where[':uniacid'] = $this->web_w['uniacid'];
              $list     = pdo_fetchall("select * from  {$table_pe}lianhu_school where uniacid=:uniacid ",$where);
           }else{
              $list     = pdo_fetchall("select * from  {$table_pe}lianhu_school ");
           }
           return $list; 
    }
    //获取年级数据
    public function getGradeList(){
         $table_pe = $this->table_pe;
         $where[':uniacid'] = $this->web_w['uniacid'];
         $list     = pdo_fetchall("select * from {$table_pe}lianhu_grade where uniacid=:uniacid and status=1",$where);
         return $list;
    }  
    //获取所有的班级数据这个公众号下
    public function getAllClassList(){
         $table_pe = $this->table_pe;
         $where[':uniacid'] = $this->web_w['uniacid']; 
         $list = pdo_fetchall("select * from {$table_pe}lianhu_class where uniacid=:uniacid and status=1",$where);
         return $list;
    }
    //获取学生数据
    public function getStundentList($class_id){
        $table_pe = $this->table_pe;
        $where[":class_id"] = $class_id;
        $list    = pdo_fetchall("select * from {$table_pe}lianhu_student where class_id=:class_id and status=1 ",$where);
        return $list;
    }
    //获取设备数据
    public function getDeviceList(){
        global $_W;
        $table_pe = $this->table_pe;
        $list     = pdo_fetchall("select * from {$table_pe}lianhu_device where uniacid=:uniacid ",array(":uniacid"=>$_W['uniacid']));
        foreach ($list as $key => $value) {
            $img_arr='';
            if($value['img_ads']){
                $img_arr= explode("#",$value['img_ads']);
                foreach ($img_arr as $k => $v) {
                    $img_arr[$k] = $this->web_w['attachurl'].$v;
                }
            }
            if($img_arr)
                $list[$key]['img_ads'] = implode("#",$img_arr);
        }
        return $list;
    }
    //获取学校组id
    public function getSchoolAdminGroupId(){
        $school_admin_id = pdo_fetchcolumn("select id from ".tablename('users_group')." where name='学校组' ");
        return $school_admin_id;
    }
    //获取该系统所有的学校组用户
    public function getAllSchoolAdminList(){
        $table_pe = $this->table_pe;
        $list     = pdo_fetchall("  select {$table_pe}lianhu_school_admin.*,  ".tablename('users').".username,".tablename('users').".uid
                                    from {$table_pe}lianhu_school_admin
                                    left join ".tablename('users')." on ".tablename('users').".uid={$table_pe}lianhu_school_admin.uid
                                ");    
        return $list;
    }
    //获取教师组group_id
    public function getTeacherGroupId(){
        $group_id=pdo_fetchcolumn("select id from ".tablename('users_group')." where name='教师组' ");
        return $group_id;
    }
    //获取系统所有的教师用户
    public function getAllTeacherList(){
        $table_pe = $this->table_pe;
        $list     = pdo_fetchall("select tea.* ,users.username,fan.nickname,users.uid
                                  from {$table_pe}lianhu_teacher tea 
                                  left join ".tablename('users')." users  on  users.uid=tea.fanid 
						     	  left join ".tablename('mc_members')." fan on fan.uid=tea.uid  
                                ");
        return $list;
    }
    //获取UId用户对应的权限
    public function getUidPermission($uid){
        $permission = pdo_fetchcolumn("select permission from ".tablename('users_permission')." where uid=:uid ",array(":uid"=>$uid));
        return $permission;
    }
    //获取这个学校下的所有教师
    public function getSchoolTeacherList($school_id,$all=false){
        $params[':school_id']  = $school_id;
        $where                 = "school_id = :school_id ";
        if(!$all){
            $params[':status'] = 1;
            $where             .=" and status=:status ";
        }
        $list                = pdo_fetchall("select * from ".tablename("lianhu_teacher")."  where ".$where." ",$params);
        return $list;
    }
    //获取关系
    public function getRelation(){
        $class_system   = new system;
        $relation_list  = $class_system->student_admin_relation;
        return $relation_list;
    }
    //根据UId获取当前的fanid
	public function mobileGetFanidByUid($uid){
		 global $_W;
		 $fanid = pdo_fetchcolumn("select fanid from  ".tablename("mc_mapping_fans")."  where uid=:uid order by fanid desc "
								  ,array(":uid"=>$uid) );
		 return $fanid;
	}
    //根据UId获取当前的avatar
    public function mobileGetAvatarByUid($uid){
		 $avatar = pdo_fetchcolumn("select avatar from  ".tablename("mc_members")."  where uid=:uid "
									,array(":uid"=>$uid) );
		 return $avatar;       
    }
    //根据UId获取当前的Nickname
    public function mobileGetNicknameByUid($uid){
		 $nickname = pdo_fetchcolumn("select nickname from  ".tablename("mc_members")."  where uid=:uid "
									,array(":uid"=>$uid) );
		 return $nickname;       
    }
    //表单防止返回
    public function tokenForm(){
        global $_W;
        $token = $_W['token'];
        setcookie("form_token",$token, time()+3600,'/');
        return $token;
    }
    //创建附件文件夹
    public function createAttaFile(){
         $base_dir=ATTACHMENT_ROOT.'images/'.date("Y/m/d",time()).'/';
         if(!file_exists($base_dir))
                mkdirs($base_dir);   
         return $base_dir;
    }
    //创建mobile url 
    public function createMobileUrl($fun_name,$arr){
        global $_W; 
        $url = '/index.php?i='.$_W['uniacid'].'&c=entry&do='.$fun_name.'&m=lianhu_school';
        if($arr){
            foreach ($arr as $key => $value) {
                $str .="&".$key.'='.$value;
            }
        }
        return $url.$str;
    }
    //创建web url 
    public function createWebUrl($fun_name,$arr){
        global $_W;
        $url = '/index.php?c=site&a=entry&do='.$fun_name.'&m=lianhu_school';
        $str = implode("&",$arr);
        return $url.'&'.$str;
    }   
    //发送模板消息
    public function sendTplNotice($openid,$mu_id,$mu_data,$url=false){
        if($this->student_id){
            $class_student = D('student');
            $student_info  = $class_student->getStudentInfo($this->student_id);
            if($this->web_config['msg']== $mu_id ){
                $school_msg = true;
            }else{
                $school_msg = false;
            }
            $content = $this->findOutTplContent($mu_data,$school_msg);
        }
        if($openid == 'sms' && $student_info){
            $re      = $this->sendSmsMsg($student_info['parent_phone'],$content );
        }else{
            if(!$this->class_accobj){
                load()->classs('weixin.account');
                $accObj             = \WeixinAccount::create($_W['acid']);
                $this->class_accobj = $accObj;           
            }
            if($student_info['sms_status']==1 && $student_info['parent_phone']){
                $re      = $this->sendSmsMsg($student_info['parent_phone'],$content );
            }
            $re = $this->class_accobj->sendTplNotice($openid,$mu_id,$mu_data,$url);         
        }
        $this->student_id = 0;
        return $re;            
    }
	public function sendSmsMsg($phone,$content){
		$cclass_sms 			   = C('sms');
		$cclass_sms->in_class_base = $this;
		$cclass_sms->setApi();
		$cclass_sms->sendSms($phone,$content);
	}
    //内容优先识别
    public function findOutTplContent($mu_data,$school_msg=false){
        if($mu_data['content'] && $mu_data['subject']){
             $content = "科目：".$mu_data['subject']['value'].';内容：'.$mu_data['content']['value'];   
        }elseif($mu_data['childName']){
             $content = $mu_data['childName']['value'].'  打卡了；时间：'.$mu_data['time']['value'].'；'.$mu_data['remark']['value'];   
        }elseif($mu_data['keyword4'] && $mu_data['keyword1'] && !$school_msg){
             $content = "班级：".$mu_data['keyword1']['value'].'；通知人：'.$mu_data['keyword2']['value'].'；内容：'.$mu_data['keyword4']['value'];
        }elseif($school_msg){
             $content = "【".$mu_data['keyword1']['value'].'】通知人：'.$mu_data['keyword2']['value'].'；内容：'.$mu_data['keyword4']['value'];
        }
        return $content;
    }

}