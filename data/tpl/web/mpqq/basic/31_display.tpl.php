<?php defined('IN_IA') or exit('Access Denied');?><div class="panel panel-default">
	<div class="panel-heading">
		回复内容
	</div>
	<ul class="list-group">
		<li class="row list-group-item" ng-repeat="item in context.items">
			<div class="block">
				<div class="col-xs-12 col-sm-12">
					<textarea class="form-control content" ng-hide="item.saved" placeholder="添加要回复的内容" ng-model="item.content" rows="4" onkeyup="if (this.value.split('\n').length>4) this.rows=this.value.split('\n').length;"></textarea>
					<p class="form-control-static" ng-show="item.saved" ng-bind-html="item.content | nl2br"></p>
				</div>
				<div class="col-xs-12 col-sm-12 help-block">您还可以使用表情和链接。<a class="emotion-triggers" href="javascript:;" ng-init="initEmotion(this);"><i class="fa fa-github-alt"></i> 表情</a> <a class="emoji-triggers" href="javascript:;" ng-click="selectEmoji(this)" title="添加表情"><i class="fa fa-github-alt"></i> Emoji</a></div>
			</div>
			<div class="col-sm-12 text-right">
				<div class="btn-group">
					<a href="javascript:;" class="btn btn-default" ng-click="context.saveItem(item);">{{item.saved ? '编辑' : '保存'}}</a>
					<a href="javascript:;" class="btn btn-default" ng-click="context.removeItem(item);">删除</a>
				</div>
			</div>
		</li>
	</ul>
	<!-- <div class="form-group">
		<div class="col-sm-9">
			<textarea type="text" name="welcome" class="form-control" id="welcomeinput" autocomplete="off" /></textarea>
			<div class="help-block">设置用户添加公众帐号好友时，发送的欢迎信息。<a href="javascript:;" id="welcome"><i class="fa fa-github-alt"></i> 表情</a></div>
		</div>
	</div> -->
	<div class="panel-footer">
		<a href="javascript:;" class="btn btn-default" ng-click="context.addItem();">添加回复条目</a>
		<span class="help-block">添加多条回复内容时, 随机回复其中一条</span>
	</div>
	<input type="hidden" name="replies" />
</div>
<script>
	window.initReplyController = function($scope) {
		$scope.context = {};
		$scope.context.items = <?php  echo json_encode($replies)?>;
		if(!$.isArray($scope.context.items)) {
			$scope.context.items = [];
		}
		if($scope.context.items.length == 0) {
			$scope.context.items.push({content: ''});
		}
		$scope.context.addItem = function(){
			$scope.context.items.push({
				content: ''
			});
		};
		$scope.context.saveItem = function(item){
			item.saved = !item.saved;
		};
		$scope.context.removeItem = function(item) {
			require(['underscore'], function(_){
				$scope.context.items = _.without($scope.context.items, item);
				$scope.$digest();
			});
		};
		$scope.initEmotion = function(obj) {
			require(['util'], function(util){
				var elm = $('.emotion-triggers').eq(obj.$index);
				util.emotion(elm[0], elm.parent().parent().find('.content')[0], function(txt, elm, target){
					obj.item.content = $(target).val();
					$scope.$digest();
				});
			});
		};
        /*选择Emoji表情*/
		$scope.selectEmoji = function(obj) {
            require(['util'], function(util){
				var elm = $('.emoji-triggers').eq(obj.$index);
				var textbox = elm.parent().parent().find('.content')[0];
    			util.emojiBrowser(function(emoji){
    				var unshift = '[U+' + emoji.find("span").text() + ']';
    				var newstart = textbox.selectionStart + unshift.length;
    				var insertval = textbox.value.substr(0,textbox.selectionStart) + unshift + textbox.value.substring(textbox.selectionEnd);
    				obj.item.content = insertval;
    				$scope.$digest();
    			});
            });
		};
	};
	window.validateReplyForm = function(form, $, _, util, $scope) {
		var val = [];
		$scope.$digest();
		angular.forEach($scope.context.items, function(v, k){
			if($.trim(v.content) != '') {
				this.push(v);
			}
		}, val);
		if(val.length == 0) {
			util.message('请输入有效的回复内容.');
			return false;
		}
		$scope.$digest();
		val = angular.toJson(val);
		$(':hidden[name=replies]').val(val);
		return true;
	};
</script>