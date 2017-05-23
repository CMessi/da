<?php

error_reporting(E_ALL ^ E_NOTICE);

require_once './src/QcloudApi/QcloudApi.php';

include $_SERVER['DOCUMENT_ROOT'].'da/script/dbo.php';
//查出还没有进行情感分析的文章内容
$sql = "select * from da_article_content where is_active=1 limit 1";
$dbo = new MysqlConnector();
$articles = $dbo->query($sql);

//配置
$config = array('SecretId'        => 'AKIDBAuXtzEOgofFZftDbjaAUXLs74keEMs8',
             'SecretKey'       => '7ygPtHOEn68tNaXQ3RXNwEEwPlqeAOLF',
             'RequestMethod'  => 'POST',
             'DefaultRegion'    => 'gz');
$wenzhi = QcloudApi::load(QcloudApi::MODULE_WENZHI, $config);
/*
成功返回格式：
array (size=3)
  'codeDesc' => string 'Success' (length=7)
  'positive' => float 0.99481022357941
  'negative' => float 0.0051898001693189
*/
foreach($articles as $v){
	$content = $v['content'];
	$article_id = $v['article_id'];
	$id = $v['id'];

	$package = array("content"=>$content);
	$a = $wenzhi->TextSentiment($package);
	if ($a === false) {
	    $error = $wenzhi->getError();
	    echo "Error code:" . $error->getCode() . ".\n";
	    echo "message:" . $error->getMessage() . ".\n";
	    echo "ext:" . var_export($error->getExt(), true) . ".\n";
	} else {
	    $positive = $a['positive'];
	    $negative = $a['negative'];
	    $r = bccomp($positive,$negative,8);//比较最后结果
	    //更新da_article_content 为已经进行情感分析
	    $sql = "update da_article_content set is_active=2 where id = $id";
	    $dbo->executeSql($sql);
	    //积极消极分值
	    if($r<=0){
	    	$active_score = intval($negative*10000000);
	    }else{
	    	$active_score = intval($positive*10000000);
	    }
	    //更新情感分析结果
	    $sql = "update da_article set is_active='$r',active_score=$active_score where id=$article_id";
	    $dbo->executeSql($sql);
	}
}