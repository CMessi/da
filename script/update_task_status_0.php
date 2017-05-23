<?php
/*
	更新任务的状态 准备抓取，每小时一次
*/


include $_SERVER['DOCUMENT_ROOT'].'da/script/dbo.php';

$dbo = new MysqlConnector();

$date = date("Y-m-d H:i:s" ,time());

  //$kwd = "吃";
$sql      = "select id,query_task_id,kwds from query_task_detail where status=2 and '$date'>start_time and '$date'<end_time";

$r        = $dbo->query($sql);

foreach($r as $v){

	$task_id  = $v['query_task_id'];

	$id       = $v['id'];

	$sql = "update query_task set status=0 where id=$task_id";

	$dbo->executeSql($sql);

	$sql = "update query_task_detail set status=0 where id=$id";

	$dbo->executeSql($sql);	
	
}




