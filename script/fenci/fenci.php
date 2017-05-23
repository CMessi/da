<?php
	header("Content-type: text/html; charset=utf-8");
	//echo memory_get_usage().'start';
	include '../dbo.php';
	include 'PHPAnalysis.class.php';
	$prefix = 'da_';
	$dbo 	= new MysqlConnector();
  	$pa 	= new PhpAnalysis();
	$sql 	= "select * from {$prefix}article_content where is_fenci=1 limit 5";//
	$str 	= $dbo->query($sql);

	foreach($str as $k=>$v){
		$s = '';
		$content 	= $v['content'];
		$task_pid 	= $v['task_pid'];
		$task_id 	= $v['task_id'];
		$article_id = $v['article_id'];
		$id 		= $v['id'];
		$pa->SetSource("$content");
		$pa->resultType=2;
		$pa->differMax=true;
		//$pa->unitWord=false;
		//$pa->notSplitLen=2;
		$pa->StartAnalysis();
		$arr 		= $pa->GetFinallyIndex();
		foreach($arr as $k=>$v){
			//查询每个分词的类型
			$sql 	= "select type from {$prefix}fenci where name='$k' ";
			$r 		= $dbo->query($sql);
			//把task_id article_id fenci fenci_type count 
			if($r){
				$type 	= $r[0]['type'];
				unset($r);
				$s.= "(NULL,".$task_pid.','.$task_id.','.$article_id.','."'$k'".','."'$type'".','.$v.','.'NOW()'."),";
			}				
		}
		$s = rtrim($s,",");
		$sql = "insert into {$prefix}fenci_result values $s";
		$dbo->executeSql($sql);
		$sql = "update {$prefix}article_content set is_fenci=2 where id=$id";
		$dbo->executeSql($sql);
		unset($s);
		unset($v);
	}
//echo memory_get_usage().'end';