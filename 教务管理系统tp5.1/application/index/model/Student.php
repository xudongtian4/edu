<?php
namespace app\index\model;
use think\Model;
use think\model\concern\SoftDelete;
/**
 * 学生表模型
 */
/**
 * 
 */
class Student extends Model
{
	//引入软删除方法集
	use SoftDelete;
	protected $deleteTime="delete_time";

	//设置当前默认的时间格式
	protected $dateFormat="Y年m月d日";

	//开启自动写入时间戳
	protected $autoWriteTimestamp=true; 
	//创建时间字段
	protected $createTime="create_time";
	//更新时间字段
	protected $updateTime="update_time";

	protected $type=['start_time'=>'timestamp' ];

	//获取器
	public function getSexAttr($value){
           $sex=[
           	     0=>'女',
                 1=>'男'
                ];
            return $sex[$value];    
	}
	
	//定义与班级表多对一的反关联关系
	public  function grade(){
		return $this->belongsTo('grade');
	}
}