<?php
/**
 * Created by PhpStorm.
 * User: rehellinen
 * Date: 2017/7/23
 * Time: 19:50
 */

namespace Common\Model;
use Think\Model;


class ClassModel extends Model
{
    private $_db;
    public function __construct()
    {
        $this->_db = M('class_info');
    }

    public function getClass($data,$page,$pageSize = 10) {
        $data['status'] = array('neq',-1);
        $offset = ($page -1) * $pageSize;
        $list = $this->_db->where($data)->order('listorder desc , class_id desc')->limit($offset,$pageSize)->select();
        return $list;
    }

    public function findClassName($id) {
        if(!$id || !is_numeric($id)){
            return array();
        }
        $list = $this->_db->where('class_id='.$id)->find();
        return $list;
    }

    public function getclassById($id){
        return $this->_db->where('class_id='.$id)->find();
    }

    public function insert($data = array()) {
        if(!$data || !is_array($data)) {
            return 0;
        }
        return $this->_db->add($data);
    }

    public function updateClassById($id , $data){
        if(!$id || !is_numeric($id)){
            throw_exception('ID不合法');
        }
        if(!$data || !is_array($data)){
            throw_exception('更新的数据不合法');
        }
        return $this->_db->where('class_id='.$id)->save($data);
    }

    public function getClassCount($data = array()) {
        $data['status'] = array('neq',-1);
        return $this->_db->where($data)->count();
    }

    public function findClass($id) {
        if(!$id || !is_numeric($id)){
            return array();
        }
        return $this->_db->where('class_id='.$id)->find();
    }

    public function updateStatusById($id , $status){
        if(!is_numeric($id) || !$id){
            throw_exception("ID不合法");
        }
        $data['status'] = $status;
        $data['class_id'] = $id;
        return $this->_db->where('class_id='.$id)->save($data);
    }



    public function updateCommentListorder($id , $listorder) {
        if(!$id || !is_numeric($id)) {
            throw_exception('ID不合法');
        }
        $data = array(
            'listorder' => intval($listorder),
        );
        return $this->_db->where('class_id='.$id)->save($data);
    }



    //小程序用
    public function getClsInfo($data) {//传入课程id
        $result = $this->_db->where("class_id='$data'")->select();
        return $result;
    }

    public function getTeaNeedcheckCls($tea_id){
        $result = $this->_db->where("tea_id='$tea_id' AND class_type='0'" )->select();
        return $result;
    }

    public function getTeaingCls($tea_id){
        $result = $this->_db->where("tea_id='$tea_id' AND class_type='1'" )->select();
        return $result;
    }

    public function getTeaedCls($tea_id){
        $result = $this->_db->where("tea_id='$tea_id' AND class_type='-1'" )->select();
        return $result;
    }

    public function getTeaFailCls($tea_id){
        $result = $this->_db->where("tea_id='$tea_id' AND class_type='-2'" )->select();
        return $result;
    }

    public function insertCls($data = array()) {
        if(!$data || !is_array($data)) {
            return 0;
        }
        return $this->_db->add($data);
    }
    
    public function getCls($condition) {
        $result = $this->_db->where("$condition")->select();
        return $result;
    }
}