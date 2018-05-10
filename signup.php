<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="./assets/css/questionMaker.css?<?= time(); ?>">
<style type="text/css">
	.HideItem{
		display: none;
	}
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
	<div class="row">
	<div class="col-xs-1 col-md-2 col-lg-4"></div>
	<div class="col-xs-10 col-md-8 col-lg-4 RequiredMsg HideItem">
		<h3>Existing User name or email.</h3>
	</div>
	</div>

	<div class="row" style="height: 50px;"></div>
	<div class="col-xs-1 col-md-2 col-lg-4"></div>
	<div class="col-xs-10 col-md-8 col-lg-4">
		<form>
			<label for userMail> User Email </label><br>
			<input type="email" id="userMail" name="userMail" required><br>
			<label for userName> User Name </label><br>
			<input type="text" id="userName" name="userName" required><br>
			<label for userPass> User Password </label><br>
			<input type="password" id="userPass" name="userPass" required><br><br>
			<input type="button" name="" value="Confirm" onclick="ConfirmClicked()">
		</form>
		<p>go to <a href="login.php">Login page</a>.</p>
	</div>
	<div class="col-xs-1 col-md-2 col-lg-4"></div>
<script type="text/javascript">
	function ConfirmClicked(){
		var strUserMail = $("#userMail").val();
		var strUserName = $("#userName").val();
		var strUserPass = $("#userPass").val();
		$.ajax({
			method: "POST",
			url: "userManager.php",
			data: { userSignup: strUserMail, userName: strUserName, userPass: strUserPass}
		}).done( function(msg){
			if( msg == "YES"){
				window.location.href = "login.php";
			} else{
				$(".RequiredMsg").removeClass("HideItem");
			}
		});
	}
</script>