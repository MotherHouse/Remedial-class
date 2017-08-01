<?php
/**
 * Created by PhpStorm.
 * User: rehellinen
 * Date: 2017/7/24
 * Time: 11:07
 */

namespace Common\Model;
use Think\Model;


class OpenidModel extends Model
{
    private $_db;

    public function __construct()
    {
        $this->_db = M('openid');
    }

    public function findOpenid($openid) {
        $data['openid'] = $openid;
        $result = $this->_db->where($data)->find();
        return $result;
    }

    public function insertOpenid($openid) {
        $data['openid'] = $openid;
        $data['type'] ="0";
        $result = $this->_db->add($data);
        $result = $this->_db->where($data)->find();
        return $result;
    }

    public function changeType($openid,$type,$people_id) {//用于修改openid表中的type
        //$data['openid'] = $openid;//
        $data['type'] =$type;
        $data['people_id']=$people_id;
        $result = $this->_db->where("openid='$openid'")->setField($data);
        return $result;
    }

    //tp框架用

    public function updateStatusById($id , $type) {
        if(!$id || !is_numeric($id)){
            throw_exception('ID不合法');
        }
        if(!$id || !is_numeric($id)){
            throw_exception('类型不合法');
        }
        if($type == 2){
            $data['type'] = $type;
            $res = $this->_db->where('people_id='.$id.' AND type=1')->save($data);
        }
        if($type == 1){
            $data['type'] = $type;
            $res = $this->_db->where('people_id='.$id.' AND type=2')->save($data);
        }
        return $res;
    }




}