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
		$timequery=$DBH->prepare('SELECT time FROM alllearncontent WHERE step_id=? AND part_id=0');
		$timequery->bindParam(1,$step_id);
		$timequery->execute();
		$time=$timequery->fetch(PDO::FETCH_ASSOC);
	}catch(PDOException $e){
		die($e->getMessage());
	}
	$t=array();
	$time=intval($time['time']);//300s
	$t['s']=$time%(60);
	$t['m']=(($time-$t['s'])/60)%60;
	$t['h']=($time-$t['m']*60-$t['s'])/(60*60);
	echo json_encode($t);

?>