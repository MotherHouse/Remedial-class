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
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">评价管理</h4>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <form id="singcms-listorder">
                                    <table class="table table-hover table-striped singcms-table">
                                        <thead>
                                        <th width="14">排序</th>
                                        <th>ID</th>
                                        <th>学生名字</th>
                                        <th>老师名字</th>
                                        <th>课程名字</th>
                                        <th>评分</th>
                                        <th>内容</th>
                                        <th>时间</th>
                                        <th>状态</th>
                                        <th>操作</th>
                                        </thead>
                                        <tbody>
                                        <?php if(is_array($comment)): $i = 0; $__LIST__ = $comment;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$comment): $mod = ($i % 2 );++$i;?><tr>
                                                <td>
                                                    <input size="2" type="text" name="listorder[<?php echo ($comment["comment_id"]); ?>]" value="<?php echo ($comment["listorder"]); ?>"/>
                                                </td>
                                                <td><?php echo ($comment["comment_id"]); ?></td>
                                                <td><?php echo ($comment["stu_id"]); ?></td>
                                                <td><?php echo ($comment["tea_id"]); ?></td>
                                                <td><?php echo ($comment["class_id"]); ?></td>
                                                <td><?php echo ($comment["stars"]); ?></td>
                                                <td>
                                                    <a id="rehe-detail"  attr-commentid="<?php echo ($comment["comment_id"]); ?>">
                                                    点我查看
                                                    </a>
                                                </td>
                                                <td><?php echo ($comment["comment_time"]); ?></td>
                                                <td><span attr-status="<?php if($comment['status'] == 1): ?>0<?php else: ?>1<?php endif; ?>"
                                                    attr-id="<?php echo ($comment["comment_id"]); ?>" class="sing_cursor singcms-on-off" id="singcms-on-off">
                                                    <?php echo (getStatus($comment["status"])); ?>
                                                    </span></td>
                                                <td>
                                                    <span class="pe-7s-close-circle "id="rehe-delete" attr-id="<?php echo ($comment["comment_id"]); ?>" attr-message="删除"></span>
                                                </td>
                                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                                        </tbody>
                                    </table>

                                    <nav>
                                        <ul>
                                            <?php echo ($pageRes); ?>
                                        </ul>
                                    </nav>
                                    <div>
                                        <button onclick="listorder()" id="button-listorder" type="button" class="btn btn-info btn-fill" style="margin: 10px 15px;padding:7px 15px">更新排序</button>
                                    </div>
                                </form>
                            </div>
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
        'skip_url' : 'admin.php?c=comment&a=add',
        'edit_url' :'admin.php?c=comment&a=edit',
        'set_status_url' : 'admin.php?c=comment&a=setStatus',
        'listorder_url' : 'admin.php?c=comment&a=listorder'
    }
</script>

<!--   Core JS Files   -->
<script src="Public/assets/js/jquery-1.10.2.js" type="text/javascript"></script>
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


<script src="Public/js/dialog/layer.js"></script>
<script src="Public/js/dialog.js"></script>
<script src="Public/js/common.js"></script>

</html>