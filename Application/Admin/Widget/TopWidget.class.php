<?php

/*
*	后台首页顶部的展示栏
*	Top/order 	显示代发货订单	
*	Top/message 	显示待处理的留言
*	$author 蒋永忠	
*/

namespace Admin\Widget;
use Think\Controller;

class TopWidget extends Controller{
	/*
	*	显示顶部的待收货
	*/
	public function order(){
		//查询代发货订单
		$o = M('order_action');
		$count = $o -> where('action_status=1') -> count();
		//查询付款未发货的订单
		$order = $o -> where('action_status=1') -> field('acti,action_count') -> order('order_time desc') -> limit(4) -> select();
		$this -> assign('list',$order);
		$this -> assign('count',$count);
		$this -> display('Public:order');
	}

	/*
	*	显示顶部的待处理信息
	*/
	Public function message(){
		$m = M('admin_message');
		//收件人的ID
		$id = $_SESSION['admin']['id'];
		$count = $m -> where('is_delete=0 and is_readed=0 and receiver_id='.$id) -> count();
		$this -> assign('count',$count);
		$msg = $m -> where('is_delete=0 and is_readed=0 and receiver_id='.$id) -> order('send_time desc') -> limit(5) -> select();
		//查询发信人的信息
		foreach($msg as &$vmsg){
			$auser = M('admin_user') -> where('id='.$vmsg['send_id']) -> field('admin_name,img') -> find();
			$vmsg['name'] = $auser['admin_name'];
			$vmsg['img'] = $auser['img'];
		}
		$this -> assign('msg',$msg);
		$this -> display('Public:message');
	}
}