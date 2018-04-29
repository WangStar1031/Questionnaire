<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="./assets/css/questionMaker.css?<?= time(); ?>">
<link rel="stylesheet" type="text/css" href="./assets/css/courseManager.css?<?= time(); ?>">

</head>
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
	#CourseMngTbl td{
		border: 2px solid gray; text-align: center;
	}
	.up{
		transform: rotate(-135deg); -webkit-transform: rotate(-135deg);
	}
	.down{
		transform: rotate(45deg); -webkit-transform: rotate(45deg);
	}
	#CourseMngTbl th{
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
<iframe src="" style="display: none;" id="iframeTag" name="iframeTag"></iframe>
<div class="HOutLine container">		
</div>
<div class="BOutLine container">
	<div class="fBody">
		<img  id="exitIcon" src="./assets/img/exit.png">
<!-- 		<form action="admin.php" method="POST">
			<input type="image" id="exitIcon" src="./assets/img/exit.png" alt="Submit Form">
		</form>
 -->		<div class="Header">
			<h1>Course Management</h1>
		</div>
		<div class="mainCoursePan ShowItem">
			<h3>Course</h3>	
			<div class="CourseArea row">
				<div class="col-lg-3 col-md-2 col-xs-1"></div>
				<div class="CourseTable col-lg-6 col-md-8 col-xs-12">
					<table>
			<?php
				require_once "userManager.php";
				$arrCourse = getCourseNames();
				for( $i = 0; $i < count($arrCourse); $i++){
					$curCourse = explode( '---', $arrCourse[$i]);
					$courseId = $curCourse[0];
					$courseName = $curCourse[1];
			?>
					<tr>
						<td><input type="text" name="newCourseName" readonly value="<?= $courseName ?>"></td>
						<td class="edtBtn" onclick="editCourse(<?= $i ?>)">&#x270E;</td>
						<td class="delBtn" onclick="deleteCourse(<?= $i ?>)">&#x2716;</td>
					</tr>
			<?php
				}
			?>
					</table>
				</div>
				<div class="col-lg-3 col-md-2 col-xs-1"></div>
			</div>
			<div class="addCourse row">
				<div class="col-lg-5 col-md-5 col-xs-3"></div>
				<div class="addCourseBtn col-lg-2 col-md-2 col-xs-6 btnShape" onclick="addCourse()">Add course</div>
				<div class="col-lg-5 col-md-5 col-xs-3"></div>
			</div>
			<div class="row">
				<div class="col-lg-5 col-md-5 col-xs-3"></div>
				<input class="btnShape col-lg-2 col-md-2 col-xs-6" action="action" onclick="window.location.href='admin_all.php'; return false;" type="button" value="Back" />
				<div class="col-lg-5 col-md-5 col-xs-3"></div>
			</div>
		</div>
		<div class="addCoursePan HideItem">
			<p>Course Name 
				<span>
				<select onchange="courseChanged()" id="courseSelect">
					<?php
					for( $i = 0; $i < count($arrCourse); $i++){
						$curCourse = explode( '---', $arrCourse[$i]);
						$courseId = $curCourse[0];
						$courseName = $curCourse[1];
					?>
					<option><?= $courseName ?></option>
					<?php
					}
					?>
				</select>
				</span>
				<span class="edtBtn" onclick="changeCourseName()">&#x270E;</span>
			</p>
			<!-- <p>Course Name <span><input type="text" name="courseName" id="courseName" onchange="courseNameChange()" required></span></p> -->
			<table id="CourseMngTbl">
				<tr>
					<th onclick="changeNumberOrder()">ID Number<i class="arrow up activeArrow"></i></th>
					<th onclick="changeFamilyNameOrder()">Family Name<i class="arrow up"></i></th>
					<th onclick="changeGivenNameOrder()">Given Name<i class="arrow up"></i></th>
					<th onclick="changeeMailOrder()">Email Address<i class="arrow up"></i></th>
				</tr>
			</table>
			<div class="row">
				<div class="col-lg-3 col-md-2 col-xs-2"></div>
				<div class="addIndividualBtn col-lg-3 col-md-4 col-xs-4 btnShape" onclick="addIndividual()">Add individual</div>
				<div class="col-lg-1 col-md-1 col-xs-1"></div>
				<div class="addFromFileBtn col-lg-3 col-md-4 col-xs-4 btnShape" onclick="addFromFile()">
					<form id="uploadExcelForm" target="iframeTag" action="excelParsing.php" enctype="multipart/form-data" method="post">
						<div id="uploadFilePicker">
							<label for="file-upload" class="custom-file-upload">
								<i class="fa fa-cloud-upload"></i>Add from file
							</label>
							<input id="file-upload" name="upload" type="file"/>
							<input type="text" name="CourseName" id="CourseName" class="HideItem" required>
						</div>
					</form>
				</div>
				<div class="col-lg-2 col-md-2  col-xs-1"></div>
			</div>
			<div class="row">
				<div class="col-lg-5 col-md-5 col-xs-4"></div>
				<div class="col-lg-2 col-md-2 col-xs-4 btnShape" onclick="closeAddPan()">close</div>
				<div class="col-lg-5 col-md-5 col-xs-4"></div>
			</div>
		</div>
	</div>
</div>
<div id="myModal" class="modal">
	<div class="modal-content">
		<span class="close">&times;</span>
		<table>
			<tr>
				<td>Number</td>
				<td><input type="text" name="newNumber" id="newNumber" placeholder="Enter the Number" required></td>
			</tr>
			<tr>
				<td>F-Name</td>
				<td><input type="text" name="newFName" id="newFName" placeholder="Enter the Family Name" required></td>
			</tr>
			<tr>
				<td>G-Name</td>
				<td><input type="text" name="newGName" id="newGName" placeholder="Enter the Given Name"></td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input type="text" name="newPass" id="newPass" placeholder="Enter the Password"></td>
			</tr>
			<tr>
				<td>Email</td>
				<td><input type="email" name="newMail" id="newMail" placeholder="Enter the Email Address"></td>
			</tr>
		</table>
		<div class="btnConfirm">Confirm</div>
	</div>
</div>

<script type="text/javascript">
	var modal = document.getElementById("myModal");
	var btnConfirm = document.getElementsByClassName("btnConfirm")[0];
	var span = document.getElementsByClassName("close")[0];
	var isNew = true;
	var nCurrentRow = 0;
	var arrCourseInfo = [];
	var idCurMember;
	span.onclick = function(){
		modal.style.display = "none";
	}
	window.onclick = function(event){
		if( event.target == modal){
			modal.style.display = "none";
		}
	}
	btnConfirm.onclick = function(){
		var strNumber = $("#newNumber").val();
		var strFName = $("#newFName").val();
		var strGName = $("#newGName").val();
		var strPass = $("#newPass").val();
		var strMail = $("#newMail").val();
		var strCourseName = $("#courseSelect").val();
		if( strNumber == "" || strFName == "" || strGName == ""){
			alert("Please enter the Number or Names");
			return;
		}

		if( isNew == false){
			$.ajax({
				method: "POST",
				url: "userManager.php",
				data: { memberChange: strCourseName, IDMember: idCurMember, IDNumber: strNumber, strFName:strFName, strGName:strGName, strPass:strPass, strMail:strMail}
			}).done( function(msg){
				if( msg == "YES"){
					courseChanged();
					modal.style.display = "none";
				} else{
					alert("Cannot insert.");
				}
			});
			return;
		}
		$.ajax({
			method: "POST",
			url: "userManager.php",
			data: { newMemberToCourse: strCourseName, IDNumber: strNumber, strFName:strFName, strGName:strGName, strPass:strPass, strMail:strMail}
		}).done( function(msg){
			if( msg == "YES"){
				courseChanged();
				modal.style.display = "none";
			} else{
				alert("Cannot insert.");
			}
		});
	}
	function addNewCourse(strCourseName){
		var arrTrs = $(".CourseTable").find("table tr");
		var isEqual = false;
		for( var i = 0; i < arrTrs.length; i++){
			var elem = arrTrs.eq(i);
			if( elem.find("td").eq(0).find("input").val() == strCourseName){
				isEqual = true;
				break;
			}
		}
		if( isEqual == true){
			alert("Exist Course Name");
			return;
		}
		$.ajax({
			method: "POST",
			url: "userManager.php",
			data: { newCourseName: strCourseName}
		}).done( function(msg){
			if( msg == "YES"){
				var nCourseNum = $(".CourseTable").find("table tr").length;
				var strHtml = '';
				strHtml += '<tr><td><input type="text" readonly value="'+strCourseName+'"></td><td class="edtBtn" onclick="editCourse('+nCourseNum+')">&#x270E;</td><td class="delBtn" onclick="deleteCourse('+nCourseNum+')">&#x2716;</td></tr>';
				$(".CourseTable").find("table").append(strHtml);
				strHtml = "<option>"+strCourseName+"</option>";
				$("#courseSelect").append(strHtml);
				modal.style.display = "none";
			}else{
				alert("Cannot insert Course.");
			}
		});
	}
	function addCourse(){
		var strCourseName = prompt("Please enter the course Name");
		if( strCourseName == null || strCourseName == ""){
			return;
		} else {
			addNewCourse(strCourseName);
		}
	}
	function deleteCourse(nNumber){
		var aa = confirm("Are you sure Delete?");
		if( aa == true){
			var strCourseName = $(".CourseTable tr").eq(nNumber).find("input").val();
			console.log(strCourseName);
			$.ajax({
				method: "POST",
				url: "userManager.php",
				data: { removeCourse: strCourseName}
			}).done( function(msg){
				var trElem = $(".CourseTable tr");
				for( var i = 0; i < trElem.length; i++){
					if( trElem.eq(i).find("input").val() === strCourseName){
						trElem.eq(i).remove();
					}
				}
				var selElem = $("#courseSelect option");
				for( var i = 0; i < selElem.length; i ++){
					if( selElem.eq(i).html() === strCourseName){
						selElem.eq(i).remove();
					}
				}
			});
		}
	}
	function editCourse(nNumber){
		$("#courseSelect").prop('selectedIndex', nNumber);
		var strCourseName = $(".CourseTable table tr").eq(nNumber).find("input").val();
		var elemTr = $(".addCoursePan table tr");
		for( var i = elemTr.length - 1; i > 0; i--){
			elemTr.eq(i).remove();
		}
		$(".addCoursePan p span").find("input").val(strCourseName);
		$(".mainCoursePan").removeClass("ShowItem").addClass("HideItem");
		$(".addCoursePan").removeClass("HideItem").addClass("ShowItem");

		$.ajax({
			method: "POST",
			url: "userManager.php",
			datatype:"JSON",
			data: { getInfoFromCourseName: strCourseName}
		}).done( function(msg){
			var arrInfos = [];
			arrInfos = JSON.parse(msg);
			arrCourseInfo = arrInfos;
			$(".arrow").removeClass("activeArrow").removeClass("down").addClass("up");
			$(".arrow").eq(0).addClass("activeArrow");
			for( var i = 0; i < arrInfos.length; i++){
				var strNumber = arrInfos[i].Number;
				var strFName = arrInfos[i].FamilyName;
				var strGName = arrInfos[i].GivenName;
				var strPass = arrInfos[i].UserPassword;
				var strEmail = arrInfos[i].eMail;
				var strHtml = "<tr><td>"+strNumber+"</td><td>"+strFName+"</td><td>"+strGName+"</td><td>"+strEmail+"</td><td class='edtBtn' onclick='editMember("+i+")'>&#x270E;</td><td class='delBtn' onclick='delMember("+i+")'>&#x2716;</td></tr>";
				$(".addCoursePan table").append(strHtml);
			}
		});
	}
	function addIndividual(){
		if( $("#courseName").val() == ""){
			alert("Please enter the Course Name");
			return;
		}
		isNew = true;
		modal.style.display = "block";
	}
	function addFromFile(){
	}
	function closeAddPan(){
		$(".addCoursePan").removeClass("ShowItem").addClass("HideItem");
		$(".mainCoursePan").removeClass("HideItem").addClass("ShowItem");
	}
	function courseNameChange(){
		$("#CourseName").val($("#courseName").val());
	}
	document.getElementById("file-upload").onchange = function() {
		if( $("#courseName").val() == ""){
			alert("Please enter the Course Name");
			return;
		}
		document.getElementById("uploadExcelForm").submit();
	};
	// function changeNumberOrder(_type){
	// 	$('.arrow').removeClass("activeArrow");
	// 	switch(_type){
	// 		case 'Number':
	// 			$('.arrow').eq(0).addClass("activeArrow");
	// 			break;
	// 		case 'FamilyName':
	// 			$('.arrow').eq(1).addClass("activeArrow");
	// 			break;
	// 		case 'GivenName':
	// 			$('.arrow').eq(2).addClass("activeArrow");
	// 			break;
	// 		case 'eMail':
	// 			$('.arrow').eq(3).addClass("activeArrow");
	// 			break;
	// 	}
	// }
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
	function orderTable(){
		var arrInfos = [];
		arrInfos = arrCourseInfo;
		$(".addCoursePan table tr").filter(function(index){return index > 0;}).remove();
		for( var i = 0; i < arrInfos.length; i++){
			var strNumber = arrInfos[i].Number;
			var strFName = arrInfos[i].FamilyName;
			var strGName = arrInfos[i].GivenName;
			var strPass = arrInfos[i].UserPassword;
			var strEmail = arrInfos[i].eMail;
			var strHtml = "<tr><td>"+strNumber+"</td><td>"+strFName+"</td><td>"+strGName+"</td><td>"+strEmail+"</td><td class='edtBtn' onclick='editMember("+i+")'>&#x270E;</td><td class='delBtn' onclick='delMember("+i+")'>&#x2716;</td></tr>";
			$(".addCoursePan table").append(strHtml);
		}
	}
	function changeNumberOrder(){
		var orderDir = changeOrderIcon(0);
		arrCourseInfo.sort( function(a, b){
			if( orderDir){
				return (a.Number > b.Number) ? 1 : -1;
			} else {
				return (a.Number < b.Number) ? 1 : -1;
			}
		});
		orderTable();
	}
	function changeFamilyNameOrder(){
		var orderDir = changeOrderIcon(1);
		arrCourseInfo.sort( function(a, b){
			if( orderDir){
				return (a.FamilyName > b.FamilyName) ? 1 : -1;
			} else {
				return (a.FamilyName < b.FamilyName) ? 1 : -1;
			}
		});
		orderTable();
	}
	function changeGivenNameOrder(){
		var orderDir = changeOrderIcon(2);
		arrCourseInfo.sort( function(a, b){
			if( orderDir){
				return (a.GivenName > b.GivenName) ? 1 : -1;
			} else {
				return (a.GivenName < b.GivenName) ? 1 : -1;
			}
		});
		orderTable();
	}
	function changeeMailOrder(){
		var orderDir = changeOrderIcon(3);
		arrCourseInfo.sort( function(a, b){
			if( orderDir){
				return (a.eMail > b.eMail) ? 1 : -1;
			} else {
				return (a.eMail < b.eMail) ? 1 : -1;
			}
		});
		orderTable();
	}
	function editMember(_index){
		isNew = false;
		idCurMember = arrCourseInfo[_index].Id;
		$("#newNumber").val(arrCourseInfo[_index].Number);
		$("#newFName").val(arrCourseInfo[_index].FamilyName);
		$("#newGName").val(arrCourseInfo[_index].GivenName);
		$("#newPass").val(arrCourseInfo[_index].UserPassword);
		$("#newMail").val(arrCourseInfo[_index].eMail);

		modal.style.display = "block";
	}
	function delMember(_index){
		var aa = confirm("Are you sure Delete?");
		if( aa == true){
			var curInfo = arrCourseInfo[_index];
			console.log(curInfo);
			$.ajax({
				method: "POST",
				url: "userManager.php",
				data: { removeMember: curInfo.Id}
			}).done( function(msg){
				if(msg == "YES"){
					courseChanged();
				} else{
					alert("Can't remove.");
				}
			});

		}
	}
	function courseChanged(){
		var _index = $("#courseSelect").prop('selectedIndex');
		editCourse(_index);
	}
	function changeCourseName(){
		var strCourseName = $("#courseSelect").val();
		var strNewCourseName = prompt("Please enter new course Name.", strCourseName);
		if( strNewCourseName == null)
			return;
		var options = $("#courseSelect").find("option");
		var isEqual = false;
		for( var i = 0; i < options.length; i++){
			var elem = options.eq(i);
			if( elem.html() === strNewCourseName){
				isEqual = true;
				break;
			}
		}
		if( isEqual == true){
			alert("Exist Course Name");
			return;
		}
		// ajax call to change course name

		$.ajax({
			method: "POST",
			url: "userManager.php",
			datatype:"JSON",
			data: { changeCourseName: strCourseName, strNewCourseName: strNewCourseName}
		}).done( function(msg){
			if( msg == "YES"){
				var options = $("#courseSelect").find("option");
				for( var i = 0; i < options.length; i++){
					var elem = options.eq(i);
					if( elem.html() === strCourseName){
						elem.html(strNewCourseName);
						break;
					}
				}
				var arrTrs = $(".CourseTable").find("table tr");
				for( var i = 0; i < arrTrs.length; i++){
					var elem = arrTrs.eq(i);
					if( elem.find("input").val() == strCourseName){
						elem.find("input").val(strNewCourseName);
						break;
					}
				}
			} else{
				alert("Can't change.");
			}
		});
	}
</script>