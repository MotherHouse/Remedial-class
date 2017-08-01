<?php
/**
 * Created by PhpStorm.
 * User: rehellinen
 * Date: 2017/7/25
 * Time: 14:06
 */

namespace Admin\Controller;
use Think\Controller;

class CommonController extends Controller
{
       public function __construct()
        {
            parent::__construct();
            $this->_init();
        }

        private function _init() {
            $user = session("adminUser");
            if($user && is_array($user)){
                $res =  true;
            }else{
                $res =  false;
            }

            if(!$res){
                $this->redirect('/admin.php?c=login');
            }
        }

}