<?php

/**
	*   订单和支付页面，继承Auth权限管理及Common公共类
	*   Order/index				订单页面展示
	*   Order/addressedit		通过页面传参调用静态类Area以生成对应地址
	*   Order/address			删除或修改订单地址
	*   Order/delete			删除订单地址
	*   Order/info				提交订单
	*   Order/confirm			支付页面
	*   Order/pwdch			支付密码验证
	*   Order/pay				支付
	*   @author					孙永军
**/

namespace Home\Controller;
use Think\Area;

class OrderController extends AuthController{

	// 订单页面
	public function index(){
		//用户地址
		$addr = M('user_address');
		$map['user_id'] = array('eq',$_SESSION['user']['id']);

		//@deprecate  省市区  不推荐适用 推荐本类中的addressedit方法
		$address = Area::city(array('请选择','请选择','请选择'));
		$num = 0;
		if($addrs = $addr->where($map)->order('id desc')->limit(10)->select()){
			$num = count($addrs);
			$this->assign('addr',$addrs);
		}
		
		$this->assign('num',$num);	
		$this->assign('address',$address);

		//修改地址展示
		if($_POST['id']){
			$map['id'] = array('eq',$_POST['id']);
			$ad = $addr -> where($map) ->find();
			$this->assign('ad',$ad);
			$this->ajaxReturn($ad);
		}

		//配送方式选择
		$ship = M('shipping');
		$ships = $ship->where('is_status=1')->order('shipping_money desc')->select();
		$this->assign('ships',$ships);

		//支付方式选择
		$paytypes = M('pay_type');
		$paytype = $paytypes -> where('is_status=1') ->select();
		$this->assign('paytype',$paytype);

		$this -> display();
	}


	//修改地址时原地址生成
	public function addredit() {
		$addr = M('user_address');
		$address = $addr->find($_POST['id']);
		
		if(!$_POST['id']){
			$address = Area::city(array('请选择','请选择','请选择'));
		}else{
			$address = Area::city(array($address['address_province'],$address['address_city'],$address['address_county']));
		}
		$this->ajaxReturn($address);
	}


	//添加或修改订单地址
	public function address() {
		$addr = M('user_address');
		if($_POST['id']){
			if($addr->create()){
				$addr-> save();
			}
		}else{
			$_POST['user_id'] = $_SESSION['user']['id'];
			$addr->create();
			$addr->add();
		}
		$this->ajaxReturn($_POST);
	}


	//删除订单地址
	public function delete() {
		if($_POST['id']){
			$addr = M('user_address');
			$map['id'] = array('eq',$_POST['id']);
			if($addr->where($map)->delete()){
				$this->ajaxReturn(1);
			}
		}
	}


	//提交订单
	public function info() {
		if(IS_POST){
			
			$addr = M('order_action');
			$_POST['acti'] = date('YmdHis').mt_rand(100,999);//订单号
			$_POST['user_id'] = $_SESSION['user']['id'];
			$_POST['action_status'] = 0;//订单状态			
			$_POST['shipping_status'] = 0;//配送状态
			$_POST['order_time'] = time();//订单生成时间

			$a = $addr->create();
			$id = $addr->add();

			$orderg = M('order_goods');
			$goods = M('goods');

			$data['action_id'] = $id;

			foreach($_SESSION['cart'] as $k => $v) {

				//生成订单商品列表
				$data['goods_id'] = $v['id'];
				$data['goods_number'] = $v['num'];
				$orderg ->create($data);
				$orderg ->add();

				//销量增加
				$mapg['id'] = array('eq',$v['id']);
				$goods ->where($mapg)->setInc('sales_volume',$v['num']);
				$goods ->where($mapg)->setDec('goods_number',$v['num']);
			}
			unset($_SESSION['cart']);
			if(!empty($_SESSION['bak'])) {
				foreach($_SESSION['bak'] as $k=>$v) {
					$_SESSION['cart'][$k] = $v;
				}
				unset($_SESSION['bak']);
			}
			$this->ajaxReturn($id);			
		}
	}


	//付款页面
	public function confirm() {
		$action = M('order_action');
		$confirm = $action->find($_GET['id']);

		//支付方式
		$pays = M('pay_type');
		$map['is_status'] = 1;
		$pay = $pays->where($map)->select();
		foreach($pay as &$v) {
			if($v['id'] == $comfirm['pay_id']) {
				$v['che'] = 'class="chked"';
			}
		}

		$this->assign('pay',$pay);
		$this->assign('confirm',$confirm);

		$this->display();
	}


	//确认支付密码
	public function pwdch() {
		$user = M('user');
		$users = $user->field('user_pwd')->find($_SESSION['user']['id']);
		if(md5($_POST['pwd']) == $users['user_pwd']) {
			$this->ajaxReturn(true);
		}else{
			$this->ajaxReturn(false);
		}
	}	

	//支付
	public function pay() {
		$action = M('order_action');
		$inc = $action -> find($_GET['id']);
		$user = M('user');
		
		//判断钱是否够用
		$userd = $user->find($_SESSION['user']['id']);
		if($userd['user_money'] < $inc['action_count']) {
			exit($this->error('您的余额不足,无法购买',U('Home/MyOrder/order')));			
		}

		$map['id'] = array('eq',$_SESSION['user']['id']);
		if($user ->where($map) -> setDec('user_money',$inc['action_count'])){//花费金额
			$user->where($map) -> setDec('user_coin',$inc['pcoin']);//花费花粉
			$user ->where($map) -> setInc('user_coin',$inc['pay_coin']);//赠送花粉

			$map['id'] = $_GET['id'];
			$map['action_status'] = 1;//已付款

			$action->create($map);
			$action->save();
			
			$this->success('支付成功',U('Home/MyOrder/order'));
		}else{
			$this->error('支付失败');
		}
	}

}