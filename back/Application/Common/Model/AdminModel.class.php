<?php
/**
 * Created by PhpStorm.
 * User: rehellinen
 * Date: 2017/7/22
 * Time: 14:27
 */
namespace Common\Model;
use Think\Model;

class AdminModel extends Model {
    private $_db;

    public function __construct(){
        $this->_db = M('teacher');
    }

    public function getTeacherById($id) {
        if(!$id || !is_numeric($id)){
            throw_exception('ID不合法');
        }
        return $this->_db->where('tea_id='.$id)->find();
    }

    //登录时根据用户名获取用户信息
    public function getAdminByUsername($username){
        $ret = $this->_db->where('tea_name="'.$username.'"')->find();
        return $ret;
    }

    public function findTeacherName($id) {
        if(!$id || !is_numeric($id)){
            return array();
        }
        $list = $this->_db->where('tea_id='.$id)->find();
        return $list['tea_name'];
    }

    public function insert($data = array()) {
        if(!$data || !is_array($data)){
            return 0;
        }
        return $this->_db->add($data);
    }

    public function editShow($id) {
        if(!$id || !is_numeric($id)) {
            return array();
        }
        return $ret = $this->_db->where('tea_id='.$id)->find();
    }

    public function insertTeacher($data = array()) {
        if(!$data || !is_array($data)) {
            return 0;
        }
        return $this->_db->add($data);
    }

    public function updateTeacherById($id,$data) {
        if(!$id || !is_numeric($id)){
            throw_exception('ID不合法');
        }
        if(!$data || !is_array($data)){
            throw_exception('更新的数据不合法');
        }
        return $this->_db->where('tea_id='.$id)->save($data);
    }

    public function getTeacherCount($data = array()){
        $data['root'] = array('neq',1);
        $data['status'] = array('neq',-1);
        return $this->_db->where($data)->count();
    }

    public function get1TeacherCount($data = array()){
        $data['root'] = array('neq',1);
        $data['status'] = 1;
        return $this->_db->where($data)->count();
    }

    public function updateStatusById($id , $type) {
        if(!$id || !is_numeric($id)){
            throw_exception('ID不合法');
        }
        $data['status'] = $type;
        $res = $this->_db->where('tea_id='.$id)->save($data);
        return $res;
    }

    public function updateTeacherListorderById($id,$listorder) {
        if(!$id || !is_numeric($id)) {
        throw_exception('ID不合法');
    }
        $data = array(
            'listorder' => intval($listorder),
        );
        return $this->_db->where('tea_id='.$id)->save($data);
    }

    public function getTeacherTp($data,$page,$pageSize) {
        $offset = ($page - 1) * $pageSize;

        $data['root']=array('neq',1);
        $data['status']=array('neq',-1);
        $ret = $this->_db->where($data)->order('listorder desc , tea_id desc')->limit($offset,$pageSize)->select();
        return $ret;
    }


    //小程序用
    public function getTeacher() {
        $data['root']=array('neq',1);
        $ret = $this->_db->where($data)->select();
        return $ret;
    }

    public function getTeacherInfo($tea_id) {//在小程序时登录时用teaid查询并加载“个人信息”
        $ret = $this->_db->where("tea_id='$tea_id'")->find();
        return $ret;
    }

    public function deleteTeacher($tea_id) {
        $ret = $this->_db->where("tea_id='$tea_id'")->delete();
        return $ret;
    }

    public function getAdminByAdminId($id) {
        return $res = $this->_db->where('tea_id='.$id)->find();
    }
}