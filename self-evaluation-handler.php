<?php
	session_start();
	if(!isset($_SESSION['token'])||!isset($_SESSION['usrid'])||!isset($_SESSION['name'])){
        exit('illegal access!');
	}else{
	$user_id=$_SESSION['usrid'];
	$nickname=$_SESSION['name'];
	}
	
	include("connect.php");
    $point1=$_POST['point1'];
    $point2=$_POST['point2'];
    $point3=$_POST['point3'];
    $point4=$_POST['point4'];
	
	/*存入数据库*/
	try{
	$query=$DBH->prepare('INSERT into self_evaluation (yb_id,nickname,aspect1,aspect2,aspect3,aspect4,time) VALUES (?,?,?,?,?,?,now())');
	$query->bindParam(1,$user_id);
	$query->bindParam(2,$nickname);
	$query->bindParam(3,$point1);
	$query->bindParam(4,$point2);
	$query->bindParam(5,$point3);
	$query->bindParam(6,$point4);
	$query->execute();
	}catch(PDOException $e){
		echo "fail";
		//die($e->getMessage());
		die("Database Error.Please contact supporter!");
	}
	echo "success";
?>