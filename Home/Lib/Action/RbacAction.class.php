<?php
class RbacAction extends CommonAction{

/*
	用户管理部分
*/	
	//用户列表
	public function user(){

		$dbo =M('rbacuser');

		$userList = $dbo->select();

		$this->assign('userList',$userList);

		$this->display();
	}

	//添加用户
	function adduser(){
		$dbo = M('rbacrole');
		//角色列表
		$this->list = $dbo->select();
		$this->display();
	}

	//添加用户方法
	public function addUserHandle(){
		$dbo 			= M('rbacuser');
		$dbo->username 	= $_POST['username'];//用户名
		$dbo->password 	= md5($_POST['password']);//密码
		$dbo->type 		= $_POST['type'];//用户类型
		$dbo->email 	= $_POST['email'];
		$dbo->phone_no 	= $_POST['phone_no'];
		$uid = $dbo->add();
		if($uid){
			$role_user 	= D('rbacroleuser');
			$role_user->role_id = $_POST['type'];
			$role_user->user_id = $uid;
			if($role_user->add()){
				$this->success('添加成功','user');
			}
		}else{
			$this->error('添加失败','adduser');
		}
	}

	//删除用户
	function ajaxDelUser(){
		$user_id = $_POST['user_id'];
		D('rbacuser')->where('id='.$user_id)->delete();
		$this->ajaxReturn('','删除成功',1);
	}

	//显示修改账号页面
	function upuser(){
		$uid 	= $_GET['user_id'];
		$user 	= D('rbacuser')->where('id='.$uid)->find();
		$this->roleuser = D('rbacroleuser')->where('user_id='.$uid)->find();
		$this->username = $user['username'];
		$this->password = $user['password'];
		$this->uid = $user['id'];
		$this->display();
	}
	//修改账号和密码
	function ajaxSaveUser(){
		$user 			= D('rbacuser');
		$user->id 		= $_POST['uid'];
		$user->username = $_POST['name'];
		$user->password = md5($_POST['pass']);
		if($user->save()){
			die('ok');
		}else{
			die('no');
		}
	}
//修改账号的状态
	function ajaxSaveUserStatus(){
		$user 			= D('rbacuser');
		$user->id 		= $_POST['uid'];
		$user->status 	= $_POST['status'];

		if($user->save()){
			die('ok');
		}else{
			die('no');
		}
	}
/*
	用户组管理部分
*/
	//创建用户组
	function addusergrouphandle(){

		if(M('rbacrole')->add($_POST)){
			$this->redirect('role');
		}else{
			$this->error('添加失败','addusergroup');
		}
	}

	//给用户组分配权限的页面
	function alltoaccount(){
		$rid = $_GET['id'];
		import('ORG.Util.Tree');
		$node = D('rbacnode')->select();
		$node = Tree::create($node);
		$data = array();//存放当前用户组的应有权限
		$access = D('rbacaccess');
		foreach($node as $v){
			$count = $access->where('role_id='.$rid.' and node_id='.$v['id'])->count();
			if($count){
				$v['access']=1;
			}else{
				$v['access']=0;
			}
			$data[]=$v;
		}
		$this->nodeList=$data;
		$this->rid = $rid;
		//拿到角色名称
		$this->name = D('rbacrole')->getFieldById($rid,'name');
		$this->display();
	} 

//添加权限
	function addnode(){
		$this->display();
	}
	function ajaxAddNode(){
		if($_POST['pid']==''){
			$_POST['pid']=1;
		}
		$bool = D('rbacnode')->add($_POST);
		if($bool){
			die('ok');
		}else{
			die('no');
		}
	}
	//删除节点权限
	function ajaxDelNode(){
		$node_id = $_POST['node_id'];
		D('rbacnode')->where('id='.$node_id)->delete();
		$this->ajaxReturn('','删除成功',1);
	}
	//权限管理列表
	function node(){
		import('ORG.Util.Tree');
		$nodeList = D('rbacnode')->where('status=1')->select();
		$this->nodeList = Tree::create($nodeList);
		$this->display();
	}
//修改用户组权限
	function ajaxUpAccess(){
		$rid = $_POST['rid'];
		$access = D('rbacaccess');
		$access->where('role_id='.$rid)->delete();//exit;
		if(isset($_POST['access'])){
			$data=array();
			foreach($_POST['access'] as $v){
				$temp = explode('_', $v);
				$data[]=array(
					'role_id'=>$rid,
					'node_id'=>$temp[0],
					'level'=>$temp[1]
				);
			}
			if($access->addAll($data)){
				$this->success('添加成功',U('rbac/role'));
			}else{
				$this->success('添加失败',U('rbac/role'));
			}
		}		
	}	
	//角色列表
	function role(){
		$this->role_list = D('rbacrole')->select();
		$this->display();
	}
//获取所有一级菜单
	function getNode(){
		$node = D('rbacnode')->where('level=2')->select();
		$html ='';
		foreach($node as $v) {
			$locationId = $v["id"];
			$locationName = $v["title"];
			$html.= "<option value='$locationId'>$locationName</option>";
		}
		die($html); 
	}
//获取所有权限信息
	function getRole(){
		$role = D('rbacrole')->select();
		$html ='';
		foreach($role as $v) {
			$locationId = $v["id"];
			$locationName = $v["name"];
			$html.="<option value='$locationId'>$locationName</option>";
		}
		die($html);
	}

}