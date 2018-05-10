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
		<form action="admin_all.php" method="post" id="formSubmit">
			<p>* Required</p>
			<label for adminName> Admin Name </label><br>
			<input type="text" id="adminName" name="adminName" required><br>
			<label for adminPass> Admin Password </label><br>
			<input type="password" id="adminPass" name="adminPass" required><br><br>
			<input type="button" name="" value="Confirm" onclick="ConfirmClicked()">
		</form>	
	</div>
	<div class="col-xs-1 col-md-2 col-lg-4"></div>
<script type="text/javascript" src="assets/js/cookie.js"></script>
<script type="text/javascript">
	function setCookie(cname,cvalue,exdays) {
		var d = new Date();
		d.setTime(d.getTime() + (exdays*24*60*60*1000));
		var expires = "expires=" + d.toGMTString();
		document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	}
	function ConfirmClicked(){
		var strAdminName = $("#adminName").val();
		var strAdminPass = $("#adminPass").val();
		console.log(strAdminName);
		console.log(strAdminPass);
		$.ajax({
			method: "POST",
			url: "userManager.php",
			data: { adminVerify: strAdminName, password: strAdminPass}
		}).done( function(msg){
			if( msg == "YES"){
				setCookie("QuestionnaireTeacherName", strAdminName, 1);
				window.location.href = "admin_all.php";
				document.getElementById("formSubmit").submit();
			} else{
				$(".RequiredMsg").removeClass("HideItem");
			}
		});
	}
</script>