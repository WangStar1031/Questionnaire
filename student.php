<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="./assets/css/questionMaker.css?<?= time(); ?>">
<style type="text/css">
	.HideItem{
		display: none;
	}
</style>
	<div class="row" style="height: 50px;"></div>
	<div class="row">
	<div class="col-xs-1 col-md-2 col-lg-4"></div>
	<div class="col-xs-10 col-md-8 col-lg-4 RequiredMsg HideItem">
		<h3>Invalid admin Name or Password!</h3>
	</div>
	</div>

<style type="text/css">
	label, input{
		font-size: 2em;
	}
	label:after{
		content: "*";
		color: red;
	}
	p, h3{
		color: red;
	}
</style>
	<div class="row" style="height: 50px;"></div>
	<div class="col-xs-1 col-md-2 col-lg-4"></div>
	<div class="col-xs-10 col-md-8 col-lg-4">
		<form>
			<p>* Required</p>
			<label for studentNumber> Student Number </label><br>
			<input type="text" id="studentNumber" name="studentNumber" required><br>
			<label for studentName> Student Name </label><br>
			<input type="text" id="studentName" name="studentName" required><br><br>
			<input type="button" name="" value="Confirm" onclick="ConfirmClicked()">
		</form>	
	</div>
	<div class="col-xs-1 col-md-2 col-lg-4"></div>
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
function ConfirmClicked(){
	var studentNumber = $("#studentNumber").val();
	var studentName = $("#studentName").val();
	console.log(studentNumber);
	console.log(studentName);
	$.ajax({
		method: "POST",
		url: "userManager.php",
		data: { userVerify: studentNumber, studentName: studentName}
	}).done( function(msg){
		console.log(msg);
		if( msg ){
			var idStudent = parseInt(msg);
			setCookie("QuestionnaireStudentNumber", studentNumber, 1);
			setCookie("QuestionnaireStudentName", studentName, 1);
			window.location.href = "student_main.php?userId=" + idStudent;
		} else{
			$(".RequiredMsg").removeClass("HideItem");
		}
	});
}
</script>