<?php
//用于加载审核通过老师“个人中心”以及里面的信息
//确认用户type为2才能调用此控制器,传入tea_id
namespace Admin\Controller;
use Think\Controller;

class WxLoadTeaPersonalController extends Controller
{
	public function loadTeaInfo(){//传入老师id获取老师详细信息
		$result = D('Admin')->getTeacherInfo($_GET["tea_id"]);
    	$result['pwd']="*";
    	api_return($result);
	}

	public function loadTeaClsNeedCheckList(){
	    //直接获得teaid
	 	$result = D('Class')->getTeaNeedcheckCls($_GET['tea_id']);
	 	//去课程库里找对应信息，class_type为0待审核的课
	 	$i=1;
	 	foreach($result as $k=>$val){    
		   $rt_data["class{$i}"]=$val;
		   $i++;   
		} 
		//去class表中获取课程信息
	 	api_return($rt_data);
	}

	public function loadTeaClsingList(){
	    //直接获得teaid
	 	$result = D('Class')->getTeaingCls($_GET['tea_id']);
	 	//去课程库里找对应信息，class_type为1正在上的课
	 	$i=1;
	 	foreach($result as $k=>$val){    
		   $rt_data["class{$i}"]=$val;
		   $i++;   
		} 
		//去class表中获取课程信息
	 	api_return($rt_data);
	}

	public function loadTeaClsedList(){
	    //直接获得teaid
	 	$result = D('Class')->getTeaedCls($_GET['tea_id']);//正在上的课
	 	//去课程库里找对应信息，class_type为-1完结的课
	 	$i=1;
	 	foreach($result as $k=>$val){    
		   $rt_data["class{$i}"]=$val;
		   $i++;   
		} 
		//去class表中获取课程信息
	 	api_return($rt_data);
	}

	public function loadTeaClsFailList(){
	    //直接获得teaid
	 	$result = D('Class')->getTeaFailCls($_GET['tea_id']);//正在上的课
	 	//去课程库里找对应信息，class_type为-2审核失败的课
	 	$i=1;
	 	foreach($result as $k=>$val){    
		   $rt_data["class{$i}"]=$val;
		   $i++;   
		} 
		//去class表中获取课程信息
	 	api_return($rt_data);
	}

	public function teaAddCls(){//传入tea_id和课程信息，插入class数据库
		$db_data['tea_id']=$_GET['tea_id'];
		$db_data['class_time']=$_GET['class_time'];
		$db_data['method']=$_GET['method'];//0为上门，1为到店
		$db_data['number_limit']=$_GET['number_limit'];
		$db_data['grade']=$_GET['grade'];
		$db_data['subject']=$_GET['subject'];
		//fee需要赞叔添加，添加完了type从0改为1
		$class_id = D('Class')->insertCls($db_data);
		if($class_id){
			$rt_data['status']="1";
			$rt_data['message']="add success,wait for check!";
		}else{
			$rt_data['status']="0";
			$rt_data['message']="add fail!";
		}
		api_return($rt_data);
	}

	public function loadTeaClsingStuInfo(){//点击一门正在上的课，显示出选了这门课的学生
		//传入课程id，返回学生信息
	 	$result = D('Score')->getClsingStuInfo($_GET['class_id']);//获取正在上的课的学生
	 	$i=1;
	 	foreach($result as $k=>$val){  
			$result1 = D('Student')->getStudentInfo($val['stu_id']);  
			$rt_data["student{$i}"]=$result1;
			$i++;   
		} 
		//去stuinfo表中获取课程信息
	 	api_return($rt_data);
	}

	public function loadTeaStuList(){//传入tea_id,返回学生信息
		$result = D('Score')->getStu($_GET['tea_id']);
		$i=1;
	 	foreach($result as $k=>$val){  
			$result1 = D('Student')->getStudentInfo($val['stu_id']);  
			$rt_data["student{$i}"]=$result1;
			$i++;   
		} 
		//去stuinfo表中获取x信息
	 	api_return($rt_data);
	}

	public function loadComment(){//传入老师id获取其评论
    	$result = D('Comment')->teaGetComment($_GET["tea_id"]);
    	$i=1;
    	foreach($result as $k=>$val){   
		   $rt_data["comment{$i}"]=$val;
		   $i++;   
		}
    	api_return($rt_data);
    }
}