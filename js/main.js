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
	
	// Tagien lisääminen postausta varten
	document.getElementById('tag-input').addEventListener('input', function(event) {
		var targetElement = event.target || event.srcElement;
		var results = getElementsByValue('option', targetElement.value.toLowerCase());
		if (results.length) {
			document.getElementById('selected-tag-id').value = results[0].getAttribute('id');
			document.getElementById('selected-tag-name').value = results[0].value;
		}
	});
	
	document.getElementById('tag-input').addEventListener('keypress', function(event) {
		if (event.which == 13 || event.keyCode == 13) {
			event.preventDefault();
		}
	});
	
	document.getElementById('add-tag-button').addEventListener('click', function(event) {
		var tagValue = document.getElementById('tag-input').value;
		if (tagValue != '') {
			var tagIsInList = false;
			if (document.getElementById('selected-tag-id').value == '') {
				var old = document.getElementsByClassName('selected-tag-hidden-name');
				for (var i = 0; i < old.length; i++) {
					console.log(old[i].value + " ja " + document.getElementById('tag-input').value);
					if (old[i].value != '') {
						if (old[i].value == document.getElementById('tag-input').value) {
							tagIsInList = true;
							break;
						}
					}
				}
			} else{
				var old = document.getElementsByClassName('selected-tag-hidden');
				for (var i = 0; i < old.length; i++) {
					console.log(old[i].value + " ja " + document.getElementById('selected-tag-id').value);
					if (old[i].value != '') {
						if (old[i].value == document.getElementById('selected-tag-id').value) {
							tagIsInList = true;
							break;
						}
					}
				}
			}
			if (!tagIsInList) {
				var selectedTag = document.createElement('div');
				selectedTag.className = 'selected-tag';
				
				var removeButton = document.createElement('i');
				removeButton.className = 'fa fa-times unselect-tag';
				removeButton.addEventListener('click', removeTag, false);
				
				var tagTextNode = document.createTextNode(tagValue + ' ');
				
				selectedTag.appendChild(tagTextNode);
				selectedTag.appendChild(removeButton);
				
				document.getElementById('selected-tags').appendChild(selectedTag);
				
				if (document.getElementById('selected-tag-id').value == '') {
					var tagIdHidden = document.createElement('input');
					tagIdHidden.setAttribute('type', 'hidden');
					tagIdHidden.setAttribute('name', 'tagIds[]');
					tagIdHidden.className = 'selected-tag-hidden';
					tagIdHidden.setAttribute('value', '');
					
					document.getElementById('selected-tags').appendChild(tagIdHidden);
					
					var tagNameHidden = document.createElement('input');
					tagNameHidden.setAttribute('type', 'hidden');
					tagNameHidden.setAttribute('name', 'tagNames[]');
					tagNameHidden.className = 'selected-tag-hidden-name';
					tagNameHidden.setAttribute('value', document.getElementById('tag-input').value);
					
					document.getElementById('selected-tags').appendChild(tagNameHidden);
				} else {
				
					// Hidden lisäys joka lähetetään submitissa
					var tagIdHidden = document.createElement('input');
					tagIdHidden.setAttribute('type', 'hidden');
					tagIdHidden.setAttribute('name', 'tagIds[]');
					tagIdHidden.className = 'selected-tag-hidden';
					tagIdHidden.setAttribute('value', document.getElementById('selected-tag-id').value);
					
					document.getElementById('selected-tags').appendChild(tagIdHidden);
					
					var tagNameHidden = document.createElement('input');
					tagNameHidden.setAttribute('type', 'hidden');
					tagNameHidden.setAttribute('name', 'tagNames[]');
					tagNameHidden.className = 'selected-tag-hidden-name';
					tagNameHidden.setAttribute('value', document.getElementById('selected-tag-name').value);
					
					document.getElementById('selected-tags').appendChild(tagNameHidden);
				}
				
			}
			document.getElementById('selected-tag-id').value = '';
			document.getElementById('selected-tag-name').value = '';
			document.getElementById('tag-input').value = '';
		}
	});
	
	var removeTag = function(event) {
		var targetElement = event.target || event.srcElement;
		targetElement.parentNode.nextSibling.remove();
		targetElement.parentNode.nextSibling.remove();
		targetElement.parentNode.remove();
	};
	
	function getElementsByValue(element, value) {
    var elements = document.getElementsByTagName(element);
    var results = [];
    for(var x = 0; x < elements.length; x++)
      if(elements[x].value == value)
        results.push(elements[x]);
    return results;
	}
	
	var unselectTag = document.getElementsByClassName("unselect-tag");
	for(var i=0;i<unselectTag.length;i++){
		unselectTag[i].addEventListener('click', removeTag, false);
  }
})();