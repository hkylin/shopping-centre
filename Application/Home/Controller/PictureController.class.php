<?php
namespace Home\Controller;

class PictureController extends CommonController{
	public function index(){
		if(!$_GET['id']){
			$this -> error('没有找到指定商品！','Index/index');
		}
		$m = M('goods_gallery');
		$pic = $m -> field('img_url') -> where("goods_id=".$_GET['id']) -> select();
		// $pic = explode(' ', $pic['img_url']);
		if($pic[0]){
			$this -> assign('pic',$pic);
			$this -> assign('pic1',$pic[0]);
		}else{
			$this -> assign('pic1',0);
			$this -> assign('pic',0);
		}
		$this -> display();
	}
}