
<?php
/**
增加了到达选择分类的锚点
**/
/**
增加了到达答题内容的锚点
**/
    error_reporting(0);
	session_start();
	if(!isset($_SESSION['token'])||!isset($_SESSION['usrid'])||!isset($_SESSION['name'])){
        exit('illegal access!');
	}else{
	$user_id=$_SESSION['usrid'];
	$nickname=$_SESSION['name'];
	}
	include("connect2.php");
	header("Content-Type:text/html;charset=utf8");
	/*保证这是今天第一次答题*/	
	/*$dresult = mysql_query("SELECT time FROM user_info WHERE yb_id='$user_id' order by time DESC");
	$drow = mysql_fetch_row($dresult);
	if(!$drow){
		$todaydone=0;
	}else{
		$date = date_create($drow[0]);
		if(date("Y-m-d")==date_format($date, 'Y-m-d')){
			$todaydone=1;
		//die ("<p>你今天已经答过题了</p>");
		}else{
			$todaydone=0;
		}
		
	}*/
	
	?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" href="css/init.css">
	<link rel="stylesheet" href="css/classify.css">
	<link rel="stylesheet" href="css/save2.css">
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
		<a name="choice-content"></a>
		<div class="ansbar" >
			<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-6">
					<div class="ansbar-content">
						<div class="ansbar-content-title">小易为您准备了这些分类~</div>
						<div class="btn-group">
						  <button type="button" class="btn btn-warning">下拉可选择分类</button>
						  <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
						    <span class="caret"></span>
						    <span class="sr-only">Toggle Dropdown</span>
						  </button>
						  <ul class="dropdown-menu" role="menu">
						    <li><a href="answer.php?choice=text#ans">文本题</a></li>
						    <li><a href="answer.php?choice=img#ans">图像题</a></li>
						    <li><a href="answer.php?choice=audio#ans">音频题</a></li>
						    <li><a href="answer.php?choice=video#ans">视频题</a></li>
						    <li><a href="answer.php?choice=judge#ans">判断题</a></li>
						  </ul>
						</div>
					</div>
				</div>
				<div class="col-md-3"></div>
			</div>
		</div>	
	</div>
	<div class="col-md-1"></div>
</div>
</body>
</html>

