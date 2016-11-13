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
	<a name='start'></a>
    <div style="background-color:#FF1520">
        <div class="container">
            <!--循环此处即可-->
			<?php
			try{	
		        $get_sxhb=$DBH->prepare("select * from thought_report");	
		        $get_sxhb->execute();
				$sxhbs=$get_sxhb->fetchAll(PDO::FETCH_ASSOC);
	        }catch(PDOException $e){
		        die($e->getMessage());
	        }
			$nums=count($sxhbs);
			for($i=0;$i<$nums;$i++){
			?>
            <div class="row"style="background-color:white">
                <div class="col s12 m12">
                    <div class="card-panel red">
                        <span class="white-text"><!--此处为文本内容-->
						<pre><?php echo $sxhbs[$i]['content'];
						?>
						</pre>
                        </span>
						<span><?=$sxhbs[$i]['time']?></span>
						<span>&nbsp &nbsp &nbsp &nbsp    by <?=$sxhbs[$i]['yb_nickname']?></span>
						
                    </div>
                </div>
            </div>
			<?php
			}
			?>
            <!--循环此处即可-->
            <a class="waves-effect waves-light btn  col s2 offset-s10 red" href="./sxhb.html">我要写心得</a>
            <a class="waves-effect waves-light btn  col s2 offset-s10 red" href="./mine.php">查看我的心得</a>
        </div>
    </div>
    <footer class="page-footer red accent-4"></footer>
    
    <!--Import jQuery before materialize.js--> 
    <script src="js/jquery-2.1.1.min.js"></script> 
    <script type="text/javascript" src="js/jquery.cookie-1.4.1.min.js"></script> 
    <script  src="js/materialize.min.js"></script>
</body>
</html>
