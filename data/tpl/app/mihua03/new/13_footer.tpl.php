<?php defined('IN_IA') or exit('Access Denied');?><div style="width:100%;height:80px;">
</div>
<?php  $class_mobile = D('mobile');?>
<?php  $button_list  = $class_mobile->getButtonNav(true); ?>
<div class="weui_tabbar" style="position:fixed;">
        <?php  if(is_array($button_list)) { foreach($button_list as $row) { ?>
            <a href="<?php  if($row['keyword']=='school_home') { ?>
                        <?php  if($this->school_info['host_url'] ) { ?><?php  echo $this->school_info['host_url'];?><?php  } else { ?><?php  echo $this->createMobileUrl('wapHome',array('school_id'=>$this->school_info['school_id'] ) )?> <?php  } ?> 
                    <?php  } else if(!$row['url']) { ?>
                        <?php  echo $this->createMobileUrl($row['keyword'])?>
                    <?php  } else { ?>
                        <?php  echo $row['url'];?>
                    <?php  } ?> " class="weui_tabbar_item weui_bar_item_on">
                <div class="weui_tabbar_icon">
                    <img src="<?php  echo $row['img'];?>" alt="">
                </div>
                <p class="weui_tabbar_label"><?php  echo $row['name'];?></p>
            </a>        
        <?php  } } ?>
    </div>
    </body>
    
    </html>