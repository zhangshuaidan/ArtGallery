<?php
include_once"lib/fun.php";
if(!checkLogin()){
	msg(2,"请登录","login.php");
	exit;
}
$userId = $_SESSION["user"]["user_id"];
if(!empty($_POST["name"])){
	$goodsId=intval($_POST["goodsId"]);
//	echo $goodsId;
}
$pdo = mysqlInit("mysql", "localhost", "artgallery", "root", "");

$name = mysql_real_escape_string(trim($_POST["name"]));
$price = intval($_POST["price"]); 
$des = mysql_real_escape_string(trim($_POST["des"]));
$content = mysql_real_escape_string(trim($_POST["content"]));
//var_dump($_FILES["file"]);

if($_FILES["file"]["size"]>0){
	$pic =imgUpload($_FILES["file"], $userId);
}else{
	$pic = "";
}
//var_dump((bool)$pic);
//$result = $pdo->exec("")
$now = time();
if(!$pic){
	$sql = "update goods set goods_name='{$name}',
	price='{$price}',des='{$des}',content='{$content}',update_time='{$now}' where goods_id='{$goodsId}' ";
}else{
	$sql = "update goods set goods_name='{$name}',
	price='{$price}',des='{$des}',content='{$content}',pic='{$pic}',update_time='{$now}' where goods_id='{$goodsId}' ";
}
$result = $pdo->exec($sql);

if($result){
	msg(1,"操作成功","user.php");
	exit;
}else{
	msg(2,"操作失败","edit.php");
	exit;
}

?>