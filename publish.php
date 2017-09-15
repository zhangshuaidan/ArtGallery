<?php
include_once"lib/fun.php";
//判断是否已经登录
if(!checkLogin()){
	msg(2,"请登录","login.php");
}
$user = $_SESSION["user"]["username"];

if(!empty($_POST["name"])){
	$pdo = mysqlInit("mysql", "localhost", "artgallery", "root", "");
	$name = mysql_real_escape_string(trim($_POST['name']));
	$price = intval($_POST["price"]); 
	$des = mysql_real_escape_string(trim($_POST['des']));
	$content = mysql_real_escape_string(trim($_POST["content"]));
	$userId = $_SESSION["user"]["user_id"];
	$now = time();
	//在入库前对商品做一些验证，
	$result = $pdo->query("select count(goods_id) as total from 
	goods where goods_name ='{$name}'");
	$row = $result->fetchALL(PDO::FETCH_ASSOC);
//	print_r($row);
	if($row[0]['total']>0){
		msg(2,"商品名称已存在,请重新输入");
		exit;
	}
	//接收上传文件
	$file = $_FILES['file'];
//		print_r($file);	 // [tmp_name]表示上传图片的临时文件的路径和文件名
	$pic=imgUpload($file,$userId);
//	echo $pic;
	$result=$pdo->exec("insert into goods (goods_name,price,des,content,pic,user_id,
	create_time,update_time,view) values ('{$name}','{$price}','{$des}',
	'{$content}','{$pic}','{$userId}','{$now}','{$now}',0)");
	if($result){
		msg(1,"操作成功","user.php");
	}else{
		msg(2,"上传失败");
	}
	
	
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>添加画品</title>
	<link href="static/css/common.css" type="text/css" rel="stylesheet">
    <link href="static/css/add.css" type="text/css" rel="stylesheet">
</head>
<body>
	<div class="header">
			<div class="logo f1">
				<img src="static/img/logo.png">
			</div>
			<div class="auth fr">
				<ul>
					<li><a href="#"><span>管理员：<?php echo $user; ?></span></a></li>
					<li><a href="#">退出</a></li>
				</ul>
			</div>
	</div>
        <div class="content">
		<div class="addwrap">
			<div class="addl fl">
				<header>添加画品</header>
				<form name="publish-form" id="publish-form" action="publish.php" method="post"
                  enctype="multipart/form-data">
                <div class="additem">
                    <label id="for-name">画品名称</label><input type="text" name="name" id="name" placeholder="请输入画品名称">
                </div>
                <div class="additem">
                    <label id="for-price">价值</label><input type="text" name="price" id="price" placeholder="请输入画品价值">
                </div>
                <div class="additem">
                    <!-- 使用accept html5属性 声明仅接受png gif jpeg格式的文件                -->
                    <label id="for-file">画品</label><input type="file" accept="image/png,image/gif,image/jpeg" id="file" name="file">
                </div>
                <div class="additem textwrap">
                    <label class="ptop" id="for-des">画品简介</label><textarea id="des" name="des"
                                                                           placeholder="请输入画品简介"></textarea>
                </div>
                <div class="additem textwrap">
                    <label class="ptop" id="for-content">画品详情</label>
                    <div style="margin-left: 120px" id="container">
                        <textarea id="content" name="content"></textarea>
                    </div>

                </div>
                <div style="margin-top: 20px">
                    <button type="submit">发布</button>
                </div>

            </form>
			</div>
			<div class="addr fr">
				<img src="static/img/index_banner.png">
			</div>
		</div>
		
	</div>
    <div class="footer">
	    <p><span>Art-GALLARY</span>©2017 GOOD GOOD STUDY DAY DAY UP</p>
	</div>

</body>
<script src="static/js/jquery-1.10.2.min.js"></script>
<script src="static/js/layer/layer.js"></script>
<script src="static/js/kindeditor/kindeditor-all-min.js"></script>
<script src="static/js/kindeditor/lang/zh_CN.js"></script>
<script>
    var K = KindEditor;
    K.create('#content', {
        width      : '475px',
        height     : '400px',
        minWidth   : '30px',
        minHeight  : '50px',
        items      : [
            'undo', 'redo', '|',
            'justifyleft', 'justifycenter', 'justifyright', 'clearhtml',
            'fontsize', 'forecolor', 'bold',
            'italic', 'underline', 'link', 'unlink', '|'
            , 'fullscreen'
        ],
        afterCreate: function () {
            this.sync();
        },
        afterChange: function () {
            //编辑器失去焦点时直接同步，可以取到值
            this.sync();
        }
    });
</script>
<script type="text/javascript">
	$(function(){
		$("#publish-form").submit(function(){
			var name = $("#name").val(),
				price = $("#price").val(),
				file = $("#file").val(),
				des = $("#des").val(),
				content = $("#content").val();
			if(name.length <= 0 || name.length>30){
				layer.tips('商品名应在1-30字符之内','#name',{time:2000,tips:2});
				$('#name').focus();
				return false;
			}
			//验证为正整数
            if (!/^[1-9]\d{0,8}$/.test(price)) {
                layer.tips('请输入最多9位正整数', '#price', {time: 2000, tips: 2});
                $('#price').focus();
                return false;
            }
            
            if (file == '' || file.length <= 0) {
                layer.tips('请选择图片', '#file', {time: 2000, tips: 2});
                $('#file').focus();
                return false;
            }
            
            if (des.length <= 0 || des.length >= 100) {
                layer.tips('画品简介应在1-100字符之内', '#content', {time: 2000, tips: 2});
                $('#des').focus();
                return false;
            }
            
            if (content.length <= 0) {
                layer.tips('请输入画品详情信息', '#container', {time: 2000, tips: 3});
                $('#content').focus();
                return false;
            }
            return true;
            
		})
	})
</script>
</html>