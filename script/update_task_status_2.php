<?php
/*
	更新任务的状态 抓取成功，每小时一次
*/

include $_SERVER['DOCUMENT_ROOT'].'da/script/dbo.php';

$dbo = new MysqlConnector();

$date = date("Y-m-d H:i:s" ,time());

$sql      = "select id,query_task_id,kwds from query_task_detail where status=0 and '$date'>start_time and '$date'<end_time";

$r        = $dbo->query($sql);

foreach($r as $v){

	$task_id  = $v['query_task_id'];

	$id       = $v['id'];

	$sql = "update query_task set status=2 where id=$task_id";

	$dbo->executeSql($sql);
	/*
	$sql = "update query_task_detail set status=2 where id=$id";
	$dbo->executeSql($sql);	
	*/
}




