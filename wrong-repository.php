<?php
	session_start();
	if(!isset($_SESSION['token'])||!isset($_SESSION['usrid'])||!isset($_SESSION['name'])){
        exit('illegal access!');
	}else{
	$user_id=$_SESSION['usrid'];
	$nickname=$_SESSION['name'];
	}
	include("connect.php");
	header("Content-Type:text/html;charset=utf8");
	try{
		$query=$DBH->prepare("SELECT p_id FROM user_info WHERE ifwrongrepository=1 AND yb_id=?");
		$query->bindParam(1,$user_id);
		$query->execute();
		$wrong_flags=$query->fetchAll(PDO::FETCH_ASSOC);

	}catch(PDOException $e){
		die($e->getMessage());
		//die("Database Error.Please contact supporter!");
	}
	$result=array();
	foreach($wrong_flags as $oneitem){
		$result[]=$oneitem['p_id'];
	//	echo $oneitem['p_id']."<br>";
	}
	
	$string=implode("','",$result);
	$strings = "('".$string."')";//('57a78a42a60f9','57a78ae1b54cc','57a78b5271191')
	try{
		$sql=$DBH->prepare("SELECT * FROM allquestion WHERE p_id in $strings");
		$sql->execute();
		$questions=$sql->fetchAll(PDO::FETCH_ASSOC);
	//	var_dump($questions);
	}catch(PDOException $e){
		die($e->getMessage());
		//die("Database Error.Please contact supporter!");
	}
?>
<html>
<head>
<?php $title='错题库'; include("head.php");?>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<link rel="stylesheet" href="css/init.css">
	<link rel="stylesheet" href="css/classify.css">
	<link rel="stylesheet" href="css/self-center.css">
	<link rel="stylesheet"  type='text/css' href="css/self-evaluation.css" />
	<link rel="stylesheet" href="css/wrong-repository.css">


	<title>Document</title>
	<script src="js/remove.js"></script>
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
		<?php
		$i=1;
		foreach($questions as $question){
			?>
			<div class="questionbar">
				<div class="questionbody"><?=$question['p_body']?></div>
				<div class="questionchoice">A.<?=$question['choice1']?></div>
				<div class="questionchoice">B.<?=$question['choice2']?></div>
				<?php if($question['choice3']){?>
				<div class="questionchoice">C.<?=($question['choice3']?$question['choice3'].'</br>':'')?></div>
				<?php }?>
				<?php if($question['choice4']){?>
				<div class="questionchoice">D.<?=($question['choice4']?$question['choice4'].'</br>':'')?></div>
				<?php }?>
				<?php if($question['audio']){?>
				<div class="questionaudio"><audio src="<?=$question['audio']?> " controls="controls" ></audio></div>
				<?php
				}
				?>
				<?php if($question['video']){?>
				<div class="questionvideo"><video src="<?=$question['video']?> " controls="controls" ></video></div>
				<?php
				}
				?>
				<?php if($question['img']){?>
				<div class="questionimg"><img style="width:100%" src="<?=$question['img']?> " ></img></div>
				<?php
				}
				?>
				
				<div class="correctanswer">正确答案：<?=$question['correct_answer']?></div>
				<div class="remove" id=<?=$question['p_id']?>>删除</div>
				</br></br>
			</div>
			<?php
			$i++;
		}
	?>	
	</div>
	</div>
	<div class="col-md-1"></div>
</div>
	
</body>
</html>