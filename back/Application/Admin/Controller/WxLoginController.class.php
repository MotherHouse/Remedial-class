<?php

//小程序用于加载已注册用户的个人页面的接口

namespace Admin\Controller;
use Think\Controller;

class WxloginController extends Controller
{	
	//根据用户类型、id加载不同的“个人中心”界面
	//需要参数openid，返回类型以及对应的id，最好缓存在本地不用多次调用
	//若判断是游客或审核未过返回：{"message":"tourist or wait for check!","type":"0"}
    //若判断是学生返回：{"message":"student","type":"1"}
    //若判断是老师返回：{"message":"teacher","type":"2"}
	public function loginPersonalCenter() {
	    $db_data=array();//get到了操作数据库的数据
        $rt_data=array();//用于api return的数据
        if(""==$_GET['openid']) {
            $rt_data['type']="";
            $rt_data['message']="can't get openid from your page";
            api_return($rt_data);  
            return 0;          
        }//检测有没有获得openid

        $result =  D('Openid')->findOpenid($_GET['openid']);
        //判断openid表里有没有存着
        if($result){//若openid表里已经有了，判断类型并返回people_id
            if('0' == $result['type'] ){//判断出是游客+审核未过老师
                $rt_data['type']='0';
                $rt_data["message"]="tourist or check fail!";
                api_return($rt_data);
            }elseif('-1'== $result['type'] ){
                $rt_data['type']='-1';
                $rt_data['tea_id']=$result['people_id'];
                $rt_data["message"]="teacher wait for check!";
                api_return($rt_data);
            }elseif('1'== $result['type'] ){
                $rt_data['type']='1';
                $rt_data['stu_id']=$result['people_id'];
                $rt_data["message"]="student";
                api_return($rt_data);
            }elseif ('2'== $result['type'] ) {
                $rt_data['type']='2';
                $rt_data['tea_id']=$result['people_id'];
                $rt_data["message"]="teacher";
                api_return($rt_data);
            }
        }else{
                //如果不存在，插入openid
                $result1 = D('Openid')->insertOpenid($_GET['openid']);
                if($result1){;
                    $rt_data['type']=$result1['type'];
                    $rt_data['message']="insert new openid success!";
                    api_return($rt_data);
                }else{
                    //如果不存在并且插入失败
                    $rt_data['type']="";
                    $rt_data['message']="insert new openid fail!";
                    api_return($rt_data);
                }
            }
	}//public end
}


