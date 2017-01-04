<?php

/*
*   后台管理员部分，继承common类
*   AdminUser/index        管理员列表 
*   AdminUser/add          添加管理员 
*   AdminUser/insert       执行添加管理员 
*   AdminUser/checkName    检查管理员是否已存在 
*   AdminUser/save     	   管理员编辑 
*   AdminUser/save_doit    执行修改管理员信息
*   AdminUser/del          删除单条管理员
*   AdminUser/delAll       多条删除管理员
*   AdminUser/changePwd    修改管理员密码
*   AdminUser/changePwds   验证旧密码是否正确
*   AdminUser/sureChange   执行修改管理员密码
*   @author                王雪

*/

namespace Admin\Controller;

class AdminUserController extends CommonController{
	public function index(){
		$user = M('admin_user');
		if($_GET['keywords']){
	            $maps['admin_name'] = array('like','%'.$_GET['keywords'].'%');
	        }
		$count = $user->where($maps)-> count();
        
        // 调用自定义的分页
        $mypage = $this -> mypage($count,8);

        $list = $user-> where($maps) -> limit($mypage->firstRow.','.$mypage->listRows)->select();

        $show = $mypage->show();// 分页显示输出
        $g = M('auth_group');
        
        $i = 0;
        foreach($list as &$v){
        	$group = $g -> where('id='.$v['admin_level']) -> field('id,title') -> find();
        	$list[$i]['level_name'] = $group['title'];
        	$i ++;

        	if(!$v['admin_login']) {
        		$v['admin_login'] = '';
        	}else{
        		$v['admin_login'] = date('Y-m-d H:i:s',$v['admin_login']);
        	}
        }
        
        $this->assign('list',$list);     // 赋值数据集
        $this->assign('page',$show);     // 赋值分页输出

		$this -> assign('admin','AdminUser');
		$this -> assign('adminList','AdminUserIndex');
		$this -> display();
	}

	// 添加管理员
	public function add(){
		// 分配左侧菜单样式变量
        $this -> assign('admin','AdminUser');
        $this -> assign('adminList','AdminUserAdd');
        //遍历出管理员组
        $g = M('auth_group');
        $group = $g -> field('id,title') -> select();
        $this -> assign('group',$group);

		$this -> display();
	}

	// 执行添加管理员
	public function insert(){
		$user = M(admin_user);
		if(IS_POST){
			$_POST['admin_pwd'] = md5($_POST['admin_pwd']);
			$post = $_POST;
			$post['admin_addtime'] = time();
			
			$ip= $_SERVER['REMOTE_ADDR'];
			$ipp = ip2long($ip);
			$post['admin_ip'] = $ipp;
			if(!$user -> create($post)){
				$this -> ajaxReturn(1);
			}else{
				if($uid = $user -> add()){
					$g  = M('auth_group_access');
					$gd['uid'] = $uid;
					$gd['group_id'] = $_POST['admin_level'];
					if($g -> data($gd) -> add()){
						$this -> ajaxReturn(2);
					}else{
						$user -> delete($uid);
						$this -> ajaxReturn(1);
					}
				}else{
					$this -> ajaxReturn(1);
				}
			}


		}
		
	}

	// 检查管理员是否已存在
	public function checkName(){
		$admin = M('admin_user');
		$where['admin_name']=$_POST['adname'];
		$admins = $admin -> where($where) -> find();
		if($admins){
			$this ->ajaxReturn(true);
		}else{
			$this -> ajaxReturn(false);
		}

	}

	// 编辑管理员
	public function save(){
		$user = M(CONTROLLER_NAME);
		if(IS_GET){
			$map['id'] = array('eq',$_GET['id']);
			$data = $user -> where($map) -> select();
			$this -> assign('user',$data[0]);
		}
		//遍历出管理员组
        $g = M('auth_group');
        $group = $g -> field('id,title') -> select();
        $this -> assign('group',$group);
		$this->display();
	}

	// 执行修改
	public function save_doit(){
		// 分配左侧菜单样式变量
        $this -> assign('admin','AdminUser');
		$user = D(CONTROLLER_NAME);

		if(IS_POST){
			if(!$user->create()){
				exit($user->getError());
			}else{
				$map= 'id='.$_POST['id'];
				if($user->where($map)->save()){
					// 修改auth_group_access里面的用户名对应的组名
					$uid = $_POST['id'];
					$data['group_id'] = $_POST['admin_level'];
					$aga = M('auth_group_access');
					$aga -> where('uid='.$uid) -> save($data);
					$this->redirect('AdminUser/index');
				}else{
					$this->error('修改失败');
				};
			}		
		}	
	}

	// 执行删除
	public function del(){
		$user = M(CONTROLLER_NAME);
		$map = 'id='.$_POST['id'];
		$admin = $user->where($map)->delete();
		if($admin){
			echo 1;
		}else{
			echo 2;
		}
	}

	// 执行批量删除
	public function delAll(){
		if(IS_AJAX){
            $ids = I('post.id');
            $ids = implode(',', $ids);
            $m = M(CONTROLLER_NAME);
            if($m -> delete($ids)){
                echo 1;
            }else{
                echo 0;
            }
        }
	}

	// 修改密码
	public function changePwd(){
		$this -> assign('admin','AdminUser');
        $this -> assign('adminList','AdminUserchangepwd');
		$this ->display();
	}

	// 验证旧密码是否正确
	public function changePwds(){
		$pwd = md5($_POST['userpwd']);
		$admin = M('admin_user');
		$id = $_SESSION['admin']['id'];
		$admin_user = $admin -> find($id);

		if($admin_user['admin_pwd'] == $pwd){
			$this -> ajaxReturn(true);
		}else{
			$this -> ajaxReturn(false);
		}


	}

	// 执行修改密码
	public function sureChange(){
		$admin = M('admin_user');
		$pwd = $_POST['newpwd'];
		$id = $_SESSION['admin']['id'];
		$where['id'] = $id;
		$adminpwd['admin_pwd'] = md5($pwd);
		$admins = $admin -> where($where) -> save($adminpwd);
		if($admins){
			$this -> ajaxReturn(true);
		}else{
			$this -> ajaxReturn(false);
		}

	} 
}