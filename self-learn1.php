<?php
	if(!empty($_GET['id'])){
		$step_id=intval($_GET['id']);		
	}else{
		$step_id=0;
	}

	session_start();
	//include("connect.php");
	header("Content-Type:text/html;charset=utf8");
	if(!isset($_SESSION['token'])||!isset($_SESSION['usrid'])||!isset($_SESSION['name'])){
        exit('illegal access!');
	}else{
	$user_id=$_SESSION['usrid'];
	$nickname=$_SESSION['name'];
	}
	include("connect.php");
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" href="css/init.css">
	<link rel="stylesheet" href="css/classify.css">
	<link rel="stylesheet" href="css/save3.css">
	<!--modal-->
	<link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
	  <script>
	var step_id="<?=$step_id?>"
  </script>
	<script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="js/self-learn.js"></script>

	<title>Document</title>
</head>
<body>
	<a href="#idd">zzzzzzzzzzzzz</a>
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
		<div class='ansbar2'>


  <div class="container result">
  <div class="list">
  <h1>所有的学习内容</h1>
  <?php
	try{
		$alllist=$DBH->prepare('SELECT * FROM learn_list order by step_id ASC');
		$alllist->execute();
		$list=$alllist->fetchAll(PDO::FETCH_ASSOC);
	}catch(PDOException $e){
			die($e->getMessage());
	}
		$i=1;
		//var_dump($list);
		foreach($list as $onestep){?>
			<div class="listindex" id="list-<?=$i?>">第<?=$i?>个学习阶段</div>
			<?php
			try{
			
			$settime=$DBH->prepare('SELECT time FROM alllearncontent WHERE step_id=? AND part_id=0');
			$settime->bindParam(1,$i);
			$settime->execute();
			$st=$settime->fetch(PDO::FETCH_ASSOC);
				
			$finishedtime=$DBH->prepare('SELECT time FROM self_learn WHERE yb_id=? AND step_id=?');
			$finishedtime->bindParam(1,$user_id);
			$finishedtime->bindParam(2,$i);
			$finishedtime->execute();
			$ft=$finishedtime->fetch(PDO::FETCH_ASSOC);
			
			}catch(PDOException $e){
				die($e->getMessage());
			}
			if($ft['time']>=$st['time']){
			?>
			<div  id="showresult">你已经完成该阶段的学习</div>
		<?php
		}
		?>
			<a href="self-learn.php?id=<?=$onestep['step_id']?>"><?php echo $onestep['title'];?></a>
		<?php
		
		$i++;
		}
  ?>
  </div>
  <?php if($step_id!=0){//说明进入了学习阶段
  /*  从数据库检验是否可以进入这一学习阶段  */
		if($step_id>1){
			$last_id=$step_id-1;
			try{
				
			$settime=$DBH->prepare('SELECT time FROM alllearncontent WHERE step_id=? AND part_id=0');
			$settime->bindParam(1,$last_id);
			$settime->execute();
			$st=$settime->fetch(PDO::FETCH_ASSOC);
				
			$finishedtime=$DBH->prepare('SELECT time FROM self_learn WHERE yb_id=? AND step_id=?');
			$finishedtime->bindParam(1,$user_id);
			$finishedtime->bindParam(2,$last_id);
			$finishedtime->execute();
			$ft=$finishedtime->fetch(PDO::FETCH_ASSOC);
			
			}catch(PDOException $e){
				die($e->getMessage());
			}
			
				if(intval($ft['time'])<intval($st['time'])){
					die("请先完成上一个阶段的学习");
				}
		}
	
		

	  ?>
		<div>当前进行到第<?=$step_id?>个学习阶段</div>
		<a name="idd"></a>
		<div id="txt"></div>/<div id="limitTime"></div>
		<div class="learn-content">
		<div class="content-h1" id="content-h1"></div>
		<div class="content-h2" id="content-h2"></div>
		<div class="content-h3"  id="content-h3"></div>
		<div class="content-h4" id="content-h4"></div>
		<div class="content-h5"  id="content-h5"></div>
		<div class="content-h6"  id="content-h6"></div>
		<div class="content-p"  id="content-p" style="text-indent:2em;"></div>
		<div class="content-span"  id="content-span"></div><!--span可以是加粗之类的属性-->
		<img src="" class="hidden" id="content-img" ></img>
		<audio src="" class="hidden" controls="controls" id="content-audio"></audio>
		<video src="" class="hidden" controls="controls" id="content-video"></video>
		</div>
		 
		<div onclick="confirm(step_id)">下一步</div>
	  
  <?php }?>


  </div>
  
		</div>
	</div>
	<div class="col-md-1"></div>
</div>
</body>
</html>
