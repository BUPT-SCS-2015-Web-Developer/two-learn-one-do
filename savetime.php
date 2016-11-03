<?php
//最好是加密传输
	$step_id=intval($_POST['step_id']);
	session_start();
	include("connect.php");
	if(!isset($_SESSION['token'])||!isset($_SESSION['usrid'])||!isset($_SESSION['name'])){
        exit('illegal access!');
	}else{
	$user_id=$_SESSION['usrid'];
	$nickname=$_SESSION['name'];
	}
	$h=intval($_POST['h']);
	$m=intval($_POST['m']);
	$s=intval($_POST['s']);
	$t=60*60*$h+60*$m+$s;
	try{
		$update=$DBH->prepare('UPDATE self_learn SET time=? WHERE yb_id=? AND step_id=?');
		$update->bindParam(1,$t);
		$update->bindParam(2,$user_id);
		$update->bindParam(3,$step_id);
		$update->execute();
	}catch(PDOException $e){
		die($e->getMessage());
	}
	
	?>