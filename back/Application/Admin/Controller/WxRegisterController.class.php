<?php
/**
 * Created by PhpStorm.
 * User: rehellinen
 * Date: 2017/7/24
 * Time: 14:01123
 */
//小程序用于插入openid的接口

namespace Admin\Controller;
use Think\Controller;

class WxRegisterController extends Controller
{	
    //注册时判断学生还是老师
    //传入type参数：注册时选择学生则应为1，选择老师则应为-1;传入openid
    //type为1时需要插入学生的姓名、年龄、年级、性别、（注册时间在php后台获取）、照片地址到stu_basic_info表，并获取自增后的stu_id
    //插入并获取stu_id成功后在openid表修改type与stu_id
    //成功注册返回state值1，失败返回0
    //type为-1
    public function register() {
        $db_data=array();//get到了操作数据库的数据
        $rt_data=array();//用于api return的数据
        
        if('1' == $_GET['type'] ){
        	//判断：学生
            $db_data['stu_name'] = $_GET['stu_name'];
            $db_data['age'] = $_GET['age'];
            $db_data['grade'] = $_GET['grade'];
            $db_data['gender'] = $_GET['gender'];
            $db_data['stu_register_date'] = date("Y-m-d");
            $db_data['stu_photo_url'] = $_GET['stu_photo_url'];
            $db_data['stu_tel'] = $_GET['tel'];

            $stu_id = D('Student')->insertStudent($db_data);
            //小程序端必须保证学生信息全部填写完毕，否则插入数据库会出错
            if(!$stu_id){
                $rt_data['message']="db_stu_basic_info insert fail!";
                $rt_data['status']="0";
                api_return($rt_data);
                return 0;
            }//获取学生id,如果获取失败说明数据库出错

            $result = D('Openid')->changeType($_GET['openid'],1,$stu_id);
            if(!$result){
                D('Student')->deleteStudent($stu_id);//注册失败时保证数据库不重复存入信息
            	$rt_data['message']="openid not exist in db_openid";
            	$rt_data['status']="0";
                api_return($rt_data);
                return 0;
            }//更新openid表学生type为	1,如果失败说明没有get到openid或者数据库没有这个openid
        	$rt_data['message']="student(type:1) register success!";
        	$rt_data['status']="1";
            api_return($rt_data);
            //echo $result;
            //操作openid表，修改type并插入people_id
         }
         elseif('-1' == $_GET['type']){
         	 //判断：需要审核的老师
            $db_data['tea_name'] = $_GET['tea_name'];
            $db_data['tea_photo_url'] = $_GET['tea_photo_url'];
            $db_data['self_introduction'] = $_GET['self_introduction'];
            $db_data['pwd'] = $_GET['pwd'];
            $db_data['tea_gender'] = $_GET['gender'];
            $db_data['tea_tel'] = $_GET['tel'];
            //$data['tea_type'] = -1;默认为-1，需要赞叔审核,通过后：openid表type改为2，teacher表改为1；未通过：openid表改为0，teacher表改为0

            $tea_id = D('Admin')->insertTeacher($db_data);
          
            //小程序端必须保证老师信息全部填写完毕，否则插入数据库会出错
            if(!$tea_id){
                $rt_data['message']="db_teacher insert fail!";
                $rt_data['status']="0";
                api_return($rt_data);
                return 0;
            }//如果获取失败说明数据库出错

            $result = D('Openid')->changeType($_GET['openid'],-1,$tea_id);
            if(!$result){
                D('Admin')->deleteTeacher($tea_id);//注册失败时保证数据库不重复存入信息
            	$rt_data['message']="openid not exist in db_openid";
            	$rt_data['status']="0";
                api_return($rt_data);
                return 0;
            }//更新openid表待审核老师type-1,如果失败说明没有get到openid或者数据库没有这个openid
        	$rt_data['message']="teacher(type:-1) register success!wait for check...";
        	$rt_data['status']=1;
            api_return($rt_data);
            //echo $result;
        }

    }

	
}
// //传入参数openid，查看openid表
    // //若openid存在：返回type类型（老师已通过返回2，学生返回1，游客返回0，老师待审核返回-1，老师审核失败重置为0）
    // //若openid不存在：返回
 //    public function judgeOpenid() {
 //     $rt_data = array();
 //     //没有获取openid
 //        if(""==$_GET['openid']) {
 //            $rt_data['type']="";
 //            $rt_data['message']="can't get openid from your page";
 //            api_return($rt_data);            
 //        }else{
 //         //尝试在表中寻找openidd
    //         $result = D('Openid')->findOpenid($_GET['openid']);
    //         //如果存在，返回openid
    //         if($result){
    //             $rt_data['type']=$result['type'];
    //             $rt_data['message']="get type success!";
    //             api_return($rt_data);
    //         }else{
    //          //如果不存在，插入openid
    //             $result1 = D('Openid')->insertOpenid($_GET['openid']);
    //             if($result1){;
    //                  $rt_data['type']=$result1['type'];
    //              $rt_data['message']="insert new openid success!";
    //              api_return($rt_data);
    //             }else{
    //              //如果不存在并且插入失败
    //                 $rt_data['type']="";
    //              $rt_data['message']="insert new openid fail!";
    //              api_return($rt_data);
    //             }
    //         }
 //        }
 
 //    }