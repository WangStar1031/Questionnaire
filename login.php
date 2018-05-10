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
		<h3>Invalid User Name or Password!</h3>
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
		<form action="admin_all.php" method="post" id="formSubmit">
			<p>* Required</p>
			<label for userMail> User Email or Name </label><br>
			<input type="text" id="userMail" name="userMail" required><br>
			<label for userPass> User Password </label><br>
			<input type="password" id="userPass" name="userPass" required><br><br>
			<input type="button" name="" value="Confirm" onclick="ConfirmClicked()">
			<input type="text" id="adminName" name="adminName" style="display: none;">
		</form>
		<p>If you don't have account, please <a href="signup.php">Signup</a>.</p>
	</div>
	<div class="col-xs-1 col-md-2 col-lg-4"></div>
<!-- 
<script type="text/javascript" src="assets/js/cookie.js"></script>
-->
<script type="text/javascript">
	function setCookie(cname,cvalue,exdays) {
		var d = new Date();
		d.setTime(d.getTime() + (exdays*24*60*60*1000));
		var expires = "expires=" + d.toGMTString();
		document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	}
	function ConfirmClicked(){
		var strUserName = $("#userMail").val();
		var strUserPass = $("#userPass").val();
		$.ajax({
			method: "POST",
			url: "userManager.php",
			data: { teacherVerify: strUserName, password: strUserPass}
		}).done( function(msg){
			if( msg != ""){
				$("#adminName").val(msg);
				setCookie("QuestionnaireUserName", strUserName, 1);
				setCookie("QuestionnaireUserPass", strUserPass, 1);
				// document.getElementById("formSubmit").submit();
			} else{
				$(".RequiredMsg").removeClass("HideItem");
			}
		});
		// console.log("ConfirmClicked");
		// window.location.href = "admin_all.php";
	}
</script>