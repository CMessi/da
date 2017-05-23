<?php
	set_time_limit(0);
	global $cookie_arr;
	header("Content-type: text/html; charset=utf-8");
	include $_SERVER['DOCUMENT_ROOT'].'da/script/dbo.php';
	include __DIR__.'/function.php';
	include __DIR__.'/QueryList/phpQuery.php';  
	include __DIR__.'/QueryList/QueryList.php';

    $dbo    = new MysqlConnector();
    $date   = date("Y-m-d H:i:s" ,time());
    $sql    = "select id,kwds,task_id from da_query_task where status=0 and fid=1 and task_id!=0 and '$date'>start_time and '$date'<end_time and kwds!='' limit 1";
    $r      = $dbo->query($sql);
    $kwd    = $r[0]['kwds'];
    $pid 	= $r[0]['task_id'];//父ID
    $id     = $r[0]['id'];
    if(!$kwd) die('没有待运行的任务');

$username = base64_encode('18221915571');//修改点二
$password = '15623852773';//修改点一
$keyword=urlencode($kwd);//修改点三
$totalrow=20;//修改点四
$loginUrl = 'https://login.sina.com.cn/sso/login.php?client=ssologin.js(v1.4.15)&_='.time();
$loginData['entry'] = 'sso';
$loginData['gateway'] = '1';
$loginData['from'] = 'null';
$loginData['savestate'] = '30';
$loginData['useticket'] = '0';
$loginData['pagerefer'] = '';
$loginData['vsnf'] = '1';
$loginData['su'] = $username;
$loginData['service'] = 'sso';
$loginData['sp'] = $password;
$loginData['sr'] = '1920*1080';
$loginData['encoding'] = 'UTF-8';
$loginData['cdult'] = '3';
$loginData['domain'] = 'sina.com.cn';
$loginData['prelt'] = '0';
$loginData['returntype'] = 'TEXT';   
$content =  loginPost($loginUrl,$loginData);
list($header, $html) = explode("\r\n\r\n", $content);
	if(preg_match_all("/set\-cookie:((.*)\r\n)?/i", $header, $matches)){  
			$cookie_arr= $matches[2]; 
	}  
//var_dump($cookie_arr);
$html=json_decode($html);

$arr_t=$html->crossDomainUrlList;
$result=httpscurl($arr_t[0]);
list($header, $html) = explode("\r\n\r\n", $result);
	if(preg_match_all("/set\-cookie:((.*)\r\n)?/i", $header, $matches)){  
			$cookie_arr= array_merge($cookie_arr,$matches[2]); 
 }   
$result=httpcurl_r('http://weibo.cn/pub/');
list($header, $html) = explode("\r\n\r\n", $result);
	if(preg_match_all("/set\-cookie:((.*)\r\n)?/i", $header, $matches)){  
			$cookie_arr= array_merge($cookie_arr,$matches[2]); 
 }   
$p= 1;
$totalpage; 
$currentrow=1;
$go=true;
while($go){
		//$inputstr='<meta charset="UTF-8">';
		$rule1=array(
			'html'=>array('.c','html'),
			'page'=>array('#pagelist','text') 
		) ;
		$ssurl='http://weibo.cn/search/mblog?hideSearchFrame=&keyword='.$keyword.'&page='.$p; 
		$html1 = \QL\QueryList::Query($ssurl,$rule1)->data;

		foreach($html1 as $k=>$v){
			if($currentrow>$totalrow) {
				$go=false;	
				break;
			}
			if($k==0 && $p==1){
					$pagearr=explode('/',$v['page']); 
					$totalpage=intval($pagearr[1]); 
					
			}
			$rule2=array(  
			 'nkhref'=>array('.nk','href'),
			 'nkname'=>array('.nk','text'),
			 'content'=>array('.ctt','text'),
			 'contenttime'=>array('.ct','text')
			); 
			$html2 = \QL\QueryList::Query($v['html'],$rule2)->data; 
			//匹配点赞，评论，转发
			preg_match_all('/[\x{4e00}-\x{9fa5}]\[(\d*)\]/u',$v['html'],$othermatch);  
			if(!empty($html2) && !empty($html2[0]['nkhref'])){
					$currentrow++;
					/*$inputstr.='<div style="border:5px solid red; ">'
								.'昵称:'.$html2[0]['nkname']
								.'<br/>内容:'.$html2[0]['content']
								."<br/>赞:".$othermatch[1][0]
								."<br/>转发:".$othermatch[1][1]
								."<br/>评论:".$othermatch[1][2]
								."<br/>评论时间:".$html2[0]['contenttime'];*/ 
								$nkname 	= $html2[0]['nkname'];//昵称
								$content 	= $html2[0]['content'];//内容
								//$contenttime= $html2[0]['contenttime'];//评论时间
								$contenttime= date('Y-m-d',time());//评论时间
								$pattern 	= '/【(.*)】/isU';
								$content = trim(strip_tags($content));
								preg_match_all($pattern, $content, $matchess);
								//var_dump($matchess);
								//$title 		= $matchess[1][0];
								//微博很多没有明确的标题
								//if(!$title){
								$title = mb_substr($content,0,50);
								//}
								$like_cnt 	= $othermatch[1][0];//赞
								$rply_cut 	= $othermatch[1][1];//转发
								$rply_cnt 	= $othermatch[1][2];//评论

				//博主信息抓取
				$rule3=array(
					'address'=>array('.ut>.ctt:eq(0)','text'),//性别信息
					'sign'=>array('.ut>.ctt:last','text'),//签名
					'otherinfo'=>array('.tip2:eq(0)','text')//微博，关注，粉丝等
				) ;
				$blogurl=$html2[0]['nkhref']; 
				$bloginfo = \QL\QueryList::Query($blogurl,$rule3)->data;
				preg_match_all('/[\x{4e00}-\x{9fa5}]\[(\d*)\]/u',$bloginfo[0]['otherinfo'],$otherinf_arr);  
				preg_match_all('/[\x{4e00}-\x{9fa5}]+/u',$bloginfo[0]['address'],$address);  
				/*$inputstr.='<br/>博主性别/地址:'.$address[0][1].$address[0][2]
						   .'<br/>博主签名:'.$bloginfo[0]['sign']
						   .'<br/>微博数量:'.$otherinf_arr[1]['0']
						   .'<br/>关注:'.$otherinf_arr[1][1]
						   .'<br/>粉丝:'.$otherinf_arr[1][2]
						   .'<br/>分组:'.$otherinf_arr[1][3]
						   ."</div>";*/  
						   $weibo_author_info 	= $address[0][1].$address[0][2];
						   $sign 				= $bloginfo[0]['sign'];
						   $weibo_article_cnt 	= $otherinf_arr[1]['0'];
						   $weibo_guanzhu_cnt 	= $otherinf_arr[1][1];
						   $weibo_fensi_cnt 	= $otherinf_arr[1][2];
				$sql = "insert into da_article(task_pid,task_id,fid,tm_post,author,title,content,rply_cnt,rply_cut,like_cnt,weibo_author_info,weibo_article_cnt,weibo_guanzhu_cnt,weibo_fensi_cnt,create_time) values($pid,$id,1,'$contenttime','$nkname','$title','$content','$rply_cnt','$rply_cut','$like_cnt','$weibo_author_info','$weibo_article_cnt','$weibo_guanzhu_cnt','$weibo_fensi_cnt',NOW())";
				//echo $sql;
				$dbo->executeSql($sql);
			} 
		}       
		if($p>=$totalpage) break;	  
		if($go) $p++;	   
} 
//echo '总共抓取数据'.$currentrow.'共抓取了'.$p.'页';

    //完成抓取后改变状态为成功
    $sql = "update da_query_task set status=2 where id=$id";
    $dbo->executeSql($sql);





?>