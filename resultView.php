<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="./assets/css/studentAnswer.css?<?= time(); ?>">
</head>
<style type="text/css">
	ul { list-style-type: none; margin: 0; padding: 0; }
	li .name{ font-size: 2em; text-align: left; }
	.resultOption:after, .resultOption.hover:after{ color: red; font-size: 0.5em; cursor: pointer; }
	.resultOption:after{ content: 'View Results'; }
	.resultOption.hover:after{ content: 'Hide Results'; }
	.resultOption{ margin-left: 50px; }
	.StudentResults.hover{ display: none; }
	.StudentResults{ display: block; border: 1px solid black; padding: 10px; }
	table{ margin-left: 2%; width: 96%; display: block; }
	table.hover{ display: none; }
	td{ border: 1px solid black; text-align: center; }
	h3{ text-align: left; margin-top: 0; }
	.chkArea{ margin: auto; width: 15px; height: 15px; margin: 5px; border-radius: 50%; }
	.chkPrints{ color: black; border: 1px solid red; margin-right: 20px; margin-left: 10px; font-weight: bold; }
	.chkPrints:after{ content: "O"; }
	.chkPrints.hover:after{ content: "X"; margin-left: 1px; margin-right: 1px; }
	#exitIcon:hover{ cursor: pointer; }
	#exitIcon{ position: relative; left: 49%; margin-bottom: -26px; }
	.courseList, .topicList, .surveyList{ text-align: left; font-size: 1.5em; }
	.courseList li:hover, .topicList li:hover, .surveyList li:hover{ cursor: pointer; }
	.courseId, .topicId, .surveyId{ display: none; }
	.selOption{ padding-left: 1.1em; border: 1px solid #aaa; border-radius: 50%; margin-right: 10px;}
	.mainOption{ background-color: #139dff; border: 1px solid #139dff; }
	.btnBack, .btnNext{
		color: white; background-color: #139dff; border-radius: 20px; width: 6em; float: right; margin: 5px; font-size: 20px;
	}
</style>
<?php
	include './userManager.php';
	include './questionManager.php';
	$arrAllUsers = getAllStudents();
	$arrTitles = json_encode(getAllQuestions());
?>
<body>
<div class="HOutLine container">
</div>
<div class="BOutLine container">
	<div class="fBody">
		<img  id="exitIcon" src="./assets/img/exit.png">
		<div class="Header">
			<h1>Result View</h1>
		</div>
		<div class="Category row col-xs-12">
			<div class="col-xs-4">
				<h3>Course</h3>
				<ul class="courseList">
				<?php
					include_once("userManager.php");
					$courses = getCourseNames();
					for( $i = 0; $i < count($courses); $i ++){
						$course = $courses[$i];
						$arrCourseInfo = array();
						$arrCourseInfo = explode("---", $course);
						$courseId = $arrCourseInfo[0];
						$courseName = $arrCourseInfo[1];
				?>
					<li onclick="courseClicked(<?= $courseId ?>)">
						<span class="selOption"></span>
						<span class="courseId"><?= $courseId ?></span>
						<span class="courseName"><?= $courseName ?></span>
					</li>
				<?php
					}
				?>
				</ul>
			</div>
			<div class="col-xs-4">
				<h3>Topic</h3>
				<ul class="topicList">
				<?php
					$topics = getAllTopicNames();
					$_idTopic = 0;
					for( $i = 0; $i < count($topics); $i ++){
						$topic = $topics[$i];
						if( $i == 0) $_idTopic = $topic->Id;
				?>
					<li onclick="topicClicked(<?= $topic->Id ?>)">
						<span class="selOption"></span>
						<span class="topicId"><?= $topic->Id ?></span>
						<span class="topicName"><?= $topic->TopicName ?></span>
					</li>
				<?php
					}
				?>
				</ul>
			</div>
			<div class="col-xs-4">
				<h3>Survey</h3>
				<ul class="surveyList">
				<?php
					$surveys = getAllSurveysFromTopic($_idTopic);
					for( $i = 0; $i < count($surveys); $i ++){
						$survey = $surveys[$i];
				?>
					<li onclick="surveyClicked(<?= $survey->Id ?>)">
						<span class="selOption"></span>
						<span class="surveyId"><?= $survey->Id ?></span>
						<span class="surveyName"><?= $survey->SurveyName ?></span>
					</li>
				<?php
					}
				?>
				</ul>
			</div>
			<div class="col-xs-12">
				<div class="btnNext" onclick="nextClicked()">Next</div>
			</div>
		</div>
		<div class="ResultView row col-xs-12">
			<div class="col-xs-12">
				<div class="btnBack" onclick="backClicked()">Back</div>
			</div>
			<div class="col-lg-1 col-md-1"></div>
			<div class="col-lg-10 col-md-10 col-xs-12">
				<ul>
			<?php
				$arrBuf = array();
				for( $i = 0; $i < count($arrAllUsers); $i++){
					// $arrBuf = explode("---", $arrAllUsers[$i]);
					$strCourse = $arrAllUsers[$i]->CourseName; //$arrBuf[0];
					$userNumber = $arrAllUsers[$i]->UserNumber; //$arrBuf[1];
					$userFName = $arrAllUsers[$i]->FamilyName; //$arrBuf[2];
					$userGName = $arrAllUsers[$i]->GivenName; //$arrBuf[3];
					$userId = VerifyStudentInfo($userNumber, $userFName, $userGName);
			?>
				<li id="li_<?= $userId ?>"><div class="name"><?= $userFName." ".$userGName ?>
			<?php
				if( IsExistsUserAnswer($userId)){
			?>
				<span class="resultOption" onclick="viewToggle(<?= $i ?>, <?= $userId ?>)"></span>
			<?php
				}
			?>
				</div>
				<div class="StudentResults hover"></div>
			</li>
			<?php
				}
			?>
				</ul>
			</div>
			<div class="col-lg-1 col-md-1"></div>
			<br>
		</div>
		<div class="row">
			<input class="btnShape" action="action" onclick="window.location.href='admin_all.php'; return false;" type="button" value="Goto Main page" />
			<!-- <div class="col-lg-4 col-md-3 col-xs-2"></div> -->
		</div>
	</div>
</div>
<script type="text/javascript" src="assets/js/cookie.js"></script>
<script type="text/javascript">
	var arrTitles = [];
	arrTitles = JSON.parse('<?= $arrTitles ?>');
	console.log(arrTitles);
	function viewToggle(nId, uId){
		$(".resultOption").eq(nId).toggleClass('hover');
		$(".StudentResults").eq(nId).toggleClass('hover');
		if( $(".StudentResults").eq(nId).html() == ""){
			var strHtml = "";
			strHtml += '<p style="text-align: left;color: red;">select to view individual results</p>';
			for( var i = 0; i < arrTitles.length; i++){
				strHtml += '<div class="answerPan"><div class="chkArea fLeft" id="chk_'+uId+'_'+i+'" onclick="chkClick('+uId+','+i+')"></div>';
				strHtml += '<h3>' + arrTitles[i].Topic + '</h3>';
				strHtml += '<table class="hover">';
				strHtml += '<tr>';
				strHtml += '<td>question</td>'
				for( var j = 0; j < arrTitles[i].Questions.length; j++){
					strHtml += '<td>' + arrTitles[i].Questions[j].question + '</td>';
				}
				strHtml += '</tr>';
				strHtml += '<tr>';
				strHtml += '<td>answer</td>'
				for( var j = 0; j < arrTitles[i].Questions.length; j++){
					strHtml += '<td id="answer_'+uId+'_' + i + '_' + j + '"></td>';
				}
				strHtml += '</tr>';
				strHtml += '<tr>';
				strHtml += '<td>feedback</td>'
				for( var j = 0; j < arrTitles[i].Questions.length; j++){
					strHtml += '<td id="feedback_'+uId+'_' + i + '_' + j + '"></td>';
				}
				strHtml += '</tr>';
				strHtml += '</table></div>';
			}
			strHtml += "<div class='row'><p style='color:red;float:right;cursor:pointer;margin-right:20px;' id='chkPrint_"+uId+"' onclick='onPrint("+uId+")'>Print</p></div>";
			$(".StudentResults").eq(nId).html(strHtml);
			$.ajax({
				type: 'POST',
				url: 'questionManager.php',
				data: {getStudentAnswer: uId, fileCount:arrTitles.length}
			}).done(function (d) {
				var retVal = JSON.parse(d);
				console.log(retVal);
				//Answer
				for( var i = 0; i < retVal.length; i++){
					if( retVal[i] == "")continue;
					var question = retVal[i].Questions;
					for( var j = 0; j < question.length; j++){
						if( question[j].Kind == "shortAnswerSection"){
							if( question[j].answer == "")
								$("#answer_"+uId+"_"+i+"_"+j).html("no answer");
							else
								$("#answer_"+uId+"_"+i+"_"+j).html(question[j].answer);
						} else{
							var answerIds = [];
							answerIds = question[j].answer.split(",");
							var strHtml = '';
							if( answerIds.length == 0)
								strHtml = 'no answer';
							for( var k = 0; k < answerIds.length; k++){
								if( k == 0)
									strHtml += arrTitles[i].Questions[j].answers[parseInt(answerIds[k])].answer;
								else
									strHtml += ", " + arrTitles[i].Questions[j].answers[parseInt(answerIds[k])].answer;
							}
							$("#answer_"+uId+"_"+i+"_"+j).html( strHtml);
						}
					}
				}
				//Feedback
				for( var i = 0; i < retVal.length; i++){
					if( retVal[i] == "")continue;
					var question = retVal[i].Questions;
					for( var j = 0; j < question.length; j++){
						if(arrTitles[i].Questions[j].feedBack.isNeed == "false")
							continue;
						if( question[j].Kind == "shortAnswerSection"){
							$("#feedback_"+uId+"_"+i+"_"+j).html(arrTitles[i].Questions[j].feedBack[0]);
						} else{
							$("#feedback_"+uId+"_"+i+"_"+j).html(arrTitles[i].Questions[j].feedBack[0]);

							var answerIds = [];
							answerIds = question[j].answer.split(",");
							var strHtml = '';
							if( answerIds.length == 0)
								strHtml = 'no answer';
							for( var k = 0; k < answerIds.length; k++){
								if( k == 0)
									strHtml += arrTitles[i].Questions[j].feedBack.feedbacks[parseInt(answerIds[k])].feedback;
								else
									strHtml += ", " + arrTitles[i].Questions[j].feedBack.feedbacks[parseInt(answerIds[k])].feedback;
								console.log(strHtml);
							}
							$("#feedback_"+uId+"_"+i+"_"+j).html( strHtml);
						}
					}
				}
			});
		}
	}
	function chkClick(nUId,nQId){
		$("#chk_"+nUId+"_"+nQId).toggleClass('hover');
		$("#li_"+nUId).find(".answerPan").eq(nQId).find("table").toggleClass('hover');
	}
	function onPrint(nUId){
		// document.getElementById("li_"+nUId).print();

		var restorepage = document.body.innerHTML;
		$("#li_"+nUId).find(".StudentResults p").eq(0).remove();
		$("#chkPrint_"+nUId).remove();
		$("#li_"+nUId).find(".name .resultOption").eq(0).remove();
		var arrAnswers = $("#li_"+nUId).find(".StudentResults .answerPan");
		for( var i = arrAnswers.length-1; i >= 0; i--){
			if( ! arrAnswers.eq(i).find(".chkArea").hasClass("hover")){
				arrAnswers.eq(i).remove();
			}
		}
		var printcontent = document.getElementById("li_"+nUId).innerHTML;
		document.body.innerHTML = printcontent;
		window.print();
		document.body.innerHTML = restorepage;
	}
	function courseClicked(_id){
		$(".courseList li .selOption").removeClass("mainOption");
		$(".courseList li").filter(function(){
			return $(this).find(".courseId").html() == _id;
		}).find(".selOption").addClass("mainOption");
	}
	function topicClicked(_id){
		$(".topicList li .selOption").removeClass("mainOption");
		$(".topicList li").filter(function(){
			return $(this).find(".topicId").html() == _id;
		}).find(".selOption").addClass("mainOption");
	}
	function surveyClicked(_id){
		$(".surveyList li .selOption").removeClass("mainOption");
		$(".surveyList li").filter(function(){
			return $(this).find(".surveyId").html() == _id;
		}).find(".selOption").addClass("mainOption");
	}
	function nextClicked(){
		$(".Category").hide();
	}
	function backClicked(){
		$(".Category").show();
	}
</script>