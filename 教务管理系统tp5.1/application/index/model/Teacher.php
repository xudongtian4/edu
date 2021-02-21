<?php
namespace app\index\model;
use think\Model;
use think\model\concern\SoftDelete;
/**
 * 教师表模型
 */
/**
 */
class Teacher extends Model
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
    
    protected $type=['hiredate'=>'timestamp'];
    
    //定义自动完成的属性
    protected $insert =['status'=>1];

    //设置与班级表一对一的反关联表
    protected function grade(){

    	return $this->belongsTo('grade');
    }
    
    //获取器
    public  function getDegreeAttr($value){
         $degree=[ 
                 1=>"专科",
                 2=>"本科",
                 3=>'研究生'   
              ];
         return $degree[$value];
    }

}