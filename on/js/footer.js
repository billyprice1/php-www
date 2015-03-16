function getWindowHeight() {
	var windowHeight = 0;
	if (typeof(window.innerHeight) == 'number') {
		windowHeight = window.innerHeight;
	}
	else {
		if (document.documentElement && document.documentElement.clientHeight) {
			windowHeight = document.documentElement.clientHeight;
		}
		else {
			if (document.body && document.body.clientHeight) {
				windowHeight = document.body.clientHeight;
			}
		}
	}
	return windowHeight;
}


function setFooter() {
	if (document.getElementById) {
		var windowHeight = getWindowHeight();
		if (windowHeight > 0) {
			var coreHeight = document.getElementById('core').offsetHeight;
			var need = windowHeight - coreHeight;
			if (need > 255) {
				document.getElementById('footer').style.marginTop = (need-255) + 'px';
			}
			else
				document.getElementById('footer').style.marginTop = '0px';
		}
	}
}

/*
window.onload = function() {
	setFooter();
}
*/

function addLoadEvent(func)
{
	var oldonload = window.onload;
	if(typeof window.onload != 'function')
	{
		window.onload = func;
	}
	else
	{
		window.onload = function()
		{
			oldonload();
			func();
		}
	}
}

addLoadEvent(setFooter);

/*
window.onresize = function() {
	setFooter();
}
*/