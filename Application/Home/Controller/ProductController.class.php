<?php

/*
*	商品详情页，包括商品信息、商品相册、商品评价、推荐商品、推荐品牌商品
* 	$author 蒋永忠
*/

namespace Home\Controller;

class ProductController extends CommonController{
	public function index(){
		$id = intval($_GET['id']);
		if(!$id){
			$this -> error('非法参数！');
		}
		$good = M('goods');
		//商品的点击量+1
		$good -> where('id='.$id) -> setInc('goods_click');
		$goods = $good -> find($id);
		
		// 判断传过来的ID，没有赋值跳转回首页
		if(empty($id) || empty($goods)){
			$this -> error('没有找到指定商品！',U('Index/index'));
		}
		
		//查询商品的品牌
		$brand = M('brand') -> field('brand_name,brand_logo') -> where('id='.$goods['brand_id']) -> find();
		$goods['brand_name'] = $brand['brand_name'];
		$goods['brand_logo'] = $brand['brand_logo'];

		//计算市场价格
		$price = round($goods['goods_price'] / $goods['goods_sale'],2);
		$goods['mprice'] = $price;

		//查询商品的相册
		$img = M('goods_gallery') -> field('img_url') -> where("goods_id='".$goods['id']."'") -> limit(4) -> select();
		// $goods['img_url'] = explode(' ', $img['img_url']);
		$goods['img_url'] = $img;
		
		//推荐组合，找三个同类品牌的商品
		$where['brand_id'] = array('eq',$goods['brand_id']);
		$where['id'] = array('neq',$goods['id']);
		$where['is_on_sale'] = array('eq',1);
		$where['is_delete'] = array('eq',0);
		$tj = M('goods') -> field('id,goods_name,goods_img,goods_price,goods_sale') -> where($where) -> limit(3) -> order('goods_click desc') -> select();
		//循环遍历出推荐商品的总价格和市场价格
		$psum = 0;//总价格
		$msum = 0; //总的市场价
		$ids = '';
		foreach($tj as $pv){
			$psum += $pv['goods_price'];
			$msum += round($pv['goods_price']/$pv['goods_sale'],2);
			$ids .= $pv['id'].',';
		}
		$this -> assign('psum',$psum);
		$this -> assign('msum',$msum);
		$this -> assign('ids',trim($ids,','));
		$this -> assign('tj',$tj);
		//查询商品的评价
		$pj = M('comment');
		$pwhere['goods_id'] = array('eq',$goods['id']);
		$pwhere['is_show'] = array('eq',1);
		$pingjia = $pj -> field('user_id,comment_content,comment_time,comment_rank,reply_time,reply') -> where($pwhere) -> select();
		//计算总的星级
		$ranks = 0;
		foreach ($pingjia as &$rank) {
			$ranks += $rank['comment_rank'];
			$username = M('user') -> field('user_email,user_pic') -> where("id='".$rank['user_id']."'") -> find(); 
			$rank['username'] = $username['user_email'];
			$rank['pic'] = $username['user_pic'];
		}
		// var_dump($pingjia);
		//评论星级
		$pjs = count($pingjia);
		$ranks = ceil($ranks / $pjs);
		$this -> assign('pingjia',$pingjia);
		$this -> assign('ranks',$ranks);
		$this -> assign('pjs',$pjs);

		//评价过的不显示评论框，返回1代表评论过了
		$out_pj = 0;
		$pjwhere['goods_id'] = array('eq',$goods['id']);
		$pjwhere['user_id'] = array('eq',$_SESSION['user']['id']);
		if($pj -> where($pjwhere) -> find()){
			$out_pj = 1;
		}
		//查询订单内已完成的订单，再到订单商品表里面查是否有该商品
		$action = M('order_action');
		$ogoods = M('order_goods');
		//查询出订单ID
		$uid = $_SESSION['user']['id'];
		$act = $action -> field('id') -> where('action_status AND user_id='.$uid) -> select();
		//再到订单商品表里面查询是否有该商品
		$gid = $_GET['id'];
		foreach($act as $v){
			$owhere['action_id'] = array('eq',$v['id']);
			$owhere['goods_id'] = array('eq',$gid);
			$og = $ogoods -> where($owhere) -> find();
			
			if($og){
				$out_pj = 1;
				// break;
			}
		}
		
		
		$this -> assign('ispj',$out_pj);
		//面包屑导航条
		$m = M('shop_type');
		$i= $goods['type_id'];
		$pp = array();
		while($i){
			if($i == 0){
				break;
			}
			$path = $m -> field('pid,type_name') -> find($i);
			$pp[] = $path;
			$i = $path['pid'];
		}
		$this -> assign('path',array_reverse($pp));
		
		//同类最热销商品
		$hmap['type_id'] = array('eq',$goods['type_id']);
		$hmap['is_on_sale'] = array('eq',1);
		$hmap['is_delete'] = array('eq',0);
		$hgood = $good -> field('id,goods_name,goods_price,goods_sale,goods_img') -> where($hmap) -> limit(5) -> order('sales_volume desc') -> select();
		
		//计算出里面的市场价格
		if($hgood){
			foreach($hgood as &$vh){
				$vh['mprice'] = round(($vh['goods_price'] / $vh['goods_sale']),2);
			}
			$this -> assign('hgood',$hgood);
		}
		
		//同品牌最热销商品
		$tmap['brand_id'] = array('eq',$goods['brand_id']);
		$tmap['id'] = array('neq',$goods['id']);
		$tmap['is_on_sale'] = array('eq',1);
		$tmap['is_delete'] = array('eq',0);
		$tgood = $good -> field('id,goods_name,goods_price,goods_sale,goods_img') -> where($tmap) -> limit(5) -> order('sales_volume desc') -> select();
		//计算出里面的市场价格
		if($tgood){
			foreach($tgood as &$th){
				$th['mprice'] = round(($th['goods_price'] / $th['goods_sale']),2);
			}
			$this -> assign('tgood',$tgood);
		}
		
		//查询到的商品信息分配给变量
		$this -> assign('goods',$goods);
		//查询该商品的赠品
		$gift = M('gift') -> where('id='.$goods['gift_id']) ->find();
		
		$this -> assign('gift',$gift);
		$this -> display();
	}
}
