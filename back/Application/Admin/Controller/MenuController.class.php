<?php
/**
 * Created by PhpStorm.
 * User: rehellinen
 * Date: 2017/7/23
 * Time: 11:15
 */

namespace Admin\Controller;
use Think\Controller;
use Think\Exception;


class MenuController extends CommonController
{
    public function index() {
        $data = array();
        //分页
        $page = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
        $pageSize = $_REQUEST['pageSize'] ? $_REQUEST['pageSize'] :8;

        //获取菜单
        $menus = D("Menu")->getMenuTable($data,$page,$pageSize);
        $menusCount = D("Menu")->getMenuCount($data);


        $res = new \Think\Page($menusCount,$pageSize);
        $pageRes = $res->show();
        //传递菜单
        $this->assign('pageRes' , $pageRes);
        $this->assign('menus' , $menus);
        $this->display();
    }

    public function add() {

        if($_POST){
            if(!isset($_POST['name']) || !$_POST['name']){
                return show(0,'菜单名不能为空');
            }
            if(!isset($_POST['c']) || !$_POST['c']){
                return show(0,'控制器名不能为空');
            }
            if(!isset($_POST['f']) || !$_POST['f']){
                return show(0,'方法名不能为空');
            }

            //通过是否有menu_id来判断是添加还是编辑
            if($_POST['menu_id']) {
                return $this->save($_POST);
            }

            //add方法插入成功返回主键id
            $menuID = D("Menu")->insertMenu($_POST);
            if($menuID) {
                return show(1,'新增成功');
            }
            return show(0,'新增失败');
        }else{

            $this->display();
        }

    }

    public function edit() {
        $menuId = $_GET['id'];
        $menu = D("Menu")->editShow($menuId);
        $this->assign('menus',$menu);
        $this->display();
    }

    public function save($data) {
        $menuId = $data['menu_id'];
        unset($data['menu_id']);
        try{
            $id = D("Menu")->updateMenuById($menuId,$data);
            if($id === false) {
                return show(0,'更新失败');
            }
            return show(1,'更新成功');
        }catch(Exception $e){
            return show(0,$e->getMessage());
        }

    }

    public function setStatus() {
        if($_POST) {
            $id = $_POST['id'];
            $status = $_POST['status'];

            $res = D("Menu")->updateStatusById($id,$status);
            if($res){
                return show(1,'操作成功');
            }else{
                return show(0,'操作失败');
            }
        }

        return show(0,'没有提交数据');
    }

    public function listorder() {
        $listorder = $_POST['listorder'];
        $jumpUrl = $_SERVER['HTTP_REFERER'];
        $errors = array();
        if($listorder){
            foreach($listorder as $menuId=>$value) {
                $id = D("Menu")->updateMenuListorderById($menuId,$value);
                if($id===false){
                    $errors[] = $menuId;
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