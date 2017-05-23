<?php
/*
  拿到微信抓取的首页内容
*/
header('content-Type: text/html; charset=utf-8');  
 
/*
查出数据库抓取关键字
根据关键字查询出微信数据
*/

    include_once('simple_html_dom.php');
    include $_SERVER['DOCUMENT_ROOT'].'da/script/dbo.php';
//拿到待抓取关键字信息
    $dbo    = new MysqlConnector();
    $date   = date("Y-m-d H:i:s" ,time());
    $sql    = "select id,kwds,task_id from da_query_task where status=0 and fid=2 and task_id!=0 and '$date'>start_time and '$date'<end_time and kwds!='' limit 1";
    $r      = $dbo->query($sql);
    $kwd    = $r[0]['kwds'];
    $pid    = $r[0]['task_id'];//父ID
    $id     = $r[0]['id'];
    if(!$kwd) die('没有待运行的任务');

    //完成抓取后改变状态为成功
    $sql = "update da_query_task set status=2 where id=$id";
    $dbo->executeSql($sql);

    //$url 微信浏览器地址栏url
    $url = "http://weixin.sogou.com/weixin?type=2&query=$kwd&ie=utf8&_sug_=n&_sug_type_=&w=01015002&oq=&ri=0&sourceid=sugg&sut=722&sst0=1463810369460&lkt=2%2C1463810368630%2C1463810369322";
    //获取html数据转化为对象
    $html = file_get_html($url);
    $time = time();
    //获取关键字查询结果
    for($i=0;$i<10;$i++){
    //$listData为数组对象 拿到第一个文章的数据
        $listData = $html->find("#main .news-list #sogou_vr_11002601_box_".$i);

        foreach($listData as $t){
            $titleUrl  = $t->find(".txt-box h3 a",0)->href;//获取标题的url
        }
      //strip_tags($titleUrl);   signature和timestamp必须用预先写死的
        $u = str_replace("&amp;", "&", $titleUrl);
//http://mp.weixin.qq.com/s?src=3&amp;timestamp=1486829675&amp;ver=1&amp;signature=eySvhHuvS00CoaoodvJ0fb1uSHCodnXXlpMbtW*BdtOvsyYw0DYqRY0D-hoQaTpwDDio4yOfNs6CEbX60NrmErjBp92EIfl*JQtYpiaQp4vn8asqOWaS-qfqErmjVCcANN9wxMDPz*DdhEynnu84V3d5FcaK3tLHkGGIBU5z0to=    
        $arr = explode("signature", $u);
        $signature = rtrim($arr[1],"=");
//http://mp.weixin.qq.com/s?src=3&timestamp=1486829987&ver=1&
        $timestamp = explode('timestamp',$arr[0]);
        $timestamp = substr($timestamp[1],1,10);

        //拿到点赞和阅读数
        $new_url = "http://mp.weixin.qq.com/mp/getcomment?src=3&ver=1&timestamp=".$timestamp."&signature".$signature."%3D&&uin=&key=&pass_ticket=&wxtoken=&devicetype=&clientversion=0&x5=0";

        $ss = file_get_contents($new_url);
        $json = json_decode($ss);
        //获取阅读数和点赞数
        $read_cnt = $json->read_num;
        $like_cnt = $json->like_num;

        $html2 = file_get_html($u);
        $listData2 = $html2->find('#img-content');
        foreach($listData2 as $t2){
            //发布日期
            $tm_post          = $t2->find("#post-date",0)->innertext;
            //微信号中文名称
            $weixin_code_cn   = $t2->find("#post-user",0)->innertext;
            //文章标题
            $title            = $t2->find("#activity-name",0)->innertext;
            $title            = trim($title);
            //文章作者
            $author           = $t2->find("#post-user",0)->innertext;
            //微信号
            $weixin_code_en   = $t2->find("#js_profile_qrcode .profile_meta_value",0)->innertext;
            //微信简介
            $weixin_suggest   = $t2->find("#js_profile_qrcode .profile_meta_value",1)->innertext;
            //微信内容
            $weixin_content   = $t2->find('#js_content', 0)->innertext;
           
            $weixin_content  = trim(strip_tags($weixin_content));
            $sql = "insert into da_article(task_pid,task_id,fid,tm_post,author,title,content,read_cnt,like_cnt,weixin_code_en,weixin_code_cn,weixin_suggest,create_time) values($pid,$id,2,'$tm_post','$author','$title','$weixin_content','$read_cnt','$like_cnt','$weixin_code_en','$weixin_code_cn','$weixin_suggest',NOW())";
            $dbo->executeSql($sql);
        }
    }
//http://weixin.sogou.com/weixin?query=%E4%B8%AD%E5%9B%BD&_sug_type_=&sut=4419&lkt=5%2C1489762391745%2C1489762395597&s_from=input&_sug_=n&type=2&sst0=1489762395723&page=1&ie=utf8&w=01019900&dr=1
//http://weixin.sogou.com/weixin?query=%E4%B8%AD%E5%9B%BD&_sug_type_=&sut=&lkt=&s_from=input&_sug_=n&type=2&sst0=&page=4&ie=utf8&w=01019900&dr=1
//http://weixin.sogou.com/weixin?query=%E5%90%83%E7%9A%84&_sug_type_=&sut=5756&lkt=1%2C1489763870726%2C1489763870726&s_from=input&_sug_=y&type=2&sst0=1489763870838&page=5&ie=utf8&w=01019900&dr=1
/*
for($i=2;$i<11;$i++){
  $url = "http://weixin.sogou.com/weixin?hp=32&query=$kwd&sut=4751&lkt=6%2C1463830881769%2C1463830885232&_sug_=y&sst0=1463830885357&oq=ch&stj0=0&stj1=0&hp1=&stj2=0&stj=0%3B0%3B0%3B0&_sug_type_=&ri=0&type=2&page=$i&ie=utf8&w=01015002&dr=1";
  //获取html数据转化为对象
  $html = file_get_html($url);

    for($n=0;$n<10;$n++){
        $listData=$html->find("#main .results #sogou_vr_11002601_box_".$n);//$listData为数组对象  拿到第一个文章的数据
        foreach($listData as $t){
          $titleUrl = $t->find(".txt-box h4 a",0)->href;//获取标题的url
        }  
        $u = str_replace("&amp;", "&", $titleUrl);
              $html2 = file_get_html($u);
        $listData2 = $html2->find('#img-content');
        foreach($listData2 as $t2){
        $tm_post          = $t2->find("#post-date",0)->innertext;//发布日期
        $weixin_code_cn   = $t2->find("#post-user",0)->innertext;//微信号中文名称
        $title            = $t2->find("#activity-name",0)->innertext;
        $title            = trim($title);//文章标题
        $author           = $t2->find("#post-user",0)->innertext;//作者
        //微信号英文
        $weixin_code_en   = $t2->find("#js_profile_qrcode .profile_meta_value",0)->innertext;
        //微信简介
        $weixin_suggest   = $t2->find("#js_profile_qrcode .profile_meta_value",1)->innertext;
        $read_cnt         = $t2->find("#sg_readNum3",0)->innertext;//阅读数
        $like_cnt         = $t2->find("#sg_likeNum3",0)->innertext;//点赞数
        $weixin_content   = $t2->find('#js_content', 0)->innertext;//微信内容
        $weixin_content1  = trim(strip_tags($weixin_content));
        $sql = "insert into article(task_id,fid,create_time,title,tm_post,author,weixin_code_en,weixin_code_cn,weixin_suggest,content,read_cnt,like_cnt) values($task_id,1,NOW(),'$title','$tm_post','$author','$weixin_code_en','$weixin_code_cn','$weixin_suggest','$weixin_content1','$read_cnt','$like_cnt')";
        $dbo->executeSql($sql);
      }
    }
}
*