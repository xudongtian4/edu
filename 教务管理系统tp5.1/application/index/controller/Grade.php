<?php
namespace app\index\controller;
use app\index\controller\Base;
use think\facade\Request;
use app\index\model\Grade as GradeModel;
use app\index\model\Teacher;

/**
 * 
 */
class Grade extends Base
{
	  //班级列表
	  public function  gradeList(){
           //获取所有班级列表
           $grade=GradeModel::all();
           $count=GradeModel::count();
           $gradeList=[];
           foreach($grade as $value){
           $data=['id'=>$value->id,
           	    'name'=>$value->name,
           	   'length'=>$value->length,
           	     'price'=> $value->price,
           	      'status'=>$value->status,
           	   'create_time'=>$value->create_time,
           	         'teacher'=>isset($value->teacher->name) ? $value->teacher->name : "未分配",
                  ];
               $gradeList[]=$data;
           }
  	  	   //分配模板变量
           $this->assign('title','班级列表');  
  	  	   $this->assign('count',$count);
  	  	   $this->assign('gradeList',$gradeList);
           return $this->fetch();
	  }

    //更改班级状态
    public function setStatus(){
           //获取id
           $user_id=Request::param('id');
           //获取当前用户的状态
           $status=GradeModel::where('id',$user_id)->value('status');
           //进行判断和更新
           if($status==1){
             GradeModel::update(['status'=>0],['id'=>$user_id]);
           }else{
              GradeModel::update(['status'=>1],['id'=>$user_id]);
           }
            
    }

    //渲染班级编辑页面
    public function gradeEdit(){
           //获取要编辑的班级id
           //$grade_id=Request::param('id');

           //获取向对应的班级模型
           $grade=GradeModel::get(8);
           return $grade->teacher->name;
          //halt($grade);
           //halt($grade->teacher);
           //进行关联查询,与班级模型相对应的教师姓名
          /* $teacher=$grade->teacher->name;

           $this->assign('title','班级编辑');
           $this->assign('keywords','项目实战');
           $this->assign('desc','教学案例');
           //模板赋值
           $this->assign('teacher',$teacher);
           $this->assign('grade_info',$grade->getData());
           return $this->fetch(); */
    }

    //班级编辑更新更能
    public function gradeUpdate(){
           //获取数据
           $data=Request::param();
           //更新数据
           $res=GradeModel::update($data);
           if(is_null($res)){
               return ['status'=>0,'message'=>'更新失败'];
           }else{
               return ['status'=>1,'message'=>'更新成功'];
            }
    }
	
}