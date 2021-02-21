<?php
namespace app\index\controller;
use app\index\controller\Base;

class Index  extends Base
{
    public function index()
    {   
    	
    	$this->isLogin();
        //return  view(); 使用助手函数渲染模板
        $this->assign('title',"教学管理系统实战项目");
        return $this->fetch();
    }

    
}
