<?php
    session_start();
	header("Content-Type:text/html;charset=utf8");
	if(!isset($_SESSION['token'])||!isset($_SESSION['usrid'])||!isset($_SESSION['name'])){
        exit('illegal access!');
	}else{
	$user_id=$_SESSION['usrid'];
	$nickname=$_SESSION['name'];
	}
	include("connect.php");
?>
<?php
	$text=$_POST['text'];
	try{	
		$commit_sxhb=$DBH->prepare("INSERT INTO thought_report(yb_id,yb_nickname,time,content) values ('$user_id','$nickname',now(),?)");	
		$commit_sxhb->bindParam(1,$text);
		$commit_sxhb->execute();
	}catch(PDOException $e){
		die($e->getMessage());
	}
	echo "success";
?>