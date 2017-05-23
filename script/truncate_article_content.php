<?php
/*
	删除前面三小时的文章内容
*/


include $_SERVER['DOCUMENT_ROOT'].'da/script/dbo.php';

$dbo = new MysqlConnector();

$time = date("Y-m-d H:i:s" , time()-(3600*4));

$sql = "update article set content='' where create_time<'$time'";

$dbo->executeSql($sql);