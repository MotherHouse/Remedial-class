<?php
/**
 * Created by PhpStorm.
 * User: rehellinen
 * Date: 2017/7/23
 * Time: 16:11
 */

namespace Admin\Controller;


class AdminController extends CommonController
{
    public function index() {
        $data=array();
        //分页
        $page = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
        $pageSize = $_REQUEST['pageSize'] ? $_REQUEST['pageSize'] : 8;
        //获取老师信息
        $teacher = D("Admin")->getTeacherTp($data,$page,$pageSize);
        //获取老师数量
        $teacherCount = D("Admin")->getTeacherCount();
        $res = new \Think\Page($teacherCount,$pageSize);
        $pageRes = $res->show();
        $this->assign('pageRes', $pageRes);
        $this->assign('teacher' , $teacher);
        $this->display();
    }

    public function insertTeacher($info=array()) {

    }

    public function edit() {
        $teaId = $_GET['id'];
        $teacher = D('Admin')->editShow($teaId);
        $this->assign('teacher',$teacher);
        $this->display();

    }

    public function add() {

        if($_POST){
            if(!isset($_POST['tea_name']) || !$_POST['tea_name']){
                return show(0,'老师姓名不能为空');
            }
            if(!isset($_POST['tea_gender']) || !$_POST['tea_gender']){
                return show(0,'老师性别不能为空');
            }
            if(!isset($_POST['tea_age']) || !$_POST['tea_age']){
                return show(0,'老师年龄不能为空');
            }
            if(!isset($_POST['tea_photo_url']) || !$_POST['tea_photo_url']){
                return show(0,'照片不能为空');
            }
            if(!isset($_POST['self_introduction']) || !$_POST['self_introduction']){
                return show(0,'自我介绍不能为空');
            }
            if(!isset($_POST['tea_tel']) || !$_POST['tea_tel']){
                return show(0,'联系方式不能为空');
            }
            if(!isset($_POST['pwd']) || !$_POST['pwd']){
                return show(0,'密码不能为空');
            }

            //如果有tea_id则表示是编辑模式
            if($_POST['tea_id']){
                return $this->save($_POST);
            }

            $teaId = D("Admin")->insert($_POST);
            if($teaId){
                return show(1,'新增成功',$teaId);
            }

            return show(0,'新增失败',$teaId);
        } else {
            $this->display();
        }
        $this->display();
    }


    public function save($data) {
        //print_r($data);exit;
        $teaId = $data['tea_id'];
        unset($data['tea_id']);

        $id = D("Admin")->updateTeacherById($teaId , $data);
        if($id === false) {
            return show(0,'更新失败');
        }
        return show(1,'更新成功');
    }

    public function setStatus() {
        if($_POST){
            $id = $_POST['id'];

            //执行审核操作
            if($_POST['type']){
                $type = $_POST['type'];
                $res = D("Openid")->updateStatusById($id,$type);
                $res2 = D("Admin")->updateStatusById($id,$type);
                if($res){
                    return show(1,'成功');
                }else{
                    return show(0,'失败');
                }
            }

            //执行删除操作
            if($_POST['status']){
                $status = $_POST['status'];
                $res = D("Admin")->updateStatusById($id,$status);
                if($res){
                    return show(1,'成功');
                }else{
                    return show(0,'失败');
                }
            }

        }
        return show(0,'没有提交的数据');
    }

    public function listorder() {
        $listorder = $_POST['listorder'];
        $jumpUrl = $_SERVER['HTTP_REFERER'];
        $errors = array();
        if ($listorder) {
            try {
                foreach ($listorder as $teaID => $value) {
                    //执行更新
                    $id = D("Admin")->updateTeacherListorderById($teaID, $value);
                    if ($id === false) {
                        $errors[] = $menuID;
                    }
                }
            }catch (Exception $e){
                return show(0,$e->getMessage(),array('jump_url'=>$jumpUrl));
            }
            if($errors) {
                return show(0,'排序失败-'.implode(',',$errors),array('jump_url'=>$jumpUrl));
            }
            return show(1,'排序成功',array('jump_url'=>$jumpUrl));
        }
        return show(0,'排序数据失败',array('jump_url'=>$jumpUrl));
    }

    public function personal(){
        $id = $_SESSION['adminUser']['tea_id'] ? $_SESSION['adminUser']['tea_id'] : '';
        //print_r($_SESSION);exit;
        $loginUser = D("Admin")->getAdminByAdminId($id);
        $this->assign('loginUser',$loginUser);
        $this->display();
    }


}