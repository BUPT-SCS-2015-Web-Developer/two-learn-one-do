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
  	<script src="js/self-learn.js"></script>
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
	<a href="#idd"></a>
	<div class="header-section" id="header">
		<div class="well-com"><img src="img/self-learn.png" style="width:100%" alt=""></div>
	</div>
	<div class="contain">		
		<section class="main">
			<div class="baraja-demo center">
				<ul id="baraja-el" class="baraja-container">
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
									<img src="img/3.jpg" alt="image1"/>
									<h4 class="feature-title color-scheme listindex" id="list-<?=$i?>">第<?=$i?>个学习阶段</h4>
									<p class="feature-text">
										Curabitur posuere feugiat ipsum, sed elementum tortor maximus ut.
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
								<img src="img/finished.png" class="finished" alt="">
							<?php
							}
							?>
								<a href="self-learn.php?id=<?=$onestep['step_id']?>" class="fancy-button button-line btn-col ">
									<?php echo $onestep['title'];?>
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
			<nav class="actions light">
				<span id="nav-prev" class="glyphicon glyphicon-arrow-left"></span>
				<span id="close" class="glyphicon glyphicon-resize-small"></span>
				<span id="open" class="glyphicon glyphicon-resize-full"></span>
				<span id="nav-next" class="glyphicon glyphicon-arrow-right"></span>	
			</nav>
		</section>			
    </div>
    <script type="text/javascript" src="js/jquery.baraja.js"></script>
    <script type="text/javascript">	
		$(function() {

			var $el = $( '#baraja-el' ),
				baraja = $el.baraja();

			// navigation
			$( '#nav-prev' ).on( 'click', function( event ) {

				baraja.previous();
			
			} );

			$( '#nav-next' ).on( 'click', function( event ) {

				baraja.next();
			
			} );
			$( '#close' ).on( 'click', function( event ) {

				baraja.close();
			
			} );
			$('#open').on('click',function(event){
				baraja.fan( {
					speed : 500,
					easing : 'ease-out',
					range : 60,
					direction : 'right',
					origin : { x : 50, y : 200 },
					center : true
				} );
			})
			
		});
	</script>

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
						die("请先完成上一个阶段的学习");
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
						<div onclick="confirm(step_id)" class="next-step">下一步</div>
					</div>
				</div>
				<div class="col-md-4 step-img">
					<img src="img/note.png" style="width:100%;">
				</div>
			</div>
		</div>
	</div>
	  <?php }?>
</body>
</html>