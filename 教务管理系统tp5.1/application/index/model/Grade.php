<?php
namespace app\index\model;
use think\Model;
use think\model\concern\SoftDelete;
/**
 * 班级模型
 */
class Grade extends Model{
    //引入软删除方法集
	use SoftDelete;
	protected $deleteTime="delete_time";

	//设置当前默认的时间格式
	protected $dateFormat="Y/m/d";

	//开启自动写入时间戳
	protected $autoWriteTimestamp=true; 
	//创建时间字段
	protected $createTime="create_time";
	//更新时间字段
	protected $updateTime="update_time";

    //保存自动完成列表,数据表在新增或者更新的时候自动完成,不能添加或者编辑
	protected $auto=[
     'delete_time'=>NULL,
	];

	//新增自动完成的属性
	protected $insert=['status'=>1];
    
	//定义关联方法
	public function teacher(){
		  //班级表与教师表是一对一关联
		  return $this->hasOne('Teacher');
	}

	public function student(){
		 //班级表与学习表是一对多关系
		 return $this->hasMany('student');
	}
    
    //状态获取器
	public function getStatusAttr($value){
		  $status=
		      [
		      	0=>'已停用',
		      	1=>'已启用'
		      ];
          return $status[$value];	
	}

}