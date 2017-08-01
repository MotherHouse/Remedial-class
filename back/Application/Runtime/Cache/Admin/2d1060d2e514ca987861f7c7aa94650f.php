<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>后台管理</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="Public/assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="Public/assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="Public/assets/css/light-bootstrap-dashboard.css" rel="stylesheet"/>


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="Public/assets/css/demo.css" rel="stylesheet" />


    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="Public/assets/css/pe-icon-7-stroke.css" rel="stylesheet" />

    <script src="Public/assets/js/jquery-1.10.2.js" type="text/javascript"></script>
    <script src="Public/uploadify/jquery.uploadify.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="Public/uploadify/uploadify.css">

</head>
<body>
<?php
 $menu = D("Menu")->getMenu(); $username = getLoginUsername(); foreach($menu as $key=>$value) { if($value['c'] == 'admin' && $username != 'admin'){ unset($menu[$key]); } if($value['c'] == 'menu' && $username != 'admin'){ unset($menu[$key]); } if($value['c'] == 'comment' && $username != 'admin'){ unset($menu[$key]); } if($value['c'] == 'class' && $username != 'admin'){ unset($menu[$key]); } if($value['c'] == 'student' && $username != 'admin'){ unset($menu[$key]); } } ?>


<div class="wrapper">
    <div class="sidebar" data-color="red" data-image="Public/assets/img/sidebar-5.jpg">

        <!--   you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple" -->

        <div class="sidebar-wrapper">
            <div class="logo">
                <a href="#" class="simple-text">
                    后台管理
                </a>
            </div>

            <ul class="nav">
                <li>
                    <a href="admin.php">
                        <i class="pe-7s-graph"></i>
                        <p>首页</p>
                    </a>
                </li>
                <li class="active">
                    <a href="admin.php?c=admin&a=personal">
                        <i class="pe-7s-user"></i>
                        <p>个人中心</p>
                    </a>
                </li>
                <?php if(is_array($menu)): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li>
                        <a href="admin.php?c=<?php echo ($menu["c"]); ?>&a=<?php echo ($menu["a"]); ?>">
                            <i class="pe-7s-note2"></i>
                            <p><?php echo ($menu["name"]); ?></p>
                        </a>
                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
    </div>

<div class="main-panel">
    <nav class="navbar navbar-default navbar-fixed">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">后台管理</a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-left">

                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="admin.php?c=login&a=loginout">
                            <p>退出登录</p>
                        </a>
                    </li>
                    <li class="separator hidden-lg hidden-md"></li>
                </ul>
            </div>
        </div>
    </nav>


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6">

                        <form class="form-horizontal" id="rehe-form">
                            <div class="form-group">
                                <label for="inputname" class="col-sm-2 control-label">学生名字:</label>
                                <div class="col-sm-5">
                                    <input type="text" name="stu_id" class="form-control" id="inputname" placeholder="请填写学生名字" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">老师名字:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="tea_id" id="inputPassword3" placeholder="请填写老师名字">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">课程名字:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="class_id" id="inputPassword3" placeholder="请填写课程名字">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">分数:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="score" id="inputPassword3" placeholder="请填写分数">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">分数备注:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="score_remark" id="inputPassword3" placeholder="请填写分数备注">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="button" class="btn btn-info btn-fill" onclick="formSubmit()">提交</button>
                                </div>
                            </div>


                        </form>


                    </div>

                </div>
            </div>

            <script>
                var SCOPE = {
                    //点击提交后跳转的链接
                    'add_url' : 'admin.php?c=score&a=add',
                    //成功后返回的链接
                    'success_url' : 'admin.php?c=score'
                }
            </script>

            <footer class="footer">
    <div class="container-fluid">
        <nav class="pull-left">
            <ul>
                <li>
                    <a href="#">
                        联系我们
                    </a>
                </li>
            </ul>
        </nav>
        <p class="copyright pull-right">
            &copy; <script>document.write(new Date().getFullYear())</script> four people
        </p>
    </div>
</footer>

</div>
</div>


</body>

<!--   Core JS Files   -->
<script src="Public/assets/js/bootstrap.min.js" type="text/javascript"></script>

<!--  Checkbox, Radio & Switch Plugins -->
<script src="Public/assets/js/bootstrap-checkbox-radio-switch.js"></script>

<!--  Charts Plugin -->
<script src="Public/assets/js/chartist.min.js"></script>

<!--  Notifications Plugin    -->
<script src="Public/assets/js/bootstrap-notify.js"></script>


<!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
<script src="Public/assets/js/light-bootstrap-dashboard.js"></script>

<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
<script src="Public/assets/js/demo.js"></script>

<!-- 弹出层插件 -->
<script src="Public/js/dialog.js"></script>
<script src="Public/js/dialog/layer.js"></script>

<!-- 通用函数 -->
<script src="Public/js/common.js"></script>
</html>