<?php 
		$this->checkAdminWeb();
		$admin_result = D('admin')->judeAdminType();
		$left_top     = 'wap_admin';
		$left_nav     = 'article_class';
		$title        = '文章分类';  
		$sidebar_list = array(
				array('fun_str'=>'','fun_name'=>'官网管理'),
				array('fun_str'=>'article_class','fun_name'=>'文章分类'),
		);
		$top_action = array(
			array('action_name'=>'添加新的分类','action'=>'article_class','arr'=>array('ac'=>'new') ),
		);	
        $class_grade = D('grade');
        $class_grade->school_id = getSchoolId();
        $grade_list    = $class_grade->getSchoolList();
        $class_article = D("article");
        if($ac=='list'){
            $list = $class_article->getClassList(true,1000,1);
            foreach ($list as $key => $value) {
              $params[":pid"] = $value['class_id'];
              $list[$key]['list'] = $class_article->getClassList(true,1000,2,$params);
            }
            if(!$list){
                  $list  = $class_article->getClassList(true,1000,2);
            }
        }else{
            $list = $class_article->getClassList(false,1000,1);
        }
        if($ac=='new'){
            if($_GPC['submit']){
                if($_GPC['type']==2 && !$_GPC['pid'] ){
                     $this->myMessage('必须要有父级分类',$this->createWebUrl('article_class'),'错误');
                }
                $in['class_name']   = $_GPC['class_name'];
                $in['class_img']    = $_GPC['class_img'];
                $in['class_sort']   = $_GPC['class_sort'];
                $in['class_type']   = $_GPC['class_type'];
                $in['grade_id']     = $_GPC['grade_id'] ? $_GPC['grade_id']:0;
                $in['status']       = $_GPC['status'];
                $in['type']         = $_GPC['type'];
                $in['pid']          = $_GPC['pid'];

                $class_id = $class_article->addClass($in);
                if($_GPC['type']==1){
                    $params["type"] = 2;
                    $params["pid"]  = 0;
                    pdo_update("lianhu_article_class",array("pid"=>$class_id),$params);
                }
                $this->myMessage('新增成功',$this->createWebUrl('article_class'),'成功');
            }
        }
        if($ac=='edit'){
            $id     = $_GPC['id'];
            $result = $class_article->editClass( $id  );
            if($_GPC['submit']){
                if($_GPC['type']==2 && !$_GPC['pid'] ){
                     $this->myMessage('必须要有父级分类',$this->createWebUrl('article_class'),'错误');
                }
                $in['class_name']   = $_GPC['class_name'];
                $in['class_img']    = $_GPC['class_img'];
                $in['class_sort']   = $_GPC['class_sort'];
                $in['class_type']   = $_GPC['class_type'];
                $in['grade_id']     = $_GPC['grade_id']?$_GPC['grade_id']:0;
                $in['status']       = $_GPC['status'];
                $in['type']         = $_GPC['type'];
                $in['pid']          = $_GPC['pid'];
                $class_article->editClass($id,$in);
                $this->myMessage('编辑成功',$this->createWebUrl('article_class'),'成功');
            }
        }
        include $this->template('../admin/web_article_class');
        exit();