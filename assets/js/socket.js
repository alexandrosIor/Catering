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
				try 
				{
					$('div.orders').append(data);
					$('.orders div:last').hide().fadeToggle(700);
					set_timer($('div.orders .order-timer:last'));
				}
				catch(err) {
					console.log(err);
				}		
					notification_sound('notification');
					toastr_notification('success', 'Νέα παραγγελία', message_container.message.message_data.message);
				},
				error: function() {
					alert('failure');
				}
			});
		}

		if (message_container.message.message_type == 'waiter_order_served')
		{
			$('.order-panel[data-order_record_id="' + message_container.message.message_data.record_id + '"]').parent().fadeToggle();
			$('.order-panel[data-order_record_id="' + message_container.message.message_data.record_id + '"]').remove();
		}		

		if (message_container.message.message_type == 'waiter_order_updated')
		{
			notification_sound('notification-2');
			toastr_notification('info', 'Ενημέρωση παραγγελίας', message_container.message.message_data.message);

			if( $('.order-panel[data-order_record_id="' + message_container.message.message_data.record_id + '"]').length == 0)
			{
				$.ajax({
					type: 'POST',
					url: '/orders/ajax_create_new_order_panel',
					async: false,
					data: message_container.message.message_data,
					success: function(data) {
					try 
					{
						$('div.orders').append(data);
						$('.orders div:last').hide().fadeToggle(700);
						set_timer($('div.orders .order-timer:last'));
					}
					catch(err) {
						console.log(err);
					}		
						notification_sound('notification');
						toastr_notification('success', 'Νέα παραγγελία', message_container.message.message_data.message);
					},
					error: function() {
						alert('failure');
					}
				});
			}
			else
			{
				$('.order-panel[data-order_record_id="' + message_container.message.message_data.record_id + '"] .order-total-cost').html(message_container.message.message_data.total_price + ' €');
			}
		}
	}

	if (message_container.sender === 'store' && message_container.recipient === 'waiter')
	{
		if (message_container.message.message_type == 'store_order_update')
		{	
			custom_notification(message_container.message.message_data.message, '<i class="fa fa-times fa-lg"></i>');

			order_chip = $('.incomplete-order[data-order_record_id="' + message_container.message.message_data.order_record_id + '"] .chip-delete');

			if (message_container.message.message_data.order_completed)
			{
				order_chip.removeClass('hidden');
			}
			else
			{
				if (order_chip.hasClass('hidden') === false)
				{
					order_chip.addClass('hidden');
				}
			}

			notification_sound('notification');
		}

		if (message_container.message.message_type == 'store_notify_waiter')
		{
			custom_notification(message_container.message.message_data.message + ' ' + message_container.message.message_data.notification_sender, '<i class="fa fa-bell fa-lg"></i>');
			notification_sound('notification');
		}
	}
}

conn.onclose = function (e)
{
	// το εκανα comment γιατι στον firefox αν ανοιξεις socket δεν μπορεις να κανεις navigate αλου γιατι ερχετε πρωτα εδω
	//location.reload();
	console.log('Connection to websocket closed');
}