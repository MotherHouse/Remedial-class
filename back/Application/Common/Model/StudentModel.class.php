<?php
/**
 * Created by PhpStorm.
 * User: rehellinen
 * Date: 2017/7/23
 * Time: 20:02
 */

namespace Common\Model;
use Think\Model;


class StudentModel extends Model
{
    private $_db;
    public function __construct()
    {
        $this->_db = M('stu_basic_info');
    }

    public function getStudent($data,$page,$pageSize = 10) {
        $data['status'] = array('neq',-1);
        $offset = ($page -1) * $pageSize;
        $list = $this->_db->where($data)->order('listorder desc , stu_id desc')->limit($offset,$pageSize)->select();
        return $list;
    }

    public function getStudentCount($data = array()) {
        $data['status'] = array('neq',-1);
        return $this->_db->where($data)->count();
    }

    public function insert($data = array()) {
        if(!$data || !is_array($data)) {
            return 0;
        }
        return $this->_db->add($data);
    }

    public function updateStudentById($id , $data){
        if(!$id || !is_numeric($id)){
            throw_exception('ID不合法');
        }
        if(!$data || !is_array($data)){
            throw_exception('更新的数据不合法');
        }
        return $this->_db->where('stu_id='.$id)->save($data);
    }



    public function findStudent($id) {
        if(!$id || !is_numeric($id)){
            return array();
        }
        return $this->_db->where('stu_id='.$id)->find();
    }

    public function findStudentName($id) {
        if(!$id || !is_numeric($id)){
            return array();
        }
        $list = $this->_db->where('stu_id='.$id)->find();
        return $list['stu_name'];
    }

    public function updateStatusById($id , $status){
        if(!is_numeric($id) || !$id){
            throw_exception("ID不合法");
        }
        if(!is_numeric($status) || !$status){
            throw_exception("状态不合法");
        }
        $data['status'] = $status;
        $data['stu_id'] = $id;
        return $this->_db->where('stu_id='.$id)->save($data);
    }

    public function updateStudentListorder($id , $listorder) {
        if(!$id || !is_numeric($id)) {
            throw_exception('ID不合法');
        }
        $data = array(
            'listorder' => intval($listorder),
        );
        return $this->_db->where('stu_id='.$id)->save($data);
    }


    //小程序用
    public function getStudentInfo($stu_id) {
        $result = $this->_db->where("stu_id='$stu_id'")->find();
        return $result;
    }
    
    public function insertStudent($data = array()) {
        if(!$data || !is_array($data)) {
            return 0;
        }
        return $this->_db->add($data);
    }

    public function deleteStudent($stu_id){
        $result = $this->_db->where("stu_id='$stu_id'")->delete();
        return $result;
    }


}