// doc script

$(function()
{
	
		
});

function showAnswer(id)
{
	var options = {};
	$("#intro").css("display", "none");
	$("#questions").css("display", "none");
	$("#title").html($("#question-" + id).html());
	$("#answer-" + id).show("drop", options, 200);
}

function showQuestions(id)
{
	var options = {};
	$("#answer-" + id).css("display", "none");
	$("#title").html($("#hiddentitle").html());
	$("#questions").show("drop", options, 200);
}