<?php
	$step_id=$_POST['step_id'];
	session_start();
	include("connect.php");
	if(!isset($_SESSION['token'])||!isset($_SESSION['usrid'])||!isset($_SESSION['name'])){
        exit('illegal access!');
	}else{
	$user_id=$_SESSION['usrid'];
	$nickname=$_SESSION['name'];
	}
	try{
		$contentquery=$DBH->prepare('SELECT * FROM alllearncontent WHERE part_id>0  AND step_id=? order by part_id ASC');
		$contentquery->bindParam(1,$step_id);
		$contentquery->execute();
		$content=$contentquery->fetchall(PDO::FETCH_ASSOC);
	}catch(PDOException $e){
		die($e->getMessage());
	}
	echo json_encode($content);
?>