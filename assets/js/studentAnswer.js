var nQuestionCount = 0;
// var strTopic = "";
function addQuestion(strQuestion) {
	// strTopic = document.getElementById("idTopic").value;
	// if( strTopic == ""){
	// 	alert("Please enter the Topic Name!");
	// 	return;
	// }
	nQuestionCount ++;
	var elem = $("#Questions").clone();
	elem.removeClass("HideItem");
	elem.removeClass("ShowItem");
	elem.attr("id","Questions"+nQuestionCount);
	elem.find(".QuestionNumber").html("Q" + nQuestionCount + ": " + strQuestion);
	elem.insertBefore(".addQuestion");
}
var chara = ['A','B','C','D','E','F','G','H','I','J','H','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
function changeKindById(strId, strPrefix){
	var parent = $("#"+strId);
	// var elem = parent.find(".ShowItem .orderKind").eq(0);
	var value = strPrefix;
	var prefix, lastfix;
	if( value == "A)"){
		prefix = "A"; lastfix = ")";
	} else if( value == "A."){
		prefix = "A"; lastfix = ".";
	} else if( value == "a)"){
		prefix = "a"; lastfix = ")";
	} else if( value == "a."){
		prefix = "a"; lastfix = ".";
	} else if( value == "1)"){
		prefix = "1"; lastfix = ")";
	} else if( value == "1."){
		prefix = "1"; lastfix = ".";
	}
	var elemTr = parent.find(".ShowItem table").eq(0).find("tr");
	var curPre;
	for( var i = 0; i < elemTr.length; i++){
		if( prefix == "A") curPre = chara[i];
		else if( prefix == "a") curPre = chara[i].toLowerCase();
		else curPre = i;
		console.log(prefix + curPre + lastfix);
		elemTr.eq(i).find(".chr").html( curPre + lastfix);
	}
}
function mulChkClicked(nNumber, nRow){
	var elemTable = $("#Questions"+nNumber).find(".multiChoiceSection .Question table tr");
	$("#Questions"+nNumber).find(".multiChoiceSection .Question table .chkArea").removeClass('hover');
	elemTable.eq(nRow).find(".chkArea").addClass('hover');
	// elemTable.find(".chr").html("F");
	// elemTable.eq(nRow).find(".chr").html("T");
}
function chkChoClicked( nNumber, nRow){
	var elemTable = $("#Questions"+nNumber).find(".checkBoxSection .Question table tr").eq(nRow);
	elemTable.find(".chkArea").toggleClass('hover');
}
function getKind(strClass){
	if( strClass.indexOf("multiChoiceSection") > -1)
		return "multiChoiceSection";
	if( strClass.indexOf("checkBoxSection") > -1)
		return "checkBoxSection";
	if( strClass.indexOf("shortAnswerSection") > -1)
		return "shortAnswerSection";
}
function saveQuestion(){
	var qStrings = {};
	var arrQuestions = [];
	// qStrings.Topic = $("#idTopic").html();
	for( var i = 1; i < nQuestionCount+1; i++){
		var questions = {};
		var elemKind = $("#Questions"+i).find(".ShowItem");
		var strClass = elemKind.attr("class");
		var strKind = getKind(strClass);
		var elemTrs = elemKind.find(".Question table tr");
		var strAnswer = "";
		questions.Kind = strKind;
		if( strKind == "multiChoiceSection" || strKind == "checkBoxSection"){
			for( var j = 0; j < elemTrs.length; j++){
				var strChk = elemTrs.eq(j).find(".chkArea");
				if( strChk.attr("class").indexOf("hover") > -1){
					if( strAnswer == "")
						strAnswer += j;
					else
						strAnswer += "," + j;
				}
			}
		} else if( strKind == "shortAnswerSection"){
			strAnswer = elemTrs.eq(0).find("textarea").val();
			strAnswer = strAnswer.replace(/"/g, "`");
			strAnswer = strAnswer.replace(/'/g, "`");
		}
		questions.answer = strAnswer;

		arrQuestions.push( questions);
	}
	qStrings.Questions = arrQuestions;
	var sss = {saveAnswers: fileName, contents:qStrings, userNumber:userNumber, userName: userName};
	$.ajax({
		type: 'POST',
		url: 'questionManager.php',
		data: {saveAnswers: fileName, contents:qStrings, userId:userId}
	}).done(function (d) {
		console.log(d);
		alert("Saved!");
	});

}
function addMulChoiceFromData( nQNum, nANum, strAnswer){
	var elem = $("#Questions"+nQNum).find(".multiChoiceSection .Question table");
	var nRows = $("#Questions"+nQNum).find(".multiChoiceSection .Question table tr").length;
	var strTr = '<tr>';
	strTr += '<td><div class="chkArea" onclick="mulChkClicked('+nQNum+','+(nRows)+')"></div></td>';
	strTr += '<td class="chr">F</td>';
	strTr += '<td><input readonly type="text" name="chkQuestion"';
	if( strAnswer!= "") strTr += " value='" + strAnswer + "'";
	strTr += ' class="answer"></td>';
	strTr += '</tr>';
	elem.append(strTr);
}
function addChkChoiceFromData(nQNum, nANum, strAnswer){
	var elem = $("#Questions"+nQNum).find(".checkBoxSection .Question table");
	var strTr = '<tr>';
	strTr += '<td><div class="chkArea" onclick="chkChoClicked('+nQNum+','+(nANum-1)+')"></div></td>';
	// strTr += '<td class="chr">'+chara[nANum-1]+'</td>';
	strTr += '<td><input readonly type="text" name="mulQuestion"';
	if( strAnswer!= "") strTr += " value='" + strAnswer + "'";
	strTr += ' class="answer"></td>';
	strTr += '</tr>';
	elem.append(strTr);
}
function addShtChoiceFromData(nQNum, nANum, strAnswer){
	var elem = $("#Questions"+nQNum).find(".shortAnswerSection .Question table");
	var nRows = $("#Questions"+nQNum).find(".shortAnswerSection .Question table tr").length;
	var strTr = '<tr>';
	strTr += '<td><textarea placeholder="Please enter the short Answer." class="answer">';
	if( strAnswer != "") strTr += strAnswer;
	strTr += '</textarea></td></tr>';
	elem.append(strTr);
}
function parseContents( jsonContents){
	if( jsonContents =="")return;
	// strTopic = jsonContents.Topic;
	// $("#idTopic").html( strTopic);
	for( var i = 0; i < jsonContents.Questions.length; i++){
		var Questions = jsonContents.Questions[i];
		strType = Questions.type;
		addQuestion(Questions.question);
		var parent = $("#Questions"+(i+1));
		parent.find(".multiChoiceSection").removeClass("ShowItem").addClass("HideItem");
		parent.find(".checkBoxSection").removeClass("ShowItem").addClass("HideItem");
		parent.find(".shortAnswerSection").removeClass("ShowItem").addClass("HideItem");

		if( strType == "Add multiple choice"){
			parent.find(".multiChoiceSection").removeClass("HideItem").addClass("ShowItem");
			parent.find(".multiChoiceSection").find(".inputQuestion").val(Questions.question);
		} else if ( strType == "Check box"){
			parent.find(".checkBoxSection").removeClass("HideItem").addClass("ShowItem");
			parent.find(".checkBoxSection").find(".inputQuestion").val(Questions.question);
		} else{
			parent.find(".shortAnswerSection").removeClass("HideItem").addClass("ShowItem");
			parent.find(".shortAnswerSection").find(".inputQuestion").val(Questions.question);
		}
		for( var j = 0; j < Questions.answers.length; j++){
			var answers = Questions.answers[j];
			var chr = answers.chara;
			var answer = answers.answer;
			if( strType == "Add multiple choice"){
				addMulChoiceFromData( i + 1, j + 1, answer);
			} else if ( strType == "Check box"){
				addChkChoiceFromData( i + 1, j + 1, answer);
			} else {
				addShtChoiceFromData( i + 1, j + 1, "");
				break;
			}
		}
		if( strType == "Add multiple choice"){
			changeKindById("Questions"+(i+1), Questions.selectKind);
		}
	}
}
function parseAnswers(strAnswer){
	if( strAnswer == ""){
		console.log("No Answer.");
		return;
	}
	console.log(strAnswer);
	var arrQuestions = strAnswer.Questions;
	for( var i = 0; i < arrQuestions.length; i++){
		var strKind = arrQuestions[i].Kind;
		var strMidAnswer = arrQuestions[i].answer;
		if( strKind == "multiChoiceSection"){
			var arrRows = strMidAnswer.split(",");
			for( var j = 0; j < arrRows.length; j++){
				$("#Questions"+(i+1)).find(".ShowItem .Question table tr").eq(j).find(".chkArea").addClass("hover");
				// $("#Questions"+(i+1)).find(".ShowItem .Question table tr").eq(j).find(".chr").html("T");
			}
		} else if(strKind == "checkBoxSection"){
			var arrRows = strMidAnswer.split(",");
			for( var j = 0; j < arrRows.length; j++){
				$("#Questions"+(i+1)).find(".ShowItem .Question table tr").eq(j).find(".chkArea").addClass("hover");
			}
		} else if( strKind == 'shortAnswerSection'){
			$("#Questions"+(i+1)).find(".ShowItem table textarea").val(strMidAnswer);
		}
	}
}