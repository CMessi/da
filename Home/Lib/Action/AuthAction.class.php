<?php
class AuthAction extends CommonAction {

//添加授权用户界面
	public function mng_main_misson_authorization(){
		$list = M('auth_user')->select();
		$this->assign('list',$list);
		$this->display();		
	}
//获取用户组
	public function ajaxGetUserGroup(){
		$dbo = M('auth_user');
		$id = $_POST['id'];
		$sql = "select username,id from da_rbacuser where id not in (select user_id from da_auth_user where task_pid=$id)";
		$userGroup = $dbo->query($sql);
		$html = '';
		foreach ($userGroup as $v) {
			$id = $v['id'];
			$username = $v['username'];
			$html.=$username.':<input name="username" type="checkbox" value="'.$id.'-'.$username.'" style="margin-right:15px">';
		}
		echo $html;
	}
//添加授权用户操作
	public function ajaxAddAuthUser(){
		$id = $_POST['id'];
		$usernames = $_POST['usernames'];
		foreach($usernames as $v){
			$user = explode('-',$v);
			$user_id = $user[0];
			$username = $user[1];
			$sql = "insert into da_auth_user(task_pid,user_id,username,create_time) values($id,$user_id,'$username',NOW())";
			if(M('da_auth_user')->execute($sql)){
				echo 'ok';
			}else{
				echo 'no';
			}
		}
	}

//删除授权用户操作
	public function ajaxDelAuthUser(){
		$id = $_POST['id'];
		if(M("auth_user")->delete($id)){
			echo 'ok';
		}else{
			echo 'no';
		}
	}

}