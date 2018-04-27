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
				<table>
					<tr>
						<td colspan="2">Topics</td>
						<td colspan="2">Survey</td>
					</tr>
				<?php
					$dir = 'assets/questions/';
					$files = scandir($dir);
					$arrRet = array();
					$rowCount = 0;
					for( $i = 0; $i < count($files); $i ++){
						$fName = $files[$i];
						if( $fName != '.' && $fName != '..'){
							$rowCount ++;
							$pos = strpos($fName, ".");
							$buff = substr($fName, 0, $pos);
							$contents = file_get_contents($dir . $fName);
				?>
					<tr>
						<td><a href="questionMaker.php?title=<?= $buff ?>" class="Topic" style="text-align: left;"></a></td>
						<td class="edtBtn" onclick="changeTopics(<?= $rowCount ?>)">&#x270E;</td>
						<td class="Survey"><?= $buff ?></td>
						<td class="edtBtn" onclick="changeSurvey(<?= $rowCount ?>)">&#x270E;</td>
						<script type="text/javascript">
							var buff = <?= $contents ?>;
							arrTopics.push(buff.Topic);
						</script>
					</tr>
				<?php
						}
					}
				?>
				</table>
			</div>
			<div class="col-lg-3 col-md-2 col-xs-1"></div>
			<div style="clear: both;"></div>
			<br>
		</div>
		<div class="addNew" onclick="addNew()">+ NEW +</div>
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
</script>
<script type="text/javascript" src="assets/js/cookie.js"></script>
