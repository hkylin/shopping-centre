<?php
/**
	*   秒杀管理
	*   Sale/_initialize  		分配控制器及方法名以动态该方法执行时的导航样式
	*   Sale/salelist			秒杀列表
	*   Sale/index			添加及修改
	*   Sale/doit			执行添加修改
	*   Sale/delete			删除
	*   Sale/deleteall		批量删除
	*   Sale/timeche		判断秒杀时间	@return bool；
	*   @deprecate			edit 已废弃 该修改方法
	*   @author		孙永军
**/ 

namespace Admin\Controller;

class SaleController extends CommonController{

	// 分配控制器及方法名以动态该方法执行时的导航样式
	public function _initialize() {
		parent::_initialize();
		$this->assign('menuList',CONTROLLER_NAME.'-'.ACTION_NAME);
		$this->assign('menu','sale');
	}

	// 添加及修改
	public function index() {
		if($_GET['id']){
			$goodm = M('goods');
			$map['id'] = array('eq',$_GET['id']);
			$goods = $goodm -> where($map) ->find();
			$this->assign('good',$goods);

			if($goods['id']){
				$salem = M('sale');
				$maps['goods_id'] = array('eq',$_GET['id']);
				$sale = $salem -> where($maps) ->find();
				$this->assign('sale',$sale);
			}
			$this -> display();

		}else{
			$this->error('非法操作');
		}
	}

	// 执行添加修改
	public function doit() {
		//查询是否存在该商品的秒杀数据
		$salem = M('sale');
		$map['goods_id'] = array('eq',$_POST['goods_id']);

		$_POST['sale_start'] = strtotime($_POST['sale_start']);
		$_POST['sale_end'] = strtotime($_POST['sale_end']);
		
		if(!$salem-> where($map) -> find()){
			$salem->create();
			if($salem->add()){
				$this->success('添加秒杀成功','salelist');
			}else{
				$this->error('添加失败');
			}
		}else{
			$salem->create($_POST);
			if($salem->where($map) ->save()){
				$this->success('修改成功','salelist');
			}else{
			
				$this->error('修改失败');
			}
		}
	
	}

	// 秒杀列表
	public function salelist() {
		$salem = M('sale');
		$goodsm = M('goods');
		 $count =  $salem -> count();
		$mypage = $this -> mypage($count,8);
		$sale = $salem->limit($mypage->firstRow,$mypage->listRows) -> select();

		foreach($sale as &$v) {
			$goods = $goodsm->find($v['goods_id']);
			$v['goods_name'] = $goods['goods_name'];	
			$v['goods_price'] = $goods['goods_price'];		
		}

		$page = $mypage -> show();
		$this->assign('page',$page);
		$this->assign('sale',$sale);
		$this->display();
	}

	// 删除
	public function delete() {
		if($_GET){
			$salem = M('sale');
			$_GET['is_delete'] = 0;
			$salem -> create($_GET);
			if($salem ->save()){
				$this->success('删除成功');
			}else{
				$this->error('删除失败');
			}
		}
	}

	/* 
		*   @deprecate	 已废弃 该修改方法
	 */
	public function edit() {
		if($_GET['id']){
			$goodm = M('goods');
			$salem = M('sale');
			$maps['goods_id'] = array('eq',$_GET['id']);
			$sale = $salem -> where($maps) ->find();
			$goods = $goodm->find($sale['goods_id']);
			$sale['name'] = $goods['goods_name'];
			$sale['goods_id'] = $goods['id'];
			$this->assign('sale',$sale);

			$this -> display();

		}else{
			$this->error('非法操作');
		}
	}

	//批量删除
	public function delall() {
		$goods = M('sale');
		$ids = implode(',',$_POST['id']);
		$map['id'] = array('in',$ids);
		$sale['is_delete'] = 0;
		if($num = $goods->where($map)->save($sale)) {
			$this -> ajaxReturn($num);
		}else{
			$this -> ajaxReturn(false);
		}
	}

	//判断秒杀时间
	public function timeche() {
		if($_POST['end']) {
			if(strtotime($_POST['start']) > strtotime($_POST['end'])) {
				$this->ajaxReturn(false);
			}else{
				$this->ajaxReturn(true);
			}
		}
		if(strtotime($_POST['start']) < time()) {
			$this->ajaxReturn(false);
		}else{
			$this->ajaxReturn(true);
		}

	}

}