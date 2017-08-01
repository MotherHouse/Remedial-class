<?php
/**
 * Created by PhpStorm.
 * User: rehellinen
 * Date: 2017/7/23
 * Time: 16:53
 */

namespace Admin\Controller;


class CommentController extends CommonController
{
    public function index () {
        $data = array();
        $page = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
        $pageSize = $_REQUEST['pageSize'] ? $_REQUEST['pageSize'] : 8;

        $commentCount = D("Comment")->getCommentCount($data);
        //获取评论
        $comment = D("Comment")->getComment($data,$page,$pageSize);
        //根据id找到相应的名字
        foreach ($comment as $key=>$value){
            foreach ($value as $key2=>$value2){
                //echo $key2."=>".$value2;
                if($key2=='stu_id'){
                    //此时value2即为stu_id
                    //获取学生的名字
                    $studentName[$value2] = D("Student")->findStudentName($value2);
                    $comment[$key][$key2] = $studentName[$value2];
                }
                if($key2=='class_id'){
                    $list = D("Class")->findClassName($value2);
                    $classGrade[$value2] = $list['grade'];
                    $classSubject[$value2] = $list['subject'];
                    $comment[$key][$key2] = $classGrade[$value2].'-'.$classSubject[$value2];
                }
                if($key2=='tea_id'){
                    $teacherName[$value2] = D("Admin")->findTeacherName($value2);
                    $comment[$key][$key2] = $teacherName[$value2];
                }
            }
        }

        $res = new \Think\Page($commentCount,$pageSize);
        $pageRes = $res->show();
        $this->assign('pageRes', $pageRes);
        $this->assign('comment' , $comment);
        $this->display();
    }

    public function add(){
        if($_POST) {
            if(!isset($_POST['stu_id']) || !$_POST['stu_id']){
                return show(0,'学生名不能为空');
            }
            if(!isset($_POST['tea_id']) || !$_POST['tea_id']){
                return show(0,'老师名不能为空');
            }
            if(!isset($_POST['class_id']) || !$_POST['class_id']){
                return show(0,'课程名不能为空');
            }
            if(!isset($_POST['content']) || !$_POST['content']){
                return show(0,'内容不能为空');
            }
            if($_POST['comment_id']){
                return $this->save($_POST);
            }
            $id = D("Comment")->insert($_POST);
            if($id){
                return show(1,'新增成功',$menuId);
            }

            return show(0,'新增失败',$menuId);
        }else{
            $this->display();
        }
    }

    public function save($data) {
        $id = $data['comment_id'];
        unset($data['comment_id']);
        try{
            $id = D("Comment")->updateCommentById($id , $data);
            if($id === false) {
                return show(0,'更新失败');
            }
            return show(1,'更新成功');
        }catch (Exception $e){
            return show(0,$e->getMessage());
        }

    }


    public function edit() {
        $commentId = $_GET['id'];
        $comment = D('Comment')->findComment($commentId);
        $this->assign('comment',$comment);
        $this->display();
    }


    public function setStatus(){
        try{
            if($_POST){
                $id = $_POST['id'];
                $status = $_POST['status'];
                //执行数据更新操作
                $res = D("Comment")->updateStatusById($id,$status);
                //echo $res;exit;
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
                foreach ($listorder as $commentID => $value) {
                    //执行更新
                    $id = D("Comment")->updateCommentListorder($commentID, $value);
                    if ($id === false) {
                        $errors[] = $commentID;
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