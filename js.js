/* AJAX LIBRARY http://stackoverflow.com/a/18078705 */
var ajax = {};
var x;
ajax.x = function() {
    try {
        return new ActiveXObject('Msxml2.XMLHTTP')
    } catch (e1) {
        try {
            return new ActiveXObject('Microsoft.XMLHTTP')
        } catch (e2) {
            return new XMLHttpRequest()
        }
    }
};
ajax.send = function(url, callback, method, data, sync) {
    x = ajax.x();
    x.open(method, url, sync);
    x.onreadystatechange = function() {
        if (x.readyState == 4) {
            callback(x.responseText)
        }
    };
    if (method == 'POST') {
        x.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    }
		x.send(data);
};

ajax.get = function(url, data, callback, sync) {
    var query = [];
    for (var key in data) {
        query.push(encodeURIComponent(key) + '=' + encodeURIComponent(data[key]));
    }
    ajax.send(url + '?' + query.join('&'), callback, 'GET', null, sync)
};

ajax.post = function(url, data, callback, sync) {
    var query = [];
    for (var key in data) {
        query.push(encodeURIComponent(key) + '=' + encodeURIComponent(data[key]));
    }
    ajax.send(url, callback, 'POST', query.join('&'), sync)
};
/* END OF AJAX LIBRARY */

// Hook into submitting form
var form = document.getElementById( 'todoist-form' );
if (form.attachEvent) {
	form.attachEvent( "submit", processForm );
} else {
	form.addEventListener( "submit", processForm );
}
function processForm( e ) {
	e.preventDefault();
	var todoist_content = form.inbox_item.value;
	var todoist_password = '';
	if( form.inbox_password )
		todoist_password = form.inbox_password.value;

	ajax.post( 'index.php', {
		inbox_item: todoist_content,
		inbox_password: todoist_password,
		send_inbox_item: ''
	}, function() {
		var responseDiv = document.getElementById( 'response' );
		responseDiv.innerHTML = x.response;
		responseDiv.className += " with-response";
		if( x.response.toLowerCase().indexOf( 'success' ) >= 0 ) {
			responseDiv.className += " success-response";
		} else {
			responseDiv.className = responseDiv.className.replace( ' success-response', '' );
		}
	} );
}

var title = document.getElementById( 'title' );
var titleContent = document.getElementById( 'title' ).innerHTML;

