function Paz(x,y) {	
	try {				
		var xmlhttp;

		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
			// most browsers
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			// internet explorer
		}
		
		var pagez = x;
		var items = y;
		
		xmlhttp.onreadystatechange = function() {			
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				var strOut;			
				strOut = xmlhttp.responseText;
				document.getElementById("results").innerHTML = strOut;
			}
		}
		
		xmlhttp.open("POST", "Ajax/FindPage.php", true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");			
		xmlhttp.send("page="+pagez+"&items="+items);
	}
	catch(err) {
		alert(err);
	}
}

