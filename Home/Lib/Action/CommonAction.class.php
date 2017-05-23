<?php
class CommonAction extends Action{ 
	function _initialize(){

		if(!isset($_SESSION[C('USER_AUTH_KEY')])){
			$this->redirect('Login/index');
		}
		//rbac认证
		$notAuth = in_array(MODULE_NAME,explode(',',C('NOT_AUTH_MODULE'))) || in_array(ACTION_NAME,explode(',',C('NOT_AUTH_ACTION')));

		if(C('USER_AUTH_ON') && !$notAuth){
			import('ORG.Util.RBAC');
			if(!RBAC::AccessDecision()){
				$this->error('没有权限','Index/index');
				//echo "<script language='JavaScript' type='text/javascript'>alert('没有权限!');</script>";
			}
		}else{
			//echo 111;
		}
	}
	//拿到菜单 
	public function ajaxGetMenu(){
		//这里进入到超级管理员账号  会把没有的菜单取到
		if(session(C('ADMIN_AUTH_KEY'))){
			$node = D('Rbacnode')->where('level=2 and type=1')->order('sort asc')->relation(true)->select();
			//echo $D('Rbacnode')->getLastSql();
			
		}else{
			// 这里进入到非超级管理员 账号
		//取出所有node
			$node 		= D('Rbacnode')->where('level=2 and type=1')->relation(true)->order('sort asc')->select();
						
			$module 	= '';
			$node_id 	= '';
			//取出当前登录用户的权限
			$accessList = $_SESSION['_ACCESS_LIST'];
			foreach($accessList as $k1=>$v1){
				foreach($v1 as $k2=>$v2){
					$module = $module.'.'.$k2;
					foreach($v2 as $k3=>$v3){
						$node_id = $node_id.'.'.$v3;
					}
				}
			} 	
			//去除没有权限的节点
			foreach($node as $k=>$v){
				if(!in_array(strtoupper($v['name']),explode('.',$module))){
					unset($node[$k]);
				}else{
					foreach($v['node'] as $k2=>$v2){
						if(!in_array($v2['id'],explode('.',$node_id))){
							unset($node[$k]['node'][$k2]);
						}
					}
				}
			}
		}
		$this->assign('node',$node);
		$this->display("Public:menu");
	}



//公共分页类部分
	public function CommonPageAction($pageNum,$count,$map){
		// 导入分页类
	    import("ORG.Util.Page");
	    // 实例化分页类
	    $pageNum= !empty($pageNum)?$pageNum:10;//每页显示数量
	   	$p 		= new Page($count, $pageNum);
	    // 获取查询参数
	    foreach($map as $key=>$val) { 
	        $p->parameter .= "$key=".urlencode($val)."&"; 
	    }
	    return $p;
	}

	
}