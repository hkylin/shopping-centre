<?php

namespace Home\Widget;
use Think\Controller;

class MenuWidget extends Controller{
	public function index(){
		// 公共页面的导航栏
	    $m  = M('shop_type');
	    //首先找出顶级分类
	    $map['pid'] = 0;
	    $map['is_show'] = 1;
	    $tm = $m -> field('id,type_name') -> where($map) -> order('type_order desc') -> select();
	    $this -> assign('pt',$tm);
	    //再找出子级分类
	    $map['pid'] = array('gt',0);
	    $map['is_show'] = 1;
	    $cm = $m -> field('id,pid,type_name') -> where($map) -> order('type_order desc') -> select();
	    $this -> assign('ct',$cm);

	    $this -> display('Public:menu');
	}

	public function searchBrand(){
		//找出所有的品牌
		$b = M('brand');
		$g = M('goods');
		$brand = $b -> field('id,brand_name') -> where('is_show = 1') -> select();
		// 遍历其中的商品数 
		foreach($brand as &$vb){
			$count = $g -> where('brand_id='.$vb['id']) -> count();
			$vb['count'] = $count;
		}
		$this -> assign('brand',$brand);
		$this -> display('Public:SearchBrand');
	}


	public function centers(){
		$this->display('Public:centers');
	}
}