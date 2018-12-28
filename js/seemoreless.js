$(document).ready(function() {
	$("#toggle").click(function() {
		var elem = $("#toggle").text();
		if (elem == "Read More") {
			//Stuff to do when btn is in the read more state
			$("#toggle").text("Cancel");
			$("#text").slideDown();
		} else {
			//Stuff to do when btn is in the read less state
			$("#toggle").text("Update My Info");
			$("#text").slideUp();
		}
	});
});