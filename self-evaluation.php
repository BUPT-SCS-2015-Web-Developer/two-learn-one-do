<?php
	session_start();

	if(!isset($_SESSION['token'])||!isset($_SESSION['usrid'])||!isset($_SESSION['name'])){
        exit('illegal access!');
	}else{
	$user_id=$_SESSION['usrid'];
	$nickname=$_SESSION['name'];
	}
	include("connect.php");
	try{
		$query=$DBH->prepare('SELECT time FROM self_evaluation WHERE yb_id=? order by time DESC');
		$query->bindParam(1,$user_id);
		$query->execute();
		$evaluated_date=$query->fetch(PDO::FETCH_ASSOC);
	}catch(PDOException $e){
		die($e->getMessage());
		//die("Database Error.Please contact supporter!");
	}
	$now_date=date("Y-m-d");
	//var_dump($now_date);
	//var_dump((strtotime($now_date)-strtotime($evaluated_date['time']))/86400);
	$bynow=((strtotime($now_date)-strtotime($evaluated_date['time']))/86400);
	/*if($bynow>=7){
		echo "超过一周没有自评了";
	}else{
		exit("这周已经自评过了");
	}*/
?>
<html lang="en">
<head>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" href="css/init.css">
	<link rel="stylesheet" href="css/classify.css">
	<link rel="stylesheet" href="css/self-center.css">
	<link rel="stylesheet" href="css/self-evaluation.css">
	<link rel="stylesheet" href="css/save2.css">
	<!--modal-->
	<link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
	
	<title>Document</title>




<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</head>
<script>
var b;
var a=new Array();
$(document).ready(function(){
	
	$('.star').click(function () {
	  var i=0;
	  $(this).toggleClass('selected');
	   
	   b=$(this).parent().parent().index();

	   a[b-1]=$(this).index();
	  for(i=0;i<=a[b-1];i++){
	  	$(this).parent().find("#star-"+b+"-"+i).find("img").attr("src","pics/red-star.png");
	  }
	  for(i;i<=4;i++){
	  	$(this).parent().find("#star-"+b+"-"+i).find("img").attr("src","pics/yellow-star.png");
	  }
	  console.log(a[0]+1);
	  console.log(a[1]+1);
	  console.log(a[2]+1);
	  console.log(a[3]+1);
	});


})
function confirm(){
	var point1=$(".stars-1").find(".selected").length;
	var point2=$(".stars-2").find(".selected").length;
	var point3=$(".stars-3").find(".selected").length;
	var point4=$(".stars-4").find(".selected").length;
		$.ajax({
			type:"POST",
			url:"self-evaluation-handler.php",
			dataType: "text",
			data:{
				point1:a[0]+1,
				point2:a[1]+1,
				point3:a[2]+1,
				point4:a[3]+1,
			},
			beforeSend:function (XMLHttpRequest) {
				$(".response").html("提交中...");
			},
			success: function(msg){
				if(msg==="fail"){
					$(".response").html("好像哪里不对...");
				}else if(msg=="success"){
					setTimeout("window.location.href='index.php'","1000");
				}
			},
			complete:function(){
				$(".response").html("提交成功，即将返回首页");
				console.log(a);
			},
		})
}
</script>
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
		<?php
			if($bynow<7){
				die("<div class='ansbar2'><div class='result'>你这周已经自评过了</div></div>");
			}
		?>
		<div class="ansbar">
			<div class="col-md-1"></div>
			<div class="col-md-10">
				<h3>自评内容有四项，分别指向政治立场、工作学习、对群众的态度、个人作风：</h3>
				<div class="evaluation-content content1">
					<div class="content-desc">a.政治立场坚定，严守党的纪律，服从党的安排，坚决拥护党的各项方针、路线、政策。</div>
					<div class=" stars stars-1">
						 <div class="star star-1 star-a" id="star-1-0"><img width="100%"  src="pics/yellow-star.png"></div>
						 <div class="star star-1 star-b" id="star-1-1"><img width="100%"  src="pics/yellow-star.png"></div>
						 <div class="star star-1 star-c" id="star-1-2"><img width="100%"  src="pics/yellow-star.png"></div> 
						 <div class="star star-1 star-d" id="star-1-3"><img width="100%"  src="pics/yellow-star.png"></div>
						 <div class="star star-1 star-e" id="star-1-4"><img width="100%"  src="pics/yellow-star.png"></div>   
					</div>
				</div>
				<div class="evaluation-content content2">
					<div class="content-desc">b.认真学习，勤勉工作、积极思考。力求在学习、工作上有进步，在党性修养上有提高。</div>
					<div class="stars stars-2">
						 <div class="star star-2 star-a" id="star-2-0"><img width="100%"  src="pics/yellow-star.png"></div>
						 <div class="star star-2 star-b" id="star-2-1"><img width="100%"  src="pics/yellow-star.png"></div>
						 <div class="star star-2 star-c" id="star-2-2"><img width="100%"  src="pics/yellow-star.png"></div> 
						 <div class="star star-2 star-d" id="star-2-3"><img width="100%"  src="pics/yellow-star.png"></div>
						 <div class="star star-2 star-e" id="star-2-4"><img width="100%"  src="pics/yellow-star.png"></div>
					</div> 
				</div>
				<div class="evaluation-content content3">
					<div class="content-desc">c.能从群众的角度看待问题，始终把群众的利益放在第一位，诚心诚意的“以群众为本，为群众服务”。</div>
					<div class="stars stars-3"> 
						 <div class="star star-3 star-a" id="star-3-0"><img width="100%"  src="pics/yellow-star.png"></div>
						 <div class="star star-3 star-b" id="star-3-1"><img width="100%"  src="pics/yellow-star.png"></div>
						 <div class="star star-3 star-c" id="star-3-2"><img width="100%"  src="pics/yellow-star.png"></div> 
						 <div class="star star-3 star-d" id="star-3-3"><img width="100%"  src="pics/yellow-star.png"></div>
						 <div class="star star-3 star-e" id="star-3-4"><img width="100%"  src="pics/yellow-star.png"></div>  
					</div>
				</div>
				<div class="evaluation-content content4">
					<div class="content-desc">d.遵守党章、遵纪守法。严格的要求自己的一言一行，深刻的意识意识到自己肩负的责任，坚决抵制不正之风，为他人做好表率。</div>
					<div class="stars stars-4">
						 <div class="star star-4 star-a" id="star-4-0"><img width="100%"  src="pics/yellow-star.png"></div>
						 <div class="star star-4 star-b" id="star-4-1"><img width="100%"  src="pics/yellow-star.png"></div>
						 <div class="star star-4 star-c" id="star-4-2"><img width="100%"  src="pics/yellow-star.png"></div> 
						 <div class="star star-4 star-d" id="star-4-3"><img width="100%"  src="pics/yellow-star.png"></div>
						 <div class="star star-4 star-e" id="star-4-4"><img width="100%"  src="pics/yellow-star.png"></div>    
					</div>
				</div>
				<div class="response"></div>
				<div class="confirm" onclick="confirm()">提交</div>
			</div>
			<div class="col-md-1"></div>
			
			
		</div>	
	</div>
	<div class="col-md-1"></div>
</div>



</body>
</html>
