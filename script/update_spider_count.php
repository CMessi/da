<?php
/*
	更新任务的抓取总数，每小时一次
*/


include $_SERVER['DOCUMENT_ROOT'].'da/script/dbo.php';

$dbo = new MysqlConnector();

$sql = 'select kwds from query_task';

$sql = "select count(*) c ,task_id from article group by task_id";

$r = $dbo->query($sql);

foreach($r as $v){
	$id = $v['task_id'];
	$c = $v['c'];
	$sql = "update query_task set article_count=$c where id = $id";
	//echo $sql;
	$dbo->executeSql($sql);
}