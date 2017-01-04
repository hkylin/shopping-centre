<?php
/**
	*   商品回收站
	*   Recycle/_initialize  		分配控制器及方法名以动态该方法执行时的导航样式
	*   Recycle/index			回收站列表
	*   Recycle/delete			删除
	*   Recycle/deleteall		批量删除
	*   Recycle/recycle			还原
	*   Recycle/recycleall		批量还原
	*   @author		孙永军
**/ 
namespace Admin\Controller;

class RecycleController extends CommonController{

	// 分配控制器及方法名以动态该方法执行时的导航样式
	public function _initialize() {
		parent::_initialize();
		$this->assign('menuList',CONTROLLER_NAME.'-'.ACTION_NAME);
		$this->assign('menu','Goods');
	}

	// 回收站列表
	public function index(){
		$type =  M('goods');
		 if($_GET['keywords']){
	            $maps['goods_name'] = array('like','%'.$_GET['keywords'].'%');
	        }
	        $maps['is_delete'] = array('eq',1);
		$count =  $type -> where($maps) -> count();
		$mypage = $this -> mypage($count,8);
		
		$data = $type -> where($maps)->limit($mypage->firstRow,$mypage->listRows) -> select();

		$ptype = M('shop_type');
		$brands = M('brand');

		//查询所属分类并赋予变量
		//查询所属品牌并赋予变量
		foreach($data as $k=>$v) {
			//分类
			$map['id'] = array('eq',$v['type_id']);
			$result = $ptype ->where($map) -> find();
			$data[$k]['pname'] = $result['type_name'];

			//品牌
			$map['id'] = array('eq',$v['brand_id']);
			$brand = $brands->where($map)->find();
			$data[$k]['bname'] = $brand['brand_name'];
		}

		$page = $mypage -> show();
		$this->assign('page',$page);
		$this->assign('type',$data);
		$this -> display();
	}

	//删除
	public function delete() {
		if(IS_GET) {
			$map['id'] = array('eq',$_GET['id']);
			$user = M('goods');

			//删除商品前先删除有关的秒杀信息和评论
			$sale = M('sale');
			$comment = M('comment');

			$maps['goods_id'] = $_GET['id'];
			$sale -> where($maps) -> delete();
			$comment -> where($maps) -> delete();

			if($user-> where($map) -> delete()){
				$this->success('删除成功');
			}else{
				$this->error('删除失败');
			}
		}
	}

	//批量删除
	public function delall() {
		foreach($_POST['id'] as $v) {
			//删除商品前先删除有关的秒杀信息和评论
			$sale = M('sale');
			$comment = M('comment');

			$maps['goods_id'] = $v;
			$sale -> where($maps) -> delete();
			$comment -> where($maps) -> delete();
		}
		$ids = implode(',',$_POST['id']);
		$goods = M('goods');
		if($goods -> delete($ids)){
			$this -> ajaxReturn(true);
		}else{
			$this -> ajaxReturn(false);
		}
	}

	//还原
	public function recycle() {
		$goods = M('goods');
		$goods->id = $_GET['id'];
		$goods-> is_delete = 0;
		if($goods->save()) {
			$this->success('还原成功');
		}else{
			$this->error('还原失败');
		}
	}

	//批量还原
	public function recycleall() {
		$goods = M('goods');
		$ids = implode(',',$_POST['id']);
		$map['id'] = array('in',$ids);
		$sale['is_delete'] = 0;
		if($num = $goods->where($map)->save($sale)) {
			$this -> ajaxReturn($num);
		}else{
			$this -> ajaxReturn(false);
		}
	}


}