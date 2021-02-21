<?php
namespace app\common\validate;
use think\Validate;
/**
 * 这是用户表的公共验证器
 */
class User extends Validate
{
	protected $rule=[

'name|用户名'=>'require|length:5,20|chsAlphaNum|unique:user',
 
   'password|密码'=>'require|length:6,15|alphaNum',
       'email|邮箱'=>'require|email|unique:user',

       /*'name|姓名'=>[
	            'require'=>'require',
	            'length'=>'5,20',
	        'chsAlphaNum'=>'chsAlphaNum',   //仅允许汉字字母和数字
       ],
       'email|邮箱'=>[
       	        'require'=>'require',
       	        'email'  =>'email',
       	        'unique' =>'zh_user'       //在zh_user表中，邮箱应唯一
       ],
    'mobile|手机号'=>[
    	        'require'=>'require',
    	        'mobile' =>'mobile' ,
    	        'unique' =>'zh_user',      //在zh_user表中，手机号应唯一
    	        'number' =>'number'        //手机号为纯数字
       ],
     'password|密码'=>[
                'require'=>'require',
                'length'=>'6,15',
               'alphaNum'=>'alphaNum',   //仅允许字母和数字
               'confirm' =>'confirm'     //确保再次输入一致
      ],*/
	];
	
}