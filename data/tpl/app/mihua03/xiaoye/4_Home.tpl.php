<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../xiaoye/head', TEMPLATE_INCLUDEPATH)) : (include template('../xiaoye/head', TEMPLATE_INCLUDEPATH));?>
<script src="<?php echo MODULE_URL;?>/template/xiaoye/js/load.js"></script>
<link href="<?php echo MODULE_URL;?>style/css/weui.min.css" rel="stylesheet" type="text/css" />
<body>
<div class="weui_dialog_alert" id="change_student_area" style="display:none" data-dis='no' onclick="changeDisplay('change_student_area')" >
    <div class="weui_mask"     ></div>
    <div class="weui_dialog"  >
        <div class="weui_dialog_hd"><strong class="weui_dialog_title">切换学生</strong></div>
        <div class="weui_dialog_bd">
                <div class="weui_cells weui_cells_access">
                    <?php  if(is_array($list)) { foreach($list as $row) { ?>
                    <a class="weui_cell " href="<?php  echo $this->createMobileUrl('change_student',array('op'=>'post','sid'=>$row['student_id']) );?>" >
                        <div class="weui_cell_bd weui_cell_primary">
                            <p <?php  if($row['student_id']== $result['student_id']) { ?> style="color:red" <?php  } ?> > <?php  echo $row['student_name'];?></p>
                        </div>
                    </a>
                    <?php  } } ?>
                </div>
        </div>
        <?php  if(D('school')->getSchoolParams('much_class')) { ?>
            <div class="weui_dialog_hd"><strong class="weui_dialog_title">切换班级</strong></div>
            <div class="weui_dialog_bd">
                    <div class="weui_cells weui_cells_access">
                        <?php  if(is_array($class_list)) { foreach($class_list as $row) { ?>
                        <a class="weui_cell " href="<?php  echo $this->createMobileUrl('change_student',array('op'=>'class_post','sid'=>$result['student_id'],'class_id'=>$row['class_id'] ) );?>" >
                            <div class="weui_cell_bd weui_cell_primary">
                                <p <?php  if($row['class_id']==  $now_class_id ) { ?> style="color:red" <?php  } ?> > <?php  echo $row['class_name'];?></p>
                            </div>
                        </a>
                        <?php  } } ?>
                    </div>
            </div>
        <?php  } ?>
        <div class="weui_dialog_ft">
        </div>        
    </div>
</div>

<div class="weui_dialog_alert"  id="student_code_area" style="display:none"  data-dis='no'onclick="changeDisplay('student_code_area')" >
    <div class="weui_mask"  ></div>
    <div class="weui_dialog"  >
        <div class="weui_dialog_hd"><strong class="weui_dialog_title">学生二维码</strong></div>
        <div class="weui_dialog_bd">
            <img src="<?php  echo $class_student->getStudentQrcode($result['student_id']);?>" style="width:300px;">
        </div>
            <div class="weui_dialog_ft">
                <br>
            </div>        
    </div>
</div>

<div class="all" style="width:980px;">
  <div class="headzy" style="background-image:url(<?php  echo $_W['attachurl'];?><?php  echo D('adv')->getAdvInfoKeyWord('student_top_img'); ?>);">
    <div class="QH">
      <a href="javascript:;" onclick="changeDisplay('change_student_area')"><img src="<?php echo MODULE_URL;?>/template/xiaoye/img/QH.png"></a>
    </div>
    <div class="L-D"> <a href="javascript:;" onclick="changeDisplay('student_code_area')">
                        <div style="background-image: url(<?php  echo $_W['attachurl'];?><?php  echo $result['student_img'];?>) "  class="home_head_img"></div>
                     </a> 
    </div>
    <div class="L-D-R">
      <li style="font-size:50px; "> <?php  echo $result['student_name'];?>
        <a class="z_xcz" href="<?php  echo $this->createMobileUrl('add_student');?>" ><img src="<?php echo MODULE_URL;?>/template/xiaoye/upimg/jiahao.png"></a>
      </li>
      <li style="font-size:30px; "><?php  echo $grade_name;?><?php  echo $class_name;?></li>
    </div>
  </div>

  <div class="TZ"> <img src="<?php echo MODULE_URL;?>/template/xiaoye/img/TZ-Z.png">
      <li>通知</li>
      <a href="<?php  echo $this->createMobileUrl('neimsg')?>">
      <li1>查看全部通知</li1>
      </a> 
  </div>

<div class="TZ-B">
  <div class="TZ-L"> <img src="<?php echo MODULE_URL;?>/template/xiaoye/img/TZ-P.png"> </div>
  <div class="TZ-R"> <a href="<?php  echo $this->createMobileUrl('msg_content',array("id"=>$msg_list['0']['msg_id']))?>">
    <p style="color:#333333;"><span class="biaoti1"><?php  echo $msg_list[0]['msg_title'];?></span> <span class="biaoti2"> <?php  echo  date("m-d H:i",$msg_list[0]['add_time'])?></span></p>
    </a>
    <p style="color:#777777;" class="head_msg_content"><?php  echo S('fun','formatLimitContent',array($msg_list[0]['msg_content'],20));?>...</p>
  </div>
</div>

<?php  $class_mobile = D('mobile');?>
<?php  $index_list  = $class_mobile->getIndexNav(true); ?>
<?php  if(is_array($index_list)) { foreach($index_list as $row) { ?>
    <?php  if($row['top']['name']) { ?>
            <div class="TZ"> <img src="<?php echo MODULE_URL;?>/template/xiaoye/img/CY.png">
              <li><?php  echo $row['top']['name'];?></li>
            </div>
    <?php  } ?>
          <div>
            <div class="CY">
            <?php  if(is_array($row['list'])) { foreach($row['list'] as $val) { ?>
            <?php  $params = json_decode($val['dis_three'],1);?>
                    <li> <a href="<?php  if($val['url']) { ?><?php  echo $val['url'];?><?php  } else { ?> 
                                  <?php  $keyword = C('mobile')->studentIndexOther($val['keyword']);?>
                                  <?php  echo $this->createMobileUrl(  $keyword ,$params)?> <?php  } ?>">
                                  <img src="<?php  echo $val['img'];?>"></a> <a href="">
                      <p><?php  echo $val['name'];?></p>
                    </a> </li>
            <?php  } } ?>
          </div>
          </div>
          <div style="height:50px; overflow:hidden; width:100%;"></div>
<?php  } } ?>
</div>
<?php  $footer_type = 'center';?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../xiaoye/footer', TEMPLATE_INCLUDEPATH)) : (include template('../xiaoye/footer', TEMPLATE_INCLUDEPATH));?>
</body>
</html>