<?php
namespace Home\Controller;

class CollectController extends AuthController{
	// 显示我的收藏
	public function index(){

	}
	//添加收藏
	public function insert(){
		$uid = $_SESSION['user']['id'];
		$gid = intval($_POST['id']);
		$m = M('collect_goods');
		//第一步判断是否已经收藏
		$where['user_id'] = array('eq',$uid);
		$where['goods_id'] = array('eq',$gid);
		if($m -> where($where) -> find()){
			$out['status'] = 2;
			$out['content'] = '您已经收藏过该商品了！';
			$this -> ajaxReturn($out);
			return;
		}
		//没有收藏添加收藏
		$data = array(
			'user_id' => $uid,
			'goods_id' => $gid,
			'add_time' => time()
			);
		$m -> create($data);
		if($m -> add()){
			$out['status'] = 1;
			$out['content'] = '收藏成功！';
		}else{
			$out['status'] = 2;
			$out['content'] = '收藏失败！';
		}
		$this -> ajaxReturn($out);
	}

	//评价商品
	public function comment(){
		//判断当前的用户是否已经评论过该商品，有无评价权限在product页面进行判断
		$where['goods_id'] = array('eq',$_POST['goods_id']);
		$where['user_id'] = array('eq',$_SESSION['user']['id']);
		$out = M('comment') -> where($where) -> find();
		if($out){
			$this -> ajaxReturn(array(
				'status' => 0,
				'content' => '亲，您已经评论过了！'
				));
		}
		if(IS_AJAX){
			//判断评论是否需要审核
			if(C('COMMENT') == 1){
				$_POST['is_show'] = 1;
			}else{
				$_POST['is_show'] = 0;
			}
			$_POST['user_id'] = $_SESSION['user']['id'];
			$_POST['comment_time'] = time();
			$_POST['comment_ip'] = ip2long($_SERVER['REMOTE_ADDR']);
			$m = M('comment');
			if($m -> create() && $m -> add()){
				$data['status'] = 1;
				$data['content'] = '评论成功！';
			}else{
				$data['status'] = 0;
				$data['content'] = '评论失败，请重试！';
			}
		}else{
			$data['status'] = 0;
			$data['content'] = '非法操作！';
		}
		$this -> ajaxReturn($data);
	}
}