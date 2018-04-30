<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="./assets/css/studentAnswer.css?<?= time(); ?>">


<?php
	include_once("userManager.php");
	$userId = '';
	$title = '';
	if( isset($_GET['uId'])){
		$userId = $_GET['uId'];
		$title = $_GET['title'];
	} else{
		exit();
	}
	$userInfo = getUserInfoFromId($userId);
	if( $userInfo == null) exit();
	$userNumber = $userInfo['UserNumber'];
	$userFName = $userInfo['FamilyName'];
	$userGName = $userInfo['GivenName'];
	$userName = $userFName . " " . $userGName;
	$surveyInfo = getSurveyFromId($title);
	$topicId = $surveyInfo['TopicId'];
	$surveyTitle = $surveyInfo['SurveyName'];
	$topicTitle = getTopicNameFromId($topicId);
	if( $surveyInfo == null) exit();
?>
</head>
<style type="text/css">
	.Header h1 span{
		font-size: 0.7em;
		color: gray;
	}
	#exitIconST:hover{
		cursor: pointer;
	}
	#exitIconST{
		position: relative; left: 49%; margin-bottom: -26px;
	}
</style>
<body>
<div class="HOutLine container">
</div>
<div class="BOutLine container">
	<div class="fBody">
		<img  id="exitIconST" src="./assets/img/exit.png">
		<div class="Header">
			<h1><?= $userName?>`s Answer<span> (<?= $topicTitle."-".$surveyTitle ?>)</span></h1>
		</div>
		<div class="addQuestion">
			<br>
			<div class="col-lg-5 col-md-4 col-xs-3"></div>
			<div class="saveQuestionsBtn col-lg-2 col-md-4 col-xs-6 btnShape" onclick="saveQuestion()">Submit Answers</div>
			<input class="btnShape" action="action" onclick="window.history.go(-1); return false;" type="button" value="Back" />
			<div class="col-lg-5 col-md-4 col-xs-3"></div>
		</div>
		<div style="clear: both;"></div>
	</div>
</div>
<?php
	$fileName = $title;
	$contents = "";
	$isNew = "";
	$answers = "";
	$userId = $_GET['uId'];
	$contents = json_encode(file_get_contents("assets/questions/".$title.".txt"));
	if( file_exists("assets/answers/".$userId."_".$fileName.".txt")){
		$isNew = "OK";
		$answers = json_encode(file_get_contents("assets/answers/".$userId."_".$fileName.".txt"));
	}
?>
<script type="text/javascript">
	var userName = '<?= $userName ?>';
	var userNumber = '<?= $userNumber ?>';
	var userId = '<?= $userId ?>'
	var strTopic;
	var fileName = "<?= $fileName ?>";
</script>
<div class="HideItem">
	<div class="Questions" id="Questions">
		<br>
		<div class="QuestionHeader container">
			<div class="QuestionNumber">Question1</div>
		</div>
		<div class="multiChoiceSection">
			<div class="col-md-3 col-lg-3"></div>
			<div class="Question col-md-6 col-lg-6 col-xs-12">
				<table>
				</table>
				<div style="clear: both;"></div>
			</div>
			<div style="clear: both;"></div>
		</div>
		<div class="checkBoxSection HideItem">
			<div class="col-md-3 col-lg-3"></div>
			<div class="Question col-md-6 col-lg-6 col-xs-12">
				<table>
				</table>
				<div style="clear: both;"></div>
			</div>
			<div style="clear: both;"></div>
		</div>
		<div class="shortAnswerSection HideItem">
			<div class="col-md-3 col-lg-3"></div>
			<div class="Question col-md-6 col-lg-6 col-xs-12">
				<table>
				</table>
				<div style="clear: both;"></div>
			</div>
			<div style="clear: both;"></div>
		</div>
	</div>
</div>
<script src="./assets/js/studentAnswer.js?<?= time(); ?>"></script>
<script type="text/javascript">
	var contents;
	contents = JSON.parse(<?= $contents?>);
	console.log(contents);
	parseContents(contents);
	var answers = "";
	var isNew = "<?= $isNew ?>";
	if( isNew != ""){
		answers = JSON.parse(<?= $answers ?>);
	}
	parseAnswers( answers);
</script>

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
</script>
</body>