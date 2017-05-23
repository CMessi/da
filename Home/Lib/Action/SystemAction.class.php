<?php
//系统管理
class SystemAction extends CommonAction {

//服务器管理
    public function server(){

        $dbo = M("fwq");

        $fwqs = $dbo->select();

        $this->assign("fwqs", $fwqs);

        $this->display();
    }

//添加/修改服务器
    public function ajaxAddServer(){
        $dbo = M("fwq");
        $data['fwq_name'] = $_POST['fwq_name'];
        $data['fwq_ip'] = $_POST['fwq_ip'];
        $data['create_time'] = date('Y-m-d H:i:s',time());
        //修改
        if($_POST['fwq_id']!=''){
            $data['id'] = $_POST['fwq_id'];
            if($dbo->save($data)){
                echo "success";
            }else{
                echo 'fail';
            }
        }else{
        //添加
            if($dbo->add($data)){
               echo "success";
            }else{
                echo 'fail';
            }
        }
    }

//删除服务器
    public function ajaxDelServer(){
        $dbo = M("fwq");
    	if($dbo->delete($_POST['id'])){
    		echo "success";
    	}else{
            echo 'fail';
        }
    }



//站点管理
    public function website(){

        $dbo = M("website");

        $websites = $dbo->select();

        $this->assign("websites", $websites);

        $this->display();
    }
















}