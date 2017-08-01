/**
 * Created by rehellinen on 2017/7/22.
 */

var login = {
    check : function () {
        //获取登录页面中的用户名和密码
        var username = $('input[name="loginUser"]').val();
        var password = $('input[name="loginPwd"]').val();

        //判断用户名、密码是否为空
        if(!username) {
            dialog.error('用户名不能为空');
        }
        if(!password) {
            dialog.error('密码不能为空');
        }

        //用 $.post 执行异步请求
        var url = "index.php?m=admin&c=Login&a=check";
        var data = {'username':username , 'password':password};
        $.post(url,data,function(result){
            if(result.status == 0){
                return dialog.error(result.message);
            }
            if(result.status == 1){
                return dialog.success(result.message,'index.php?m=admin&c=index');
            }
        },'JSON');
    }
};


