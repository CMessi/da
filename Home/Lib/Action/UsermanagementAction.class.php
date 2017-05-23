<?php
class UsermanagementAction extends CommonAction {

//用户管理界面
    public function user(){
    	$id = $_SESSION['authId'];
    	$this->info = M('rbacuser')->where("id=".$id)->select();

		$this->display();
    }

//修改密码
    public function user_setting_password(){
    	$id = $_SESSION['authId'];
    	$this->info = M('rbacuser')->where("id=".$id)->select();

		$this->display();
    }

    public function ajax_up_pwd(){
    	$dbo = M('rbacuser');
    	$id = $_SESSION['authId'];
    	$oldpwd = $_POST['oldpwd'];
    	$user_info = $dbo->where("id=".$id)->find();
    	if($user_info['password']!=md5($oldpwd)){
    		die('error');
    	}
    	$data['password'] = md5($_POST['newpwd']);
    	$data['id'] = $id;
    	if($dbo->save($data)){
    		die('success');
    	}else{
    		die('fail');
    	}
    	
    }
//修改邮箱
    public function ajax_up_email(){
    	$dbo = M('rbacuser');
    	$data['id'] = $_SESSION['authId'];
    	$data['email'] = $_POST['email'];
    	if($dbo->save($data)){
    		die('success');
    	}else{
    		die('fail');
    	}
    	
    }

//修改手机号
    public function user_setting_mob(){
    	$id = $_SESSION['authId'];
    	$this->info = M('rbacuser')->where("id=".$id)->select();

		$this->display();
    }







	
}