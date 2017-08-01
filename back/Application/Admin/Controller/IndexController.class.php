<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
        //待审核老师数量
        $teaCount = D("Admin")->get1TeacherCount();
        $this->assign('teaCount',$teaCount);

        //课程数量
        $classCount = D("Class")->getClassCount();
        $this->assign('classCount',$classCount);

        //待审核评价数量
        $commentCount = D("Comment")->get1CommentCount();
        $this->assign('commentCount',$commentCount);

        //学生数量
        $studentCount = D("Student")->getStudentCount();
        $this->assign('studentCount',$studentCount);


        $this->display();
    }

    public function content() {
        if($_GET['tea_id']){
            $tea = D('Admin')->getTeacherById($_GET['tea_id']);
            $this->assign('tea',$tea);
        }

        if($_GET['score_id']){
            $score = D('Score')->getScoreById($_GET['score_id']);
            $this->assign('score',$score);
        }

        if($_GET['comment_id']){
            $comment = D('Comment')->getcommentById($_GET['comment_id']);
            $this->assign('comment',$comment);
        }

        if($_GET['class_id']){
            $class = D('Class')->getclassById($_GET['class_id']);
            foreach ($class as $key=>$value){
                if($key=='tea_id'){
                    $teacherName[$value] = D("Admin")->findTeacherName($value);
                    $class[$key] = $teacherName[$value];
                }
            }
            $this->assign('class',$class);
        }
        $this->display();
    }

    public function judge(){
        if($_POST['tea_id']){
            $tea = D('Admin')->getTeacherById($_POST['tea_id']);
            if($tea){
                $this->assign('tea',$tea);
                return show(1,'成功');
            }
            return 0;
        }
    }

}