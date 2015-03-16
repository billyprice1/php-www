// Main javascript
	
$(function()
{
	// DIALOGS //
	newFlexibleDialog('login', 350);
	newFlexibleDialog('signup', 500);
	newFlexibleDialog('register', 500);
	newFlexibleDialog('message', 250);
	newFlexibleDialog('changepass', 350);
	newFlexibleDialog('cookie', 700);
	
	// CONNECTOR RATING //
	$('.star').raty(
	{
		numberMax: 5,
		number: 500,
		path: '/on/images/icons',
		score: function() {
			return $(this).attr('data-score');
		},
		click: function() {
			rate($(this).attr('data-id'), $('.star').raty('score'));
		}
	});

	$('.bigstar').raty(
	{
		numberMax: 5,
		number: 500,
		width: 150,
		readOnly: true,
		path: '/on/images/icons',
		score: function() {
			return $(this).attr('data-score');
		},
		starOff : 'starbig-off.png',
		starOn: 'starbig-on.png',
		click: function() {
			rate($(this).attr('data-id'), $('.star').raty('score'));
		}
	});
	
	// EDITOR
	$(".formeditor").sceditor({
			plugins: "bbcode",
			toolbar: "bold,italic,underline|code,quote,horizontalrule,image,email,link,unlink|source",
    });
	
	$(".ui-dialog-titlebar").hide();
	
	// CATEGORIES MENU //
	$('.scategory').hover(
		function () {
			$('ul', this).fadeIn(200);
		}, 
		function () {
			$('ul', this).fadeOut(200);			
		}
	);
	
	// FIXED STORE MENU //
	var num = 120;
	$(window).bind('scroll', function ()
	{
		if( $(window).scrollTop() > num )
		{
			$('.menu-fixed').addClass('fixed');
		}
		else
		{
			$('.menu-fixed').removeClass('fixed');
		}
	});
});

function success()
{
	var options = {};
	$("#success").show("fade", options, 500);
	$("#success").hide("fade", options, 500);
}

function rate(id, rate)
{
	var json = $.getJSON("/directory/ajax_rate?id=" + id + "&rating=" + rate, function(data)
	{ 
		success();
	});
}

function newDialog(name, width, height)
{
	$("#" + name).dialog(
	{
		width: width,
		height: height,
		autoOpen: false,
		modal: true,
		show: {
			effect: "fade",
			duration: 200
		},
		hide: {
			effect: "fade",
			duration: 200
		},
		open: function()
		{
			jQuery('.ui-widget-overlay').bind('click',function() {
				jQuery("#" + name).dialog('close');
			})
		}
	});
}

function newFlexibleDialog(name, width)
{
	$("#" + name).dialog(
	{
		width: width,
		autoOpen: false,
		modal: true,
		show: {
			effect: "fade",
			duration: 200
		},
		hide: {
			effect: "fade",
			duration: 200
		},
		open: function()
		{
			jQuery('.ui-widget-overlay').bind('click',function() {
				jQuery("#" + name).dialog('close');
			})
		}
	});
}