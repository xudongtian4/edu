<?php
namespace app\index\controller;
use app\index\controller\Base;
use think\facade\Request;
use app\index\model\User as UserModel;
use think\facade\Session;



class User  extends  Base
{
	//渲染登录页面
    public function login()
    {   
          $this->alerdyLogin();
          return $this->fetch();
    }
    //验证用户登录信息,用到控制器里的$this->validate($data,$rule,$message)
    public function checkLogin(){
          $data=Request::param();
          //创建验证规则
          $rule=[
            'name|用户名'=>'require',
          'password|密码' =>'require|alphaNum',
               ];
          // $res=$this->validate($data,$rule);
          //自定义验证规则
          $msg=[
            "name"=>['require'=>'用户名不能为空,请检查！'],
         "password"=>['require'=>'密码不能为空,请检查！',
                     'alphaNum'=>'密码只能是数字和字码'
                    ],
                ];
         $message=$this->validate($data,$rule,$msg); 

         //对数据进行验证
         if(true !==$message){
             return ["status"=>0,'message'=>$message];
             }else{
                //说明数据验证没问题，进入数据库查询
                //构造查询条件
                $map=['name'=>$data['name'],'password'=>md5($data['password'])];
                //数据库查询
               //执行查询操作
                $user=UserModel::where($map)->find();

                if(!is_null($user)){

                     //将用户信息保存在session中
                     Session::set('user_id',$user->id);
                     Session::set('time',time());
                     
                     //获取模型中的原始数据的所有信息，返回的二维数组
                     Session::set('user_info',$user->getData()); //返回的二维数组
                     
                     //用户登录成功后对数据库的数据进行更新
                     UserModel::where('id',$user->id)->update(['login_time'=>Session::get('time'),'login_count'=>$user->login_count+1]);
                      
                     return ["status"=>1,'message'=>'登录成功！']; 

                }else{

                    return ["status"=>-1,'message'=>'用户名或密码错误！'];
                }
          }
    }
    
    //退出登录
    public  function logOut(){
              Session::delete('user_id');
              Session::delete('user_info');
              $this->success('注销登录,正在返回！','user/login');
    }

    //渲染管理员列表
    public function adminList(){
           //模板变量
           $this->assign('title','管理员列表');
           $this->assign('keywords','实战项目');
           $this->assign('desc','教学案例');
           //获取总的管理员数量
           $count=UserModel::count();
           $username=Session::get('user_info.name');
           //判断，如果是超级管理员，可以查看所有
           if($username=='admin'){
               $userlist=UserModel::all();
           }else{
           //普通管理员只可以查看自己
               $userlist=UserModel::all(['name'=>$username]);
           }
           //模板变量赋值
           $this->assign('count',$count);
           $this->assign('userlist',$userlist);
           return  $this->fetch();
    }
    
    //更新管理员状态
    public function setStatus(){
           //获取id
           $user_id=Request::param('id');
           //获取当前用户的状态
           $status=UserModel::where('id',$user_id)->value('status');
           //进行判断和更新
           if($status==1){
             UserModel::update(['status'=>0],['id'=>$user_id]);
           }else{
              UserModel::update(['status'=>1],['id'=>$user_id]);
           }
            
    }
    //渲染用户编辑页面
    public function adminEdit(){
           //获取用户id
           $user_id=Request::param('id');
           $result=UserModel::get($user_id);
           $this->assign('title','管理员编辑');
           $this->assign('keywords','项目实战');
           $this->assign('desc','教学案例');

           $this->assign('user_info',$result->getData());
           return $this->fetch(); 
    }
    
    //渲染用户添加模板
    public function adminAdd(){
           $this->assign('title','管理员添加');
           $this->assign('keywords','项目实战');
           $this->assign('desc','教学案例');
           return  $this->fetch('adminAdd');
    }
   
    //检查用户名是否重复
    public function chechUsername(){
           //获取提交的用户名
           $name=trim(Request::param('name'));
           if(empty($name)){
              return ['status'=>-1,'message'=>'用户名不能为空'];
           }

           //数据库查询是否有改用户
           $user=UserModel::get(['name'=>$name]);

           if(!is_null($user)){
               //说明用户名已经存在
                return ['status'=>0,'message'=>'用户名已存在'];

           }else{

                return ['status'=>1,'message'=>'用户名可用'];
           }
    }
    
    //检查邮箱是否重复
    public function chechUseremail(){
          //获取提交的用户名
           $email=trim(Request::param('email'));
           if(empty($email)){
              return ['status'=>-1,'message'=>'邮箱不能为空'];
           }

           //数据库查询是否有改用户
           $user=UserModel::get(['email'=>$email]);

           if(!is_null($user)){
               //说明用户名已经存在
                return ['status'=>0,'message'=>'邮箱已存在'];

           }else{

                return ['status'=>1,'message'=>'邮箱可用'];
           }
    }

    //插入新用户
    public function userAdd(){
          //获取添加信息
           $data=Request::param();
           //设置验证规则
           $rule=[
           'name|用户名'=>'require|min:3|max:12|unique:user',
           'password|密码' =>'require|alphaNum|min:6',
           'email|邮箱'=>'require|email|unique:user'
           ];
           //$rule='app\common\validate\User';

           $result=$this->validate($data,$rule);

           if(true!==$result){
               
               return ['status'=>-1,'message'=>$result];
           }
           else{
                 $res=UserModel::create($data);
                 
                 if($res){
                    return ['status'=>1,'message'=>'添加成功'];
                 }else{
                    return ['status'=>0,'message'=>'添加失败'];
                 }
           }
           
    }

    //用户编辑更新更能
    public function adminUpdate(){
           //获取数据
           $data=Request::param();
           //验证数据
           
           //更新数据
           $res=UserModel::update($data);
           if(is_null($res)){
               return ['status'=>0,'message'=>'更新失败'];
          }else{
               return ['status'=>1,'message'=>'更新成功'];
            }
    }

    //用户删除
    public function adminDel(){
              //获取用户id
              $user_id=Request::param('id');
              //通过用户id删除用户
              //删除之前先将该用户的is_delete属性更改
              //UserModel::update(['is_delete'=>1],['id'=>$user_id]);
              $res=UserModel::destroy($user_id);

              if($res){

                  return ['status'=>1,'message'=>'已删除'];

             }else{
                  
                  return ['status'=>0,'message'=>'删除失败'];
              }
    }

    //用户批量删除功能
    public function batchDel(){
             //获取id
             $id=input("id/a"); //使用变量修饰符,强制转换成数组类型

             //$id=implode(',', $id);     //将一维数组转换为字符串
             //删除之前先将该用户的is_delete属性更改
             //UserModel::where("id in ($id)")->update(['is_delete'=>1]);

             $res=UserModel::destroy($id);

             if($res){

                  return ['status'=>1,'message'=>'已删除'];

             }else{
                  
                  return ['status'=>0,'message'=>'删除失败'];
              }
        
    }

    //批量恢复功能
    public function unDelete(){
            
              UserModel::update(['delete_time'=>NULL],['is_delete'=>1]);
    }
}

