<?php
//任务分类/主题
class CategoryAction extends CommonAction {

//任务分类界面展示
    public function user_mission_category(){

        $dbo = M("category");

        import('ORG.Net.page');

        $where = '1=1';

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
        $rows = $dbo->where($where)->order('create_time desc')->limit(($curpage - 1) * $showrow . ',' . $showrow)->select();
        //分页地址
        $url = "?page={page}";
        //总记录数大于每页显示数，显示分页
        if ($total > $showrow) {
            $page = new page($total, $showrow, $curpage, $url, 2);
            $show = $page->myde_write();
        }

        $this->assign("show", $show);

    	$this->assign('categorys',$rows);

        $this->display();
    }   

//任务主题界面展示
    public function user_mission_theme(){
            $dbo = M("theme");

            import('ORG.Net.page');

            $where = '1=1';

            //每页显示的行数
            $showrow = 10;
            //当前的页,还应该处理非数字的情况
            $curpage = empty($_GET['page']) ? 1 : $_GET['page'];
            //分页地址
            $url = "?page={page}";
            //总数
            $total = $dbo->where($where)->count();
            //当前页数大于最后页数，取最后一页
            if (!empty($_GET['page']) && $total != 0 && $curpage > ceil($total / $showrow))
                $curpage = ceil($total_rows / $showrow); 
            //分页获取数据
            $rows = $dbo->where($where)->order('create_time desc')->limit(($curpage - 1) * $showrow . ',' . $showrow)->select();
            //总记录数大于每页显示数，显示分页
            if ($total > $showrow) {
                $page = new page($total, $showrow, $curpage, $url, 2);
                $show = $page->myde_write();
            }

            $this->assign("show", $show);

            $this->assign('themes',$rows);

            $this->display();
    } 

//添加分类/主题名称
    public function ajaxAddCategory(){
        $data['name'] = $_POST['name'];
        $data['create_time'] = date('Y-m-d H:i:s',time());
        $dbo = $_POST['type'];
        //修改
        if($_POST['id']!=''){
            $data['id'] = $_POST['id'];
            if(M($dbo)->save($data)){
                echo "ok";
            }
        }else{
        //添加
           if(M($dbo)->add($data)){
               echo "ok";
           } 
        }
    }

//删除分类名称
    public function ajaxDelCategory(){
        $dbo = $_POST['type'];
    	if(M($dbo)->delete($_POST['id'])){
    		echo "ok";
    	}
    }
//用户语义分词管理
    public function user_mission_segmentation(){
        $dbo = M('fenci');

        $fenci_name  = I('fenci_name');

        import('ORG.Net.page');

        $where = '1=1';
        
        if($fenci_name){
            $where.=" and name='$fenci_name'";
        }
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
        $rows = $dbo->where($where)->limit(($curpage - 1) * $showrow . ',' . $showrow)->select();
        //分页地址
        $url = "?page={page}&fenci_name=$fenci_name";
        //总记录数大于每页显示数，显示分页
        if ($total > $showrow) {
            $page = new page($total, $showrow, $curpage, $url, 2);
            $show = $page->myde_write();
        }
        //分词类型
        $fenci_types = M('fenci_type')->select();

        $this->assign("show", $show);

        $this->assign('list',$rows);

        $this->assign('fenci_types',$fenci_types);

        $this->assign('fenci_name',$fenci_name);

        $this->display();
    }
//添加分词
    public function ajaxAddFenci(){
        $dbo = M('fenci');
        $data['name'] = I('name');
        $data['type'] = I('fenci_type');
        $id = I('id');
        //修改
        if($id){
            $data['id'] = $id;
            if($dbo->save($data)){
                echo 'success';
            }else{
                echo 'fail';
            }
        }else{
        //添加
            if($dbo->where("name='$name'")->find()){
                echo 'exist';
            }else{
                if($dbo->add($data)){
                    echo 'success';
                }else{
                    echo 'fail';
                }
            }
        }
    }
//删除分词
    public function ajaxDelFenci(){
        if(M('fenci')->delete(I('id'))){
            echo 'success';
        }else{
            echo 'fail';
        }
    }




}