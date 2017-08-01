<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>登录</title>
    <!-- Bootstrap -->
    <link href="Public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container ">
    <form method="post" enctype="multipart/form-data" class="form-signin">
        <h3 class="form-signin-heading">请登录</h3>
        <br />
        <label for="loginUser">用户名</label>
        <input type="text" class="form-control" name="loginUser" id="loginUser" placeholder="请输入用户名"  required autofocus>
        <br />
        <label for="loginPwd">密码</label>
        <input type="password" class="form-control" name="loginPwd" id="loginPwd" placeholder="请输入密码" enquire>
        <br />
        <button class="btn btn-lg btn-primary btn-block" type="button" onclick="login.check()">登录</button>
    </form>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="Public/bootstrap/js/bootstrap.min.js"></script>
<script src="Public/js/admin/login.js"></script>
<script src="Public/js/dialog/layer.js"></script>
<script src="Public/js/dialog.js"></script>
</body>
</html>