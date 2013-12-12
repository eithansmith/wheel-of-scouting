<?php
	$messageType = Session::get('messageType', 'alert');
	$messageText = Session::get('messageText', '');
	
	switch ($messageType)
	{
		case 'warning':
			$messageTitle =  Session::get('messageTitle', 'Warning:');
			$messageIcon =  Session::get('messageIcon', 'cus-error');
			$messageLayout =  Session::get('messageLayout', 'top');
			$messageAutoHide =  Session::get('messageAutoHide', 'N');
			$messageAutoHideDelay =  Session::get('messageAutoHideDelay', 5000);
			break;
		case 'success':
			$messageTitle =  Session::get('messageTitle', 'Success:');
			$messageIcon =  Session::get('messageIcon', 'cus-accept');
			$messageLayout =  Session::get('messageLayout', 'top');
			$messageAutoHide =  Session::get('messageAutoHide', 'Y');
			$messageAutoHideDelay =  Session::get('messageAutoHideDelay', 4000);
			break;
		case 'alert':
			$messageTitle =  Session::get('messageTitle', 'Alert:');
			$messageIcon =  Session::get('messageIcon', 'cus-exclamation');
			$messageLayout =  Session::get('messageLayout', 'top');
			$messageAutoHide =  Session::get('messageAutoHide', 'N');
			$messageAutoHideDelay =  Session::get('messageAutoHideDelay', 5000);
			break;
		case 'information':
			$messageTitle =  Session::get('messageTitle', 'Information:');
			$messageIcon =  Session::get('messageIcon', 'cus-information');
			$messageLayout =  Session::get('messageLayout', 'top');
			$messageAutoHide =  Session::get('messageAutoHide', 'Y');
			$messageAutoHideDelay =  Session::get('messageAutoHideDelay', 5000);
			break;
		case 'error':
			$messageTitle =  Session::get('messageTitle', 'Error:');
			$messageIcon =  Session::get('messageIcon', 'cus-exclamation');
			$messageLayout =  Session::get('messageLayout', 'top');
			$messageAutoHide =  Session::get('messageAutoHide', 'N');
			$messageAutoHideDelay =  Session::get('messageAutoHideDelay', 5000);
			break;
		default:
			$messageTitle =  Session::get('messageTitle', 'Alert:');
			$messageIcon =  Session::get('messageIcon', 'cus-exclamation');
			$messageLayout =  Session::get('messageLayout', 'top');
			$messageAutoHide =  Session::get('messageAutoHide', 'N');
			$messageAutoHideDelay =  Session::get('messageAutoHideDelay', 5000);	
	}
?>
<div id="noty-message" style="display:none;" data-type="{{ $messageType }}" data-layout="{{ $messageLayout }}" data-auto_hide="{{ $messageAutoHide }}" data-auto_hide_delay="{{ $messageAutoHideDelay }}">
	<table style="width:100%;">
		<tr>
			<td style="text-align:left;"><i class="{{ $messageIcon }}"></i> <strong>{{ $messageTitle }}</strong>&nbsp;&nbsp;{{ $messageText }}</td>
			<td style="text-align:right"><i id="notyCloseButton" class="icon-remove notyCloseButton"></i></td>
		</tr>
	</table>
</div>

<script>
	$(document).ready(function() {
		var message = $('#noty-message');
		noty({
			layout: message.data('layout'),
			type: message.data('type'),
			text: message.html(),
			dismissQueue: true,
		    callback: {
			    afterShow: function() {
					var id = this.options.id;
				    if (message.data('auto_hide') == 'Y') {
			    		setTimeout(function() {  $.noty.close(id); }, message.data('auto_hide_delay'));
				    }
		    	}
		    }
		});
	});
</script>