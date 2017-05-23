<?php
class TaskAction extends CommonAction {
//添加任务 new
	public function mng_mission_add(){
    	$list = M('website')->select();
    	$this->assign('list',$list);
		$this->display();
	}

//添加任务方法 new
    public function ajaxAddTaskHandle(){
    	$dbo = M('query_task');
    	$data['task_name'] 		= $_POST['task_name'];
    	$data['fid'] 			= $fid = rtrim($_POST['site_id'],',');
    	$data['user_id'] 		= $_SESSION['authId'];
    	$data['kwds'] 			= $_POST['kwds'];
    	$data['start_time'] 	= $_POST['start_time'];
    	$data['end_time'] 		= $_POST['end_time'];
    	$data['more_kwds'] 		= $_POST['more_kwds'];
    	$data['del_kwds'] 		= $_POST['del_kwds'];
    	$data['search_type'] 	= $_POST['search_type'];
    	$data['create_time']    = date('Y-m-d H:i:s',time());
		//判断排除关键字
		$del_kwds_e = explode(' ', $data['del_kwds']);
		if(count($del_kwds_e)>3){
			echo 'del_kwds';return;
		}
		//判断并列关键词
		$more_kwds_e = explode(' ', $data['more_kwds']);
		if(count($more_kwds_e)>3){
			echo 'more_kwds';return;
		}
		if(strtotime($data['end_time'])<strtotime($data['start_time'])){
			echo 'eq';return;
		}
		//写入任务总表
		$dbo->add($data);
		$newID = $dbo->getLastInsID();
		//task_id 默认为0 即为总任务 其他的为总任务下的分任务
		$data['task_id'] = $newID;
		//写入任务详情
		if(strlen($fid)>2){
			//先把并列主关键字写入到详情
			$data['fid'] = $fid[0];
			$dbo->add($data);
			$data['fid'] = $fid[2];
			$dbo->add($data);
			//如果有从关键字
			if($data['more_kwds']!=''){
				$c = count($more_kwds_e);
				$data['task_type'] = 2;//并列主关键字任务值 默认为1
				for($i=0;$i<$c;$i++){
					$data['kwds'] = $more_kwds_e[$i];
					$data['fid'] = $fid[0];
					$dbo->add($data);
					$data['fid'] = $fid[2];
					$dbo->add($data);
				}
			}
			echo 'ok';return;	
		}else{
			$data['fid'] = $fid[0];
			$dbo->add($data);
			if($data['more_kwds']!=''){
				$c = count($more_kwds_e);
				$data['task_type'] = 2;//并列主关键字任务值 默认为1
				for($i=0;$i<$c;$i++){
					$data['kwds'] = $more_kwds_e[$i];
					$data['fid'] = $fid[0];
					$dbo->add($data);
				}
			}
			echo 'ok';return;
		}
    }

//任务管理 new
	public function mng_main_misson(){
		$list = M("query_task")->field('id,task_name,fid,article_count,start_time,end_time,status,kwds')->where('task_id=0')->select();
		$this->assign('list',$list);
		$this->display();
	}

//暂停任务 new
	public function ajaxStopMission(){
		$query_task = M("query_task");
		if($_POST['type']=='stop'){
			$query_task-> where('id='.$_POST['id'])->setField('status',5);
			$query_task-> where('task_id='.$_POST['id'])->setField('status',5);
		}else{
			$query_task-> where('id='.$_POST['id'])->setField('status',0);
			$query_task-> where('task_id='.$_POST['id'])->setField('status',0);		
		}
	}

//任务文章明细 new
	public function task_detail(){
		import('ORG.Net.page');
		$dbo 	= M('article');
		$id 	= $_GET['id'];
		$task_name 	= $_GET['task_name'];

		$where 	= "task_pid=$id";
		//每页显示的行数
		$showrow = 20;
		//当前的页,还应该处理非数字的情况
		$curpage = empty($_GET['page']) ? 1 : $_GET['page'];
		//总数
		$total 	= $dbo->where($where)->count();
        //当前页数大于最后页数，取最后一页
        if (!empty($_GET['page']) && $total != 0 && $curpage > ceil($total / $showrow))
            $curpage = ceil($total_rows / $showrow);
        //分页获取数据
		$list = $dbo->field('author,create_time,fid,id')->limit(($curpage - 1) * $showrow . ',' . $showrow)->where($where)->select();
        //分页地址
        $url = "?page={page}&task_name=$task_name&id=$id";
        //总记录数大于每页显示数，显示分页
        if ($total > $showrow) {
            $page = new page($total, $showrow, $curpage, $url, 2);
            $show = $page->myde_write();
        }
		$this->assign('list',$list);
		$this->assign('task_name',$task_name);
		$this->assign('show',$show);
		$this->display();
	}

//ajax获取文章详情 new
	public function ajaxGetContentByID(){
		$id 	= $_POST['id'];
		$fid 	= intval($_POST['fid']);
		$dbo 	= M('article');
		$sql 	= "select a.tm_post,a.author,a.title,a.rply_cnt,a.read_cnt,a.rply_cut,a.like_cnt,a.weixin_code_en,a.weixin_code_cn,a.weixin_suggest,a.weibo_author_info,a.weibo_article_cnt,a.weibo_guanzhu_cnt,a.weibo_fensi_cnt,ac.content from da_article a left join da_article_content ac on a.id=ac.article_id where a.id=$id";
		$info = $dbo->query($sql);
		$title = $info[0]['title'];//标题
		$content = $info[0]['content'];//内容
		$tm_post = $info[0]['tm_post'];//发布时间
		$author = $info[0]['author'];//作者
		$rply_cnt = $info[0]['rply_cnt'];//评论数 用于微博
		$read_cnt = $info[0]['read_cnt'];//阅读数 用于微信
		$rply_cut = $info[0]['rply_cut'];//转发数 用于微博
		$like_cnt = $info[0]['like_cnt'];//“赞”主要用于微博、微博
		$weixin_code_en = $info[0]['weixin_code_en'];//信微号英文名称
		$weixin_code_cn = $info[0]['weixin_code_cn'];//微信号中文名称
		$weixin_suggest = $info[0]['weixin_suggest'];//微信介绍
		$weibo_author_info = $info[0]['weibo_author_info'];//微博作者信息
		$weibo_article_cnt = $info[0]['weibo_article_cnt'];//微博发文数
		$weibo_guanzhu_cnt = $info[0]['weibo_guanzhu_cnt'];//微博关注数
		$weibo_fensi_cnt = $info[0]['weibo_fensi_cnt'];//微博粉丝数
		$html = '<h4 class="center" style="font-weight:bold">'.$title.'</h4>
		<div class="center" style="font-size:12px">发布时间：'.$tm_post.' 作者：'.$author.'</div>';
		if($fid==1){
			 $html.='<div class="center" style="font-size:12px">评论数：'.$rply_cnt.' 转发数：'.$rply_cut.' 点赞数：'.$like_cnt.'</div>
			 <div class="center" style="font-size:12px">微博发文数：'.$weibo_article_cnt.' 微博关注数：'.$weibo_guanzhu_cnt.' 微博粉丝数：'.$weibo_fensi_cnt.'</div>
                        <br>';
		}else{
			$html.='<div class="center" style="font-size:12px">阅读数：'.$read_cnt.' 点赞数：'.$like_cnt.' 微信号：'.$weixin_code_cn.'</div>
			<div class="center" style="font-size:12px">微信号简介：'.$weixin_suggest.'</div>
                        <br>';
		}
		$html.='<div style="text-indent:27px">'.$content.'</div>';
		echo $html;
	}

	
}