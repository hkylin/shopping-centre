<?php

/**
*   我的蜂巢，继承Auth类
*   Center/index       蜂巢首页
*   Center/myCoin      我的花粉
*   Center/safe        账户安全
*   Center/address     地址管理
*   Center/inform      个人资料
*   Center/inform-doit 修改个人资料
*	Center/changePwd   用户密码
*   Center/checkPwd    更改密码
*   Center/checkRepwd  确认修改密码
*   Center/addre       增加或修改地址
*   Center/reason      退货原因
*   Center/like        收藏
*   Center/cancel      取消收藏
*   Center/comment     我的评论
*   Center/addrEdit    修改地址时生成原地址
*   Center/delete      删除原地址
*   @author            王雪
**/

namespace Home\Controller;
use Think\Area;

	class CenterController extends AuthController{
		public function index(){
			$goo = M('goods');
			$oa = M('order_action');
			$tr = M('user_address');
			$pay = M('pay_type');
			$og = M('order_goods');
			$coll = M('collect_goods');

			$users = $_SESSION['user'];
			$id = $_SESSION['user']['id'];

			if($id){
			$maps['user_id'] = $id;
			$trr = $tr ->where($maps)->find();
			if($trr){
				$true_name = $trr['true_name'];
			}
			$map['user_id'] = $id;
			$or = $oa->where($map)-> order(array('order_time'=>'DESC'))->find();
			if($or){
				$paid = $pay -> where('id='.$or['pay_id'])->find();
			$data['ding']= $or;
			$map1['action_id'] = $or['id'];
			$ogs = $og -> where($map1) -> select();
			// 这个订单的所有商品(二维)
			foreach ($ogs as $k => $v) {
				$map2['id'] = $v['goods_id'];
				$goos = $goo -> where($map2) ->find();
				$data['ding']['d'][$k]= $goos;
			}
		}else{
			$data=0;
		}

		// 查询 未付款的订单

		$ooa=$oa->where('action_status=0 and user_id='.$id)->select();//待付款
		$oob=$oa->where('action_status=1 and user_id='.$id)->select();//待发货
		$ooc=$oa->where('action_status=2 and user_id='.$id)->select();//待收货
		$num['a'] = count($ooa);
		$num['b'] = count($oob);
		$num['c'] = count($ooc);
		}
		// 用户收藏商品
		$where['user_id'] = $id;
		$where['is_status'] = 1;
			$colls = $coll->where($where)->order(array('add_time'=>'DESC'))->limit(4)->select();
		$i=0;
		foreach($colls as $a=>$b){
			$g[$i] = $goo -> where('id='.$b['goods_id'])->find();
			$i++;
		}
		$this -> assign('num',$num);
		$this -> assign('data',$data);
		$this -> assign('user',$users);
		$this -> assign('pay',$paid);
		$this -> assign('coll',$g);
		$this -> assign('truename',$true_name);
		$this -> display();
	}

		// 我的花粉
		public function myCoin(){
			$user = $_SESSION['user'];
			$this -> assign('user',$user);
			$this -> display();
		}

		// 账户安全设置
		public function safe(){
			$muser = M('user');
			$where['id'] = $_SESSION['user']['id'];
			$myuser = $muser -> where($where) -> find();
			$user = $_SESSION['user'];
			$this -> assign('user',$user);
			$this -> display();
		}

		// 地址管理
		public function address(){
			$id = $_SESSION['user']['id'];
			$addr = M('user_address');
			$address = Area::city(array('请选择','请选择','请选择'));
			$maps['user_id']=$id;
			$addrs = $addr -> where($maps)->limit(10) -> select();
			// 把该用户的地址发过去
			$this -> assign('address',$address);
			$this -> assign('oid',$id);
			$this -> assign('dizhi',$addrs);
			$this -> display();
		}

		// 个人资料
		public function inform(){
			$user = $_SESSION['user'];
 			$this -> assign('user',$user);
			$this -> display();
		}

		// 修改个人资料
		public function inform_doit(){
			if(IS_AJAX){
				$user = M('user');
					$_POST['id'] = $_SESSION['user']['id'];
					$_POST['user_birth'] = strtotime($_POST['user_birth']);
					if($_POST['user_pic'] == '') {
						unset($_POST['user_pic']);
					}
					if($_POST['user_question'] == '') {
						unset($_POST['user_question']);
					}
					if($_POST['user_answer'] == '') {
						unset($_POST['user_answer']);
					}
					if(empty($_POST['user_birth'])) {
						unset($_POST['user_birth']);
					}
					
					
					var_dump($user->create());
					$r = $user->save();
					if($r){
						$datas['status']=1;
						$datas['content']='修改成功';
						$datas['url'] = U('Center/index');
						$rr = $user->find($id);
						$_SESSION['user'] = $rr;
					}else{
						$datas['status']=0;
						$datas['content']='修改失败';
					}
				
				$this -> ajaxReturn($datas);
			}
		}

		//用户密码
		public function changePwd(){
			$this -> display();
		}

		//更改密码
		public function checkPwd(){
			if(IS_AJAX){
				$user = M('user');
				$id = $_SESSION['user']['id'];
				$r = $user -> find($id);
				if($r['user_pwd'] == md5($_POST['user_pwd'])){
					$data['status'] = 1;
					$data['content'] = '旧密码一致';
				}else{
					$data['status'] = 0;
					$data['content'] = '旧密码不正确';
				};
				$this -> ajaxReturn($data);
			}
		}

		// 确认新密码
		public function checkRepwd(){
			if(IS_POST){
				if($_POST['new_pwd'] != $_POST['re_new_pwd']){
					$data['status']=0;
					$this->ajaxReturn($data);
					return;
				}
				$user = M('user');
					$id = $_SESSION['user']['id'];
					$map = 'id='.$id;
					$da['user_pwd'] =md5($_POST['new_pwd']);
					$row = $user->where($map)->save($da);
					if($row){
						$data['status']=2;
						$data['url'] = U('Center/index');
					}else{
						$data['status']=0;
					}
					$this->ajaxReturn($data);
			}
		}

		// 增加或修改地址
		public function addre(){
			$addr = M('user_address');
			if($_POST['id']){
				if($addr->create()){
					$addr-> save();
					$data = '修改成功';
				}
			}else{
				$_POST['user_id'] = $_SESSION['user']['id'];
				$addr->create();
				$addr->add();
				$data = '添加成功';
			}
			$this->ajaxReturn($data);
		}

		// 退货原因
		public function reason(){
			$id = $_POST['id'];
			$m = M('order_action');
			$maps['id'] = $id;
			$data['action_status'] = 4;
			$data['reason'] = $_POST['zhi'];
			$data['reason'] .= $_POST['zhis'];
			$data['action_time'] = time();
			$result = $m -> where($maps) ->save($data);
			if($result){
				$this -> ajaxReturn(true);
			}else{
				$this -> ajaxReturn(false);
			}
		}

		// 收藏
		public function like(){
			$m = M('collect_goods');
			$mm = M('goods');
			$id = $_SESSION['user']['id'];
			$maps['user_id'] = $id; 
			$maps['is_status'] = 1;
			$result = $m -> where($maps)->order(array('add_time'=>'DESC')) ->select();
			// foreach ($result as $k => $v) {
			foreach ($result as &$v) {
				$gid = $v['goods_id'];    //收藏的商品id
				$where['id'] = $gid;
				$result1 = $mm -> where($where) -> find();
				// $result[$k]['shoucang'] = $result1;
				$v['shoucang'] = $result1;
			}
			$this -> assign('coll',$result);
			$this -> display();
		}

		// 取消收藏
		public function cancel(){
			if(IS_POST){
				$m = M('collect_goods');
				$where['goods_id'] = $_POST['gid'];
				$data['is_status'] = 0;
				$result = $m-> where($where)->save($data);	
				if($result){
					$this -> ajaxReturn(true);
				}else{
					$this -> ajaxReturn(false);
				}
			}
		}


		// 我的评论
		public function comment(){
			$id = $_SESSION['user']['id'];
			$com = M('comment');
			$where['user_id']=$id;
			$where['is_show']=1;
			$comm = $com->where($where)->select();
			$good = M('goods');
			$i=0;
			foreach($comm as $k=>$v){
				$goods[$i] = $good -> where('id='.$v['goods_id'])->find();
				$goods[$i]['content'] = $v['comment_content'];
				$goods[$i]['rank'] = intval($v['comment_rank']);
				$goods[$i]['times'] = $v['comment_time'];
				$i++;
			}
			
			$this -> assign('alias',$_SESSION['user']['user_alias']);
			$this -> assign('good',$goods);
			$this -> display();
		}

		//修改地址时原地址生成
		public function addrEdit() {
			$addr = M('user_address');
			$address = $addr->find($_POST['id']);
			$address = Area::city(array($address['address_province'],$address['address_city'],$address['address_county']));
			$this->ajaxReturn($address);
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

	}
 ?>