<?php
	$id=$_POST['r_id'];
	session_start();

	if(!isset($_SESSION['token'])||!isset($_SESSION['usrid'])||!isset($_SESSION['name'])){
        exit('illegal access!');
	}else{
	$user_id=$_SESSION['usrid'];
	$nickname=$_SESSION['name'];
	}
	include("connect.php");
	try{
		$query=$DBH->prepare("UPDATE user_info SET ifwrongrepository='0' WHERE yb_id=? AND p_id = '$id'");
		$query->bindParam(1,$user_id);
		$query->execute();
		echo "success";
	}catch(PDOException $e){
		die($e->getMessage());
		//die("Database Error.Please contact supporter!");
	}
	
	
?>