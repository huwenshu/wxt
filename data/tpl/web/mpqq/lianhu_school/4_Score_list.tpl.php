<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>
<div class='main'>
		<div class="panel-body table-responsive">
		<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" id="form1">
		<table class="table table-hover">
			<thead class="navbar-inner">
				<tr>
					<th style="width:100%">发布成绩</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($result)) { foreach($result as $item) { ?>
				<tr>
					<td>
						<?php  if($model!='student') { ?><a href="<?php  echo $this->result_result($item,$model,'url','score_list');?>"><?php  } ?>
												<?php  echo $this->result_result($item,$model,'name','msg');?>
						<?php  if($model!='student') { ?></a><?php  } else { ?>
									<input name='score[<?php  echo $item['student_id'];?>]' type='text' placeholder="请填入成绩">
						<?php  } ?>
						&nbsp;&nbsp;<input type='hidden' value='<?php  echo $model;?>' name='model'>
					</td>
				</tr>
				<?php  } } ?>
				<?php  if($model!='grade') { ?>
				<tr>
					<td><a href="javascript:;" onclick="window.history.back() ">返回</td>
				</tr>
				<?php  } ?>
			</tbody>
		</table>
        <?php  if($model=='student') { ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				添加成绩记录
			</div>
			<div class="panel-body">
				<div class="tab-content">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span>选择课程</label>
					<div class="col-sm-9 col-xs-8">
						<select name='course_id' onchange="ajax_up()" id="course_id">
						<?php  if(is_array($course_list)) { foreach($course_list as $row) { ?>
							<option value='<?php  echo $row['course_id'];?>'><?php  echo $row['course_name'];?></option>
						<?php  } } ?>
					</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span>选择考试记录</label>
					<div class="col-sm-9 col-xs-8">
						<select name='scorejilv_id' onchange="ajax_up()"id="scorejilv_id">
						<?php  if(is_array($jilv_list)) { foreach($jilv_list as $row) { ?>
							<option value='<?php  echo $row['scorejilv_id'];?>'><?php  echo $row['scorejilv_name'];?></option>
						<?php  } } ?>
					</select>
					</div>
				</div>							
			</div>
		</div>		
		<div class="form-group col-sm-12">
			<br>
			<input type='hidden' value='<?php  echo $_GPC['cid'];?>' name='class_id'>
			<input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1" />
		</div>
	</div>
    <?php  } ?>
</div>
</div>
<?php  if($model=='student') { ?>
	<script>
		$(function(){
			ajax_up();

		});
			function ajax_up(){
				var cid=<?php  echo $_GPC['cid'];?>;
				var course_id=$('#course_id').val();
				var scorejilv_id=$('#scorejilv_id').val();
				$.ajax({
					type:'post',
					url:'<?php  echo $this->createWebUrl('ajax',array('ac'=>'student_score_list'))?>',
					data:{cid:cid,course_id:course_id,scorejilv_id:scorejilv_id},
					dataType:'json',
					success:function(obj){
						if(obj.status=='yes'){
							$.each(obj.student_score_list,function(i,e){
								$('input[name="score['+e.student_id+']"]').val(e.score);
							});
						}
					}
				});								
			}
	</script>
<?php  } ?>