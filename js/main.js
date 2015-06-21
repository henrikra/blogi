(function() {
	window.onload = function () {
		// Estetään transitio-animaatiot ennen kuin DOM on latautunut
		var body = document.getElementsByTagName('body')[0];
		body.className = '';
		
		// Otetaan pois käytöstä linkit, joissa on disabled-attribuutti
		var anchors = document.getElementsByTagName('a');
    for (var i = 0; i < anchors.length; i++) {
			if (anchors[i].getAttribute('disabled') == '') {
				anchors[i].onclick = function() {return(false);};
			}
    }
	}
	
	function appendAfterElement(targetElement, newElement) {
		targetElement.parentNode.insertBefore(newElement, targetElement.nextSibling);
	}
	
	// Kommentteihin vastaaminen
	var classname = document.getElementsByClassName("reply-btn");
	
	var replyToComment = function(event) {
		var targetElement = event.target || event.srcElement;
		appendAfterElement(targetElement, document.getElementById('add-comment'));
		document.getElementsByName('commentReply')[0].value = targetElement.getAttribute('data-reply-id');
		event.preventDefault();
	};
	
	for(var i=0;i<classname.length;i++){
		classname[i].addEventListener('click', replyToComment);
	}
})();