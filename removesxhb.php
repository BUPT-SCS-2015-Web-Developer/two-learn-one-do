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
	$flag=$_POST['id'];
	try{	
		$remove_sxhb=$DBH->prepare("delete from thought_report where flag='$flag'");	
		$remove_sxhb->execute();
	}catch(PDOException $e){
		die($e->getMessage());
	}
	echo "success";
?>