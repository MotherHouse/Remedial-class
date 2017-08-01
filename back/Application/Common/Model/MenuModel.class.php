<?php
/**
 * Created by PhpStorm.
 * User: rehellinen
 * Date: 2017/7/23
 * Time: 15:01
 */

namespace Common\Model;
use Think\Model;


class MenuModel extends Model
{
    private $_db = '';

    public function __construct(){
        $this->_db = M('menu');
    }

    public function getMenu(){
        $data['status'] = array('neq',-1);
        $list = $this->_db->where($data)->order('listorder desc , menu_id desc')->select();
        return $list;
    }

    public function getMenuTable($data,$page,$pageSize=10){
        $offset = ($page - 1) * $pageSize;
        $data['status'] = array('neq',-1);
        $list = $this->_db->where($data)->order('listorder desc , menu_id desc')->limit($offset,$pageSize)->select();
        return $list;
    }

    public function getMenuCount($data = array()){
        $data['status'] = array('neq',-1);
        return $this->_db->where($data)->count();
    }

    public function insertMenu($data=array()) {
        if(!$data || !is_array($data)){
            return 0;
        }
        return $this->_db->add($data);
    }

    public function editShow($id) {
        if(!$id || !is_numeric($id)) {
            return array();
        }
        return $this->_db->where('menu_id='.$id)->find();
    }

    public function updateMenuById($id , $data) {
        if(!$id || !is_numeric($id)) {
            throw_exception('ID不合法');
        }

        if(!$data || !is_array($data)) {
            throw_exception('更新的数据不合法');
        }
        return $this->_db->where('menu_id='.$id)->save($data);
    }

    public function updateStatusById($id,$status) {
        if(!is_numeric($id) || !$id) {
            throw_exception("ID不合法");
        }
        if(!is_numeric($status) || !$status) {
            throw_exception("状态不合法");
        }

        $data['status'] = $status;
        return $this->_db->where('menu_id='.$id)->save($data);
    }

    public function updateMenuListorderById($id,$listorder) {
        if(!$id || !is_numeric($id)) {
            throw_exception('ID不合法');
        }

        $data = array(
            'listorder' =>intval($listorder)
        );
        return $this->_db->where('menu_id='.$id)->save($data);
    }

}