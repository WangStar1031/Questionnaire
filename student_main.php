<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="./assets/css/questionMaker.css?<?= time(); ?>">
<style type="text/css">
	.topicId, .surveyId{
		display: none;
	}
	.topicList, .surveyList{
		border: 1px solid black; padding-left: 0px; height: 300px; overflow: auto;
	}
	.topicList li, .surveyList li{
		cursor: pointer; list-style-type: none; padding: 5px; text-align: left;
	}
	.topicList li.selected{
		background-color: #cef;
	}
	#exitIconST:hover{
		cursor: pointer;
	}
	#exitIconST{
		position: relative; left: 49%; margin-bottom: -26px;
	}
</style>
</head>

<?php
	if( !isset($_GET['userId']))exit();
	include './userManager.php';
	$userId = $_GET['userId'];
	if( $userId == "")exit();
	if( $userId != 0){
?>
<script type="text/javascript">
	var arrTopics = [];
	var userId = '<?= $userId ?>';
	console.log(<?= $userId ?>);
</script>
<body>
<div class="HOutLine container">
</div>
<div class="BOutLine container">
	<div class="fBody">
		<img  id="exitIconST" src="./assets/img/exit.png">
		<div class="Header">
			<h1>Topics</h1>
		</div>
		<div class="Lessons row">
			<div class="col-lg-3 col-md-2 col-xs-1"></div>
			<div class="col-lg-6 col-md-8 col-xs-10">
				<div class="col-xs-6">
					<h3>Topics</h3>
					<ul class="topicList">
					</ul>
				</div>
				<div class="col-xs-6">
					<h3>Surveys</h3>
					<ul class="surveyList">
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var elemTable = $("table");
	for( var i = 1; i < $("table").find("tr").length; i++){
		$("table").find("tr").eq(i).find(".Topic").html(arrTopics[i-1]);
	}
</script>
<?php
}
?>
<script type="text/javascript">
function setCookie(cname,cvalue,exdays) {
	var d = new Date();
	d.setTime(d.getTime() + (exdays*24*60*60*1000));
	var expires = "expires=" + d.toGMTString();
	document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
	var name = cname + "=";
	var decodedCookie = decodeURIComponent(document.cookie);
	var ca = decodedCookie.split(';');
	for(var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') {
			c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
}
if( getCookie("QuestionnaireStudentName") == ""){
	window.location.href = "student.php";
}
document.getElementById("exitIconST").onclick = function(){
	console.log("exit");
	setCookie("QuestionnaireStudentName", "");
	window.location.href = "student.php";
}
function getAllTopic(){
	var strTeacherName = getCookie("QuestionnaireStudentName");
	$.ajax({
		method: "POST",
		url: "userManager.php",
		data: { getAllTopicFromUserId: userId}
	}).done( function(msg){
		var arrTopics = JSON.parse(msg);
		var strHtml = "";
		for( var i = 0; i < arrTopics.length; i++){
			var topic = arrTopics[i];
			if( i == 0){
				strHtml += '<li class="selected" onclick="topicClicked('+topic.Id+')"><span class="topicId">'+topic.Id+'</span><span class="topicName">'+topic.TopicName+'</span></li>';
			} else{
				strHtml += '<li onclick="topicClicked('+topic.Id+')"><span class="topicId">'+topic.Id+'</span><span class="topicName">'+topic.TopicName+'</span></li>';
			}
		}
		$(".topicList").html(strHtml);
		topicClicked(arrTopics[0].Id);
	});
}
getAllTopic();	
function topicClicked(_idTopic){
	var arrLis = $(".topicList li");
	for( i = 0; i < arrLis.length; i++){
		var elem = arrLis.eq(i).find(".topicId").eq(0);
		if( elem.html() == _idTopic){
			arrLis.removeClass("selected");
			arrLis.eq(i).addClass("selected");
			$.ajax({
				method: "POST",
				url: "userManager.php",
				datatype: "json",
				data: { getSurveys: _idTopic}
			}).done( function(msg){
				var arrSurveys = JSON.parse(msg);
				console.log(arrSurveys);
				var strHtml = "";
				for( var i = 0; i < arrSurveys.length; i++){
					var survey = arrSurveys[i];
					strHtml += '<li><span class="surveyId">'+survey.Id+'</span><span class="surveyName"><a href="studentAnswer.php?uId='+'<?= $userId ?>'+'&title='+survey.Id+'">'+survey.SurveyName+'</a></span></li>';
				}
				$(".surveyList li").remove();
				$(".surveyList").append(strHtml);
			});
		}
	}
}
</script>