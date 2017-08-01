<?php
/**
 * Created by PhpStorm.
 * User: rehellinen
 * Date: 2017/7/23
 * Time: 20:01
 */

namespace Admin\Controller;
use Think\Controller;


class StudentController extends CommonController
{
    public function index () {


        $data = array();
        $page = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
        $pageSize = $_REQUEST['pageSize'] ? $_REQUEST['pageSize'] : 8;

        $classCount = D("Student")->getStudentCount($data);
        //获取评论
        $student = D("Student")->getStudent($data,$page,$pageSize);
        $res = new \Think\Page($classCount,$pageSize);
        $pageRes = $res->show();
        $this->assign('pageRes', $pageRes);
        $this->assign('student' , $student);
        $this->display();
    }

    public function add(){

        if($_POST) {
            if(!isset($_POST['stu_name']) || !$_POST['stu_name']){
                return show(0,'姓名不能为空');
            }
            if(!isset($_POST['stu_age']) || !$_POST['stu_age']){
                return show(0,'年龄不能为空');
            }
            if(!isset($_POST['stu_grade']) || !$_POST['stu_grade']){
                return show(0,'年级不能为空');
            }
            if(!isset($_POST['stu_photo_url']) || !$_POST['stu_photo_url']){
                return show(0,'照片不能为空');
            }
            if(!isset($_POST['stu_gender']) || !$_POST['stu_gender']){
                return show(0,'性别不能为空');
            }
            if(!isset($_POST['stu_register_date']) || !$_POST['stu_register_date']){
                return show(0,'注册时间不能为空');
            }


            if($_POST['stu_id']){
                return $this->save($_POST);
            }
            $id = D("Student")->insert($_POST);
            if($id){
                return show(1,'新增成功',$id);
            }

            return show(0,'新增失败',$id);
        }else{
            $this->display();
        }
    }

    public function save($data) {
        $id = $data['stu_id'];
        unset($data['stu_id']);
        try{
            $id = D("Student")->updateStudentById($id , $data);
            if($id === false) {
                return show(0,'更新失败');
            }
            return show(1,'更新成功');
        }catch (Exception $e){
            return show(0,$e->getMessage());
        }

    }


    public function edit() {
        $classId = $_GET['id'];
        $student = D('Student')->findStudent($classId);
        $this->assign('student',$student);
        $this->display();
    }


    public function setStatus(){
        try{
            if($_POST){
                $id = $_POST['id'];
                $status = $_POST['status'];
                //执行数据更新操作
                $res = D("Student")->updateStatusById($id,$status);
                if($res){
                    return show(1,'操作成功');
                }else{
                    return show(0,'操作失败');
                }
            }
        }catch (Exception $e){
            return show(0,$e->getMessage());
        }
        return show(0,'没有提交的数据');
    }


    public function  listorder() {
        $listorder = $_POST['listorder'];
        $jumpUrl = $_SERVER['HTTP_REFERER'];
        $errors = array();
        if ($listorder) {
            foreach ($listorder as $studentId => $value) {
                //执行更新
                $id = D("Student")->updateStudentListorder($studentId, $value);
                if ($id === false) {
                    $errors[] = $studentId;
                }
            }
            if($errors) {
                return show(0,'排序失败-'.implode(',',$errors),array('jump_url'=>$jumpUrl));
            }
            return show(1,'排序成功',array('jump_url'=>$jumpUrl));
        }
        return show(0,'排序数据失败',array('jump_url'=>$jumpUrl));
    }
}