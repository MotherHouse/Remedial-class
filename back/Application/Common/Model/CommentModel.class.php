<?php
/**
 * Created by PhpStorm.
 * User: rehellinen
 * Date: 2017/7/23
 * Time: 16:52
 */

namespace Common\Model;
use Think\Model;


class CommentModel extends Model
{
    private $_db;

    public function __construct()
    {
        $this->_db = M('comment');

    }

    public function getComment($data,$page,$pageSize = 10) {
        $data['status'] = array('neq',-1);
        $offset = ($page -1) * $pageSize;
        //echo $page;exit;
        $list = $this->_db->where($data)->order('listorder desc , comment_id desc')->limit($offset,$pageSize)->select();
        return $list;
    }

    public function insert($data = array()) {
        if(!$data || !is_array($data)) {
            return 0;
        }
        return $this->_db->add($data);
    }

    public function updateCommentById($id , $data){
        if(!$id || !is_numeric($id)){
            throw_exception('ID不合法');
        }
        if(!$data || !is_array($data)){
            throw_exception('更新的数据不合法');
        }
        return $this->_db->where('comment_id='.$id)->save($data);
    }

    public function getCommentCount($data = array()) {
        $data['status'] = array('neq',-1);
        return $this->_db->where($data)->count();
    }

    public function getcommentById($id) {
        return $this->_db->where('comment_id='.$id)->find();
    }

    public function get1CommentCount($data = array()) {
        $data['status'] = 1;
        return $this->_db->where($data)->count();
    }

    public function findComment($id) {
        if(!$id || !is_numeric($id)){
            return array();
        }
        return $this->_db->where('comment_id='.$id)->find();
    }

    public function updateStatusById($id , $status){
        if(!is_numeric($id) || !$id){
            throw_exception("ID不合法");
        }
        //if(!is_numeric($status) || !$status){
          //  throw_exception("状态不合法");
        //}
        //echo $status;exit;
        $data['status'] = $status;
        $data['comment_id'] = $id;
        //print_r($data);exit;
        return $this->_db->where('comment_id='.$id)->save($data);
    }

    public function updateCommentListorder($id , $listorder) {
        if(!$id || !is_numeric($id)) {
            throw_exception('ID不合法');
        }
        $data = array(
            'listorder' => intval($listorder),
        );
        return $this->_db->where('comment_id='.$id)->save($data);
    }


    //小程序用
    public function stuGetComment($stu_id){
    	$result = $this->_db->where("stu_id='$stu_id'")->select();
    	return $result;
    }

    public function teaGetComment($tea_id){
    	$result = $this->_db->where("tea_id='$tea_id'")->select();
    	return $result;
    }

    public function clsGetComment($class_id){
        $result = $this->_db->where("class_id='$class_id'")->select();
        return $result;
    }
}