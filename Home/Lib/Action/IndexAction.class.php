<?php

class IndexAction extends CommonAction {

//任务管理员管理中心
    public function user_main(){

		import('ORG.Net.page');
        //服务器数量
    	$fwqCount = M('fwq')->count();
        //采集任务条数
        $dbo = M("query_task");
        $taskCount = $dbo->where('status=1')->count();
        //当前数据记录
        $articleCount = M('article')->count();
        //监测任务
        $where = " task_id=0  ";
        //每页显示的行数
        $showrow = 10;
        //当前的页,还应该处理非数字的情况
        $curpage = empty($_GET['page']) ? 1 : $_GET['page'];
        //总数
        $total = $dbo->where($where)->count();
        //当前页数大于最后页数，取最后一页
        if (!empty($_GET['page']) && $total != 0 && $curpage > ceil($total / $showrow))
            $curpage = ceil($total_rows / $showrow);
        //分页获取数据
        $list = $dbo->field('id,task_name,fid,article_count,start_time,end_time,status,kwds')->where($where)->limit(($curpage - 1) * $showrow . ',' . $showrow)->select();
        //分页地址
        $url = "?page={page}";
        //总记录数大于每页显示数，显示分页
        if ($total > $showrow) {
            $page = new page($total, $showrow, $curpage, $url, 2);
            $show = $page->myde_write();
        }

		$this->assign('list',$list);
        $this->assign('fwqCount',$fwqCount);
        $this->assign('articleCount',$articleCount);
        $this->assign('taskCount',$taskCount);
        $this->assign('show',$show);

		$this->display();
    }
//用户查看员管理中心
    public function mng_main(){
    	//var_dump($_SESSION);
        //服务器
        $fwqCount = M('fwq')->count();
        //采集任务条数
        $dbo = M("query_task");
        $taskCount = $dbo->where('status=1')->count();        
        //当前数据记录
        $articleCount = M('article')->count();
        //监测任务
        $where = " task_type=1  ";
        $count = $dbo->where($where)->count();
        $p = $this->CommonPageAction(10,$count,'');
        // 分页显示输出
        $page = $p->show();
        $list = $dbo->field('id,task_name,web_site,article_count,start_time,end_time,status,kwds')->limit($p->firstRow.','.$p->listRows)->where($where)->select();

		$this->assign('list',$list);
        $this->assign('fwqCount',$fwqCount);
        $this->assign('articleCount',$articleCount);
        $this->assign('taskCount',$taskCount);
        $this->assign('page',$page);    	
		$this->display();
    }

	//系统管理员管理中心
    public function sys_main(){
        //服务器
        $fwqCount = M('fwq')->count();
        //采集任务条数
        $dbo = M("query_task");
        $taskCount = $dbo->where('status=1')->count();        
        //当前数据记录
        $articleCount = M('article')->count();
        //监测任务
        $where = " task_type=1  ";
        $count = $dbo->where($where)->count();
        $p = $this->CommonPageAction(10,$count,'');
        // 分页显示输出
        $page = $p->show();
        $list = $dbo->field('id,task_name,web_site,article_count,start_time,end_time,status,kwds')->limit($p->firstRow.','.$p->listRows)->where($where)->select();

		$this->assign('list',$list);
        $this->assign('fwqCount',$fwqCount);
        $this->assign('articleCount',$articleCount);
        $this->assign('taskCount',$taskCount);
        $this->assign('page',$page);
        $this->display();
    }






	
}