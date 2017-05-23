<?php
class LoginAction extends Action {

    public function index(){

        $this->display();

    }    
    //登陆认证
    public function doLogin(){

        $name 		= $_POST['username'];

        $pass 		= md5($_POST['password']);
		
		$dbo 		= M('rbacuser');

		$userInfo 	= $dbo->where("username='$name' and password='$pass'")->find();

		if(!$userInfo) die('no');//判断账号密码是否存在

		session('username',$name);
		session('type',$userInfo['type']);//所属组

		session(C('USER_AUTH_KEY'),$userInfo['id']);

		if($_SESSION['username']==C('RBAC_SUPERADMIN')){

		    session(C('ADMIN_AUTH_KEY'),true);

		}
		//引入RBAC
		import('ORG.Util.RBAC');

		RBAC::saveAccessList();
		switch ($userInfo['type']) {
			case 1:
				$this->redirect('Index/sys_main');
				break;
			case 2:
				$this->redirect('Index/user_main');
				break;
			case 3:
				$this->redirect('Index/mng_main');
				break;
			default:
				$this->redirect('Index/user_main');
				break;
		}
	
    }
// 退出登录
    public function loginout(){
         
        $_SESSION=array();

        if(isset($_COOKIE[session_name()])){
            setcookie(session_name(),'',time()-1,'/');
        }

        session_destroy();

        $this->redirect('Login/index'); 
    }
  
}