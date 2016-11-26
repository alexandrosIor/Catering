$(document).ready(function() {

	/* Set the timer on active shifts panels */
	Date.prototype.addSeconds= function(h){
		this.setSeconds(this.getSeconds()+h);
		return this;
	}
	$('.time-worked-timer').each(function(){
		set_timer($(this));
	});

	/* Notify user */
	$('.notify-user').each(function(){
		$(this).on('click', function(){
			notify_user($(this).parent().data('user_record_id'), $(this).parent().data('notification_sender'));
		});
	});

});

/* Notify user */
function notify_user(user_record_id, notification_sender)
{
	swal({   
		title: 'Αποστολή ειδοποίησης!',    
		type: 'input',   
		showCancelButton: true,   
		closeOnConfirm: false,   
		animation: 'slide-from-top',   
		inputPlaceholder: 'Μήνυμα',
		confirmButtonText: 'Αποστολή',   
		cancelButtonText: 'Ακύρωση',
	}, 
	function(isConfirm, inputValue){
		if (isConfirm)
		{
			if (inputValue === '')
			{
				var message = 'Σας κάλεσε ο: ';
			}
			else
			{
				var message = inputValue + '<br/>Απο: ';
			}
			
			$.ajax({
				type: 'POST',
				url: '/store/ajax_send_notification',
				async: false,
				data: {'user_record_id' : user_record_id, 'notification_sender' : notification_sender, 'message' : message},
				success: function(data) {		

				},
				error: function() {
					alert('failure');
				}
			});
			swal('Το μήνυμα εστάλη', '', 'success');
		}
	});

	/* Input mask to prevent from inserting invalid characters */
	$('.sweet-alert input').unbind();
}

/* Set the timer running*/
function set_timer(timer)
{
	var date = new Date().addSeconds(-$(timer).text()) / 1000;

	$(timer).countid({
		clock: true,
		dateTime: date,
		dateTplRemaining: "%H:%M:%S",
		dateTplElapsed: "%H:%M:%S"
	});
}