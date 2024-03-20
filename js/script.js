function recuperaElementoSelect(elemento, destinoElementoSelecionado) {
	//Getting Value
	
	alert("opa!");
	var selObj = document.getElementById(elemento);
	var selValue = selObj.options[selObj.selectedIndex].text;
	
	//Setting Value
	document.getElementById(destinoElementoSelecionado).value = selValue;
}	