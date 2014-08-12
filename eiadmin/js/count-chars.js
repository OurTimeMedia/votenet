// JavaScript Document
function block_chars(taObj, limit) {
	if (taObj.value.length==limit) return false;
	return true;
}
function count_chars(taObj,Cnt, limit) { 
	var bName = navigator.appName;
	objCnt=createObject(Cnt);
	objVal=taObj.value;
	if (objVal.length>limit) objVal=objVal.substring(0,limit);
	if (objCnt) {
		if(bName == "Netscape"){	
			objCnt.textContent=limit-objVal.length;}
		else{objCnt.innerText=limit-objVal.length;}
	}
	return true;
}
function createObject(objId) {
	if (document.getElementById) return document.getElementById(objId);
	else if (document.layers) return eval("document." + objId);
	else if (document.all) return eval("document.all." + objId);
	else return eval("document." + objId);
}