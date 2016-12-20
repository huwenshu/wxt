<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../new/head', TEMPLATE_INCLUDEPATH)) : (include template('../new/head', TEMPLATE_INCLUDEPATH));?>
  <script type='text/javascript' src='http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js'></script>
<body ontouchstart >
<div class="container" id="container">
    <div class="article">
    <div class="bd">
        <article class="weui_article"> 
            <h1><?php  echo $record_re['record_intro'];?></h1>
            <?php  if($record_re['imgs']) { ?>
                <?php  $imgs = unserialize($record_re['imgs']);?>
                <?php  if($imgs) { ?>
                     <?php  $img_list =S("fun",'decodeImgs',array($imgs ,$this->module['config']['qiniu_url'] )); ?>
                     <?php  if(is_array($img_list)) { foreach($img_list as $row) { ?>
                        <img src='<?php  echo $row;?>' style="width:90%;margin-left:5%;margin-top:10px;">
                     <?php  } } ?>
                <?php  } ?>               
            <?php  } ?>
            <?php  if($record_re['voice']) { ?>
                <br>
                <br>
                <div style="width:100%;text-align:center">
                    <?php  echo  $this->echoVoiceUrl($record_re['voice']);?>
                </div>    
                <br>
            <?php  } ?>            
            <section>
                    <?php  echo htmlspecialchars_decode($record_re['record_content']);?>
            </section>
            <?php  if($record_re['url']) { ?>
                <div>
                    <a href='<?php  echo $record_re['url'];?>'>点击查看详情</a>
                </div>
            <?php  } ?>
        </article>
    <?php  $type = 1;?>
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../new/reply', TEMPLATE_INCLUDEPATH)) : (include template('../new/reply', TEMPLATE_INCLUDEPATH));?>
    </div>
    </div>
    </div>
    <div class="page-content loading-mask" id="new-stack">
      <div class="loading-icon">
        <div class="navbar-button-icon icon ion-load-d"></div>
      </div>
    </div>
	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('jsweixin', TEMPLATE_INCLUDEPATH)) : (include template('jsweixin', TEMPLATE_INCLUDEPATH));?>
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../new/footer', TEMPLATE_INCLUDEPATH)) : (include template('../new/footer', TEMPLATE_INCLUDEPATH));?>