<?php
$type = isset($_GET['type'])&& in_array($_GET['type'], array(1,2))?$_GET["type"]:2;
$msg  =  isset($_GET['msg'])&& !empty($_GET['msg'])?$_GET['msg']:"操作失败";
$url  =  isset($_GET['url'])&& !empty($_GET['url'])?$_GET['url']:null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $msg;?></title>
    <link rel="stylesheet" type="text/css" href="static/css/common.css" />
    <link rel="stylesheet" type="text/css" href="static/css/done.css" />
</head>
<body>
    <div class="header">
        <div class="logo f1">
            <img src="static/img/logo.png">
        </div>
        <div class="auth fr">
            <ul>
                <li><a href="#">登录</a></li>
                <li><a href="#">注册</a></li>
            </ul>
        </div>
    </div>
    <div class="content">
        <div class="center">
            <div class="image_center">
      
            		<?php if($type == 1){?>
            		<span class="smile_face">:)</span> 
            		<?php }else{$type==2?>
            		<span class="smile_face">:( </span>  
            		<?php }?>
            </div>
            <div class="code"><?php echo $msg;?></div>
            <div class="jump">
                页面在<strong id="time" style="...">3</strong>秒 后跳转
            </div>
        </div>
        
    </div>
    <div class="footer">
	    <p><span>Art-GALLARY</span>©2017 GOOD GOOD STUDY DAY DAY UP</p>
	</div>
</body>
<script src="static/js/jquery-1.10.2.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
	
	$(function(){
		var time = 3;
		var url = "<?php echo $url;?>"||null;//js读取php变量
		setInterval(function(){
			if(time > 1){
				time--;
				$("#time").html(time);
			}else{
				$("#time").html("0");
				if(url){
					location.href = url;
				}else{
					history.go(-1);
				}
			}
		},1000)
	})
</script>
</html>