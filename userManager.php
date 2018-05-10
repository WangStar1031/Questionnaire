<?php
	function getConn(){
		
		// $DBservername = 'localhost';
		// $DBusername = 'earthso6_root';
		// $DBpassword = '123guraud!';
		// $DBname = 'earthso6_question_user';
		
		$DBservername = 'localhost';
		$DBusername = 'root';
		$DBpassword = '';
		$DBname = 'questionnaire';

		$conn = new mysqli( $DBservername, $DBusername, $DBpassword, $DBname);
		return $conn;
	}
	function getUserInfoFromId($_id){
		$conn = getConn();
		if( $conn->connect_error){
			return null;
		}
		$sql = "SELECT * FROM user WHERE Id='$_id'";
		$result = $conn->query($sql);
		if( $result->num_rows > 0){
			$row = mysqli_fetch_assoc($result);
			return $row;
		}
		return null;
	}
	function VerifyAdminInfo($name, $pass){
		$conn = getConn();
		if( $conn->connect_error){
			echo("Connection failed: " . $conn->connect_error);
			return false;
		}
		$sql = "SELECT Id FROM user WHERE BINARY FamilyName = BINARY '" . $name . "' AND UserPassword = '" . $pass . "'";
		$result = $conn->query($sql);
		if( is_null($result))return false;
		if( $result->num_rows > 0)
			return true;
		return false;
	}
	if( isset($_POST['adminVerify'])){
		$adminName = $_POST['adminVerify'];
		$adminPass = $_POST['password'];
		if( VerifyAdminInfo($adminName, $adminPass)){
			echo "YES";
		} else{
			echo "NO";
		}
	}
	function VerifyStudentInfo($strNumber, $strName){
		$conn = getConn();
		if( $conn->connect_error){
			echo("Connection failed: " . $conn->connect_error);
			return 0;
		}
		$sql = "SELECT Id FROM user WHERE UserNumber = '" . $strNumber . "' AND ( BINARY FamilyName = BINARY '" . $strName . "' OR BINARY GivenName = BINARY '" . $strName ."')";
		$result = $conn->query($sql);
		if( is_null($result))return 0;
		if( $result->num_rows > 0){
			$row = mysqli_fetch_assoc($result);
			return $row['Id'];
		}
		return 0;
	}
	if( isset($_POST['userVerify'])){
		$userNumber = $_POST['userVerify'];
		$userName = $_POST['studentName'];
		echo VerifyStudentInfo($userNumber, $userName);
	}
	function IsExistsUserAnswer($userId){
		$dir = './assets/answers/';
		$files = scandir($dir);
		$arrRet = array();
		for( $i = 0; $i < count($files); $i ++){
			$fName = $files[$i];
			if( $fName != '.' && $fName != '..'){
				if( strpos( $fName, $userId."_") === 0){
					return true;
				}
			}
		}
		return false;
	}
	function getCourseNames(){
		$conn = getConn();
		if( $conn->connect_error){
			echo("Connection failed: " . $conn->connect_error);
			return false;
		}
		$sql = "SELECT * FROM course";
		$result = $conn->query($sql);
		if( is_null($result))return array();
		if( mysqli_num_rows($result) == 0)
			return array();
		$arrResult = array();
		while( $row = mysqli_fetch_assoc($result)){
			$CourseId = $row['Id'];
			$CourseName = $row['CourseName'];
			array_push($arrResult, $CourseId.'---'.$CourseName);
		}
		return $arrResult;
	}
	function getAllStudents(){
		$conn = getConn();
		if( $conn->connect_error){
			echo("Connection failed: " . $conn->connect_error);
			return false;
		}
		$sql = "SELECT CourseId, UserNumber, FamilyName, GivenName, eMail FROM user WHERE UserNumber <> ''";
		$result = $conn->query($sql);
		if( is_null($result))return array();
		if( mysqli_num_rows($result) == 0)
			return array();
		$arrResult = array();
		while( $row = mysqli_fetch_assoc($result)){
			$elem = new stdClass();
			$CourseId = $row['CourseId'];
			$CourseName = "";
			if( $CourseId != null){
			$sql = "SELECT CourseName FROM course WHERE Id = ".$CourseId;
				$result1 = $conn->query($sql);
				if( !is_null($result1)){
					if( mysqli_num_rows($result1)){
						$row1 = mysqli_fetch_assoc($result1);
						$CourseName = $row1['CourseName'];
					}
				}
			}
			$elem->CourseName = $CourseName;
			$elem->UserNumber = $row['UserNumber'];
			$elem->FamilyName = $row['FamilyName'];
			$elem->GivenName = $row['GivenName'];
			$elem->eMail = $row['eMail'];
			array_push($arrResult, $elem);
		}
		return $arrResult;
	}
	if(isset($_POST['getAllStudents'])){
		echo json_encode(getAllStudents());
	}
	function addStudent($Number, $CourseId, $FName, $GName, $Mail){
		$conn = getConn();
		if( $conn->connect_error){
			echo("Connection failed: " . $conn->connect_error);
			return false;
		}
		$sql = "INSERT INTO user( CourseId, UserNumber, FamilyName, GivenName, eMail) VALUES('" . $CourseId . "','" . $Number . "','" . $FName . "','" . $GName . "','" . $Mail . "')";
		$retVal = $conn->query($sql);
		if( $retVal === TRUE || $retVal == TRUE){
			return true;
		}
		return false;
	}
	function updateStudent($preNumber, $strCourse, $strNumber, $strFName, $strGName, $strMail){
		$conn = getConn();
		if( $conn->connect_error){
			echo("Connection failed: " . $conn->connect_error);
			return false;
		}
		$sql = "UPDATE user SET CourseId='".$strCourse."', UserNumber = '".$strNumber."', FamilyName = '".$strFName."', GivenName = '".$strGName."', eMail = '".$strMail."' WHERE UserNumber='".$preNumber."'";
		if($conn->query($sql) === TRUE)
			return true;
		return false;
	}
	function deleteStudent($nNumber){
		$conn = getConn();
		if( $conn->connect_error){
			echo("Connection failed: " . $conn->connect_error);
			return false;
		}
		$sql = "DELETE FROM user WHERE UserNumber='".$nNumber."'";
		if($conn->query($sql) === TRUE)
			return true;
		return false;
	}
	if( isset($_POST['Number']) && isset($_POST['FName'])){
		$Number = $_POST['Number'];
		$CourseId = $_POST['Course'];
		$FName = $_POST['FName'];
		$GName = $_POST['GName'];
		$Mail = $_POST['Mail'];
		if( addStudent($Number, $CourseId, $FName, $GName, $Mail) == true)
			echo "YES";
		else
			echo "NO";
	}
	if( isset($_POST['preNumber'])){
		$preNumber = $_POST['preNumber'];
		$strCourse = $_POST['curCourse'];
		$strNumber = $_POST['curNumber'];
		$strFName = $_POST['curFName'];
		$strGName = $_POST['curGName'];
		$strMail = $_POST['curMail'];
		if( updateStudent($preNumber, $strCourse, $strNumber, $strFName, $strGName, $strMail) == true)
			echo "YES";
		else
			echo "NO";
	}
	if( isset($_POST['delNumber'])){
		if( deleteStudent($_POST['delNumber'])){
			echo "YES";
		} else{
			echo "NO";
		}
	}
	function addCourseNames($courseName){
		$conn = getConn();
		if( $conn->connect_error){
			echo("Connection failed: " . $conn->connect_error);
			return false;
		}
		$sql = "INSERT INTO course(CourseName) VALUES('$courseName')";
		$retVal = $conn->query($sql);
		if( $retVal === TRUE || $retVal == TRUE){
			return true;
		}
		return false;
	}
	if( isset($_POST['newCourseName'])){
		$courseName = $_POST['newCourseName'];
		if( addCourseNames($courseName) == true){
			echo "YES";
		} else {
			echo "NO";
		}
	}
	function getCourseIDFromName($courseName){
		$conn = getConn();
		if( $conn->connect_error){
			echo("Connection failed: " . $conn->connect_error);
			return false;
		}
		$sql = "SELECT Id FROM course WHERE CourseName = '" . $courseName . "'";
		$result = $conn->query($sql);
		if( is_null($result))return 0;
		if( $result->num_rows > 0){
			$row = mysqli_fetch_assoc($result);
			return $row['Id'];
		}
		return 0;
	}
	function addTeacher($courseId, $nIDNumber, $strFName, $strGName, $strPass, $strMail){
		$conn = getConn();
		if( $conn->connect_error){
			echo("Connection failed: " . $conn->connect_error);
			return 0;
		}
		$sql = "INSERT INTO user(CourseId, UserNumber, FamilyName, GivenName, UserPassword, eMail) VALUES($courseId,'$nIDNumber','$strFName','$strGName','$strPass','$strMail')";
		// echo $sql;
		$retVal = $conn->query($sql);
		if( $retVal === TRUE || $retVal == TRUE){
			return 1;
		}
		return 0;

	}
	if( isset($_POST['newMemberToCourse'])){
		$courseName = $_POST['newMemberToCourse'];
		$courseId = getCourseIDFromName($courseName);
		if( $courseId == 0){
			echo "NO";
		} else{
			$nIDNumber = $_POST['IDNumber'];
			$strFName = $_POST['strFName'];
			$strGName = $_POST['strGName'];
			$strPass = $_POST['strPass'];
			$strMail = $_POST['strMail'];
			if( addTeacher($courseId, $nIDNumber, $strFName, $strGName, $strPass, $strMail) == 0){
				echo "NO";
			} else{
				echo "YES";
			}
		}
	}
	function changeTeacher($memberId, $courseId, $nIDNumber, $strFName, $strGName, $strPass, $strMail){
		$conn = getConn();
		if( $conn->connect_error){
			echo("Connection failed: " . $conn->connect_error);
			return 0;
		}
		$sql = "UPDATE user SET UserNumber='$nIDNumber', FamilyName='$strFName', GivenName='$strGName', UserPassword='$strPass', eMail='$strMail' WHERE Id='$memberId'";
		// echo $sql;
		$conn->query($sql);
		return 1;

	}
	if( isset($_POST['memberChange'])){
		$courseName = $_POST['memberChange'];
		$courseId = getCourseIDFromName($courseName);
		if( $courseId == 0){
			echo "NO";
		} else{
			$memberId = $_POST['IDMember'];
			$nIDNumber = $_POST['IDNumber'];
			$strFName = $_POST['strFName'];
			$strGName = $_POST['strGName'];
			$strPass = $_POST['strPass'];
			$strMail = $_POST['strMail'];
			if( changeTeacher($memberId, $courseId, $nIDNumber, $strFName, $strGName, $strPass, $strMail) == 0){
				echo "NO";
			} else{
				echo "YES";
			}
		}
	}
	function removeMember($idMember){
		$conn = getConn();
		if( $conn->connect_error){
			echo("Connection failed: " . $conn->connect_error);
			return "NO";
		}
		$sql = "DELETE FROM user WHERE Id = '$idMember'";
		$conn->query($sql);
		return "YES";
	}
	if( isset($_POST['removeMember'])){
		$idMember = $_POST['removeMember'];
		echo removeMember($idMember);
	}
	function removeCourse($courseName){
		$conn = getConn();
		if( $conn->connect_error){
			echo("Connection failed: " . $conn->connect_error);
			return "NO";
		}
		$sql = "DELETE FROM course WHERE binary(CourseName) = binary('$courseName')";
		$conn->query($sql);
		return "YES";
	}
	if( isset($_POST['removeCourse'])){
		$courseName = $_POST['removeCourse'];
		echo removeCourse($courseName);
	}
	function getTeachersFromCourse($courseId){
		$conn = getConn();
		if( $conn->connect_error){
			echo("Connection failed: " . $conn->connect_error);
			return "";
		}
		$sql = "SELECT Id, UserNumber, FamilyName, GivenName, UserPassword, eMail FROM user WHERE CourseId = '" . $courseId . "'";
		$result = $conn->query($sql);
		if( is_null($result))return "";
		$arrRet = array();
		$elem = new stdClass();
		while($row = mysqli_fetch_assoc($result)){
			$elem->Id = $row['Id'];
			$elem->Number = $row['UserNumber'];
			$elem->FamilyName = $row['FamilyName'];
			$elem->GivenName = $row['GivenName'];
			$elem->UserPassword = $row['UserPassword'];
			$elem->eMail = $row['eMail'];
			array_push($arrRet, clone($elem));
		}
		return $arrRet;
	}
	if( isset($_POST['getUsersFromCourseId'])){
		$courseId = $_POST['getUsersFromCourseId'];
		$arrUsers = getTeachersFromCourse($courseId);
		$arrAnswers = scandir('assets/answers');
		for($i = 0; $i < count($arrUsers); $i ++){
			$user = $arrUsers[$i];
			$prefix = $user->Id;
			$arrUsers[$i]->isAnswer = false;
			for($j = 0; $j < count($arrAnswers); $j++){
				if( strpos( $arrAnswers[$j], $prefix) !== false){
					$arrUsers[$i]->isAnswer = true;
					break;
				}
			}
		}
		echo json_encode($arrUsers);
	}
	if( isset($_POST['getInfoFromCourseName'])){
		$courseName = $_POST['getInfoFromCourseName'];
		$courseId = getCourseIDFromName($courseName);
		// echo $courseId;
		$arrInfos = getTeachersFromCourse($courseId);
		echo json_encode( $arrInfos);
	}
	function ChangeCourseName($oldName, $newName){
		$conn = getConn();
		if( $conn->connect_error){
			echo("Connection failed: " . $conn->connect_error);
			return false;
		}
		$sql = "UPDATE course SET CourseName = '$newName' WHERE binary(CourseName) = binary('$oldName')";
		$conn->query($sql);
		return true;
	}
	if( isset($_POST['changeCourseName'])){
		$oldCourseName = $_POST['changeCourseName'];
		$newCourseName = $_POST['strNewCourseName'];
		if( ChangeCourseName( $oldCourseName, $newCourseName) == true){
			echo "YES";
		} else{
			echo "NO";
		}
	}

	function getAllTopicNames($_userId){
		$conn = getConn();
		if( $conn->connect_error){
			return false;
		}
		$sql = "SELECT Id FROM teacher WHERE userName='$_userId'";
		$result = $conn->query($sql);
		$teacherId = 0;
		if( $result->num_rows != 0){
			$row = mysqli_fetch_assoc($result);
			$teacherId = $row['Id'];
		}
		if( $teacherId == 0)
			return array();

		$sql = "SELECT * FROM topic WHERE userId='$teacherId' ORDER BY Id";
		$result = $conn->query($sql);
		$arrRetVal = array();
		while($row = mysqli_fetch_assoc($result)){
			$topic = new stdClass();
			$topic->Id = $row['Id'];
			$topic->TopicName = $row['TopicName'];
			array_push( $arrRetVal, $topic);
		}
		return $arrRetVal;
	}
	function getTopicNameFromId($_id){
		$conn = getConn();
		if( $conn->connect_error){
			return "";
		}
		$sql = "SELECT * FROM topic WHERE Id='$_id'";
		$result = $conn->query($sql);
		if( $result->num_rows > 0){
			$row = mysqli_fetch_assoc($result);
			return $row['TopicName'];
		}
		return "";
	}
	function changeTopicName($_id, $_newName){
		$conn = getConn();
		if($conn->connect_error){
			return false;
		}
		$sql = "UPDATE topic SET TopicName='$_newName' WHERE Id='$_id'";
		return $conn->query($sql);
	}
	function removeTopic($_id){
		$conn = getConn();
		if( $conn->connect_error){
			return false;
		}
		$sql = "DELETE FROM topic WHERE Id='$_id'";
		if( !$conn->query($sql)){
			return false;
		}
		removeSurveyFromTopic($_id);
		return true;
	}
	function insertNewTopic($_topicName){
		$conn = getConn();
		if( $conn->connect_error){
			return false;
		}
		$sql = "INSERT INTO topic(TopicName) VALUES('$_topicName')";
		return $conn->query($sql);
	}
	function getAllSurveysFromTopic($_topicId){
		$conn = getConn();
		if( $conn->connect_error){
			return false;
		}
		$sql = "SELECT * FROM survey WHERE TopicId='$_topicId'";
		$result = $conn->query($sql);
		$arrRet = array();
		while( $row = mysqli_fetch_assoc($result)){
			$survey = new stdClass();
			$survey->Id = $row['Id'];
			$survey->SurveyName = $row['SurveyName'];
			array_push( $arrRet, $survey);
		}
		return $arrRet;
	}
	function getSurveyFromId($_id){
		$conn = getConn();
		if( $conn->connect_error){
			return null;
		}
		$sql = "SELECT * FROM survey WHERE Id='$_id'";
		$result = $conn->query($sql);
		if( $result->num_rows > 0){
			$row = mysqli_fetch_assoc($result);
			return $row;
		}
		return null;
	}
	function removeSurveyFromTopic($_id){
		$conn = getConn();
		if( $conn->connect_error){
			return false;
		}
		$sql = "DELETE FROM survey WHERE TopicId='$_id'";
		return $conn->query($sql);
	}
	function removeSurvey($_id){
		$conn = getConn();
		if( $conn->connect_error){
			return false;
		}
		$sql = "DELETE FROM survey WHERE Id='$_id'";
		return $conn->query($sql);
	}
	function insertNewSurvey($_topicId, $_newName){
		$conn = getConn();
		if( $conn->connect_error){
			return false;
		}
		$sql = "INSERT INTO survey(TopicId, SurveyName) VALUES('$_topicId', '$_newName')";
		return $conn->query($sql);
	}
	function changeSurveyName($_id, $_newName){
		$conn = getConn();
		if( $conn->connect_error){
			return false;
		}
		$sql = "UPDATE survey SET SurveyName='$_newName' WHERE Id='$_id'";
		return $conn->query($sql);
	}
	if(isset($_POST['addTopic'])){
		if( insertNewTopic($_POST['addTopic'])){
			$arrRet = array();
			$arrRet = getAllTopicNames();
			echo $arrRet[count($arrRet) - 1]->Id;
		} else{
			echo 0;
		}
	}
	if( isset($_POST['changeTopicName'])){
		echo changeTopicName($_POST['changeTopicName'], $_POST['newVal']);
	}
	if( isset($_POST['removeTopic'])){
		echo removeTopic($_POST['removeTopic']);
	}
	if( isset($_POST['getSurveys'])){
		echo json_encode(getAllSurveysFromTopic($_POST['getSurveys']));
	}
	if( isset($_POST['addSurvey'])){
		if( insertNewSurvey($_POST['addSurvey'], $_POST['newVal'])){
			$arrBuff = array();
			$arrBuff = getAllSurveysFromTopic($_POST['addSurvey']);
			echo $arrBuff[count($arrBuff) - 1]->Id;
		} else{
			echo 0;
		}
	}
	if( isset($_POST['changeSurveyName'])){
		echo  changeSurveyName($_POST['changeSurveyName'], $_POST['newVal']);
	}
	function insertTeacher($_mail, $_name, $_pass){
		$conn = getConn();
		if( $conn->connect_error){
			return false;
		}
		$sql = "SELECT Id FROM teacher WHERE userName='$_name' OR userMail='$_mail'";
		$result = $conn->query($sql);
		if( $result->num_rows > 0){
			return false;
		}
		$sql = "INSERT INTO teacher(userName, userMail, userPassword) VALUES('$_name', '$_mail', '$_pass')";
		return $conn->query($sql);
	}
	if( isset($_POST['userSignup'])){
		$_mail = $_POST['userSignup'];
		$_name = $_POST['userName'];
		$_pass = $_POST['userPass'];
		if( insertTeacher($_mail, $_name, $_pass)){
			echo "YES";
		} else{
			echo "NO";
		}
	}
	function teacherVerify($_name, $_pass){
		$conn = getConn();
		if( $conn->connect_error){
			return "";
		}
		$sql = "SELECT * FROM teacher WHERE (userName='$_name' OR userMail='$_name') AND userPassword='$_pass'";
		$result = $conn->query($sql);
		if( $result->num_rows == 0){
			return "";
		}
		$row = mysqli_fetch_assoc($result);
		return $row['userName'];
	}
	if( isset($_POST['teacherVerify'])){
		$_teacherName = $_POST['teacherVerify'];
		$_password = $_POST['password'];
		$userName = teacherVerify($_teacherName, $_password);
		echo $userName;
	}
?>