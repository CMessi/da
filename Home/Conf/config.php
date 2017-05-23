<?php
	return array(
		//'DB_DSN'=>'mysql://root:4eabf7f0af@localhost:3306/da',//使用DSN方式配置数据库信息
		'DB_DSN'=>'mysql://root:@localhost:3306/bigdata',//使用DSN方式配置数据库信息
		'DB_PREFIX'=>'da_',  //设置表前缀 
		'URL_CASE_INSENSITIVE'=>true,//url不区分大小写
		'TMPL_L_DELIM'=>'<{',//左右定界符
		'TMPL_R_DELIM'=>'}>',
		'OUTPUT_ENCODE'    =>false,//
		'DEFAULT_CHARSET'       => 'utf-8', // 默认输出编码
		'URL_MODEL'          => '2', //URL模式
		'SHOW_PAGE_TRACE'=>true,//开启页面Trace
		'TMPL_PARSE_STRING'=>array(           //添加自己的模板变量规则
			'__PUBLIC__'=>__ROOT__.'/Home/Tpl/Public',
		),
		//RBAC认证信息
		'RBAC_SUPERADMIN'=>'admin',//设置超级管理员
		'ADMIN_AUTH_KEY'=>'superadmin',//超级管理员识别
		'USER_AUTH_ON'=>true, //是否需要认证
		'USER_AUTH_TYPE'=>1, //认证类型 1为登陆后才认证 2为实时认证
		'USER_AUTH_KEY'=>'authId', //认证识别号
		 //'REQUIRE_AUTH_MODULE'=> // 需要认证模块
		//'NOT_AUTH_MODULE'=>'Index,Login', //无需认证模块  和上面是重复的
		 //'NOT_AUTH_ACTION'=>'Login', //无需认证方法
		'USER_AUTH_GATEWAY'=>'/Login/index', //认证网关
		 //'RBAC_DB_DSN'=>  //数据库连接DSN
		'RBAC_ROLE_TABLE'=>'rbacrole', //角色表名称
		'RBAC_USER_TABLE'=>'rbacroleuser', //用户表名称
		'RBAC_ACCESS_TABLE'=>'rbacaccess',// 权限表名称
		'RBAC_NODE_TABLE'=>'rbacnode', //节点表名称
		
	);












