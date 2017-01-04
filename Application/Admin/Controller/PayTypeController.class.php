<?php
/*
*	支付方式
*	$author 蒋永忠
*/
namespace Admin\Controller;

class PayTypeController extends CommonController{
	public function index(){
		// 分配左侧菜单样式变量
        $this -> assign('menu','ShopConfig');
        $this -> assign('menuList','PayTypeindex');

        $m = M(CONTROLLER_NAME);
		// 搜索条件
		if(I('get.keywords')){
			$keyword = I('get.keywords');
			$keyword = "pay_name like '%".$keyword."%'";
		}else{
			$keyword = '';
		}
		
		$count = $m -> where($keyword) -> count();// 查询满足要求的总记录数

		// 调用自定义的分页
		$mypage = $this -> mypage($count,8);

		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $m-> where($keyword)->order('id desc')->limit($mypage->firstRow.','.$mypage->listRows)->select();
		
		$show = $mypage->show();// 分页显示输出
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this -> display();
	}
	/*
	*	添加支付方式
	*/
	Public function add(){
		// 分配左侧菜单样式变量
        $this -> assign('menu','ShopConfig');
        $this -> assign('menuList','PayTypeindex');

        $this -> display();
	}
	/*
	*	插入数据
	*/
	public function insert(){
		$pay = M('pay_type');
		if($_POST['pay_name'] && $_POST['pay_desc'] && $_POST['pay_logo']){
			if($pay -> create()){
				if($pay -> add()){
					$this -> success('添加成功！','index');
				}else{
					$this -> error('添加失败！');
				}
			}else{
				$this -> error('添加失败！');
			}
		}else{
			$this -> error('请输入全部信息！');
		}
	}
	public function save(){
		if($_POST['pay_name'] && $_POST['pay_logo'] && $_POST['pay_desc']){
			$m = M('pay_type');
			if($m -> create()){
				if($m -> save()){
					echo 1;
				}else{
					echo 0;
				}
			}else{
				echo 0;
			}
		}else{
			echo 0;
		}
	}

	public function edit(){
		// 分配左侧菜单样式变量
        $this -> assign('menu','ShopConfig');
        $this -> assign('menuList','PayTypeindex');
        $m = M('pay_type');
        $pay = $m -> find($_GET['id']);

        $this -> assign('pay',$pay);

        $this -> display();
	}
	/*
	*	删除单个
	*/
	public function del(){
		$m = M('pay_type');
		if($_POST['id']){
			if($m -> delete($_POST['id'])){
				echo 1;
			}else{
				echo 0;
			}
		}else{
			echo 0;
		}
	}
	/*
	*	删除多个
	*/
	public function delall(){
		if(IS_AJAX){
			$ids = $_POST['id'];
			$ids = implode(',', $ids);
			$m = M(CONTROLLER_NAME);
			if($m -> delete($ids)){
				echo 1;
			}else{
				echo 0;
			}
		}
	}
}