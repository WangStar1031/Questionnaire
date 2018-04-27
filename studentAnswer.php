<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="./assets/css/studentAnswer.css?<?= time(); ?>">


<?php
	$userName = '';
	$title = '';
	if( isset($_GET['uName'])){
		$userName = $_GET['uName'];
		$userNumber = $_GET['uNum'];
		$title = $_GET['title'];
	} else{
		exit();
	}
?>
</head>
<body>
<div class="HOutLine container">		
</div>
<div class="BOutLine container">
	<div class="fBody">
		<div class="Header">
			<h1><?= $userName?>`s Answer (<?= $title?>)</h1>
				<p>Topic <span id="idTopic"></span></p>
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
	$fileName = $_GET['title'];
	$new = "new";
	$contents = "";
	$answers = "";
	$userId = $_GET['uId'];
	if( !isset($_GET['new'])){
		$new = "";
		$contents = file_get_contents("assets/questions/".$fileName.".txt");
		if( file_exists("assets/answers/".$userId."_".$fileName.".txt")){
			$answers = file_get_contents("assets/answers/".$userId."_".$fileName.".txt");
			// echo ($answers);
		}
		// else
		// 	echo "No Answer";
	}
?>
<script type="text/javascript">
	var userName = '<?= $userName ?>';
	var userNumber = '<?= $userNumber ?>';
	var userId = '<?= $userId ?>'
	var isNew = "<?= $new ?>" == "" ? false : true;	
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
			<!-- <p class="Title btnShape">Add multiple choice</p> -->
			<div class="col-md-3 col-lg-3"></div>
			<div class="Question col-md-6 col-lg-6 col-xs-12">
				<table>
					<!-- <tr>
						<td>Q</td>
						<td colspan="3"><input readonly type="text" name="mylQuestion" class="inputQuestion"></td>
					</tr> -->
				</table>
				<div style="clear: both;"></div>
			</div>
			<div style="clear: both;"></div>
		</div>
		<div class="checkBoxSection HideItem">
			<!-- <p class="Title btnShape">Check box</p> -->
			<div class="col-md-3 col-lg-3"></div>
			<div class="Question col-md-6 col-lg-6 col-xs-12">
				<table>
					<!-- <tr>
						<td>Q</td>
						<td colspan="3"><input readonly type="text" name="chkQuestion" class="inputQuestion"></td>
					</tr> -->
				</table>
				<div style="clear: both;"></div>
			</div>
			<div style="clear: both;"></div>
		</div>
		<div class="shortAnswerSection HideItem">
			<!-- <p class="Title btnShape">Short answer</p> -->
			<div class="col-md-3 col-lg-3"></div>
			<div class="Question col-md-6 col-lg-6 col-xs-12">
				<table>
					<!-- <tr>
						<td>Q</td>
						<td><input readonly type="text" name="ansQuestion" class="inputQuestion"></td>
					</tr> -->
				</table>
				<div style="clear: both;"></div>
			</div>
			<div style="clear: both;"></div>
		</div>
	</div>
</div>
<script src="./assets/js/studentAnswer.js?<?= time(); ?>"></script>
<?php
	if( $new == ""){
?>
<script type="text/javascript">
	var contents;
	if( isNew != true){
		contents = <?= $contents?>;
		console.log(contents);
		parseContents(contents);
		parseAnswers(<?= $answers ?>);
	}
</script>
<?php
	}
?>
</body>