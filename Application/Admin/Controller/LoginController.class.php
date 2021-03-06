<?php

/*
*	后台管理员登陆部分，继承Controller
* 	Login/index         登陆页面
* 	Login/checkLogin    验证登陆
* 	Login/logout        管理员登出
*   @author             王雪
*/	

namespace Admin\Controller;
use Think\Controller;

class LoginController extends Controller{
	public function index(){
		$this -> display();
	}

	// 检测管理员是否可登陆
	public function checkLogin(){
		if(IS_POST){
			$admin_name=$_POST['admin_name'];
			$admin_pwd=$_POST['admin_pwd'];
			$where = array(
				'admin_name' => $admin_name,
				// 'admin_pwd' => md5($admin_pwd),
			);

			$admin = M('admin_user');
			$r = $admin -> where($where) -> find();
			if(!empty($r)){
				$user = array(
					'id' => $r['id'],
					'admin_name' => $r['admin_name'],
					'admin_level' => $r['admin_level'],
					'img' => $r['img']
				);

			// session('admin',$admin_user);//把用户信息存到session
				$_SESSION['admin']=$user;

			//加入用户登录的时间
				$_SESSION['admin']['logtime'] = time();
				$lastlogin['id'] = $r['id'];
				$lastlogin['admin_login'] = time();

			// 管理员登陆时的ip
				$lastlogin['admin_ip'] = ip2long($_SERVER['REMOTE_ADDR']);
				$admin -> create($lastlogin);
				$admin-> save();
				$this -> ajaxReturn(true);
			}else{
				$this->ajaxReturn(false);
			}
		}
	}

	// 管理员登出
	public function logout(){
		session('admin',null);
		$this -> redirect('Login/index');
	}
}