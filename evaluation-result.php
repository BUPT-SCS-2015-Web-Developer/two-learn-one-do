<?php
	session_start();
	include("connect.php");
	header("Content-Type:text/html;charset=utf8");
	if(!isset($_SESSION['token'])||!isset($_SESSION['usrid'])||!isset($_SESSION['name'])){
        exit('illegal access!');
	}else{
	$user_id=$_SESSION['usrid'];
	$nickname=$_SESSION['name'];
	}
	try{
		$query=$DBH->prepare('SELECT * FROM self_evaluation WHERE yb_id=? order by time DESC');
		$query->bindParam(1,$user_id);
		$query->execute();
		$evaluated_date=$query->fetch(PDO::FETCH_ASSOC);
		$query=$DBH->prepare('SELECT * FROM self_evaluation WHERE yb_id=? ');
		$query->bindParam(1,$user_id);
		$query->execute();
		$all_evaluated=$query->fetchAll(PDO::FETCH_ASSOC);
		//var_dump(count($all_evaluated));
		//var_dump($evaluated_date);
	}catch(PDOException $e){
		die($e->getMessage());
		//die("Database Error.Please contact supporter!");
	}

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" href="css/init.css">
	<link rel="stylesheet" href="css/classify.css">
	<link rel="stylesheet" href="css/done-count.css">
	
	<!--modal-->
	<link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<title>Document</title>
</head>
<body>
	<div class="container-fluid toanswerbg">
	<div class="col-md-1"></div>
	<div class="col-md-10"> 
		<div class="content">
			<div class="jumpton">
				<img src="img/pictitle.jpg" class="jumptonlg"  style="height:'100%'">
				<img src="img/loginphone.jpg" class="jumptonxs" style="height:'100%'" >
			</div>	
			
		</div>
		<div class="line">
			<div class="row row2">
			<div class="col-md-3"></div>
				<div class="col-md-2">
					<div class="btn-group">
					  <button type="button" class="btn btn-lg btn-warning wider" onclick="window.location.href='self-learn.php'">自主学习</button>
					</div>
				</div>
				<div class="col-md-2">
					<div class="btn-group">
					  <button type="button" class="btn btn-lg btn-primary wider" onclick="window.location.href='choice.php'">开始答题</button>
					</div>
				</div>
				<div class="col-md-2">
					<div class="btn-group">
					  <button type="button" class="btn btn-lg btn-danger "  onclick="window.location.href='self-center.php'"> <div class="last">个人中心</div></button>
					  <button type="button" class="btn btn-danger  btn-lg dropdown-toggle appendix" data-toggle="dropdown">
					    <span class="caret"></span>
					    <span class="sr-only">Toggle Dropdown</span>
					  </button>
					  <ul class="dropdown-menu" role="menu">
					    <li><a href="#" onclick="window.location.href='done-count.php'">累计答题</a></li>
					    <li><a href="#" onclick="window.location.href='wrong-repository.php'">错题库</a></li>
					    <li><a href="#" onclick="window.location.href='self-evaluation.php'">每周自评</a></li>
						<li><a href="#" onclick="window.location.href='evaluation-result.php'">自评结果</a></li>
					  </ul>
					</div>
				</div>
				<div class="col-md-3"></div>
			</div>	
		</div>
		<div class="ansbar">
			<div class="ansbar-desc">
				<div class="row">
					<div class="col-md-4 ">
						<a href="javascript:history.back();"><span class="glyphicon glyphicon-circle-arrow-left"></span></a>
					</div>
					<div class="col-md-4">
						<h1>你一共自评过<?=count($all_evaluated)?>次</h1>
						<h4>你上一次的自评日期为<?=$evaluated_date['time']?></h4>
						<h3>你上次的自评结果为：a类<?=$evaluated_date['aspect1']?>颗星</h3>
						<h3>你上次的自评结果为：b类<?=$evaluated_date['aspect2']?>颗星</h3>
						<h3>你上次的自评结果为：c类<?=$evaluated_date['aspect3']?>颗星</h3>
						<h3>你上次的自评结果为：d类<?=$evaluated_date['aspect4']?>颗星</h3>
					</div>
					<div class="col-md-4"></div>
				</div>
			</div>
		</div>	
	</div>
	<div class="col-md-1"></div>
</div>
</body>
</html>