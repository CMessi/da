<?php 
	//1.确定应用名称 Home
	define('APP_NAME','Home');
	//2.确定应用路径
	define('APP_PATH','./Home/');	/* Home最后一个/一定要有 */
	//3.开启调试模式
	define('APP_DEBUG',true);
	define('THINK_PATH','./ThinkPHP/');
	//4. 确定核心文件
	require './ThinkPHP/ThinkPHP.php';
