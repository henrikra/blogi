(function() {
	window.onload = function () {
		var body = document.getElementsByTagName('body')[0];
		body.className = '';
	}
	
	// Kommentteihin vastaaminen
	var classname = document.getElementsByClassName("reply-btn");
	
	var replyToComment = function(event) {
		var targetElement = event.target || event.srcElement;
		targetElement.parentNode.insertBefore(document.getElementById('add-comment'), targetElement.nextSibling);
		document.getElementsByName('commentReply')[0].value = targetElement.getAttribute('data-reply-id');
		event.preventDefault();
	};
	
	for(var i=0;i<classname.length;i++){
			classname[i].addEventListener('click', replyToComment);
	}
})();