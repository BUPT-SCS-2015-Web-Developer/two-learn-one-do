<?php
/**
增加了到达选择分类的锚点
**/
?>
<?php

/*
include('header_api_session.php');
include('iapp.php');
include('db_config.php');
*/

/**测试的时候的代码**/
session_start();
$_SESSION['token']	= "xyz";//$access_token;
$_SESSION['usrid']	= "1234567";//$userInfo["info"]['yb_userid'];
$_SESSION['name']	= "abcd";//$userInfo["info"]['yb_username'];
/****/

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" href="css/init.css">
	<link rel="stylesheet" href="css/classify.css">
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
			<div class="col-md-3">
			<div class="btn-group">
			    <div class="btn-group">
					 <button type="button" class="btn btn-lg btn-danger "  onclick=""> <div class="last">“学”</div></button>
					 <button type="button" class="btn btn-danger  btn-lg dropdown-toggle appendix" data-toggle="dropdown">
				     <span class="caret"></span>
					    <span class="sr-only">Toggle Dropdown</span>
					  </button>
					  <ul class="dropdown-menu" role="menu">
					    <li><a href="#" onclick="window.location.href='self-learn.php#list'">自主学习</a></li>
					    <li><a href="#" onclick="window.location.href='choice.php#choice-content'">开始答题</a></li>
						<li><a href="#" onclick="window.location.href='done-count.php#start'">累计答题</a></li>
					    <li><a href="#" onclick="window.location.href='wrong-repository.php#start'">错题库</a></li>
					   
					</ul>
				</div>
			</div>
			</div>
			
			<div class="col-md-3">
			<div class="btn-group">
					 <button type="button" class="btn btn-lg btn-danger "  onclick=""> <div class="last">“做”</div></button>
					 <button type="button" class="btn btn-danger  btn-lg dropdown-toggle appendix" data-toggle="dropdown">
				     <span class="caret"></span>
					    <span class="sr-only">Toggle Dropdown</span>
					  </button>
					  <ul class="dropdown-menu" role="menu">
					    
					    <li><a href="#" onclick="window.location.href='self-evaluation.php#start'">每周自评</a></li>
						<li><a href="#" onclick="window.location.href='evaluation-result.php#start'">自评结果</a></li>
						<li><a href="#" onclick="window.location.href='sxhb.html#start'">撰写心得</a></li>
						 <li><a href="#" onclick="window.location.href='canguan.php#start'">查看心得</a></li>
						 <li><a href="#" onclick="window.location.href='mine.php#start'">我的心得</a></li>
					</ul>
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


