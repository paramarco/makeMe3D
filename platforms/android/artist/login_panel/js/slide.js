$(document).ready(function() {
	
	// Expand Panel
	$("#open").click(function(){
		$("div#panel").slideDown("slow");
	
	});	
	$("#open2").click(function(){
		$("div#panel").slideDown("slow");
		$("#toggle a").toggle();
	
	});
	
	$("#edit_profile").click(function(){
		//$("#container_profile").slideDown("slow");
		$("#container_profile").toggle();
	
	});
	
	
	// Collapse Panel
	$("#close").click(function(){
		$("div#panel").slideUp("slow");	
	});		
	
	// Switch buttons from "Log In | Register" to "Close Panel" on click
	$("#toggle a").click(function () {
		$("#toggle a").toggle();
	});		
		
});