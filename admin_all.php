<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="./assets/css/questionMaker.css?<?= time(); ?>">
<style type="text/css">
	table{
		font-size: 1.5em;
		text-align: center;
	}
	.edtBtn{
		padding: 0px; cursor: pointer;
	}
	.edtBtn:hover{
		color: red;
	}
	#exitIcon:hover{
		cursor: pointer;
	}
	#exitIcon{
		position: relative; left: 49%; margin-bottom: -26px;
	}
	.addNewBtn{
		cursor: pointer; background-color: #A93064; font-size: 20px; border-radius: 50%; color: white;padding: 0 5 0 5; margin-left: 10px;
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
	.edtTopic:hover, .delTopic:hover, .delSurvey:hover, .edtSurvey:hover{
		color: red;
	}
	.edtTopic, .delTopic, .delSurvey, .edtSurvey{
		float: right; padding-right: 5px;
	}
	.topicId, .surveyId{
		display: none;
	}
</style>
</head>
<script type="text/javascript">
	var arrTopics = [];
</script>
<body>
<div class="HOutLine container">
</div>
<div class="BOutLine container">
	<div class="fBody">
		<img  id="exitIcon" src="./assets/img/exit.png">
		<div class="Header">
			<h1>Topics</h1>
		</div>
		<div class="Lessons">
			<div class="col-lg-3 col-md-2 col-xs-1"></div>
			<div class="col-lg-6 col-md-8 col-xs-10">
				<div class="col-xs-6">
					<h3>Topics <span class="addNewBtn" onclick="addTopic()">+</span></h3>
					<ul class="topicList">
					</ul>
				</div>
				<div class="col-xs-6">
					<h3>Surveys <span class="addNewBtn" onclick="addSurvey()">+</span></h3>
					<ul class="surveyList">
					</ul>
				</div>
			</div>
			<div class="col-lg-3 col-md-2 col-xs-1"></div>
			<div style="clear: both;"></div>
			<br>
		</div>
		<div class="row">
			<div class="col-lg-1 col-md-1"></div>

			<div class="col-lg-3 col-md-3 col-xs-12"><a href="courseManager.php">Course Management</a></div>

			<div class="col-lg-1 col-md-1"></div>

			<div class="col-lg-3 col-md-3 col-xs-12"><a href="studentManager.php">Individual Management</a></div>

			<div class="col-lg-1 col-md-1"></div>

			<div class="col-lg-2 col-md-2 col-xs-12"><a href="resultView.php">Results</a></div>

			<div class="col-lg-1 col-md-3"></div>			
		</div>
	</div>
</div>
<script type="text/javascript" src="assets/js/cookie.js?<?= time() ?>"></script>
<script type="text/javascript">
	var elemTable = $("table");
	for( var i = 1; i < $("table").find("tr").length; i++){
		$("table").find("tr").eq(i).find(".Topic").html(arrTopics[i-1]);
	}
	function addNew(){
		var nLessonCount = $("table").find("tr").length;
		window.location.href = "questionMaker.php?title=Lesson " + nLessonCount+"&new=new";
	}
	function changeTopics(_i){
		var strOld = $("table").find("tr").eq(_i).find(".Topic").eq(0).html();
		var newVal = prompt("Please enter new Value", strOld);
		if( newVal != null){
			var strSurvey = $("table").find("tr").eq(_i).find(".Survey").eq(0).html();
			console.log(strSurvey);
			$.ajax({
				method: "POST",
				url: "questionManager.php",
				data: { changeTopics: strSurvey, newVal: newVal}
			}).done( function(msg){
				if( msg == "OK"){
					$("table").find("tr").eq(_i).find(".Topic").eq(0).html(newVal);
				}
			});
		}
	}
	function changeSurvey(_i){
		var strOld = $("table").find("tr").eq(_i).find(".Survey").eq(0).html();
		var newVal = prompt("Please enter new Value", strOld);
		if( newVal != null){
			var strSurvey = $("table").find("tr").eq(_i).find(".Survey").html();
			$.ajax({
				method: "POST",
				url: "questionManager.php",
				data: { changeSurvey: strSurvey, newVal: newVal}
			}).done( function(msg){
				if( msg == "OK"){
					$("table").find("tr").eq(_i).find(".Survey").eq(0).html(newVal);
				}
			});
		}
	}
	function getAllTopic(){
		var strTeacherName = getCookie("QuestionnaireTeacherName");
		$.ajax({
			method: "POST",
			url: "userManager.php",
			data: { getAllTopic: strTeacherName}
		}).done( function(msg){
			var arrTopics = JSON.parse(msg);
			var strHtml = "";
			for( var i = 0; i < arrTopics.length; i++){
				var topic = arrTopics[i];
				strHtml += '<li onclick="topicClicked('+topic.Id+')"><span class="topicId">'+topic.Id+'</span><span class="topicName">'+topic.TopicName+'</span><span class="delTopic" onclick="delTopic('+topic.Id+')">&#x2716;</span><span class="edtTopic" onclick="editTopic('+topic.Id+')">&#x270E;</span></li>';
			}
			$(".topicList").html(strHtml);
			if( arrTopics.length != 0){
				topicClicked(arrTopics[0].Id);
			}
		});
	}
	getAllTopic();
	function addTopic(){
		var newVal = prompt("Please enter new Topic Name.");
		if( newVal != null){
			var strTeacherName = getCookie("QuestionnaireTeacherName");
			var names = $(".topicName");
			$.ajax({
				method: "POST",
				url: "userManager.php",
				data: { addTopic: newVal, userName: strTeacherName}
			}).done( function(msg){
				var strHtml = '<li onclick="topicClicked('+msg+')"><span class="topicId">'+msg+'</span><span class="topicName">'+newVal+'</span><span class="delTopic" onclick="delTopic('+msg+')">&#x2716;</span><span class="edtTopic" onclick="editTopic('+msg+')">&#x270E;</span></li>';
				$(".topicList").append(strHtml);
			});
		}
	}
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
					var strHtml = "";
					for( var i = 0; i < arrSurveys.length; i++){
						var survey = arrSurveys[i];
						strHtml += '<li><span class="surveyId">'+survey.Id+'</span><span class="surveyName"><a href="questionMaker.php?title='+survey.Id+'">'+survey.SurveyName+'</a></span><span class="delSurvey" onclick="delSurvey('+survey.Id+')">&#x2716;</span><span class="edtSurvey" onclick="editSurvey('+survey.Id+')">&#x270E;</span></li>';
						// console.log(arrSurveys[i]);
					}
					$(".surveyList li").remove();
					$(".surveyList").append(strHtml);
				});
			}
		}
	}
	function editTopic(_idTopic){
		var oldVal = $(".topicList li").filter(function(){
			return $(this).find(".topicId").eq(0).html() == _idTopic;
		}).find(".topicName").html();
		var newVal = prompt("Please enter Topic Name.", oldVal);
		if( newVal != null){
			$.ajax({
				method: "POST",
				url: "userManager.php",
				data: { changeTopicName: _idTopic, newVal: newVal}
			}).done( function(msg){
				console.log(msg);
				if( !msg){
					alert("Can not change.");
					return;
				}
				$(".topicList li").filter(function(){
					return $(this).find(".topicId").eq(0).html() == _idTopic;
				}).find(".topicName").html(newVal);
			});
		}
	}
	function delTopic(_idTopic){
		var aa = confirm("Are you sure remove?");
		if( aa == true){
			$.ajax({
				method: "POST",
				url: "userManager.php",
				data: { removeTopic: _idTopic}
			}).done( function(msg){
				if( !msg){
					alert("Can not remove.");
					return;
				}
				$(".topicList li").filter(function(){
					return $(this).find(".topicId").eq(0).html() == _idTopic;
				}).find(".topicName").html(newVal);
			});
		}
	}
	function addSurvey(){
		var idTopic =  $(".topicList .selected").eq(0).find(".topicId").eq(0).html();
		var newVal = prompt("Please enter new Survey Name.");
		if( newVal != null){
			$.ajax({
				method: "POST",
				url: "userManager.php",
				data: { addSurvey: idTopic, newVal: newVal}
			}).done( function(msg){
				console.log(msg);
				if( !msg){
					alert("Can not insert.");
					return;
				}
				var strHtml = '<li><span class="surveyId">'+msg+'</span><span class="surveyName"><a href="">'+newVal+'</a></span><span class="delSurvey" onclick="delSurvey('+msg+')">&#x2716;</span><span class="edtSurvey" onclick="editSurvey('+msg+')">&#x270E;</span></li>';
				$(".surveyList").append(strHtml);
			});
		}
	}
	function editSurvey(_idSurvey){
		var oldName = $(".surveyList li").filter(function(){
			return $(this).find(".surveyId").html() == _idSurvey;
		}).find(".surveyName a").html();
		var newName = prompt("Please enter new Survey Name.", oldName);
		if( newName != null){
			console.log(newName);
			var equalElem = $(".surveyList li").filter(function() {
				return $(this).find(".surveyId").html() != _idSurvey && $(this).find(".surveyName a").html() == newName;
			});
			if( equalElem.length != 0){
				alert("Exist equal Name.");
				return;
			}
			$.ajax({
				method: "POST",
				url: "userManager.php",
				data: { changeSurveyName: _idSurvey, newVal: newName}
			}).done( function(msg){
				if( msg){
					$(".surveyList li").filter(function(){
						return $(this).find(".surveyId").html() == _idSurvey;
					}).find(".surveyName a").html(newName);
				}
			});
		}
	}
</script>