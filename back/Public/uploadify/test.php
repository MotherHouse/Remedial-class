<!DOCTYPE html>
<html>
<head>
	<title>test</title>
<link rel="stylesheet" type="text/css" href="uploadify.css" />
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="jquery.uploadify-3.1.min.js"></script>


</head>
<body>
	<input type="file" name="file_upload" id="file_upload" />


<script type="text/javascript">
$(function() {
   $('#file_upload').uploadify({
       'swf'      : 'uploadify.swf',// uploadify.swf 文件的相对JS文件的路径
        'uploader' : 'uploadify.php'//后台处理程序的相对路径
        // 更多的参数
   	 });
});
	</script>
</body>
</html>
