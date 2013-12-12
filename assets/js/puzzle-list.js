$(document).ready(function() {
	
	$('table#puzzle-list tbody tr').click(function() {
		$('table#puzzle-list tbody tr').removeClass('tr-selected');
		$(this).addClass('tr-selected');
		$(this).find('td input[type=radio]').prop('checked', true);
	});
	
});