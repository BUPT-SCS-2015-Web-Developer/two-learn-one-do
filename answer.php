<?php
/**
增加了到达答题内容的锚点
**/
?>	
<?php
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
/*	$dresult = mysql_query("SELECT time FROM user_info WHERE yb_id='$user_id' order by time DESC");
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
	
				$sort=$_GET['choice'];
?>
<!DOCTYPE HTML>
<html>
<meta charset="UTF-8">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" href="css/init.css">
	<link rel="stylesheet" href="css/classify.css">
	<link rel="stylesheet" href="css/self-center.css">
	<link rel="stylesheet"  type='text/css' href="css/self-evaluation.css" />
	<link rel="stylesheet" href="css/answer.css">
	<link rel="stylesheet" href="css/save2.css">
	<!--modal-->
	<link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<title>Document</title>
</head>
<title>答题页面</title>
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

		<a name="ans"></a>
		<div class="ansbar">

<?php

				
				/*所有答过且正确的题目拼接为一个字符串*/
				$select_rights="select p_id from user_info where yb_id='$user_id' and state='1'";
				$rights=mysql_query($select_rights,$con);
				$rs=array();
				while($row = mysql_fetch_array($rights))
				{
					$rs[]=$row['p_id'];
				}
				
				/*判断该类题是否都已经都答过*/
				$select_all="select p_id from allquestion where sort='$sort'";
				$select_result=mysql_query($select_all,$con);
				$flag=0;
				while($row = mysql_fetch_array($select_result))
				{
					if(in_array($row['p_id'],$rs)){
						$flag=0;
					}else{
						$flag=1;
						break;
					}
				}
				if($flag==0){//全部都是做过的题
					die("<div class='ansbar2'><div class='result'>这类题你已经全部做过了</div></div>");
				}
				
			/*保证打答过且正确的题不再次出现*/	
			again:	
				$select_query="select * from allquestion where sort='$sort'";
				$select=mysql_query($select_query,$con);
				$count= mysql_num_rows($select);
				$key=rand(1,$count);
				
				$i=0;
				$arr_select=array();
				while($row = mysql_fetch_array($select))
				{
					$i++;
					
					if($i==$key){
				
						if(in_array((string)$row['p_id'],$rs)){
							goto again;
						}
						$arr_select=$row;
					}
				}
				?>
			<div class="questionbar">
				<div class="questionbody">题目：<?php echo $arr_select["p_body"];?></div>
				<?php
				if($sort=="judge"){
					?>
					<form action="judge.php" method="post">
					<input type="hidden" name="pid" value="<?php echo $arr_select["p_id"];?>"> 
					<input type="hidden" name="correct" value="<?php echo $arr_select["correct_answer"];?>"> 
					<input type="radio" name="answer" value="A">对<br>
					<input type="radio" name="answer" value="B">错<br>
					<input class="submit" type="submit" value="提交答案">
					</form>
				</div>
			<?php
				}
				else if($sort=="text"){
					?>
					<form action="judge.php" method="post">
					<input type="hidden" name="pid" value="<?php echo $arr_select["p_id"];?>"> 
					<input type="hidden" name="correct" value="<?php echo $arr_select["correct_answer"];?>"> 
					<input type="radio" name="answer" value="A" ><?php echo $arr_select["choice1"];?><br>
					<input type="radio" name="answer" value="B"><?php echo $arr_select["choice2"];?><br>
					<input type="radio" name="answer" value="C" ><?php echo $arr_select["choice3"];?><br>
					<input type="radio" name="answer" value="D"><?php echo $arr_select["choice4"];?><br>
					<input class="submit" type="submit" value="提交答案">
					</form>
				</div>
			<?php
				}
				else if($sort=="img"){
					/*$fileres=file_get_contents('$arr_select["img"]');
					header('Content-type: image/jpeg');
					echo $fileres;//显示图片
					*/
					?>
					<img src="<?=$arr_select['img']?>" style=" width:100%" ></img>
					<form action="judge.php" method="post">
					<input type="hidden" name="pid" value="<?php echo $arr_select["p_id"];?>"> 
					<input type="hidden" name="correct" value="<?php echo $arr_select["correct_answer"];?>"> 
					<input type="radio" name="answer" value="A" ><?php echo $arr_select["choice1"];?><br>
					<input type="radio" name="answer" value="B"><?php echo $arr_select["choice2"];?><br>
					<input type="radio" name="answer" value="C" ><?php echo $arr_select["choice3"];?><br>
					<input type="radio" name="answer" value="D"><?php echo $arr_select["choice4"];?><br>
					<input class="submit" type="submit" value="提交答案">
					</form>
				</div>
			<?php	
				}  
			/*	while ($bookInfo = mysql_fetch_array($select)){ 
					echo $bookInfo["p_body"]."<br>";
				}						数组循环输出测试	*/
				else if($sort=="video"){
					?>
					<video src="<?=$arr_select["video"]?> " controls="controls" ></video>
					<form action="judge.php" method="post">
					<input type="hidden" name="pid" value="<?php echo $arr_select["p_id"];?>"> 
					<input type="hidden" name="correct" value="<?php echo $arr_select["correct_answer"];?>"> 
					<input type="radio" name="answer" value="A" ><?php echo $arr_select["choice1"];?><br>
					<input type="radio" name="answer" value="B"><?php echo $arr_select["choice2"];?><br>
					<input type="radio" name="answer" value="C" ><?php echo $arr_select["choice3"];?><br>
					<input type="radio" name="answer" value="D"><?php echo $arr_select["choice4"];?><br>
					<input class="submit" type="submit" value="提交答案">
					</form>
				</div>
			<?php
				}
				else if($sort=="audio"){
					?>
			<!--待加入播放视频部分-->
					<audio src="<?=$arr_select['audio']?> " controls="controls" ></audio>
					
					<form action="judge.php" method="post">
					<input type="hidden" name="pid" value="<?php echo $arr_select["p_id"];?>"> 
					<input type="hidden" name="correct" value="<?php echo $arr_select["correct_answer"];?>"> 
					<input type="radio" name="answer" value="A" ><?php echo $arr_select["choice1"];?><br>
					<input type="radio" name="answer" value="B"><?php echo $arr_select["choice2"];?><br>
					<input type="radio" name="answer" value="C" ><?php echo $arr_select["choice3"];?><br>
					<input type="radio" name="answer" value="D"><?php echo $arr_select["choice4"];?><br>
					<input class="submit" type="submit" value="提交答案">
					</form>
				</div>
					
			<?php
				}
			?>
		</div>	
	</div>
	<div class="col-md-1"></div>
</div>

</body>
</html>