<?php
/**
	*   商品评论
	*   Comment/_initialize  	分配控制器及方法名以动态该方法执行时的导航样式
	*   Comment/index			评论列表
	*   Comment/delete		删除
	*   Comment/save			修改是否显示
	*   Comment/delall			批量删除
	*   Comment/reply			回复评论
	*   Comment/replyInsert	插入回复内容
	*   @author		孙永军
**/

namespace Admin\Controller;

class CommentController extends CommonController{
	
	// 分配控制器及方法名以动态该方法执行时的导航样式
	public function _initialize() {
		parent::_initialize();
		$this->assign('menuList',CONTROLLER_NAME.'-'.ACTION_NAME);
		$this->assign('menu','Goods');
	}

	// 评论列表
	public function index(){
		$goods =  M('goods');
		$comments = M('comment');
		$users = M('user');
		
		if($_GET['keywords']){
	            $maps['comment_content'] = array('like','%'.$_GET['keywords'].'%');
	        }
	        $count =  $comments ->where($maps)-> count();
		$mypage = $this -> mypage($count,8);
		$comment = $comments ->where($maps) ->order('comment_time desc')-> limit($mypage->firstRow,$mypage->listRows) -> select();
		
		$user = $users->select();

		foreach($comment as $k=>$v) {

			//所属商品
			$goodsname = $goods->find($v['goods_id'])['goods_name'];
			$comment[$k]['goods_name'] = $goodsname;

			//评论人
			$useremail = $users->find($comment[$k]['user_id'])['user_email'];
			$comment[$k]['user_email'] = $useremail;
		}

		//分页分配
		$page = $mypage -> show();
		$this->assign('page',$page);

		$this->assign('comment',$comment);
		$this -> display();
	}

	// 删除
	public function delete() {
		if(IS_GET) {
			$map['id'] = array('eq',$_GET['id']);
			$user = M('comment');
			if($user-> where($map) -> delete()){
				$this->success('删除成功');
			}else{
				$this->error('删除失败');
			}
		}
	}

	// 修改是否显示
	public function save() {
		if(IS_POST){
			$data = M(CONTROLLER_NAME);
			if($_POST['show']){
				$show = $data -> find($_POST['id'])['is_show'];
				if($show == 1) {
					$comment['is_show'] = 0;
				}else{
					$comment['is_show'] = 1;
				}
				$comment['id'] = $_POST['id'];
				$data->create($comment);
				$data->save();	
				$this->ajaxReturn($comment);
			}
		}
	}

	//批量删除
	public function delall() {
		$ids = implode(',',$_POST['id']);
		$goods = M(CONTROLLER_NAME);
		if($goods -> delete($ids)){
			$this -> ajaxReturn($ids);
		}else{
			$this -> ajaxReturn(false);
		}
	}

	/*
	*	回复评论
	*/
	public function reply(){
		$id = $_GET['id'];
		if(!$id){
			$this -> error('非法参数！');
		}
		$c = M('comment');
		$reply = $c -> find($id);
		if($reply){
			$this -> assign('reply',$reply);
			$this -> display();
		}
	}

	/*
	*	插入回复内容
	*/
	public function replyInsert(){
		$m = M('comment');
		$_POST['is_reply'] = 1;
		$_POST['reply_time'] = time();
		if($a = $m -> create()){
			if($m -> save()){
				$this -> success('回复成功！',U('index'));
			}else{
				$this -> error('回复失败！');
			}
		}else{
			$this -> error('回复失败！');
		}
	}
}