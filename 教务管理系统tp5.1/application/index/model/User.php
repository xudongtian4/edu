<?php
namespace app\index\model;
use think\Model;
use think\model\concern\SoftDelete;
/**
 * 
 */
class User extends Model
{   
    //导入软删除的方法集
    use SoftDelete;
    protected $deleteTime = 'delete_time';

	//保存自动完成列表,数据表在新增或者更新的时候自动完成,不能添加或者编辑
	protected $auto=[
     'delete_time'=>NULL,
     'is_delete'=>1       //1允许删除,0禁止删除
	];

	//新增自动完成列表,不能添加或者编辑
	protected $insert=[
     'login_time'=>NULL, //新增时登录时间为空，因为刚创建
     'login_count'=>0    //刚新增登录次数肯定为0
	];

	//更新时自动完成列表
	protected $update=[];
    //是否需要自动写入时间戳，如果设置为字符串，则表示时间字段是类型
	protected $autoWriteTimestamp=true; //自动写入
	//创建时间字段
	protected $createTime="create_time";
	//更新时间字段
	protected $updateTime="update_time";
	//字段输出格式
	protected $dateFormat='Y年m月d日';
	

    //管理员获取器
	public function getRoleAttr($value){
		$role=
			[     0=>'管理员',
		          1=>'超级管理员'
		    ];
	     return $role[$value];
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
	
	//登录时间获取器
	public function getLogintimeAttr($value){
           return date("Y-m-d H:i:s",$value);
	}

	//密码修改器
	public function setPasswordAttr($value){
		return md5($value);
	}

}