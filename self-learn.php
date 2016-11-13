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
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" type="text/css" href="css/baraja.css" />
	<link rel="stylesheet" href="css/jquery.mCustomScrollbar.css">
	<link rel="stylesheet" type="text/css" href="css/sweetalert.css" />
	<!-- video -->
	<script src="js/jquery.js"></script>
	<script src="js/mediaelement-and-player.min.js"></script>
	 <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
	<link rel="stylesheet" href="css/mediaelementplayer.min.css">
	<!-- modal -->
	<link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
	<!-- self-learn -->
	<link rel="stylesheet" href="css/self-learn.css">
	<script>
		var step_id="<?=$step_id?>"
  	</script>
	<script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  	<script type="text/javascript" src="js/modernizr.custom.79639.js"></script>
  	<script src="js/sweetalert-dev.js"></script>
  	<script src="js/self-learn.js"></script>
  	<script type="text/javascript" src="js/jquery.mCustomScrollbar.concat.min.js"></script>
	<script>
		$(function(){
			var stepnumwidth=$(".step-num").width();
			var stepnumheight=$(".step-num").height();
			$(".step-num").height(stepnumwidth);
		})
	</script>
	<title>Document</title>
</head>
<body>
	<nav class="navbar  navbar-bg" role="navigation">
	  <div class="container">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="#">两学一做</a>
	    </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
	        <li class="active"><a href="#" onclick="window.location.href='self-learn.php'">自主学习</a></li>
	        <li><a href="#" onclick="window.location.href='choice.php'">开始答题</a></li>
	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown">个人中心 <span class="caret"></span></a>
	          <ul class="dropdown-menu" role="menu">
	            <li><a href="#" onclick="window.location.href='done-count.php'">累计答题</a></li>
	            <li><a href="#" onclick="window.location.href='wrong-repository.php'">错题库</a></li>
	            <li><a href="#" onclick="window.location.href='self-evaluation.php'">每周自评</a></li>
	            <li><a href="#" onclick="window.location.href='evaluation-result.php'">自评结果</a></li>
	          </ul>
	        </li>
	      </ul>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
	<div class="header-section" id="header">
		<div class="well-com"><img src="img/self-learn.png" style="width:100%" alt=""></div>
	</div>
	<script>
		(function($){
			$(window).load(function(){
				
				$.mCustomScrollbar.defaults.theme="light-2"; //set "light-2" as the default theme
				
				$(".scrollbox").mCustomScrollbar({
					axis:"x",
					advanced:{autoExpandHorizontalScroll:true}
				});
		
			});
		})(jQuery);
	</script>
	<a name='list'></a>
	<div class="contain" >		
		<section class="main">
			<div class="branch-demo center">
			
				<ul id="branch-el" class="scrollbox">
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
								<li>
									<img src="img/3.jpg" alt="image1" style="width:100%; height:auto"/>
									<h4 class="feature-title color-scheme listindex" id="list-<?=$i?>">第<?=$i?>个学习阶段</h4>
									<p class="feature-text">
										<?php echo $onestep['title'];?>
									</p>
									
									
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
								<img src="img/finished.png" class="finished" style="width:100%; height:auto;" alt="">
							<?php
							}
							?>
								<a href="self-learn.php?id=<?=$onestep['step_id']?>#idd" class="fancy-button button-line btn-col ">
									开始
									<span class="glyphicon glyphicon-leaf"></span>
								</a>
							</li>
							<?php
							
							$i++;
							}
					  ?>

				</ul>
			</div>
			<a name="idd"></a>
			
		</section>			
    </div>

	<!-- txt-self-learn -->
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
						?>
						<script>
						swal("警告！", "请先完成上一阶段的学习!", "error");
						</script>
						
						<?php
						die();
					}
			}
		
			

		  ?>
	<div class="section-txt">
		<div class="container step-txt">
			<div class="row">
				<div class="col-md-8">
					<div class="col-md-2 center ">
						<div class="step-num"><?=$step_id?></div>
					</div>
					<div class="col-md-10">
						<a name="idd"></a>
						<div class="time-modal">
							<div class="time">自学时间：</div><div id="txt" class="time"></div><div class="time">/</div><div id="limitTime" class="time"></div>
						</div>
						<div class="step-content">
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
							 
							
						</div>
						<a href="#add" onclick="confirm(step_id)" class="next-step">下一步</a>
					</div>
				</div>
				<div class="col-md-4 step-img">
					<img src="img/note.png" style="width:100%;">
				</div>
			</div>
		</div>
	</div>
	<div class="section-audio hidden">
		<div class="container step-audio">
			<div class="step-audio-title">
				<h3>欢迎进行视频学习</h3></div>
			<div class="row">
				<div class="col-md-4">
					<video width="100%"  src="content_video/echo-hereweare.mp4" type="video/mp4" id="player1" controls="controls" preload="none"></video>
				</div>
				<div class="col-md-4"></div>
				<div class="col-md-4"></div>
			</div>
		</div>
	</div>

	  <?php }?>
</body>
</html>
