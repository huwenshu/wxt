<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width; initial-scale=1; minimum-scale=1; maximum-scale=1"/>
<meta name="MobileOptimized" content="320"/>
<title><?php  echo $school_info['school_name'];?>微官网</title>
	<link href="<?php echo MODULE_URL;?>/wap/default/css/basic.css" rel="stylesheet" />
	<link href="<?php echo MODULE_URL;?>/wap/default/css/index.css" rel="stylesheet" />
	<script src="<?php echo MODULE_URL;?>/wap/default/js/jquery.min.js"></script>
	<script src="<?php echo MODULE_URL;?>/wap/default/js/responsiveslides.min.js"></script>
	<script src="<?php echo MODULE_URL;?>/wap/default/js/slide.js"></script>
</head>
<body>
<div class="wrap">
<?php  $banner_info =wapInfo('top_banner',1);  ?>
<?php  if($banner_info['content']) { ?>
<div class="header">
	<div class="logo" style="width:100%">
	<h1><img alt="<?php  echo $banner_info['url'];?>" src="<?php  echo $_W['attachurl'];?><?php  echo $banner_info['content'];?>" width="100%"></h1>
	</div>	
</div>
<?php  } ?>
<section class="m-focus">
<div id="swiper_focus" class="swiper-container">
<div class="swiper-wrapper">
	<?php  $img_list  =wapInfo('index_img',4);?>
	<?php  if(is_array($img_list)) { foreach($img_list as $row) { ?>
		<div class="swiper-slide"><a href="<?php  echo $row['url'];?>"><img src="<?php  echo $_W['attachurl'];?><?php  echo $row['content'];?>"></a></div>
	<?php  } } ?>
</div>
</div>
<div class="swiper-pagination"></div>
</section>


<div class="sort-nav">
<ul>
	<?php  $button_list  = wapInfo('middle_button1',16);?>
	<?php  if(is_array($button_list)) { foreach($button_list as $row) { ?>
		<li> <a href="<?php  echo $row['url'];?>" title=""> <span class="sort-circle sortid1" style="background:url('<?php  echo $_W['attachurl'];?><?php  echo $row['content'];?>') ;background-size: 100%;"></span> <span class="sort-desc"><?php  echo $row['info_name'];?></span> </a> </li>
	<?php  } } ?>
</ul>
</div>
<div class="sort-nav1">
<ul class="Special clearf">
	<?php  $button_list  = wapInfo('four_button',8);?>
		<?php  if(is_array($button_list)) { foreach($button_list as $row) { ?>
			<li><a href="<?php  echo $row['url'];?>"> <img src="<?php  echo $_W['attachurl'];?><?php  echo $row['content'];?>" alt="初中生"></a></li>
		<?php  } } ?>
</ul>
</div>
	<?php  $article_class = wapArticleClass(3,2); ?>
<div class="container" id="www_zzjs_net">
<?php  if($article_class ) { ?>
	<div class="con_title1"><span><em class="modular4"></em>学校动态</span>
	<div class="zzjs_net">
	<ul>
		<?php  if(is_array($article_class)) { foreach($article_class as $k => $v) { ?>
			<?php  $article_list[] =wapArticleList($v['class_id'],5);  ?>
			<li id="zzjs_net<?php  echo $k;?>" onclick="setTab('zzjs_net',<?php  echo $k;?>,3)" <?php  if($k==0) { ?> class="hover" <?php  } ?> ><?php  echo $v['class_name'];?></li>
		<?php  } } ?>
	</ul>
	</div>
	</div>
<?php  } ?>
<div class="nTab">
<?php  if(is_array($article_list)) { foreach($article_list as $k => $v) { ?>
	<div id="zzjs_zzjs_net_<?php  echo $k;?>" class=" <?php  if($k==0) { ?> hover <?php  } ?> TabContent" <?php  if($k!=0) { ?> style="display:none" <?php  } ?> >
		<dl>
		<a href ="<?php  echo  $this->createMobileUrl('wapContent',array('aid'=>$v[0]['list_id']))?>">
		<img class="fl" src="<?php  echo $_W['attachurl'];?><?php  echo $v[0]['artice_img'];?>" width="119" height="82">
		<div class="iNews_top_r">
		<h3><?php  echo $v[0]['article_title'];?></h3>
		<div class="time" style="text-align: right;"><?php  echo date("Y-m-d",$v[0]['add_time'])?></div>
		</div>
		</a>
		</dl>
	<ul>
		<?php  if(is_array($v)) { foreach($v as $s => $row) { ?>
			<?php  if($s >0) { ?>
					<li>
						<a href="<?php  echo  $this->createMobileUrl('wapContent',array('aid'=>$row['list_id']))?>"><?php  echo $row['article_title'];?></a>
					</li>
			<?php  } ?>
		<?php  } } ?>
	</ul>
	<div class="morebtn"><a href="<?php  echo $this->createMobileUrl('wapCategories')?>">查看更多新闻>></a></div>
	</div>
<?php  } } ?>
</div>

</div>
</div>
<?php  $img_say_list  = wapInfo('img_say',4);?>
<?php  if($img_say_list['0']) { ?>
	<div class="container">
		<div class="con_title"><span><em class="modular7"></em>图说<?php  echo $school_info['school_name'];?></span></div>
		<div class="h_20px"></div>
			<div class="left_img1"><a href="<?php  echo $img_say_list[0]['url'];?>"><img alt="" src="<?php  echo $_W['attachurl'];?><?php  echo $img_say_list[0]['content'];?>" width="100%" />
			<p><?php  echo $img_say_list[0]['info_name'];?></p></a>
		</div>
		<div class="left_img2">
			<div class="left_img3"><a href="<?php  echo $img_say_list[1]['url'];?>"> <img alt="" src="<?php  echo $_W['attachurl'];?><?php  echo $img_say_list[1]['content'];?>" width="100%" />
				<p><?php  echo $img_say_list[1]['info_name'];?></p></a>
			</div>
			<div class="left_img4"><a href="<?php  echo $img_say_list[2]['url'];?>"> <img alt="" src="<?php  echo $_W['attachurl'];?><?php  echo $img_say_list[2]['content'];?>" width="100%" />
				<p><?php  echo $img_say_list[2]['info_name'];?></p></a>
			</div>
		<div class="left_img4" style=" float:right"><a href="<?php  echo $img_say_list[3]['url'];?>"> <img alt="" src="<?php  echo $_W['attachurl'];?><?php  echo $img_say_list[3]['content'];?>" width="100%" />
			<p><?php  echo $img_say_list[3]['info_name'];?></p></a>
		</div>
		</div>
		<div class="h_20px"></div>
</div>
<?php  } ?>
	<div class="h_20px"></div>
	<div class="h_10px"></div>
	<div class="footer" style="height:1.5rem">
		<p>
			<?php  echo $school_info['school_name'];?>版权所有
		</p>
	</div>
</body>
<script>
function setTab(name,cursel,n){
	for(i=0;i<n;i++){
	var menu=document.getElementById(name+i);
	var con=document.getElementById("zzjs_"+name+"_"+i);
	menu.className=i==cursel?"hover":"";
	con.style.display=i==cursel?"block":"none";
	}
}
</script>
</html>