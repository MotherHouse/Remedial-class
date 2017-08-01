<?php
/**
 * Created by PhpStorm.
 * User: rehellinen
 * Date: 2017/7/22
 * Time: 10:53
 */

namespace Admin\Controller;
use Think\Controller;

class LoginController extends Controller
{
    public function index() {
        if(session('adminUser')){
            $this->redirect('admin.php?c=index&a=index');
        }
        $this->display();
    }
    public function check() {
        $username = $_POST['username'];
        $password = $_POST['password'];
        if(!trim($username)){
            return show(0,'用户名不能为空');
        }
        if(!trim($password)){
            return show(0,'密码不能为空');
        }
        $ret = D('Admin')->getAdminByUsername($username);
        if(!$ret){
            return show(0,'该用户不存在');
        }
        if($ret['pwd'] != $password){
            return show(0,'密码错误');
        }
        session('adminUser',$ret);
        return show(1,'登录成功');
    }

    public function loginout() {
        session('adminUser',null);
        $this->redirect('admin.php?c=Login& a=index');
    }


}