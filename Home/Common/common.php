<?php

function p($arr){
	echo "<pre>";
	print_r($arr);
	echo "</pre>";
}

//根据分词type获取分词类型中文

    function getNameByType($type){
    	$re = M('fenci_type')->field('name_c')->where(" SUBSTR('$type',1,2)=name_e or SUBSTR('$type',1,1)=name_e")->find();
    	return $re['name_c'];
    }

//根据文章ID获取文章标题
	function getTtileByID($id){
		$article = M('article')->field('title')->find($id);
		return $article['title'];
	}

	//根据竞品分析任务的任务ID拿到任务表的数据
	function getTaskBYCompeting($id){
		$r = M('query_task')->field('kwds')->find($id);
		return $r['kwds'];
	}

//根据用户ID获取用户状态（是否被禁用）
	function getUserStatusByID($status){
		//$status = M('rbacuser')->filed('status')->find($id);
		if($status==1){
			return '<font color=gren>开启</font>';
		}else{
			return '<font color=red>禁用</font>';
		}
	}
	//根据用户ID获取用户类型
	//0 超级管理员 1系统管理员sys-main，2任务管理员user-main，3任务查看员mng-main
	function getUserTypeByID($type){
		//$type = M('rbacuser')->filed('type')->find($id);
		if($type==0){
			return '超级管理员';
		}elseif($type['type']==1){
			return '系统管理员';
		}elseif($type['type']==2){
			return '任务管理员';
		}elseif($type['type']==3){
			return '任务查看员';
		}else{
			return '未知角色';
		}
	}