<!DOCTYPE HTML>
<html>
<meta charset="UTF-8">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" href="css/init.css">
	<link rel="stylesheet" href="css/classify.css">
	<link rel="stylesheet" href="css/done-count.css">
	<link rel="stylesheet" href="css/judge.css">
	<!--modal-->
	<link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<title>Document</title>
</head>
<title>结果反馈</title>
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
		<div class="ansbar">
			<div class="ansbar-desc">
				<div class="row">
					<div class="col-md-4 ">
						<a href="index.php"><span class="glyphicon glyphicon-circle-arrow-left"></span></a>
					</div>
					<div class="col-md-4">
						<?php
						session_start();
						error_reporting(0);
						if(!isset($_SESSION['token'])||!isset($_SESSION['usrid'])||!isset($_SESSION['name'])){
					        exit('illegal access!');
						}else{
						$user_id=$_SESSION['usrid'];
						$nickname=$_SESSION['name'];
						}
						
						$answer=$_POST['answer'];
						$pid=$_POST['pid'];
						$correct=$_POST["correct"];
						include_once"connect2.php";
						if($answer==$correct){
						?><div class="result"><?php echo "恭喜你答对了！";?></div>
						<div class="realanswer"><?php echo "离合格的党员又近了一步"."<br><br>";?></div>
						<?php	$insert_query="insert into user_info(yb_id,nickname,p_id,ifwrongrepository,state,time,answer) values ('$user_id','$nickname','$pid','0','1',now(),'$answer')";
							//$id = mysql_insert_id();
							$re=mysql_query($insert_query,$con);
							if(!$re){
								echo "fail!";
							}	
						}//答案正确
						else{?>
							<div class="result"><?php echo "很遗憾，你答错了！"."<br>";?></div>
							<div class="realanswer"><?php echo "正确答案为：$correct"."<br><br>";?></div>
							<?php $insert_query="insert into user_info(yb_id,nickname,p_id,ifwrongrepository,state,time,answer)values('$user_id','$nickname','$pid','0','0',now(),'$answer')";
							//$id = mysql_insert_id();
							$re=mysql_query($insert_query,$con);
							if(!$re){
								echo "fail!";
							}	
							?>
							<form action="save.php" method="post">
							<input type="hidden" name="id" value="<?php echo $pid;?>"> 
							<input class="submit" type="submit" value="加入错题本"><br><br>
							</form>
							<?php
						}
					?>
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