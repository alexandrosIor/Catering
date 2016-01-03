var hostname = document.location.hostname;
	var conn = new WebSocket('ws://'+hostname+':8087/' + user_channel);
	conn.onopen = function (e) {
		console.log("Connection to websocket established");
	};

conn.onmessage = function (e) {
	console.log('Received message');
	var message_container = $.parseJSON(e.data);
	if (message_container.sender === 'waiter' && message_container.recipient === 'store')
	{
		if (message_container.message.message_type == 'waiter_new_order')
		{	
			$.ajax({
				type: 'POST',
				url: '/orders/ajax_create_new_order_panel',
				async: false,
				data: message_container.message.message_data,
				success: function(data) {		
					$('div.orders').append(data);
					$('.orders div:last').hide().fadeToggle(700);
					set_timer($('div.orders .order-timer:last'));
					notification_sound();
				},
				error: function() {
					alert('failure');
				}
			});
		}
	}
}

conn.onclose = function (e)
{
	// το εκανα comment γιατι στον firefox αν ανοιξεις socket δεν μπορεις να κανεις navigate αλου γιατι ερχετε πρωτα εδω
	//location.reload();
	console.log('Connection to websocket closed');
}