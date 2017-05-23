<?php
class CompetingAction extends CommonAction {

/*竞品管理*/
//首页
    public function mng_mission_competingproducts(){
        $id = $_GET['id'];
//task_type=3竞品任务 task_id对应的主任务
        $list = M("query_task")->where("task_type=3 and task_id=$id")->select();
        $this->assign('list',$list);
        $this->display();
    }
    //添加竞品任务
    public function ajaxAddCompetingproduct(){
        $dbo = M('query_task');
        $data['del_kwds']   = $_POST['del_kwds'];
        $data['kwds']      = $_POST['kwds'];
        $data['task_id']    = $id = $_POST['id'];
        //查出对应的主任务信息
        $zhu_renwu          = $dbo->where("id=$id")->find();
        $data['search_type']= $zhu_renwu['search_type'];
        $data['task_name']  = $zhu_renwu['task_name'];
        $data['start_time'] = $zhu_renwu['start_time'];
        $data['end_time']   = $zhu_renwu['end_time'];
        $data['fid']        = $zhu_renwu['fid'];
        $data['create_time']= date('Y-m-d H:i:s',time());
        $data['task_type']  = 3;
        $data['user_id']    = $_SESSION['authId'];
//判断排除关键字
        $del_kwds_e = explode(' ', $del_kwds);
        if(count($del_kwds_e)>3){
            echo 'del_kwds';die;
        }
        //写入任务总表
        $dbo->add($data);
        $newID = $dbo->getLastInsID();
        $data['task_id'] = $newID;
        if(strlen($data['fid'])>2){
            $fid0 = $data['fid'][0];
            $fid2 = $data['fid'][2];
            $data['fid'] = $fid0;
            $dbo->add($data);
            $data['fid'] = $fid2;
            $dbo->add($data);
            echo 'success';return;
        }else{
            $data['fid'] = $data['fid'];
            $dbo->add($data);
            echo 'success';return;
        }

    }

/*
    竞品任务分析
*/
    public function mng_mission_competing(){
        $dbo = M("query_task");
        //查出所有的query_task表的主任务(不包括竞品任务)
        $zhu_list = $dbo->field('id,fid,task_name')->where('task_id=0')->select();
        //查出第一个主任务ID
        $zhu_id = $zhu_list[0]['id'];
        //通过ID找出匹配的竞品任务信息(可能会有多个竞品任务)
        $fu_list = $dbo->field('id,fid,kwds')->where("task_type=3 and task_id=$zhu_id")->select();
        $fid = $fu_list[0]['fid'];
        if($fid=="1,2"){
            $fid = 4;
        }
        //竞品任务分析页面展示
        $list = M('competingproduct_task')->select();

        $this->assign('zhu_list',$zhu_list);
        $this->assign('fu_list',$fu_list);
        $this->assign('fid',$fid);
        $this->assign('list',$list);
        $this->display();

    }    

//根据ID得到对应的竞品任务
    public function ajaxGetCompetingById(){
        //主任务ID
        $zhu_id = $_POST['id'];

        $dbo = M("query_task");
        //拿到竞品任务
        $fu_list = $dbo->field('id,kwds')->where("task_type=3 and task_id=$zhu_id")->select();

        $html ='';

        foreach($fu_list as $v){
            $kwds       = $v["kwds"];
            $id         = $v["id"];
            $html.= "<input type='checkbox' name='competing' field='$kwds' value='".$id."'>$kwds";
        }
        echo $html; 
    }
    //根据ID得到对应的fid
    public function ajaxGetFidById(){
        //主任务ID
        $zhu_id = $_POST['id'];

        $dbo    = M("query_task");
        //拿到竞品任务fid
        $result = $dbo->field('id,kwds,fid')->where("task_type=3 and task_id=$zhu_id")->find();
        $fid    = $result['fid'];

        $html ='<label>数据来源</label>';

        if($fid=="1,2"){
            $html .= "<label class='checkbox-inline'>
                            <input type='checkbox' name='data' value='1'>微博
                        </label>
                        <label class='checkbox-inline'>
                            <input type='checkbox' name='data' value='2'>微信
                        </label>";
        }elseif($fid=="1"){
            $html .= "<label class='checkbox-inline'>
                        <input type='checkbox' name='data' value='2'>微信
                    </label>";
        }else{
            $html .= "<label class='checkbox-inline'>
                        <input type='checkbox' name='data' value='1'>微博
                    </label>";
        }

        echo $html;
    }
//添加竞品分析任务
    public function ajaxAddCompeting(){
        $zhu_renwu  = $_POST['zhu_renwu'];
        $date       = $_POST['date'];
        $date1      = $_POST['date1'];
        $ganqing    = $_POST['ganqing'];
        $pic        = $_POST['pic'];
        $fu_kwds_view = rtrim($_POST['fu_kwds_view'],',');
        $competing  = rtrim($_POST['competing'],',');
        $data       = rtrim($_POST['data'],',');
        $now        = date('Y-m-d',time());
        //根据时间获取时间格式和where条件
        $getDateAndWhere = explode('*--*',$this->getDateAndWhere($date, $now));
        $date_frame = $getDateAndWhere[0];
        $time_view = $getDateAndWhere[1];
        $where = $getDateAndWhere[2];
        //插入竞品分析任务表
        $dbo = M("competingproduct_task");
        $sql = "insert into da_competingproduct_task(zhu_kwds,fu_kwds,graph_type,time_frame,partial,fid,time_view,create_time,fu_kwds_view) values('$zhu_renwu','$competing','$pic','$date_frame','$ganqing','$data','$time_view',NOW(),'$fu_kwds_view')";
        $new_id = 0;
        if($dbo->execute($sql)){
            echo 'success';
            $new_id = mysql_insert_id();
        }else{
            echo 'fail';
        }
//生成静态文件
        $this->addHtmlToCharts($where,$new_id,$zhu_renwu,$competing);


    }

//根据时间获取时间格式和where条件
    function getDateAndWhere($date, $now){
        if($date=='date1'){
            $d = date('Y-m-d', strtotime("-30 day"));
            $date_frame = $d.'--'.$now;
            $time_view = '最近30天';
            $where = " where create_time>'$d' and create_time<='$now' ";
        }else if($date=='date2'){
            $d = date('Y-m-d', strtotime("-60 day"));
            $date_frame = $d.'--'.$now;
            $time_view = '最近60天';
            $where = " where create_time>'$d' and create_time<='$now' ";
        }else if($date=='date3'){
            $d = date('Y-m-d', strtotime("-90 day"));
            $date_frame = $d.'--'.$now;
            $time_view = '最近90天';
            $where = " where create_time>'$d' and create_time<='$now' ";
        }else if($date=='date4'){
            $d = date('Y-m-d', strtotime("-365 day"));
            $date_frame = $d.'--'.$now;
            $time_view = '最近1年';
            $where = " where create_time>'$d' and create_time<='$now' ";
        }else if($date=='date5'){
            $date_frame = $date1;
            $time_view = $date_frame;
            $arr = explode("--", $date1);
            $start = $arr[0];
            $end = $arr[1];
            $where = " where create_time>'$start' and create_time<='$end' ";
        }
        return  $date_frame.'*--*'.$time_view.'*--*'.$where;
    }


//添加竞品分析任务的同时，生成静态HTML文件
    function addHtmlToCharts($where,$new_id,$zhu_renwu,$competing){
        $dbo = M("competingproduct_task");
        //主
        $sql = "select kwds from query_task where id=$zhu_renwu";
        $r = $dbo->query($sql);
        $zhu_renwu_kwds = $r[0]['kwds'];
        //副
        $sql = "select task_id from query_task where id=$competing";
        $r = $dbo->query($sql);
        $fu_renwu_kwds = $r[0]['task_id'];
        /*$sql = "select id from query_task where id=$fu_renwu_kwds";
        $r = $dbo->query($sql);*/
        $zhu_renwu_id = $r[0]['task_id'];
            //拿到主任务数据
            $sql = "select count(*) c,SUBSTR(create_time,1,10) d from article $where and task_id=$zhu_renwu group by CONCAT(SUBSTR(create_time,1,10),' 00:00:00') ";
            $list_zhu  =$dbo->query($sql);
        //拿到副任务数据
            $sql        = "select count(*) c,SUBSTR(create_time,1,10) d from article $where task_id=$competing group by CONCAT(SUBSTR(create_time,1,10),' 00:00:00') ";
            $list_fu  =$dbo->query($sql);

            $sql        = "select create_time from rili $where";
            $rili       = $dbo->query($sql);
            $arr = array();
            foreach($rili as $v){
                $arr[]='{"dateX": "'.$v['create_time'].'", "kts": 0, "ems": 0},';
            }
            foreach($arr as $k=>$v){
                foreach ($list_zhu as $v1) {
                    if(strpos($v, $v1['d']) !== false){
                       $arr[$k]=str_replace('"kts": 0', '"kts":'.$v1['c'], $v);
                    }
                }
            }
            foreach($arr as $k=>$v){
                foreach($list_fu as $v2){
                    if(strpos($v, $v2['d']) !== false){
                        $arr[$k]=str_replace('"ems": 0', '"ems":'.$v2['c'], $v);
                    }            
                }
            }
            foreach ($arr as $key => $value) {
                $result.= $value;
            }


        //创建静态页面
            $url = 'http://'.$_SERVER['HTTP_HOST'].'/da2/html/model.html';
            $template = file_get_contents($url);
            $html = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'da2'.DIRECTORY_SEPARATOR.'Home/Tpl/Competing'.DIRECTORY_SEPARATOR."$new_id.html";
            //$kwds = "xxxxx";
            $content = ' <script> $(function(){
             var tax_data = [
               '.$result.'
          ];
          Morris.Line({
            element: "morris-line",
            data: tax_data,
            xkey: "dateX",
            lineColors:[ "#5B9BD5", "#ED7D31"], 
            ykeys: ["kts", "ems"],
            labels: ["'.$zhu_renwu_kwds.'", "'.$fu_kwds_view.'"]
          });
        Morris.Bar({
          element: "morris-bar",
          data: [
            {x: "2011 Q1", y: 3, z: 2, a: 3},
            {x: "2011 Q2", y: 2, z: null, a: 1},
            {x: "2011 Q3", y: 0, z: 2, a: 4},
            {x: "2011 Q4", y: 2, z: 4, a: 3}
          ],
          xkey: "x",
          ykeys: ["y", "z", "a"],
          labels: ["Y", "Z", "A"]
        }).on("click", function(i, row){
          console.log(i, row);
        });
        });
        </script>
        ';

        $output = str_replace('<{content}>', $content, $template);
        file_put_contents($html, $output);

    }



//删除竞品任务
    function ajaxDelCompeting(){
        if(M("competingproduct_task")->delete($_POST['id'])){
            echo 'success';
        }else{
            echo 'fail';
        }
    }
    
}