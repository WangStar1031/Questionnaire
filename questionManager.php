<?php

	if(isset($_POST['saveContents'])){
		$title = $_POST['saveContents'];
		$contents = $_POST['contents'];
		file_put_contents("assets/questions/".$title.".txt", json_encode($contents));
	}
	if(isset($_POST['getContents'])){
		$title = $_POST['getContents'];
		echo file_get_contents("assets/questions/".$title.".txt");
	}
	if (isset($_POST['saveAnswers'])) {
		$title = $_POST['saveAnswers'];
		$contents = $_POST['contents'];
		$userId = $_POST['userId'];
		file_put_contents("assets/answers/".$userId."_".$title.".txt", json_encode($contents));
	}
	if(isset($_POST['getStudentAnswer'])){
		$studentId = $_POST['getStudentAnswer'];
		$arrSurveys = $_POST['arrSurveys'];
		$objRet = new stdClass();
		$arrRet = array();
		for( $i = 0; $i < count($arrSurveys); $i++){
			$survey = $arrSurveys[$i];
			$fileName = './assets/answers/'.$studentId.'_'.$survey.'.txt';
			// echo $fileName;
			if( file_exists($fileName)){
				array_push($arrRet, json_decode(file_get_contents($fileName)));
			} else{
				array_push($arrRet, "");
			}
		}
		$objRet->uId = $studentId;
		$objRet->answer = $arrRet;
		echo json_encode($objRet);
	}
	if( isset($_POST['changeTopics'])) {
		$fName = './assets/questions/' . $_POST['changeTopics'] . '.txt';
		$contents = file_get_contents($fName);
		$varTemp = json_decode( $contents);
		$varTemp->Topic = $_POST['newVal'];
		file_put_contents( $fName, json_encode($varTemp));
		echo "OK";
	}
	if( isset($_POST['changeSurvey'])) {
		$fName = './assets/questions/' . $_POST['changeSurvey'] . '.txt';
		$fNewName = './assets/questions/' . $_POST['newVal'] . '.txt';
		rename($fName, $fNewName);
		echo "OK";
	}
	function getTopicFromTitle($title){
		$contents = file_get_contents("assets/questions/".$title.".txt");
	}
	function getAllTopics(){
		$dir = './assets/questions/';
		$files = scandir($dir);
		$arrRet = array();
		for( $i = 0; $i < count($files); $i ++){
			$fName = $files[$i];
			if( $fName != '.' && $fName != '..'){
				$contents = file_get_contents($dir.$fName);
				$buff = json_decode($contents);
				array_push($arrRet, $buff->Topic);
			}
		}
		return $arrRet;
	}
	function getAllQuestions(){
		$dir = './assets/questions/';
		$files = scandir($dir);
		$arrRet = array();
		$fileNumber = 0;
		for( $i = 0; $i < count($files); $i ++){
			$fName = $files[$i];
			if( $fName != '.' && $fName != '..'){
				$fileNumber++;
				$contents = file_get_contents($dir.$fName);
				array_push($arrRet, json_decode( $contents));
			}
		}
		return $arrRet;
	}
?>