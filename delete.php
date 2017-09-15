
<?php
 include_once"lib/fun.php";
 if(!checkLogin()){
 	msg(2,"请登录","login.php");	
 }

 
// echo $_GET["pic"];
   $pic =$_GET["pic"];
   $pic =substr($pic,28);
// echo "<br/>".$pic;



 $goodsId = isset($_GET["goodsId"]) && intval($_GET["goodsId"])?intval($_GET["goodsId"]):"";
 if(empty($goodsId)){
 	msg(2,"参数非法","user.php");
 }
 $pdo = mysqlInit("mysql", "localhost", "artgallery", "root", "");
 $result = $pdo->query("select count(goods_id) as total from goods where goods_id={$goodsId}");
 $row = $result->fetchALL(PDO::FETCH_ASSOC);
 if($row[0]['total']==0){
 	msg(2,"商品不存在","user.php");
 }
 $result = $pdo->exec("delete from goods where goods_id ={$goodsId} limit 1");
 if($result&& unlink($pic)){
 	msg(1,"删除成功","user.php");
 }else{
 	msg(2,"删除失败","user.php");
 }

?>