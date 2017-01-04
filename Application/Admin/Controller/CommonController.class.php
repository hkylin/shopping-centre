<?php

/*
*   公共类，所有的控制器继承这个公共类
*   $author 蒋永忠
*/

namespace Admin\Controller;
use Think\Controller;

class CommonController extends Controller {
    /*
    *   自动调用方法，判断用户是否登陆，权限，登录超时等
    */
    public function _initialize(){
        $admin = session('admin');
        if($admin == false){
            $this->redirect('Login/index');
            exit;
        }

        //auth权限验证
        $uid = $_SESSION['admin']['id'];
        $rule = CONTROLLER_NAME.'/'.ACTION_NAME;

        static $auth;
        if(!$auth){
            $auth = new \Think\Auth();
        }
        //判断权限
        // if(!$auth -> check($rule,$uid)){
        //     $this -> error('对不起，你没有权限！');
        // }

        //设置登录超时,超时时间为600s=10分钟
        /*$nowtime = time();
        $logtime = $_SESSION['admin']['logtime'];  //用户的登录时间
        if($nowtime - $logtime > 600){
            session('admin',null);
            $this -> error('登录超时，请重新登录！',U('Login/index'));
        }else{
            $_SESSION['admin']['logtime'] = $nowtime;
        }*/
    }

    /* 
    * 分页方法直接调用
    * $count 总页数  $pagenumber每页的分页数
    * 返回分页对象 
    */
    Public function mypage($count,$pagenumber){
    	$Page = new \Think\Page($count,$pagenumber);//实例化分页类记录数和每页显示的记录数
    	
    	// 修改分页样式
    	$Page->setConfig('header', '共%TOTAL_ROW%条数据，当前第%NOW_PAGE%/%TOTAL_PAGE%页');
    	$Page->setConfig('prev', '上一页');
    	$Page->setConfig('first', '首页');
    	$Page->setConfig('last',   '尾页');
    	$Page->setConfig('next', '下一页');
    	$Page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE%  %LINK_PAGE%  %DOWN_PAGE% %END%');

    	// 返回分页对象
    	return $Page;
    }

    /*
    *   上传方法，直接调用  返回带目录的文件名
    */
    public function myupload(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小 
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型    
        // $upload -> rootpath = './Public/';
        $upload->savePath  =      './Uploads/'; // 设置附件上传目录,upload类里面的rootpath改为了 ./Public/    

        // 上传文件     
        $info   =   $upload->upload();  
        if(!$info) {// 上传错误提示错误信息        
            $this->error($upload->getError());    
        }else{
            // 上传成功  
            foreach($info as $file){
                $filename = $file['savepath'].$file['savename'];
            }      
            echo $filename;    
        }
    }
}