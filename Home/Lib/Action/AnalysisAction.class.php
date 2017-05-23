<?php
class AnalysisAction extends CommonAction {

	/*****************************任务筛选********************************/
	//任务筛选 new
		public function mng_misson_analysis(){
			$dbo 		= M("article");
			$task_pid 	= $_GET['id'];
			/************情感正面、负面文章TOP10************/
			$sql = "select title,id,fid from da_article where task_pid=$task_pid and is_active='1' order by active_score desc limit 10";
			$active = $dbo->query($sql);
			$sql = "select title,id,fid from da_article where task_pid=$task_pid and is_active='-1' order by active_score desc limit 10,10";
			$inactive = $dbo->query($sql);

			$this->assign('active',$active);
			$this->assign('inactive',$inactive);
			$this->display();		
		}
	/*
		ajax获取当前任务ID下的微博数据 new
	*/

		public function	ajaxGetArticleDataByID(){
			$dbo 			= M("article");
			$fid 			= $_POST['fid'];//渠道 1微博 2微信
			$task_pid 		= $_POST['id'];//任务ID
			$pagenum 		= $_POST['pagenum'];//分页数
			$is_star 		= $_POST['is_star'];//显示标星
			$date_check 	= $_POST['date_check'];//判断时间
			$article_title 	= $_POST['article_title'];//标题关键字
			$where 			= " fid=$fid and task_pid=$task_pid";//起始where条件
			//是否显示标星
			if($is_star==2){
				$checked = "checked=checked";
				$where.= ' and star=1';
			}
			//文章标题关键字
			if(!empty($article_title)){
				$where.= ' and title like "%'.$article_title.'%"';
			}
			//时间选择
			if(!$date_check){$date_check=1;}
			if($date_check==6){
				$where.= '';
			}else{
				$where.= $this->getDataByDate($date_check);
			}
			//拿到当前任务下微博总数
			$total 		= $dbo->where($where)->count();
			import('ORG.Net.page2');
			//每页显示的行数
			$showrow = 10;
			//当前的页,还应该处理非数字的情况
			$curpage = empty($pagenum) ? 1 : $pagenum;
			//当前页数大于最后页数，取最后一页
			if (!empty($_GET['page']) && $total != 0 && $curpage > ceil($total / $showrow))
			    $curpage = ceil($total_rows / $showrow);
			//分页获取数据
	        $rows = $dbo->field('read_cnt,id,create_time,title,author,tm_post,star')->where($where)->limit(($curpage - 1) * $showrow . ',' . $showrow)->select();
	        //分页地址
	        $url = "{page}";
	        //总记录数大于每页显示数，显示分页
	        if ($total > $showrow) {
	            $page = new page2($total, $showrow, $curpage, $url, 2);
	            $show = $page->myde_write();
	        }
	        $html = '<p>
	                    <div class="alert alert-info">
	                      	<input onclick="showStar()" type="checkbox" value="" name="is_star" id="is_star" '.$checked.' > 仅显示标星帖子
	                    </div>
	                 </p>
	                 <div >
	                  	<ul class="list-group" id="list">';
	        foreach($rows as $v){
	        	$id = $v['id'];
	        	$title = $v['title'];
	        	$author = $v['author'];
	        	$star = $v['star'];
	        	if($star==2){
	        		$star = 'glyphicon-star-empty';
	        		$star_title = 'title="未标星"';
	        		$star_id = 2;
	        	}else{
	        		$star = 'glyphicon-star';
	        		$star_title = 'title="已标星"';
	        		$star_id = 1;
	        	}
	        	$tm_post = $v['tm_post'];
	        	$html.='<li class="list-group-item" id="li_list_'.$id.'">
	                      <div class="panel panel-default">
	                        <div class="panel-body">
	                          <div>
	                            <input type="checkbox" name="checkbox" >
	                            <a href="__URL__/mng_mission_article_detail?id='.$id.'" target="_top">'.$title.'</a>
	                          </div>
	                          <small>
	                            <div>'.$tm_post.' 来自 <a href="__URL__/mng_mission_article_detail?id='.$id.'" target="_top">'.$author.'</a>
	                            </div>
	                          </small>
	                        </div>
	                        <div class="panel-footer">
	                          <div class="text-right">
	                            <button type="button" id="weibo_'.$id.'" class="btn btn-link glyphicon '.$star.'" '.$star_title.' onclick="addStar('.$star_id.','.$id.')"></button>
	                           <button type="button" class="btn btn-link glyphicon glyphicon-trash" onclick="delArticle('.$id.')"></button>
	                           </div>
	                         </div>
	                      </div>
	                    </li>';
	        }
	        $html.='</ul>
	                    </div>
	                    <div class="showPage">'.$show.'</div>';
	        echo $html;
		}

	//通过数值判断时间选择 new
		public function getDataByDate($date){
			$now_date 	= date('Y-m-d');//当前日期
			//日期查询
			if($date==1){
				$where =" and create_time>'$now_date'";
			}elseif($date==2){
				$w 		= date('w',strtotime($now_date));//本周第几天
				$date1 	= date('Y-m-d',strtotime("$now_date -".($w ? $w - 1 : 6).' days'));
				$where =" and create_time>'$date1'";
			}elseif($date==3){
				$start_week = date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),date("d")-date("w")+1-7,date("Y")));
				$end_week 	= date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("d")-date("w")+7-7,date("Y")));
				$where =" and create_time>'$start_week' and create_time<'$end_week' ";
			}elseif($date==4){
				$date1 		= date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),1,date("Y")));
				$where =" and create_time>'$date1'";
			}elseif($date==5){
				$start_month 	= date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m")-1,1,date("Y")));
				$end_month 		= date("Y-m-d H:i:s",mktime(23,59,59,date("m") ,0,date("Y")));
				$where =" and create_time>'$start_month' and create_time<'$end_month' ";
			}else{
				$start 	= $_GET['start_time'];
				$end 	= $_GET['end_time'];
				$where =" and create_time>'$start' and create_time<'$end' ";
			}
			return $where;
		}


	//增加标星 new
		public function ajaxAddStar(){
			if($_POST['s']==2){
				$data['star'] = 1;
			}else{
				$data['star'] = 2;
			}
			$data['id'] 	= $_POST['id'];
			if(M("article")->save($data)){
				echo 'ok';
			}else{
				echo 'no';
			}
		}
	//删除文章 new
		public function ajaxDelArticle(){
			$id = $_POST['id'];
			if(M("article")->delete($id)){
				if(M("article_content")->where('article_id='.$id)->delete()){
					echo 'ok';
				}
			}else{
				echo 'no';
			}
		}
	//文章详情 new
		public function mng_mission_article_detail(){
			$id = $_GET['id'];
			$article_detail = M("article")->field('id,fid,create_time,author')->where("id=".$id)->select();
			$this->assign('article_detail',$article_detail);
			$this->display();
		}


}