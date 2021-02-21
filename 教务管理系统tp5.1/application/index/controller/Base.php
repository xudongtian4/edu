<?php
namespace app\index\controller;
use think\Controller;
use think\facade\Session;

class Base extends Controller
{
   
   public function _initialize(){

   	   //继承父类的初始化操作
   	   parent::initialize();
   	   //define('USER_ID', Session::get('user_id'));
   } 

   //验证用户是否登录
    protected function isLogin(){
    	 if(!Session::has('user_id')){
            $this->error('无权访问,请先登录','user/login');
    	 }
    }
    //防止用户重复
    protected  function alerdyLogin(){
    	  if(Session::has('user_id')){
            $this->success('已经登录,无须重复登录','index/index');
    	 }
    }
}
