var myApp = new Framework7({
	modalTitle: 'Catering',
	material: true,
});

var $$ = Dom7;

var mainView = myApp.addView('.view-main', {});

var rightView = myApp.addView('.view-right', {});

$$(document).on('ajaxStart', function(e) {
	myApp.showIndicator();
});

$$(document).on('ajaxComplete', function() {
	myApp.hideIndicator();
});

myApp.onPageInit('catalogue', function (page) {
	$.getScript('/assets/js/waiter_mobile_views/catalogue.js');
});

function custom_notification(message, btn_text) {
	myApp.addNotification({
		message: message,
		button: {
			text: btn_text
		}
	});
}