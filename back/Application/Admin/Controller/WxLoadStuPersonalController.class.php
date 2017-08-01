<?php
//用于加载学生“个人中心”以及里面的信息
//确认用户type为1才能调用此控制器,传入stu_id
namespace Admin\Controller;
use Think\Controller;
class WxLoadStuPersonalController extends Controller
{	

    public function loadStuInfo() {
        //直接获得stuid		
     	$result = D('Student')->getStudentInfo($_GET['stu_id']);
     	//去学生库找信息
     	api_return($result);
    }



    public function loadStuClsingList() {
	    //直接获得stuid
	 	$result = D('Score')->getClsingInfo($_GET['stu_id']);//正在上的课
	 	//去分数库里找对应信息
	 	$i=1;
	 	foreach($result as $k=>$val){    
		   //echo "class".$i.":".$val["class_id"]."<br>";
		   $result1 = D('Class')->getClsInfo($val["class_id"]); //循环中获取课程id
		   $result1[0]["score"] = $val["score"];
		   $rt_data["class{$i}"]=$result1;
		   $i++;   
		} 
		//去class表中获取课程信息
	 	api_return($rt_data);
    }

    public function loadStuClsedList() {
	    //直接获得stuid
	 	$result = D('Score')->getClsedInfo($_GET['stu_id']);//上完的课
	 	//去分数库里找对应课程id
		$i=1;
	 	foreach($result as $k=>$val){    
		   //echo "class".$i.":".$val["class_id"]."<br>";
		   $result1 = D('Class')->getClsInfo($val["class_id"]); //循环中获取课程id
		   $result1[0]["score"] = $val["score"];
		   $rt_data["class{$i}"]=$result1;
		   $i++;   
		} 
		//去class表中获取课程信息
	 	api_return($rt_data);
    }

    public function loadClsInfo(){//传入课程id，从class表中获取课程详细信息
    	$result = D('Class')->getClsInfo($_GET['class_id']);
    	api_return($result);
    }



    public function loadTeaingList() {//传入stu_id	
	 	$result = D('Score')->getClsingInfo($_GET['stu_id']);//正在上的课
	 	//去分数库里找对应信息
	 	$i=1;
	 	foreach($result as $k=>$val){    
		   //echo "class".$i.":".$val["class_id"]."<br>";
		   $result1 = D('Admin')->getTeacherInfo($val["tea_id"]); //循环中获取老师id，传入tea表获取老师信息
		   //$result1["pwd"]="*";老师密码安全？
		   $rt_data["teacher{$i}"]=$result1;
		   $i++;   
		} 	
		//去admin表中获取课程信息
	 	api_return($rt_data);
    }

    public function loadTeaedList() {//传入stu_id	
	    $people_id=$_GET['stu_id'];//$result['people_id'];
	    //直接获得stuid
	 	$result = D('Score')->getClsedInfo($people_id);//正在上的课
	 	//去分数库里找对应信息
	 	$i=1;
	 	foreach($result as $k=>$val){    
		   //echo "class".$i.":".$val["class_id"]."<br>";
		   $result1 = D('Admin')->getTeacherInfo($val["tea_id"]); //循环中获取老师id，传入tea表获取老师信息
		   $rt_data["teacher{$i}"]=$result1;
		   $i++;   
		} 	
		//去admin表中获取课程信息
	 	api_return($rt_data);
    }

    public function loadTeaInfo(){//传入老师id获取老师详细信息
    	$result = D('Admin')->getTeacherInfo($_GET["tea_id"]);
    	$result['pwd']="*";
    	api_return($result);
    }

    public function loadComment(){//传入学生id获取其评论
    	$result = D('Comment')->stuGetComment($_GET["stu_id"]);
    	$i=1;
    	foreach($result as $k=>$val){   
		   $rt_data["comment{$i}"]=$val;
		   $i++;   
		}
    	api_return($rt_data);
    }
}
