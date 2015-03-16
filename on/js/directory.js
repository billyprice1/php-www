// store script

jQuery.ajaxSetup({
	beforeSend: function() {
		$('#loading').show();
	},
	complete: function(){
		$('#loading').hide();
		setFooter();
	},
	success: function() {}
});

$(function() {
	$("#searchform").on('submit', function(e) {
		e.preventDefault();
		loadDirectoryPart('search', $("#search").val());
    });
});
	
function loadDirectoryPart(part, data)
{
	disableAllDirectoryMenu();
	
	switch( part )
	{
		case 'featured':
			$("#shome").addClass('active');
			$("#directorycontainer").load("/directory/" + part);
		break;
		case 'top':
			$("#stop").addClass('active');
			$("#directorycontainer").load("/directory/" + part);
		break;
		case 'last':
			$("#snew").addClass('active');
			$("#directorycontainer").load("/directory/" + part);
		break;
		case 'category':
			$("#scategory").addClass('active');
			$("#directorycontainer").load("/directory/" + part + "?id=" + data);
		break;
		case 'search':
			$("#shome").addClass('active');
			$("#directorycontainer").load("/directory/" + part + "?keyword=" + data);
		break;
	}
}

function disableAllDirectoryMenu()
{
	$("#shome").removeClass('active');
	$("#stop").removeClass('active');
	$("#snew").removeClass('active');
	$("#scategory").removeClass('active');
}