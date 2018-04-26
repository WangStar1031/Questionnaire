<?php
	require('userManager.php');

	require('php-excel-reader/excel_reader2.php');

	require('SpreadsheetReader.php');
	function parseExcel($PathName, $FileName){
		$Reader = new SpreadsheetReader($PathName);
		foreach ($Reader as $Row)
		{
			$courseName = $Row[0];
			$courseId = getCourseIDFromName($courseName);
			if( $courseId == 0){
				addCourseNames( $courseName);
				$courseId = getCourseIDFromName($courseName);
			}
			$Number = $Row[1];
			$FName = $Row[2];
			$GName = $Row[3];
			$Email = $Row[4];
			addStudent($Number, $courseId, $FName, $GName, $Email);
		}
	}

	if(isset($_FILES['upload'])){
		if(count($_FILES['upload']['name']) > 0){
			echo count($_FILES['upload']['name']);
			$tmpFilePath = $_FILES['upload']['tmp_name'];
			echo $_FILES['upload']['tmp_name'];
			if($tmpFilePath != ""){
				$shortname = $_FILES['upload']['name'];
				mkdir("./assets/temp/");
				$filePath = "./assets/temp/" .$_FILES['upload']['name'];
				echo "<br>";
				echo $tmpFilePath;
				echo "<br>";
				echo $filePath;
				if(move_uploaded_file($tmpFilePath, $filePath)) {
					parseExcel($filePath, $_FILES['upload']['name']);
					// unlink($filePath);
				} else{
					echo "Don't copy.";
				}
			}
		}
	}
?>