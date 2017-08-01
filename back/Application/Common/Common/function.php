<?php
/**
 * Created by PhpStorm.
 * User: rehellinen
 * Date: 2017/7/22
 * Time: 13:05
 */

function show($status,$message,$data=array()){
    $result = array(
        'status' => $status,
        'message' => $message,
        'data' => $data,
    );
    exit(json_encode($result));
}

function getMenuStatus($type) {
    return $type == 1 ? '正常':'关闭';
}

function getActive($navc) {
    $c = strtolower(CONTROLLER_NAME);
    $a = strtolower(ACTION_NAME);
    //strtolower把所有字符转化为小写
    if(strtolower($navc) == $c && 'index'==$a) {
        return 'class="active"';
    }
    return '';
}

function getActive1($nava) {
    $a = strtolower(ACTION_NAME);
    if(strtolower($nava) == $a) {
        return 'class="active"';
    }
    return '';
}

function getLoginUsername() {
    return $_SESSION['adminUser']['tea_name'] ? $_SESSION['adminUser']['tea_name'] : '';
}

function getStatus($status){
    return $status == 1 ? '审核未通过':'审核通过';
}

function getStuTea($type){
    return $type == 1 ? '未结课' : '已结课';
}

function getMethod($method) {
    return $method==1?'到店':'上门';
}
//小程序用
function api_return($data=array()){
    echo(json_encode($data));
}