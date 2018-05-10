<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="./assets/css/studentManager.css?<?= time(); ?>">

</head>

<?php
	include './userManager.php';
	// $arrUsers = getAllStudents();
?>
<style type="text/css">
	.activeArrow{
		border: solid black; border-width: 0 3px 3px 0; display: inline-block; padding: 3px; margin-left: 10px; cursor: pointer;
	}
	th{
		text-align: center;
	}
	th i{
		border: solid #aaa; border-width: 0 3px 3px 0; display: inline-block; padding: 3px; margin-left: 10px; cursor: pointer;
	}
	.up{
		transform: rotate(-135deg); -webkit-transform: rotate(-135deg);
	}
	.down{
		transform: rotate(45deg); -webkit-transform: rotate(45deg);
	}
	.mainTable th{
		cursor: pointer;
	}
	#exitIcon:hover{
		cursor: pointer;
	}
	#exitIcon{
		position: relative; left: 49%; margin-bottom: -26px;
	}
</style>

<body>
<div class="HOutLine container">
</div>
<div class="BOutLine container">
	<div class="fBody">
		<img  id="exitIcon" src="./assets/img/exit.png">
		<h1>Individual Manager</h1>
		<div>
			<table class="col-lg-12 col-md-12 col-xs-12 mainTable">
				<thead>
					<tr>
						<th>N<span style="text-decoration: underline;">o</span></th>
						<th onclick="changeCourseOrder()">Course<i class="arrow up activeArrow"></i></th>
						<th onclick="changeNumberOrder()">Number<i class="arrow up"></i></th>
						<th onclick="changeFNameOrder()">F-Name<i class="arrow up"></i></th>
						<th onclick="changeGNameOrder()">G-Name<i class="arrow up"></i></th>
						<th onclick="changeEmailOrder()">Email<i class="arrow up"></i></th>
					</tr>
				</thead>
				<tbody></tbody>
			
		<?php
		// for( $i = 0; $i < count($arrUsers); $i++){
		// 	$buff = $arrUsers[$i];
		// 	$userCourse = $buff->CourseName;
		// 	$userNumber = $buff->UserNumber;
		// 	$userFName = $buff->FamilyName;
		// 	$userGName = $buff->GivenName;
		// 	$userMail = $buff->eMail;
		?>
<!-- 			<tr>
				<td><?= $i + 1 ?></td>
				<td><input type="text" name="newCourse" class="newCourse" value="<?= $userCourse ?>" readonly></td>
				<td><input type="text" name="newNumber" class="newNumber" value="<?= $userNumber ?>" readonly></td>
				<td><input type="text" name="newFName" class="newFName" value="<?= $userFName ?>" readonly></td>
				<td><input type="text" name="newGName" class="newGName" value="<?= $userGName ?>" readonly></td>
				<td><input type="email" name="newMail" class="newMail" value="<?= $userMail ?>" readonly></td>
				<td class='edtBtn' onclick='onEdit(<?= $i ?>)'>&#x270E;</td>
				<td class='delBtn' onclick='onDel(<?= $i ?>)'>&#x2716;</td>
			</tr> -->
	<?php
		// }
	?>
			</table>
		</div>
		<div class="row">
			<div class="col-lg-2 col-md-2 col-xs-1"></div>
			<div class="addNew col-lg-3 col-md-3 col-xs-5" id="myBtn">Add individual</div>
			<div class="col-lg-2 col-md-2 col-xs-1"></div>
			<div class="addNew col-lg-3 col-md-3 col-xs-5" id="myBtnFromFile">
				<form id="uploadExcelForm" target="iframeTag" action="excelParsing.php" enctype="multipart/form-data" method="post">
					<div id="uploadFilePicker">
						<label for="file-upload" class="custom-file-upload">
							<i class="fa fa-cloud-upload"></i>Add from file
						</label>
						<input id="file-upload" name="upload" type="file"/>
					</div>
				</form>
			</div>
			<div class="col-lg-2 col-md-2 col-xs-1"></div>
		</div>
		<div class="row">
			<input class="btnShape" action="action" onclick="window.history.go(-1); return false;" type="button" value="Back" />
			<!-- <div class="col-lg-4 col-md-3 col-xs-2"></div> -->
		</div>
	</div>
<script type="text/javascript">
	var arrCourseNames = [];
	var arrCourseIds = [];
</script>
<div id="myModal" class="modal">
	<div class="modal-content">
		<span class="close">&times;</span>
		<table>
			<tr>
				<td>Course</td>
				<td>
					<select style="width: 100%;" id="newCourse">
<!-- 				<?php
					$arrCourse = getCourseNames();
					for( $i = 0; $i < count($arrCourse); $i++){
						$courseName = explode("---", $arrCourse[$i]);
				?>
					<option><?= $courseName[1] ?></option>
					<script type="text/javascript">
						arrCourseIds.push('<?= $courseName[0] ?>');
						arrCourseNames.push('<?= $courseName[1] ?>');
					</script>
				<?php						
					}
				?> -->
					</select>
				</td>
			</tr>
			<tr>
				<td>Number</td>
				<td><input type="text" name="newNumber" id="newNumber" placeholder="Enter the Number"></td>
			</tr>
			<tr>
				<td>F-Name</td>
				<td><input type="text" name="newFName" id="newFName" placeholder="Enter the Family Name"></td>
			</tr>
			<tr>
				<td>G-Name</td>
				<td><input type="text" name="newGName" id="newGName" placeholder="Enter the Given Name"></td>
			</tr>
			<tr>
				<td>Email</td>
				<td><input type="email" name="newMail" id="newMail" placeholder="Enter the Email Address"></td>
			</tr>
		</table>
		<div class="btnConfirm">Confirm</div>
	</div>
</div>
<script type="text/javascript" src="assets/js/cookie.js?<?= time() ?>"></script>

<script type="text/javascript">
	var modal = document.getElementById("myModal");
	var btn = document.getElementById("myBtn");
	var btnConfirm = document.getElementsByClassName("btnConfirm")[0];
	var span = document.getElementsByClassName("close")[0];
	var isNew = true;
	var nCurrentRow = 0;
	btn.onclick = function(){
		isNew = true;
		modal.style.display = "block";
	}
	span.onclick = function(){
		modal.style.display = "none";
	}
	window.onclick = function(event){
		if( event.target == modal){
			modal.style.display = "none";
		}
	}
	var arrMembers = [];
	function getAllStudents(){
		var strTeacherName = getCookie("QuestionnaireTeacherName");
		$.ajax({
			method: "POST",
			url: "userManager.php",
			datatype: "JSON",
			data: { getAllStudents: strTeacherName}
		}).done( function(msg){
			arrMembers = JSON.parse(msg);
			console.log(arrMembers);
			drawTable();
		});
	}
	getAllStudents();
	function getAllCourseNames(){
		var strTeacherName = getCookie("QuestionnaireTeacherName");
		$.ajax({
			method: "POST",
			url: "userManager.php",
			datatype: "JSON",
			data: { getCourseNames: strTeacherName}
		}).done( function(msg){
			var arrCourses = JSON.parse(msg);
			var strHtml = "";
			for( var i = 0; i < arrCourses.length; i++){
				var course  = arrCourses[i];
				strHtml += "<option>" + course['CourseName'] + "</option>";
				arrCourseIds.push(course['Id']);
				arrCourseNames.push(course['CourseName']);
			}
			$("#newCourse").html(strHtml);
		});	
	}
	getAllCourseNames();
	function drawTable(){
		var strHtml = "";
		for( var i = 0; i < arrMembers.length; i++){
			var elem = arrMembers[i];
			strHtml += "<tr><td class='No'>"+(i+1)+"</td><td><input  type='text' name='newCourse' class='newCourse' readonly value = '"+elem.CourseName+"'></td><td><input type='text' name='Number' class='newNumber' readonly value = '"+elem.UserNumber+"'></td><td><input type='text' name='newFName' class='newFName' readonly value='"+elem.FamilyName+"'></td><td><input type='text' name='newGName' class='newGName' readonly value='"+elem.GivenName+"'></td><td><input type='email' name='newMail' class='newMail' readonly value='"+elem.eMail+"'></td><td class='edtBtn' onclick='onEdit("+i+")'>&#x270E;</td><td class='delBtn' onclick='onDel("+i+")'>&#x2716;</td></tr>"; 
		}
		var Trs = $(".mainTable tbody").find("tr");
		Trs.remove();
		$(".mainTable tbody").append(strHtml);
	}
	function onNew(strCourse, strNumber, strFName, strGName, strMail){
		var elem = $(".mainTable").find("tr");
		var stdCount = elem.length - 1;
		var strHtml = "<tr><td class='No'>"+(stdCount+1)+"</td><td><input  type='text' name='newCourse' class='newCourse' readonly value = '"+strCourse+"'></td><td><input type='text' name='Number' class='newNumber' readonly value = '"+strNumber+"'></td><td><input type='text' name='newFName' class='newFName' readonly value='"+strFName+"'></td><td><input type='text' name='newGName' class='newGName' readonly value='"+strGName+"'></td><td><input type='email' name='newMail' class='newMail' readonly value='"+strMail+"'></td><td class='edtBtn' onclick='onEdit("+stdCount+")'>&#x270E;</td><td class='delBtn' onclick='onDel("+stdCount+")'>&#x2716;</td></tr>";
		$(".mainTable").append(strHtml);
	}
	function onUpdate(strCourse, strNumber, strFName, strGName, strMail){
		$('.mainTable').find('tr').eq(nCurrentRow).find(".newCourse").val(strCourse);
		$('.mainTable').find('tr').eq(nCurrentRow).find(".newNumber").val(strNumber);
		$('.mainTable').find('tr').eq(nCurrentRow).find(".newFName").val(strFName);
		$('.mainTable').find('tr').eq(nCurrentRow).find(".newGName").val(strGName);
		$('.mainTable').find('tr').eq(nCurrentRow).find(".newMail").val(strMail);
	}
	btnConfirm.onclick = function(){
		var strCourse = $("#newCourse").val();
		var strNumber = $("#newNumber").val();
		var strFName = $("#newFName").val();
		var strGName = $("#newGName").val();
		var strMail = $("#newMail").val();
		console.log({ Number: strNumber, Course: arrCourseIds[arrCourseNames.indexOf(strCourse)], FName: strFName, GName: strGName, Mail: strMail});
		if( strNumber == ""){
			alert("Please enter the Student Number");
			return;
		}
		if( strFName == ""){
			alert("Please enter the Family Name");
			return;
		}
		if( strGName == ""){
			alert("Please enter the Given Name");
			return;
		}
		if( isNew){
			var elemTr = $('.mainTable').find('tr');
			for( var i = 1; i < elemTr.length; i++){
				var strOtherNumber = elemTr.eq(i).find(".newNumber").val();
				if( strOtherNumber == strNumber){
					alert("Exist number");
					return;
				}
			}
			$.ajax({
				method: "POST",
				url: "userManager.php",
				data: { Number: strNumber, Course: arrCourseIds[arrCourseNames.indexOf(strCourse)], FName: strFName, GName: strGName, Mail: strMail}
			}).done( function(msg){
				console.log(msg);
				if( msg == "YES"){
					onNew(strCourse, strNumber, strFName, strGName, strMail);
					var temp = {};
					temp.CourseName = strCourse;
					temp.UserNumber = strNumber;
					temp.FamilyName = strFName;
					temp.GivenName = strGName;
					temp.eMail = strMail;
					arrMembers.push(temp);
					modal.style.display = "none";
				}else{
					alert("Cannot insert User info.");
				}
			});
		} else{
			var elemTr = $('.mainTable').find('tr');
			for( var i = 1; i < elemTr.length; i++){
				if( nCurrentRow == i)continue;
				var strOtherNumber = elemTr.eq(i).find(".newNumber").val();
				if( strOtherNumber == strNumber){
					alert("Exist number");
					return;
				}
			}
			var preCourse = $('.mainTable').find('tr').eq(nCurrentRow).find(".newCourse").val();
			var preNumber = $('.mainTable').find('tr').eq(nCurrentRow).find(".newNumber").val();
			var preFName = $('.mainTable').find('tr').eq(nCurrentRow).find(".newFName").val();
			var preGName = $('.mainTable').find('tr').eq(nCurrentRow).find(".newGName").val();
			var preMail = $('.mainTable').find('tr').eq(nCurrentRow).find(".newMail").val();
			$.ajax({
				method: "POST",
				url: "userManager.php",
				data: { preNumber: preNumber, curCourse:  arrCourseIds[arrCourseNames.indexOf(strCourse)], curNumber: strNumber, curFName: strFName, curGName: strGName, curMail: strMail}
			}).done( function(msg){
				if( msg == "YES"){
					onUpdate(strCourse, strNumber, strFName, strGName, strMail);
					arrMembers[nCurrentRow-1].CourseName = strCourse;
					arrMembers[nCurrentRow-1].UserNumber = strNumber;
					arrMembers[nCurrentRow-1].FamilyName = strFName;
					arrMembers[nCurrentRow-1].GivenName = strGName;
					arrMembers[nCurrentRow-1].eMail = strMail;
					modal.style.display = "none";
				}else{
					alert("Cannot insert User info.");
				}
			})
		}
	}
	function onDel(nNumber){
		var r = confirm("Are you sure delete this student?");
		if( r != true)return;
		var strNumber = $(".mainTable").find("tr").eq(nNumber+1).find(".newNumber").val();
		$.ajax({
			method: "POST",
			url: "userManager.php",
			data: { delNumber: strNumber}
		}).done( function(msg){
			if( msg == "YES"){
				arrMembers.splice(nNumber, 1);
				var elem = $(".mainTable").find("tr").eq(nNumber+1);
				elem.remove();
				elem = $('table').find('tr');
				for( i = 1; i < elem.length; i++){
					elem.eq(i).find(".No").html(i);
					elem.eq(i).find(".delBtn").attr("onclick", "onDel("+(i-1)+")");
				}
			}else{
				alert("Cannot Delete User.");
			}
		})
	}
	function onEdit(nNumber){
		console.log( nNumber);
		isNew = false;
		nCurrentRow = nNumber + 1;
		var elem = $('.mainTable').find('tr').eq(nNumber + 1);
		$("#newCourse").val(elem.find(".newCourse").val());
		$("#newNumber").val(elem.find(".newNumber").val());
		$("#newFName").val(elem.find(".newFName").val());
		$("#newGName").val(elem.find(".newGName").val());
		$("#newMail").val(elem.find(".newMail").val());
		modal.style.display = "block";
	}
	document.getElementById("file-upload").onchange = function() {
		console.log("file-upload");
		if( $("#courseName").val() == ""){
			alert("Please enter the Course Name");
			return;
		}
		document.getElementById("uploadExcelForm").submit();
	};
	function changeOrderIcon(_index){
		var retDir = 1; // down
		if( $('.arrow').eq(_index).hasClass("activeArrow") ){
			if( $('.arrow').eq(_index).hasClass("up")){
				$('.arrow').eq(_index).removeClass("up").addClass("down");
				retDir = 0;
			} else{
				$('.arrow').eq(_index).removeClass("down").addClass("up");
			}
		} else{
			$('.arrow').eq(_index).removeClass("down").addClass("up");
		}
		$(".arrow").removeClass("activeArrow");
		$(".arrow").eq(_index).addClass("activeArrow");
		return retDir;
	}
	function changeCourseOrder(){
		var orderDir = changeOrderIcon(0);
		arrMembers.sort( function(a, b){
			if( orderDir){
				return (a.CourseName > b.CourseName) ? 1 : -1;
			} else {
				return (a.CourseName < b.CourseName) ? 1 : -1;
			}
		});
		drawTable();
	}
	function changeNumberOrder(){
		var orderDir = changeOrderIcon(1);
		arrMembers.sort( function(a, b){
			if( orderDir){
				return (a.UserNumber > b.UserNumber) ? 1 : -1;
			} else {
				return (a.UserNumber < b.UserNumber) ? 1 : -1;
			}
		});
		drawTable();
	}
	function changeFNameOrder(){
		var orderDir = changeOrderIcon(2);
		arrMembers.sort( function(a, b){
			if( orderDir){
				return (a.FamilyName > b.FamilyName) ? 1 : -1;
			} else {
				return (a.FamilyName < b.FamilyName) ? 1 : -1;
			}
		});
		drawTable();
	}
	function changeGNameOrder(){
		var orderDir = changeOrderIcon(3);
		arrMembers.sort( function(a, b){
			if( orderDir){
				return (a.GivenName > b.GivenName) ? 1 : -1;
			} else {
				return (a.GivenName < b.GivenName) ? 1 : -1;
			}
		});
		drawTable();
	}
	function changeEmailOrder(){
		var orderDir = changeOrderIcon(4);
		arrMembers.sort( function(a, b){
			if( orderDir){
				return (a.eMail > b.eMail) ? 1 : -1;
			} else {
				return (a.eMail < b.eMail) ? 1 : -1;
			}
		});
		drawTable();
	}
</script>