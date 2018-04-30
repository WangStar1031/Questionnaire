<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="./assets/css/questionMaker.css?<?= time(); ?>">

<style type="text/css">
	.row{
		margin-top: 10px;
		margin-bottom: 10px;
	}
</style>
</head>

<body>
<div class="HOutLine container">		
</div>
<div class="BOutLine container">
	<div class="fBody">
		<div class="Header">
			<h1>Questionnaire Maker</h1>
				<p>Topic <input type="text" name="Travel" placeholder="Please enter the Topic" id="idTopic"></p>
		</div>
		<div class="addQuestion row">
			<div class="col-lg-1 col-md-1 col-xs-1"></div>
			<div class="addQuestionBtn col-lg-3 col-md-3 col-xs-3 btnShape" onclick="addQuestion()">Add Question</div>
			<div class="col-lg-1 col-md-1 col-xs-1"></div>
			<div class="addQuestionBtn col-lg-2 col-md-2 col-xs-2 btnShape" onclick="delQuestion()">Del Question</div>
			<div class="col-lg-1 col-md-1 col-xs-1"></div>
			<div class="saveQuestionsBtn col-lg-3 col-md-3 col-xs-3 btnShape" onclick="saveQuestion()">Save Questions</div>
			<div class="col-lg-1 col-md-1 col-xs-1"></div>
		</div>
		<div class="row">
			<div class="col-lg-5 col-md-5 col-xs-3"></div>
			<input class="btnShape col-lg-2 col-md-2 col-xs-6" action="action" onclick="window.location.href='admin_all.php'; return false;" type="button" value="Back" />
			<div class="col-lg-5 col-md-5 col-xs-3"></div>
		</div>
	</div>
</div>
<?php
	$fileName = $_GET['title'];
	$new = "new";
	$contents = "";
	$fName = "assets/questions/".$fileName.".txt";
	if( file_exists($fName)){
	// if( !isset($_GET['new'])){
		$new = "";
		$contents = file_get_contents($fName);
		// echo $contents;
	}
?>
<script type="text/javascript">
	var isNew = "<?= $new ?>" == "" ? false : true;	
	var fileName = "<?= $fileName ?>";
</script>
<div class="HideItem">
	<div class="Questions" id="Questions">
		<div class="QuestionHeader row">
			<div class="QuestionNumber  col-md-4 col-lg-4 col-xs-4">Question1</div>
			<div class="QuestionKind  col-md-6 col-lg-6 col-xs-6" onchange="changeOption()">
				<select>
					<option>Add multiple choice</option>
					<option>Check box</option>
					<option>Short answer</option>
				</select>
			</div>
			<div class="QuestionDel btnShape col-md-2 col-lg-2 col-xs-2">Delete</div>
		</div>
		<div class="multiChoiceSection row">
			<div class="row">
				<!-- <p class="Title btnShape">Add multiple choice</p> -->
				<select class="orderKind" onchange="changeKind()" value="No Lettering">
					<option>No Lettering</option>
					<option>A)</option>
					<option>A.</option>
					<option>a)</option>
					<option>a.</option>
					<option>1)</option>
					<option>1.</option>
				</select>
			</div>
			<div class="row">
				<div class="Question col-md-6 col-lg-6 col-xs-12">
					<table>
						<tr>
							<td>Q</td>
							<td colspan="3"><input type="text" name="mylQuestion" class="inputQuestion"></td>
						</tr>
					</table>
					<p class="MulMoreBtn btnShape fLeft">Add more choices</p>
				</div>
				<div class="fbOption col-md-6 col-lg-6 col-xs-12">
					<p class="btnShape fLeft">Feedback Option</p>
					<div class="chkArea fLeft"></div>
					<table class="hover">
					</table>
				</div>
			</div>
		</div>
		<div class="checkBoxSection HideItem">
			<div class="row">
				<!-- <p class="Title btnShape">Check box</p> -->
				<select class="orderKind" onchange="changeKind()" value="No Lettering">
					<option>No Lettering</option>
					<option>A)</option>
					<option>A.</option>
					<option>a)</option>
					<option>a.</option>
					<option>1)</option>
					<option>1.</option>
				</select>
			</div>
			<div class="row">
				<div class="Question col-md-6 col-lg-6 col-xs-12">
					<table>
						<tr>
							<td>Q</td>
							<td colspan="3"><input type="text" name="chkQuestion" class="inputQuestion"></td>
						</tr>
					</table>
					<p class="ChkMoreBtn btnShape fLeft">Add more choices</p>
					<div style="clear: both;"></div>
				</div>
				<div class="fbOption col-md-6 col-lg-6 col-xs-12">
					<p class="btnShape fLeft">Feedback Option</p>
					<div class="chkArea fLeft"></div>
					<table class="hover">
					</table>
				</div>
			</div>
		</div>
		<div class="shortAnswerSection HideItem row">
			<!-- <p class="Title btnShape">Short answer</p> -->
			<div class="Question col-md-6 col-lg-6 col-xs-12">
				<table>
					<tr>
						<td>Q</td>
						<td><input type="text" name="ansQuestion" class="inputQuestion"></td>
					</tr>
					<tr>
						<td>A</td>
						<td><textarea class="answer"></textarea></td>
					</tr>
				</table>
			</div>
			<div class="fbOption ansOption col-md-6 col-lg-6 col-xs-12">
				<p class="btnShape fLeft">Feedback Option</p>
				<div class="chkArea fLeft"></div>
				<table class="hover">
					<tr>
						<td>A</td>
						<td><textarea class="answer"></textarea></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
<script src="./assets/js/questionMaker.js?<?= time(); ?>"></script>
<?php
	if( $new == ""){
?>
<script type="text/javascript">
	var contents;
	if( isNew != true){
		contents = <?= $contents?>;
		console.log(contents);
		parseContents(contents);
	}
</script>
<?php
	}
?>
</body>