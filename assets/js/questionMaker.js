var nQuestionCount = 0;
// var strTopic = "";
function addQuestion() {
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
	elem.find(".QuestionNumber").html("Question " + nQuestionCount);
	elem.find(".QuestionDel").attr("onclick", "QuestionDelete(" + nQuestionCount + ")");
	elem.find(".MulMoreBtn").attr("onclick", "addMulChoice("+nQuestionCount+")");
	elem.find(".ChkMoreBtn").attr("onclick", "addChkChoice("+nQuestionCount+")");
	elem.find(".fbOption .chkArea").attr("onclick", "fbOptionChoice("+nQuestionCount+")");
	elem.insertBefore(".addQuestion");
	elem.find(".multiChoiceSection").addClass("ShowItem");
	addMulChoice(nQuestionCount);
	addChkChoice(nQuestionCount);
}
function QuestionDelete(nQuestionNumber){
	debugger;
	var elem = $("#Questions" + nQuestionNumber) ;
	console.log(elem);
	elem.remove();
	for( var i = nQuestionNumber + 1; i <= nQuestionCount; i++){
		console.log(i);
		var preI = i - 1;
		var elemBuf = $("#Questions" + i);
		elemBuf.attr("id","Questions"+preI);
		elemBuf.find(".QuestionNumber").html("Question " + preI);
		elemBuf.find(".QuestionDel").attr("onclick", "QuestionDelete(" + preI + ")");
		elemBuf.find(".MulMoreBtn").attr("onclick", "addMulChoice("+preI+")");
		elemBuf.find(".ChkMoreBtn").attr("onclick", "addChkChoice("+preI+")");
		elemBuf.find(".fbOption .chkArea").attr("onclick", "fbOptionChoice("+preI+")");
		var arrTrs = elemBuf.find(".ShowItem .Question table tr");
		for(var j = 1; j < arrTrs.length; j++){
			arrTrs.eq(j).find(".delRow").attr("onlick", "mulDelClicked("+preI+","+j+")");
		}
	}
	nQuestionCount--;
}
function delQuestion(){
	var elem = $("#Questions" + nQuestionCount);
	elem.remove();
	nQuestionCount--;
}
var chara = ['A','B','C','D','E','F','G','H','I','J','H','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
function changeKindById(strId){
	var parent = $("#"+strId);
	var elem = parent.find(".ShowItem .orderKind").eq(0);
	var value = elem.val();
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
	for( var i = 1; i < elemTr.length; i++){
		if( prefix == "A") curPre = chara[i-1];
		else if( prefix == "a") curPre = chara[i-1].toLowerCase();
		else curPre = i;
		console.log(prefix + curPre + lastfix);
		elemTr.eq(i).find(".chr").html( curPre + lastfix);
	}
}
function changeKind(){
	var elem = document.activeElement;
	var parentId = elem.parentElement.parentElement.parentElement.id;
	console.log(parentId);
	changeKindById(parentId);
}
function changeOption(){
	var elem = document.activeElement;
	var parentId = elem.parentElement.parentElement.parentElement.id;
	var parent = $("#"+parentId);
	parent.find(".multiChoiceSection").removeClass("ShowItem").addClass("HideItem");
	parent.find(".checkBoxSection").removeClass("ShowItem").addClass("HideItem");
	parent.find(".shortAnswerSection").removeClass("ShowItem").addClass("HideItem");

	if( elem.value == "Add multiple choice"){
		parent.find(".multiChoiceSection").removeClass("HideItem").addClass("ShowItem");
	} else if ( elem.value == "Check box"){
		parent.find(".checkBoxSection").removeClass("HideItem").addClass("ShowItem");
	} else{
		parent.find(".shortAnswerSection").removeClass("HideItem").addClass("ShowItem");
	}
}
function addMulChoice(nNumber){
	var elem = $("#Questions"+nNumber).find(".multiChoiceSection .Question table");
	var nRows = $("#Questions"+nNumber).find(".multiChoiceSection .Question table tr").length;
	var strTr = '<tr><td class="chr">'+chara[nRows-1]+'</td><td><input type="text" name="mulQuestion" class="answer"></td><td><div class="chkArea" onclick="mulChkClicked('+nNumber+','+(nRows)+')"></div></td><td class="delRow" onclick="mulDelClicked('+nNumber+','+nRows+')">x</td></tr>';
	elem.append(strTr);
	strTr = '<tr><td class="chr">'+chara[nRows-1]+'</td><td><input type="text" name="mulFeedback" class="feedback"></td></tr>';
	$("#Questions"+nNumber).find(".multiChoiceSection .fbOption table").append(strTr);
	changeKindById("Questions"+nNumber);
}
function addChkChoice(nNumber){
	var elem = $("#Questions"+nNumber).find(".checkBoxSection .Question table");
	var nRows = $("#Questions"+nNumber).find(".checkBoxSection .Question table tr").length;
	var strTr = '<tr><td class="chr">'+chara[nRows-1]+'</td><td><input type="text" name="chkQuestion" class="answer"></td><td><div class="chkArea" onclick="chkChoClicked('+nNumber+','+nRows+')"></div></td><td class="delRow" onclick="chkDelClicked('+nNumber+','+nRows+')">x</td></tr>';
	elem.append(strTr);
	strTr = '<tr><td class="chr">'+chara[nRows-1]+'</td><td><input type="text" name="chkAnswer" class="feedback"></td></tr>';
	$("#Questions"+nNumber).find(".checkBoxSection .fbOption table").append(strTr);
}
function fbOptionChoice(nNumber){
	var selValue = $("#Questions"+nNumber).find(".QuestionHeader .QuestionKind select").val();
	if( selValue == "Add multiple choice"){
		$("#Questions"+nNumber).find(".multiChoiceSection .fbOption .chkArea").toggleClass('hover');
		$("#Questions"+nNumber).find(".multiChoiceSection .fbOption table").toggleClass('hover');
	} else if( selValue == "Check box"){
		$("#Questions"+nNumber).find(".checkBoxSection .fbOption .chkArea").toggleClass('hover');
		$("#Questions"+nNumber).find(".checkBoxSection .fbOption table").toggleClass('hover');
	} else{
		$("#Questions"+nNumber).find(".shortAnswerSection .fbOption .chkArea").toggleClass('hover');
		$("#Questions"+nNumber).find(".shortAnswerSection .fbOption table").toggleClass('hover');
	}
}
function mulChkClicked(nNumber, nRow){
	var elemTable = $("#Questions"+nNumber).find(".multiChoiceSection .Question table tr").eq(nRow);
	$("#Questions"+nNumber).find(".multiChoiceSection .Question table .chkArea").removeClass('hover');
	elemTable.find(".chkArea").addClass('hover');
}
function chkChoClicked( nNumber, nRow){
	var elemTable = $("#Questions"+nNumber).find(".checkBoxSection .Question table tr").eq(nRow);
	elemTable.find(".chkArea").toggleClass('hover');
}
function reArrange(tableQ, tableF, nNumber, nStartRow){
	var selValue = $("#Questions"+nNumber).find(".QuestionHeader .QuestionKind select").val();
	var funcName1, funcName2;
	if( selValue == "Add multiple choice"){
		funcName1 = "mulChkClicked";funcName2 = "mulDelClicked";
	} else if( selValue == "Check box"){
		funcName1 = "chkChoClicked";funcName2 = "chkDelClicked";
	} else{
		funcName1 = "mulChkClicked";funcName2 = "mulDelClicked";
	}
	var nRows = tableQ.find("tr").length;
	for( var i = nStartRow; i < nRows; i++){
		tableQ.find("tr").eq(i).find(".chr").html(chara[i-1]);
		tableQ.find("tr").eq(i).find(".chkArea").attr("onclick",funcName1+"("+nNumber + "," + i + ")");
		tableQ.find("tr").eq(i).find(".delRow").attr("onclick",funcName2+"("+nNumber + "," + i + ")");
		tableF.find("tr").eq(i-1).find(".chr").html(chara[i-1]);
	}
}
function mulDelClicked( nNumber, nRow){
	var elemTable = $("#Questions"+nNumber).find(".multiChoiceSection .Question table tr").eq(nRow);
	elemTable.remove();
	elemTable = $("#Questions"+nNumber).find(".multiChoiceSection .fbOption table tr").eq(nRow-1);
	elemTable.remove();
	reArrange( $("#Questions"+nNumber).find(".multiChoiceSection .Question table"), $("#Questions"+nNumber).find(".multiChoiceSection .fbOption table"), nNumber, nRow-1);
}
function chkDelClicked( nNumber, nRow){
	var elemTable = $("#Questions"+nNumber).find(".checkBoxSection .Question table tr").eq(nRow);
	elemTable.remove();
	elemTable = $("#Questions"+nNumber).find(".checkBoxSection .fbOption table tr").eq(nRow-1);
	elemTable.remove();
	reArrange( $("#Questions"+nNumber).find(".checkBoxSection .Question table"), $("#Questions"+nNumber).find(".checkBoxSection .fbOption table"), nNumber, nRow-1);
}
function saveQuestion(){
	var qStrings = {};
	var arrQuestions = [];
	// strTopic = document.getElementById("idTopic").value;
	// qStrings.Topic = strTopic;
	for( var i = 1; i < nQuestionCount+1; i++){
		var questions = {};
		var selValue = $("#Questions"+i).find(".QuestionHeader .QuestionKind select").val();
		questions.type = selValue;
		var strQuestion;
		var elemKind;
		if( selValue == "Add multiple choice"){
			elemKind = $("#Questions"+i).find(".multiChoiceSection");
			questions.selectKind = elemKind.find(".orderKind").val();
		} else if( selValue == "Check box"){
			elemKind = $("#Questions"+i).find(".checkBoxSection");
			questions.selectKind = elemKind.find(".orderKind").val();
		} else {
			elemKind = $("#Questions"+i).find(".shortAnswerSection");
		}
		strQuestion = elemKind.find(".Question table .inputQuestion").val();
		strQuestion = strQuestion.replace("'","`");
		questions.question = strQuestion;
		var answers = [];
		for( var j = 1; j < elemKind.find(".Question table tr").length; j++){
			var elemTr = elemKind.find(".Question table tr").eq(j);
			var answer = {};
			answer.chara = elemTr.find(".chr").html();
			answer.answer = elemTr.find(".answer").val();
			answer.answer = answer.answer.replace("'","`");
			answer.hover = elemTr.find(".chkArea").hasClass("hover");
			answers.push(answer);
		}
		questions.answers = answers;
		var feedBack = {};
		feedBack.isNeed = elemKind.find(".fbOption .chkArea").hasClass("hover");
		var feedBacks = [];
		for( var k = 0; k < elemKind.find(".fbOption table tr").length; k++){
			var feedback = {};
			var elemTr = elemKind.find(".fbOption table tr").eq(k);
			feedback.chara = elemTr.find(".chr").html();
			// feedback.feedback = elemTr.find(".feedback").val();
			var strBuff = "" + elemTr.find(".feedback").val();
			feedback.feedback = strBuff.replace("'","`");
			feedBacks.push(feedback);
		}
		feedBack.feedbacks = feedBacks;
		questions.feedBack = feedBack;
		arrQuestions.push( questions);
	}
	qStrings.Questions = arrQuestions;
	console.log(fileName);
	$.ajax({
		type: 'POST',
		url: 'questionManager.php',
		data: {saveContents: fileName, contents:qStrings}
	}).done(function (d) {
		alert("Saved!");
	});
}
function addMulChoiceFromData( nQNum, nANum, strAnswer, bHover, strFeedBack){
	var elem = $("#Questions"+nQNum).find(".multiChoiceSection .Question table");
	var strTr = '<tr><td class="chr">'+chara[nANum-1]+'</td><td><input type="text" name="mulQuestion"';
	if( strAnswer!= "") strTr += " value='" + strAnswer + "'";
	strTr += ' class="answer"></td><td><div class="chkArea';
	if(bHover == "true")strTr += " hover";
	strTr += '" onclick="mulChkClicked('+nQNum+','+(nANum)+')"></div></td><td class="delRow" onclick="mulDelClicked('+nQNum+','+nANum+')">x</td></tr>';
	elem.append(strTr);
	strTr = '<tr><td><input type="text" name="mulFeedback"';
	if( strFeedBack != "")strTr += 'value="' + strFeedBack +'"';
	strTr += ' class="feedback"></td></tr>';
	$("#Questions"+nQNum).find(".multiChoiceSection .fbOption table").append(strTr);
	changeKindById("Questions"+nQNum);
}
function addChkChoiceFromData(nQNum, nANum, strAnswer, bHover, strFeedBack){
	var elem = $("#Questions"+nQNum).find(".checkBoxSection .Question table");
	var nRows = $("#Questions"+nQNum).find(".checkBoxSection .Question table tr").length;
	var strTr = '<tr><td class="chr">'+chara[nANum-1]+'</td><td><input type="text" name="chkQuestion"';
	if( strAnswer!= "") strTr += " value='" + strAnswer + "'";
	strTr += ' class="answer"></td><td><div class="chkArea';
	if( bHover == "true")strTr += " hover";
	strTr += '" onclick="chkChoClicked('+nQNum+','+nRows+')"></div></td><td class="delRow" onclick="chkDelClicked('+nQNum+','+nRows+')">x</td></tr>';
	elem.append(strTr);
	strTr = '<tr><td><input type="text" name="chkAnswer"';
	if( strFeedBack != "")strTr += 'value="' + strFeedBack + '"';
	strTr += ' class="feedback"></td></tr>';
	$("#Questions"+nQNum).find(".checkBoxSection .fbOption table").append(strTr);
	changeKindById("Questions"+nQNum);
}
function addShtChoiceFromData(nQNum, nANum, strAnswer, bHover, strFeedBack){
	var elem = $("#Questions"+nQNum).find(".shortAnswerSection .Question table");
	elem.find("textarea").val(strAnswer);
	elem = $("#Questions"+nQNum).find(".shortAnswerSection .fbOption table");
	elem.find("textarea").val(strFeedBack);
}
function parseContents( jsonContents){
	if( jsonContents =="")return;
	// strTopic = jsonContents.Topic;
	// $("#idTopic").val(strTopic);
	for( var i = 0; i < jsonContents.Questions.length; i++){
		var Questions = jsonContents.Questions[i];
		strType = Questions.type;
		addQuestion();
		$("#Questions"+(i+1)).find(".QuestionHeader .QuestionKind select").val(strType);
		var parent = $("#Questions"+(i+1));
		parent.find(".multiChoiceSection").removeClass("ShowItem").addClass("HideItem");
		parent.find(".checkBoxSection").removeClass("ShowItem").addClass("HideItem");
		parent.find(".shortAnswerSection").removeClass("ShowItem").addClass("HideItem");

		var feedBack = Questions.feedBack;
		if( strType == "Add multiple choice"){
			parent.find(".multiChoiceSection").addClass("ShowItem");
			parent.find(".multiChoiceSection").find(".inputQuestion").val(Questions.question);
			if( feedBack.isNeed == "true"){
				parent.find(".multiChoiceSection").find(".fbOption table").removeClass("hover");
				parent.find(".multiChoiceSection").find(".fbOption .chkArea").addClass("hover");
			}
		} else if ( strType == "Check box"){
			parent.find(".checkBoxSection").addClass("ShowItem");
			parent.find(".checkBoxSection").find(".inputQuestion").val(Questions.question);
			if( feedBack.isNeed == "true"){
				parent.find(".checkBoxSection").find(".fbOption table").removeClass("hover");
				parent.find(".checkBoxSection").find(".fbOption .chkArea").addClass("hover");
			}
		} else{
			parent.find(".shortAnswerSection").addClass("ShowItem");
			parent.find(".shortAnswerSection").find(".inputQuestion").val(Questions.question);
			if( feedBack.isNeed == "true"){
				parent.find(".shortAnswerSection").find(".fbOption table").removeClass("hover");
				parent.find(".shortAnswerSection").find(".fbOption .chkArea").addClass("hover");
			}
		}
		mulDelClicked(i+1, 1);
		chkDelClicked(i+1, 1);
		for( var j = 0; j < Questions.answers.length; j++){
			var answers = Questions.answers[j];
			var chr = answers.chara;
			var answer = answers.answer;
			var hover = answers.hover;
			var feedback = feedBack.feedbacks[j];
			addMulChoiceFromData( i + 1, j + 1, answer, hover, feedback.feedback);
			addChkChoiceFromData( i + 1, j + 1, answer, hover, feedback.feedback);
			addShtChoiceFromData( i + 1, j + 1, answer, hover, feedback.feedback);
		}
		if( strType == "Add multiple choice" || strType == "Check box"){
			$("#Questions"+(i+1)).find(".ShowItem .orderKind").val(Questions.selectKind);
			changeKindById("Questions"+(i+1));
		}
	}
}