<?php
//分词
class SegmentationAction extends CommonAction {

	//语义分词管理
	    public function mng_main_misson_segmentation(){

	    	$id = I('id');

	    	$dbo = M('fenci_result');

	    	$fenci_types = M('fenci_type')->select();

	    	$type = I('type');

	    	$where = " task_pid=$id";
	    	
	    	if($type && $type!='all'){
	    		$where.=" and fenci_type like '%$type%'";
	    	}
	        //分页地址
	        $url = "?page={page}&id=$id&type=$type";

			import('ORG.Net.page');
		    //每页显示的行数
	        $showrow = 10;
	        //当前的页,还应该处理非数字的情况
	        $curpage = empty($_GET['page']) ? 1 : $_GET['page'];
	        //总数
	        $total_1 = $dbo->where($where)->group('fenci')->select();
	        $total = count($total_1);
	        //当前页数大于最后页数，取最后一页
	        if (!empty($_GET['page']) && $total != 0 && $curpage > ceil($total / $showrow))
	            $curpage = ceil($total_rows / $showrow);
	        //分页获取数据
	        $list = $dbo->field("sum(count) c,fenci")->where($where)->group('fenci')->order("c desc")->limit(($curpage - 1) * $showrow . ',' . $showrow)->select();

	        //总记录数大于每页显示数，显示分页
	        if ($total > $showrow) {
	            $page = new page($total, $showrow, $curpage, $url, 2);
	            $show = $page->myde_write();
	        }
	    	$this->assign("list",$list);
	    	$this->assign("show",$show);
	    	$this->assign("fenci_types",$fenci_types);
	    	$this->display();
	    }    
	//分词管理详情
	    public function mng_main_misson_segmentation_detail(){

	    	$fenci = $_GET['fenci'];

	    	$id = $_GET['id'];//任务ID

	    	$dbo = M("fenci_result");
	        //分页地址
	        $url = "?page={page}&id=$id&fenci=$fenci";

			import('ORG.Net.page');
		    //每页显示的行数
	        $showrow = 1;
	        //当前的页,还应该处理非数字的情况
	        $curpage = empty($_GET['page']) ? 1 : $_GET['page'];

	        $where = "fenci='$fenci' and task_pid=$id";
	        //总数
	        $total = $dbo->where($where)->count();

	        //当前页数大于最后页数，取最后一页
	        if (!empty($_GET['page']) && $total != 0 && $curpage > ceil($total / $showrow))
	            $curpage = ceil($total_rows / $showrow);
	        //分页获取数据
	        $list_1 = $dbo->field("article_id")->where($where)->limit(($curpage - 1) * $showrow . ',' . $showrow)->select();
	        //echo $dbo->getLastSql();
	        $article_id = $list_1[0]['article_id'];
	        $content = M('article')->field("content")->where("id=$article_id")->find();
	        //总记录数大于每页显示数，显示分页
	        if ($total > $showrow) {
	            $page = new page($total, $showrow, $curpage, $url, 2);
	            $show = $page->myde_write();
	        }

	        $article_content = $content['content'];

	        $this->assign("article_content",$article_content);
	        $this->assign("article_id",$article_id);
	        $this->assign("show",$show);

	    	$this->display();
	    }


//删除分词


    public function ajaxDelFenci(){
    	$name = I('name');
        if(M('fenci')->where("name='$name'")->delete()){
        	if(M('fenci_result')->where("fenci='$name'")->delete()){
        		echo 'success';
        	}else{
        		echo 'fail2';
        	}
            
        }else{
            echo 'fail';
        }
    }

}