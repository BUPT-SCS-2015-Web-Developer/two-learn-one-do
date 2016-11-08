
var h=0
var m=0
var s=0

$(document).ready(function(){
	console.log("自主学习页面真是整个应用里的一股清流......");
	limitTime();
	initTime();
	initContent();
	

	
	
})

function initContent(){
	$.ajax({
		type:'POST',
		async:true,
		url:'initContent.php',
		data:{
			step_id:step_id,
		},
		success:function(data){
			var msg = $.parseJSON(data);
			console.log(msg);
			$.each(msg,function(i,item){
				//console.log(i);
				//console.log(item.type);
				/*目前已经是按照part_id升序排列的数组，先判断type，再赋值颜色*/
				if(item.type=="h1"){
					var copyitem=$("#content-h1").clone();
					copyitem.append(item.content);
				}else if(item.type=="h2"){
					var copyitem=$("#content-h2").clone();
					copyitem.append(item.content);
				}else if(item.type=="h3"){
					var copyitem=$("#content-h3").clone();
					copyitem.append(item.content);
				}else if(item.type=="h4"){
					var copyitem=$("#content-h4").clone();
					copyitem.append(item.content);
				}else if(item.type=="h5"){
					var copyitem=$("#content-h5").clone();
					copyitem.append(item.content);
				}else if(item.type=="h6"){
					var copyitem=$("#content-h6").clone();
					copyitem.append(item.content);
				}else if(item.type=="p"){
					var copyitem=$("#content-p").clone();
					copyitem.append(item.content);
				}else if(item.type=="span"){
					var copyitem=$("#content-span").clone();
					copyitem.append(item.content);
				}else if(item.type=="img"){
					var copyitem=$("#content-img").clone();
					copyitem.attr("src",item.content);
					copyitem.removeClass("hidden");
				}else if(item.type=="audio"){
					var copyitem=$("#content-audio").clone();
					copyitem.attr("src",item.content);
					copyitem.removeClass("hidden");
				}else if(item.type=="video"){
					var copyitem=$("#content-video").clone();
					copyitem.attr("src",item.content);
					copyitem.removeClass("hidden");
				}
				if(item.color){
					copyitem.attr("style","color:"+item.color);
				}

				
				copyitem.attr("id","contetn-"+item.part_id);
				$(".learn-content").append(copyitem);
			})
		}
	})
}

function limitTime(){
	$.ajax({
		type:'POST',
		async:true,
		url:'limittime.php',
		data:{
			step_id:step_id,
		},
		success:function(data){
			var msg=$.parseJSON(data);
			if(msg){
				if(msg.h)
					$("#limitTime").append(msg.h+":"+msg.m+":"+msg.s);
				else
					$("#limitTime").append(msg.m+":"+msg.s);
				$("#limitTime").attr("name",60*60*msg.h+60*msg.m+msg.s);
			}
		}
	})
}

function timeCount(h,m,s)
{
	m=checkTime(m);
	s=checkTime(s);
	if(h>0)
		document.getElementById('txt').innerHTML=h+":"+m+":"+s
	else if(h==0)
		document.getElementById('txt').innerHTML=m+":"+s
	$("#txt").attr("name",60*60*h+60*m+s);
	add1s();
	setTimeout("timeCount(h,m,s)",1000)
	$.ajax({
		type:'POST',
		async:true,
		url:'savetime.php',
		data:{
			h:h,
			m:m,
			s:s,
			step_id:step_id,
		},
	})
}

function initTime(){
	$.ajax({
		type:'POST',
		async:true,
		url:'initTime.php',
		data:{
			step_id:step_id,
			
		},
		datatype:"json",
		success:function(data){
			var msg = $.parseJSON(data);
			console.log(msg);
			if(msg){
			h=msg.h;
			m=msg.m;
			s=msg.s;
			timeCount(h,m,s);
			}
		},
		error:function(){
			alert("获取学习时间失败");
		},
		
	})
}

function checkTime(i)
{
	i=parseInt(i)
if (i<10) 
  {i="0" + i}
  return i
}

function add1s(){
	s=parseInt(s)
	if(s<59){
		s=s+1;
	}else{
		s=00;
		if(m<59){
			m=m+1;
		}else{
			m=00;
			h=h+1;
		}
	}
}

function confirm(step_id){
	var finished=parseInt($("#txt").attr("name"));
	var expected=parseInt($("#limitTime").attr("name"));

	if(finished<expected){
		console.log("nonono");
		alert("请完成当前阶段的学习任务！");
	}else if(step_id==$(".listindex").length){
		alert("你已经完成全部的学习阶段");
		location.href="self-learn.php";
	}
	else{
		step_id=parseInt(step_id);
		location.href="self-learn.php?id="+(step_id+1)+"#idd";
	}
}


