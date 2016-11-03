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
		$timequery=$DBH->prepare('SELECT time FROM self_learn WHERE yb_id=? AND step_id=?');
		$timequery->bindParam(1,$user_id);
		$timequery->bindParam(2,$step_id);
		$timequery->execute();
		$time=$timequery->fetch(PDO::FETCH_ASSOC);
	}catch(PDOException $e){
		die($e->getMessage());
	}
	$t=array();
	if($time){
		$time=intval($time['time']);//300s
		$t['s']=$time%(60);
		$t['m']=(($time-$t['s'])/60)%60;
		$t['h']=($time-$t['m']*60-$t['s'])/(60*60);
	}else{
		$t['h']=$t['m']=$t['s']=0;
		try{
			$timestart=$DBH->prepare('INSERT INTO self_learn (yb_id,nickname,step_id,time)  VALUES (?,?,?,0)');
			$timestart->bindParam(1,$user_id);
			$timestart->bindParam(2,$nickname);
			$timestart->bindParam(3,$step_id);
			$timeinitstart=$timestart->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	echo json_encode($t);
?>