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
		$query=$DBH->prepare("SELECT * FROM user_info WHERE state=1 AND yb_id=?");
		$query->bindParam(1,$user_id);
		$query->execute();
		$all_right=$query->fetchAll(PDO::FETCH_ASSOC);
		$right_s=count($all_right);
		$query=$DBH->prepare("SELECT * FROM user_info WHERE state=0 AND yb_id=?");
		$query->bindParam(1,$user_id);
		$query->execute();
		$all_wrong=$query->fetchAll(PDO::FETCH_ASSOC);
		$wrong_s=count($all_wrong);
		
		$judge=$DBH->prepare("SELECT * FROM allquestion WHERE sort='judge'");
		$judge->execute();
		$judges=$judge->fetchAll(PDO::FETCH_ASSOC);
		$njudge=count($judges);
		
		$text=$DBH->prepare("SELECT * FROM allquestion WHERE sort='text'");
		$text->execute();
		$texts=$text->fetchAll(PDO::FETCH_ASSOC);
		$ntext=count($texts);
		
		$audio=$DBH->prepare("SELECT * FROM allquestion WHERE sort='audio'");
		$audio->execute();
		$audios=$audio->fetchAll(PDO::FETCH_ASSOC);
		$naudio=count($audios);
		
		$video=$DBH->prepare("SELECT * FROM allquestion WHERE sort='video'");
		$video->execute();
		$videos=$video->fetchAll(PDO::FETCH_ASSOC);
		$nvideo=count($videos);
		
		$img=$DBH->prepare("SELECT * FROM allquestion WHERE sort='img'");
		$img->execute();
		$imgs=$img->fetchAll(PDO::FETCH_ASSOC);
		$nimg=count($imgs);
		
	}catch(PDOException $e){
		die($e->getMessage());
		//die("Database Error.Please contact supporter!");
	}
	$alls=$wrong_s+$right_s;

	
?>
<?php
	
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
		<a name='start'></a>
		<div class="ansbar">
			<div class="ansbar-desc">
				<div class="row">
					<div class="col-md-4 col-xs-1">
						<a href="javascript:history.back();"><span class="glyphicon glyphicon-circle-arrow-left"></span></a>
					</div>
					<div class="col-md-4 col-xs-10">
						<h1>你一共做过<?=$alls?>道题,其中</h2>
						<h3>对了<?=$right_s?>道题</h4>
						<h3>错了<?=$wrong_s?>道题</h4>
						<?php
						$judgedone=$textdone=$audiodone=$videodone=$imgdone=0;
						for($i=0;$i<$njudge;$i++){
							for($j=0;$j<$right_s;$j++){
								if($all_right[$j]['p_id']==$judges[$i]['p_id']){
									$judgedone++;
								}
							}
							for($j=0;$j<$wrong_s;$j++){
								if($all_wrong[$j]['p_id']==$judges[$i]['p_id']){
									$judgedone++;
								}
							}
						}
						
						for($i=0;$i<$nimg;$i++){
							for($j=0;$j<$right_s;$j++){
								if($all_right[$j]['p_id']==$imgs[$i]['p_id']){
									$imgdone++;
								}
							}
							for($j=0;$j<$wrong_s;$j++){
								if($all_wrong[$j]['p_id']==$imgs[$i]['p_id']){
									$imgdone++;
								}
							}
						}
						
						for($i=0;$i<$nvideo;$i++){
							for($j=0;$j<$right_s;$j++){
								if($all_right[$j]['p_id']==$videos[$i]['p_id']){
									$videodone++;
								}
							}
							for($j=0;$j<$wrong_s;$j++){
								if($all_wrong[$j]['p_id']==$videos[$i]['p_id']){
									$videodone++;
								}
							}
						}
						
						for($i=0;$i<$naudio;$i++){
							for($j=0;$j<$right_s;$j++){
								if($all_right[$j]['p_id']==$audios[$i]['p_id']){
									$audiodone++;
								}
							}
							for($j=0;$j<$wrong_s;$j++){
								if($all_wrong[$j]['p_id']==$audios[$i]['p_id']){
									$audiodone++;
								}
							}
						}
						
						for($i=0;$i<$ntext;$i++){
							for($j=0;$j<$right_s;$j++){
								if($all_right[$j]['p_id']==$texts[$i]['p_id']){
									$textdone++;
								}
							}
							for($j=0;$j<$wrong_s;$j++){
								if($all_wrong[$j]['p_id']==$texts[$i]['p_id']){
									$textdone++;
								}
							}
						}
						?>
						<h3>你所有做过的题中判断题目有<?=$judgedone?>道，覆盖了题库中所有该类型题目的<?=round((100*$judgedone/$njudge),2)?>%</h3>
						<h3>你所有做过的题中文本题有<?=$textdone?>道，覆盖了题库中所有该类型题目的<?=round((100*$textdone/$ntext),2)?>%</h3>
						<h3>你所有做过的题中图片题有<?=$imgdone?>道，覆盖了题库中所有该类型题目的<?=round((100*$imgdone/$nimg),2)?>%</h3>
						<h3>你所有做过的题中音频题有<?=$audiodone?>道，覆盖了题库中所有该类型题目的<?=round((100*$audiodone/$naudio),2)?>%</h3>
						<h3>你所有做过的题中视频题有<?=$videodone?>道，覆盖了题库中所有该类型题目的<?=round((100*$videodone/$nvideo),2)?>%</h3>
					</div>
					<div class="col-md-4 col-xs-1"></div>
				</div>
			</div>
		</div>	
	</div>
	<div class="col-md-1"></div>
</div>
</body>
</html>

