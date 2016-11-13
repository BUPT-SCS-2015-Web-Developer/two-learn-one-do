<?php
    session_start();
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
<html>
<head>
    <meta charset="utf-8">
    <title>思想汇报</title>
    <!--Import Google Icon Font-->
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="./css/materialize.min.css"  media="screen,projection"/>
    <!--Let browser know website is optimized for mobile-->
    <link href="./css/new.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body>
    <div  id="header">
        <img src="./img/login.jpg"   class="responsive-img" style="display: block;">
    </div>
    
    <div style="background-color:#FF1520">
        <div class="container">
            <!--循环此处即可-->
			<?php
			try{	
		        $get_sxhb=$DBH->prepare("select * from thought_report where yb_id='$user_id'");	
		        $get_sxhb->execute();
				$sxhbs=$get_sxhb->fetchAll(PDO::FETCH_ASSOC);
	        }catch(PDOException $e){
		        die($e->getMessage());
	        }
			$nums=count($sxhbs);
			if($nums==0){
				?>
			
				<span class="white-text" style="font-size:36px">
				<?php
				echo"你还没有写过心得";
				?>
				</span>
			<?php
				}
			for($i=0;$i<$nums;$i++){
			?>
            <div class="row" id='<?=$i?>' style="background-color:white">
                <div class="col s12 m12">
                    <div class="card-panel red">
                        <span class="white-text"><!--此处为文本内容-->
                        <pre><?php echo $sxhbs[$i]['content'];
						?>
						</pre>
						</span>
						<span>&nbsp &nbsp &nbsp &nbsp   <?=$sxhbs[$i]['time']?></span>
                    </div>
                </div>
                <a class="waves-effect waves-light btn  col s2 offset-s5 red" href="#" onclick="removeit(<?=$i?>,<?=$sxhbs[$i]['flag']?>)">删除</a>
            </div>
			<?php
			}
			?>
            <!--循环此处即可-->
        </div>
    </div>

    <footer class="page-footer red accent-4"></footer>
    
    <!--Import jQuery before materialize.js--> 
    <script src="js/jquery-2.1.1.min.js"></script> 
    <script type="text/javascript" src="js/jquery.cookie-1.4.1.min.js"></script> 
    <script  src="js/materialize.min.js"></script>
	<script>
function	removeit(x,flag){
		console.log(x,flag);
		
		$.ajax({
			type:'POST',
			asyn:false,
			url:"removesxhb.php",
			data:{
				id:flag,
			},
			datatype:'text/html',
			success:function(msg){
				if(msg=="success"){
					$("#"+x).hide();
				}
			}
		})
	}
	</script>
</body>
</html>
