<?php
include_once"lib/fun.php";
$goodsId = isset($_GET["goodsId"]) && intval($_GET["goodsId"]) ?intval($_GET["goodsId"]):"";
if(!$goodsId){
	msg(2,"参数非法");
	die;
}
$pdo = mysqlInit("mysql", "localhost", "artgallery", "root", "");
$result = $pdo ->query("select * from goods where goods_id='{$goodsId}' ");
$goods = $result->fetchALL(PDO::FETCH_ASSOC);
if(!$goods){
	msg(2,"商品不存在");
	exit;
}
//根据user_id 查询用户名
$user_id = $goods[0]["user_id"];
$result = $pdo->query("select username from user where user_id ='{$user_id}' limit 1");
$user = $result->fetch(PDO::FETCH_ASSOC);
//print_r($user);

//更新浏览次数
$view = $goods[0]["view"]+1;
$result =$pdo->exec("update goods set view={$view} where goods_id = '{$goodsId}' ");


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>M-GALLARY</title>
    <link rel="stylesheet" type="text/css" href="static/css/common.css" />
    <link rel="stylesheet" type="text/css" href="static/css/detail.css" />
</head>
<body class="bgf8">
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
    <div class="section" style="margin-top:20px;">
        <div class="width1200">
            <div class="fl"><img src="<?php echo $goods[0]['pic'];?>" width="720px" height="432px"/></div>
            <div class="fl sec_intru_bg">
                <dl>
                    <dt><?php echo $goods[0]['goods_name']?></dt>
                    <dd>
                        <p>发布人：<span><?php echo $user["username"];?></span></p>
                        <p>发布时间：<span><?php echo date("Y年m月d日",$goods[0]["create_time"]);?></span></p>
                        <p>修改时间：<span><?php echo date("Y年m月d日",$goods[0]["update_time"]);?></span></p>
                        <p>浏览次数：<span><?php echo $goods[0]["view"];?></span></p>
                    </dd>
                </dl>
                <ul>
                    <li>售价：<br/><span class="price"><?php echo $goods[0]["price"];?></span>元</li>
                    <li class="btn"><a href="javascript:;" class="btn btn-bg-red" style="margin-left:38px;">立即购买</a></li>
                    <li class="btn"><a href="javascript:;" class="btn btn-sm-white" style="margin-left:8px;">收藏</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="secion_words">
        <div class="width1200">
            <div class="secion_wordsCon">
                <?php echo$goods[0]["content"];?>
            </div>
        </div>
    </div>
</div>
<div class="footer">
    <p><span>Art-GALLARY</span>©2017 GOOD GOOD STUDY DAY DAY UP</p>
</div>
</div>
</body>
</html>