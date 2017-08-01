<?php
/**
 * Created by PhpStorm.
 * User: rehellinen
 * Date: 2017/7/23
 * Time: 16:42
 */

namespace Common\Model;
use Think\Model;


class ScoreModel extends Model
{
    private $_db='';

    public function __construct()
    {
        $this->_db = M('subject_score');
    }

    public function getScore($data,$page,$pageSize) {
        $offset = ($page -1 ) * $pageSize;
        $data['status'] = array('neq',-1);
        $ret = $this->_db->where($data)->order('listorder desc , id desc')->limit($offset,$pageSize)->select();
        return $ret;
    }

    public function getScoreById($id) {
        $ret = $this->_db->where('id='.$id)->find();
        return $ret;
    }

    public function getScoreCount($data) {
        $data['status'] = array('neq',-1);
        return $this->_db->where($data)->count();
    }

    public function insert($data = array()) {
        if(!$data || !is_array($data)) {
            return 0;
        }
        return $this->_db->add($data);
    }

    public function find($id) {
        if(!$id || !is_numeric($id)){
            return array();
        }
        return $this->_db->where('id='.$id)->find();
    }

    public function updateScoreById($id , $data) {
        if(!$id || !is_numeric($id)){
            throw_exception('ID不合法');
        }
        if(!$data || !is_array($data)){
            throw_exception('更新的数据不合法');
        }
        return $this->_db->where('id='.$id)->save($data);
    }

    public function updateStatusById($id , $status){
        if(!is_numeric($id) || !$id){
            throw_exception("ID不合法");
        }
        if(!is_numeric($status) || !$status){
            throw_exception("状态不合法");
        }

        $data['status'] = $status;
        $data['id'] = $id;
        return $this->_db->where('id='.$id)->save($data);
    }

    public function updateListorderById($id,$listorder){
        if(!$id || !is_numeric($id)) {
            throw_exception('ID不合法');
        }
        $data = array(
            'listorder' => intval($listorder),
        );
        return $this->_db->where('id='.$id)->save($data);
    }

    //小程序用
    public function getClsingInfo($stu_id){
        $ret = $this->_db->where("stu_id='$stu_id' AND stu_tea_type='1'")->select();
        return $ret;
    }

    public function getClsedInfo($stu_id){
        $ret = $this->_db->where("stu_id='$stu_id' AND stu_tea_type='0'")->select();
        return $ret;
    }

    public function getClsingStuInfo($class_id){
        $ret = $this->_db->where("class_id='$class_id' AND stu_tea_type='1'")->select();
        return $ret;
    }

    public function getStu($tea_id){
        $ret = $this->_db->where("tea_id='$tea_id' AND stu_tea_type='1'")->order('')->select();
        return $ret;
    }

}