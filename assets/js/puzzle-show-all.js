$(document).ready(function() {
	
	$('a.delete-puzzle-button').click(function() {
		var x = confirm("Are you sure you want to delete?");
			if (x)
				return true;
			else
				return false;
	});
	
});