<?php
/**
 * Created by PhpStorm.
 * User: rehellinen
 * Date: 2017/7/23
 * Time: 19:47
 */

namespace Admin\Controller;
use Think\Controller;


class ClassController extends CommonController
{
    public function index () {
        $data = array();
        $page = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
        $pageSize = $_REQUEST['pageSize'] ? $_REQUEST['pageSize'] : 8;

        $classCount = D("Class")->getClassCount($data);
        //获取课程
        $class = D("Class")->getClass($data,$page,$pageSize);
        foreach ($class as $key=>$value){
            foreach ($value as $key2=>$value2){
                //echo $key2."=>".$value2;
                if($key2=='tea_id'){
                    $teacherName[$value2] = D("Admin")->findTeacherName($value2);
                    $class[$key][$key2] = $teacherName[$value2];
                }
            }
        }
        $res = new \Think\Page($classCount,$pageSize);
        $pageRes = $res->show();
        $this->assign('pageRes', $pageRes);
        $this->assign('class' , $class);
        $this->display();
    }

    public function add(){
        //print_r($_POST);exit;
        if($_POST) {
            if(!isset($_POST['grade']) || !$_POST['grade']){
                return show(0,'年级不能为空');
            }
            if(!isset($_POST['subject']) || !$_POST['subject']){
                return show(0,'科目不能为空');
            }
            if(!isset($_POST['tea_id']) || !$_POST['tea_id']){
                return show(0,'老师不能为空');
            }
            if(!isset($_POST['class_time']) || !$_POST['class_time']){
                return show(0,'上课时间不能为空');
            }
            if(!isset($_POST['fee']) || !$_POST['fee']){
                return show(0,'费用不能为空');
            }
            if(!isset($_POST['stu_count']) || !$_POST['stu_count']){
                return show(0,'学生人数不能为空');
            }
            if(!isset($_POST['method']) || !$_POST['method']){
                return show(0,'授课方式不能为空');
            }
            if($_POST['class_id']){
                return $this->save($_POST);
            }
            $id = D("Class")->insert($_POST);
            if($id){
                return show(1,'新增成功',$id);
            }

            return show(0,'新增失败',$id);
        }else{
            $this->display();
        }
    }

    public function save($data) {
        $id = $data['class_id'];
        unset($data['class_id']);
        try{
            $id = D("Class")->updateClassById($id , $data);
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
        $class = D('Class')->findClass($classId);
        $this->assign('class',$class);
        $this->display();
    }


    public function setStatus(){
        try{
            if($_POST){
                $id = $_POST['id'];
                $status = $_POST['status'];
                //执行数据更新操作
                $res = D("Class")->updateStatusById($id,$status);
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
            try {
                foreach ($listorder as $classID => $value) {
                    //执行更新
                    $id = D("Class")->updateCommentListorder($classID, $value);
                    if ($id === false) {
                        $errors[] = $classID;
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
}