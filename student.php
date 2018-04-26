<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="./assets/css/questionMaker.css?<?= time(); ?>">
<style type="text/css">
	table{
		font-size: 1.5em;
	}
	.addNew{
		cursor: pointer;
	}
</style>
</head>

<?php
	include './userManager.php';
	$userNumber = '';
	$userName = '';
	if( isset($_POST['userNumber']) && isset($_POST['userName'])){
		$userNumber = $_POST['userNumber'];
		$userName = $_POST['userName'];
		$userId = VerifyStudentInfo($userNumber, $userName);
		if( $userId != 0){
?>
<script type="text/javascript">
	var arrTopics = [];
</script>
<body>
<div class="HOutLine container">		
</div>
<div class="BOutLine container">
	<div class="fBody">
		<div class="Header">
			<h1>Topics</h1>
		</div>
		<div class="Lessons">
			<div class="col-lg-3 col-md-2 col-xs-1"></div>
			<div class="col-lg-6 col-md-8 col-xs-10">
				<table>
					<tr>
						<td>Lesson Number</td>
						<td>Topics</td>
					</tr>
				<?php
					$dir = 'assets/questions/';
					$files = scandir($dir);
					$arrRet = array();
					for( $i = 0; $i < count($files); $i ++){
						$fName = $files[$i];
						if( $fName != '.' && $fName != '..'){
							$pos = strpos($fName, ".");
							$buff = substr($fName, 0, $pos);
							$contents = file_get_contents($dir . $fName);
				?>
					<tr>
						<td><?= $buff ?></td>
						<td><a href="studentAnswer.php?uId=<?= $userId ?>&uNum=<?= $userNumber ?>&uName=<?= $userName ?>&title=<?= $buff ?>" class="Topic"></a></td>
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
	</div>
</div>
<script type="text/javascript">
	var elemTable = $("table");
	for( var i = 1; i < $("table").find("tr").length; i++){
		$("table").find("tr").eq(i).find(".Topic").html(arrTopics[i-1]);
	}
</script>

<?php
	}else{
		?>
	<div class="row" style="height: 50px;">
	<div class="col-xs-1 col-md-2 col-lg-4"></div>
	<div class="col-xs-10 col-md-8 col-lg-4">
		<p>Invalid UserNumber or UserName.</p>
	<div class="col-xs-1 col-md-2 col-lg-4"></div>
	</div>
		<?php
		$userNumber = '';
		$userName = '';
	}
}
	if( $userNumber == '' && $userName == ''){
?>
<style type="text/css">
	label, input{
		font-size: 2em;
	}
	label:after{
		content: "*";
		color: red;
	}
	p{
		color: red;
	}
</style>
	<div class="row" style="height: 50px;"></div>
	<div class="col-xs-1 col-md-2 col-lg-4"></div>
	<div class="col-xs-10 col-md-8 col-lg-4">
		<form action="student.php" method="POST">
			<p>* Required</p>
			<label for userNumber> Student Number </label><br>
			<input type="text" name="userNumber" required><br>
			<label for userName> Student Name </label><br>
			<input type="text" name="userName" required><br><br>
			<input type="submit" name="" value="Confirm">
		</form>	
	</div>
	<div class="col-xs-1 col-md-2 col-lg-4"></div>
<?php
}
?>