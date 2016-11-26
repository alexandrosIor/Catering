var myApp = new Framework7({
	modalTitle: 'Catering',
	material: true,
	materialRipple: false,
	cache: false,
	sortable: false,
});

var $$ = Dom7;

var mainView = myApp.addView('.view-main', {});

$$(document).on('ajaxStart', function(e) {
	myApp.showIndicator();
});

$$(document).on('ajaxComplete', function() {
	myApp.hideIndicator();
});

myApp.onPageInit('catalogue', function (page) {
	$.getScript('/assets/js/waiter_mobile_views/catalogue.js');
});

$('.shift-panel').on('open', function(){
	refresh_shift_info();
})

waiter_close_shift();

/* Refresh waiter shift info when returning from catalogue */
myApp.onPageAfterBack('catalogue', function (){
	refresh_shift_info();
	waiter_close_shift();
});

/* Set time work timer running */
Date.prototype.addSeconds= function(h){
	this.setSeconds(this.getSeconds()+h);
	return this;
}

var date = new Date().addSeconds(-$('.time-worked-timer').text()) / 1000;

$('.time-worked-timer').countid({
	clock: true,
	dateTime: date,
	dateTplRemaining: "%H:%M:%S",
	dateTplElapsed: "%H:%M:%S",
	complete: function( el ){	
	}
});

/* Waiter shift closing function */
function waiter_close_shift()
{
	$('.waiter-close-shift').on('click', function(){
		if ($('.unpaid-orders').text() > 0 )
		{
			myApp.alert('Υπάρχουν απλήρωτες παραγγελίες, παρακαλώ ολοκληρώστε τις παραγγελίες σας!');
		}
		else
		{
			modal = myApp.modal({
				title: 'Κλείσιμο βάρδιας',
				text: 'Εισάγετε το ταμείο σας:',
				afterText: '<input type="text" class="turnover-delivered modal-text-input"/>',
				buttons: [
				{
					text: 'Ακυρωση'
				},
				{
					text: 'Καταχωρηση',
					bold: true,
					onClick: function () {
						var turnover_delivered = $('.modal-text-input').val();

						if (turnover_delivered)
						{
							$.ajax({
								type: 'POST',
								url: '/logout/close_shift',
								async: false,
								data: {'turnover_delivered' : turnover_delivered},
								dataType: 'json',
								success: function(data) {		
									modal = myApp.modal({
										title: 'Η βάρδια έκλεισε!',
										text: 'Το ταμείο σας: ' + data.turnover_delivered + '</br>Σύνολο ταμείου: ' + data.turnover_calculated + ' <br/>Διαφορα ταμείου: ' + data.turnover_diff,
										buttons: [
										{
											text: 'Κλεισιμο',
											onClick: function () {
												window.location = '/logout';
											}
										},
										]
									});	
								},
								error: function() {
									alert('failure');
								}
							});
						}
						else
						{
							myApp.alert('Παρακαλώ εισάγετε το ταμείο σας!');
						}
					}
				},
				]
			});
		}
	});
}

/* Mobile layout notification messages */
function custom_notification(message, btn_text) {
	myApp.addNotification({
		message: message,
		button: {
			text: btn_text
		}
	});
}

/* notification sound for new orders */
function notification_sound(sound)
{
	var notification = new Audio('assets/sounds/'+sound+'.mp3');
	notification.play();
}

/* Input mask to prevent from inserting invalid characters */
$('.turnover-delivered').mask('0ZZZ.ZZ',{
	translation: {
		'Z': {
			pattern: /[0-9]/, optional: true
		}
	}
});

/* Refresh waiter shift info */
function refresh_shift_info()
{
	$.ajax({
		type: 'POST',
		url: '/waiter/ajax_shift_info',
		async: false,
		dataType: 'json',
		success: function(data) {
			$('.total-orders').html(data.total_orders);
			$('.unpaid-orders').html(data.unpaid_orders);
			$('.time-worked-timer').html(data.time_worked);
		},
		error: function() {
			alert('failure');
		}
	});
}