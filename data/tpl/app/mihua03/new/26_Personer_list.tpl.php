<?php defined('IN_IA') or exit('Access Denied');?><?php  $page_title = '授课教师列表['.$class_name.']';?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../new/head', TEMPLATE_INCLUDEPATH)) : (include template('../new/head', TEMPLATE_INCLUDEPATH));?>
<script type='text/javascript' src='https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js'></script>
<body ontouchstart>
<div class="container" id="container">
<div class="panel">
<div class="bd">
    <div class="weui_panel weui_panel_access">
        <div class="weui_panel_hd">教师列表</div>
        <div class="weui_panel_bd">
            <?php  if(is_array($teacher_list)) { foreach($teacher_list as $key => $row) { ?>
            <a href="<?php  echo $this->createMobileUrl('personer',array('t_id'=>$row['teacher_id']))?>" class="weui_media_box weui_media_appmsg">
                <div class="weui_media_hd">
                    <img class="weui_media_appmsg_thumb" src="<?php  if($row['teacher_img'] ) { ?>../attachment/<?php  echo $row['teacher_img'];?> <?php  } else { ?> <?php echo MODULE_URL;?>icon.jpg<?php  } ?>" alt="">
                </div>
                <div class="weui_media_bd">
                    <h4 class="weui_media_title"><?php  echo $row['teacher_realname'];?></h4>
                    <p class="weui_media_desc"><?php  echo $this->courseName($row['course_id'])?></p>
                </div>
            </a>
            <?php  } } ?>
        </div>
    </div>
</div>
</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('jsweixin', TEMPLATE_INCLUDEPATH)) : (include template('jsweixin', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../new/footer', TEMPLATE_INCLUDEPATH)) : (include template('../new/footer', TEMPLATE_INCLUDEPATH));?>