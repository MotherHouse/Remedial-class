<?php
namespace Admin\Controller;
use Think\Controller;

class WxLoadClsController extends Controller
{
	public function loadCls(){//按筛选条件加载课程
		$db_data['full']=$_GET['full'];
		$db_data['grade']=$_GET['grade'];
		$db_data['subject']=$_GET['subject'];
		$db_data['method']=$_GET['method'];
		$condition = "";
		foreach ($db_data as $key => $value) {
			if(!''==$value){
				$condition = $condition.$key."='".$value."' AND ";
			}
		}
		$condition=substr($condition, 0, -4);
		$result = D('Class')->getCls($condition);	
		api_return($result);		
	}

	public function chooseCls(){//点击课程查看详细信息,传入class_id
		$result = D('Class')->getClsInfo($_GET['class_id']);	
		api_return($result);
	}

	public function loadClsComment(){//点击课程里的评论查看,传入class_id
		$result = D('Comment')->clsGetComment($_GET["class_id"]);
    	$i=1;
    	foreach($result as $k=>$val){   
		   $rt_data["comment{$i}"]=$val;
		   $i++;   
		}
    	api_return($rt_data);
	}

	public function buyCls(){//在支付成功后（获得支付接口返回结果）调用
		//需要传入stu_id,class_id,remain_hour
		//需要更新score表、class表
		//操作数据库要上锁！stu_count为临界资源！
	}


}