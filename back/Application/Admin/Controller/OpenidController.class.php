<?php
/**
 * Created by PhpStorm.
 * User: rehellinen
 * Date: 2017/7/24
 * Time: 14:01
 */
//小程序用于插入openid的接口

namespace Admin\Controller;
use Think\Controller;

class OpenidController extends Controller
{
    public function judgeOpenid() {
        if(!$_GET['openid']) {
            return 0;
        }
        $result = D('Openid')->findOpenid($_GET['openid']);
        if($result){
            return $result['type'];
        }else{
            $result1 = D('Openid')->insertOpenid($_GET['openid']);
            if($result1){
                return $result['type'];
            }else{
                return 666;
            }
        }
    }

    public function register() {
        $data=array();
        if($_GET['type'] = 0){
            //判断是不是学生
            $data['name'] = $_GET['name'];
            $data['age'] = $_GET['age'];
            $data['grade'] = $_GET['grade'];
            $data['gender'] = $_GET['gender'];
            $data['stu_register_date'] = $_GET['stu_register_date'];
            $data['stu_photo_url'] = $_GET['stu_photo_url'];

            $stu_id = D('Student')->insertStudent($data);
            if($stu_id){
                return $stu_id;
            }
            return 666;


        }elseif ($_GET['type'] = 1){
            //判断是不是未审核的老师
            $data['tea_name'] = $_GET['tea_name'];
            $data['tea_photo_url'] = $_GET['tea_photo_url'];
            $data['self_introduction'] = $_GET['self_introduction'];
            $data['pwd'] = $_GET['pwd'];
            $data['tel'] = $_GET['tel'];

            $tea_id = D('Admin')->insertTeacher($data);
            if($tea_id){
                return $tea_id;
            }
            return 666;
        }
    }
}