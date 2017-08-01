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
 $menu = D("Menu")->getMenu(); $index = 'index'; $personal = 'personal'; $username = getLoginUsername(); foreach($menu as $key=>$value) { if($value['c'] == 'admin' && $username != 'admin'){ unset($menu[$key]); } if($value['c'] == 'menu' && $username != 'admin'){ unset($menu[$key]); } if($value['c'] == 'comment' && $username != 'admin'){ unset($menu[$key]); } if($value['c'] == 'class' && $username != 'admin'){ unset($menu[$key]); } if($value['c'] == 'student' && $username != 'admin'){ unset($menu[$key]); } } ?>


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
                <li <?php echo (getActive($index)); ?>>
                    <a href="admin.php">
                        <i class="pe-7s-graph"></i>
                        <p>首页</p>
                    </a>
                </li>
                <li <?php echo (getActive1($personal)); ?>>
                    <a href="admin.php?c=admin&a=personal">
                        <i class="pe-7s-user"></i>
                        <p>个人中心</p>
                    </a>
                </li>
                <?php if(is_array($menu)): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li <?php echo (getActive($menu["c"])); ?>>
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
        <h4>个人中心</h4>
        <div class="row">
            <div class="col-lg-6">

                <form class="form-horizontal" id="rehe-form">
                    <div class="form-group">
                        <label for="inputname" class="col-sm-2 control-label">名字:</label>
                        <div class="col-sm-5">
                            <input type="text" name="tea_name" class="form-control" id="inputname"  value="<?php echo ($loginUser["tea_name"]); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputname" class="col-sm-2 control-label">性别:</label>
                        <div class="col-sm-5">
                            <input type="text" name="tea_gender" class="form-control" id="inputname"  value="<?php echo ($loginUser["tea_gender"]); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputname" class="col-sm-2 control-label">年龄:</label>
                        <div class="col-sm-5">
                            <input type="text" name="tea_age" class="form-control" id="inputname"  value="<?php echo ($loginUser["tea_age"]); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputname" class="col-sm-2 control-label">图片:</label>
                        <div class="col-sm-5">
                            <input id="file_upload"  type="file" multiple="true" >
                            <img style="" id="upload_org_code_img" src="<?php echo ($loginUser["tea_photo_url"]); ?>" width="150" height="150">
                            <input id="file_upload_image" name="tea_photo_url" type="hidden" multiple="true" value="<?php echo ($loginUser["tea_photo_url"]); ?>">
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">自我介绍:</label>
                        <div class="col-sm-5">
                            <textarea  rows = "5" class="form-control" name="self_introduction" id="inputPassword3"><?php echo ($loginUser["self_introduction"]); ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">联系方式:</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="tea_tel" id="inputPassword3"  value="<?php echo ($loginUser["tea_tel"]); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">密码:</label>
                        <div class="col-sm-5">
                            <input type="password" class="form-control" name="pwd" id="inputPassword3"  value="<?php echo ($loginUser["pwd"]); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-info btn-fill" onclick="formSubmit()">更新</button>
                        </div>
                    </div>

                    <input type="hidden" name="tea_id"  value="<?php echo ($loginUser["tea_id"]); ?>">
                </form>
            </div>

        </div>
    </div>
</div>


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
            &copy; <script>document.write(new Date().getFullYear())</script> wanglian four people
        </p>
    </div>
</footer>

</div>
</div>


</body>



<script>
    var SCOPE = {
        'add_url' : 'admin.php?c=admin&a=add',
        'success_url' : 'admin.php?c=admin&a=personal',
        'ajax_upload_image_url' : 'admin.php?c=image&a=ajaxuploadimage',
        'ajax_upload_swf' : 'Public/uploadify/uploadify.swf',
    }
</script>

<script src="Public/js/dialog/layer.js"></script>
<script src="Public/js/dialog.js"></script>

<script src="Public/js/common.js"></script>
<script src="Public/js/image.js"></script>
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

</html>