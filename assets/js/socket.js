var hostname = document.location.hostname;
	var conn = new WebSocket('ws://'+hostname+':8087/' + store_channel);
	conn.onopen = function (e) {
		console.log("Connection to websocket established");
	};
conn.onmessage = function (e) {
	console.log('Received message');
	var message_container = $.parseJSON(e.data);
	if (message_container.sender === 'server' && message_container.recipient === 'webinterface')
	{
		if (message_container.message.message_type == 'update_workstation_info')
		{
			var workstation_div = $("[data-workstation-ip-address='" + message_container.message.message_data.ip_address + "']");

			if (message_container.message.message_data.hasOwnProperty('workstation_session_record_id'))
			{
				var label_button = workstation_div.find('#label_button');
				if (message_container.message.message_data.workstation_session_record_id)
				{
					label_button.removeClass('btn-default');
					label_button.addClass('btn-primary');
				}
				else if (! message_container.message.message_data.workstation_session_record_id)
				{
					label_button.removeClass('btn-primary');
					label_button.addClass('btn-default');
				}
			}
		}
		else if (message_container.message.message_type == 'security_violation')
		{
			var workstation_div = $("[data-workstation-ip-address='" + message_container.message.message_data.ip_address + "']");
			var security_violation_bell = workstation_div.find('.fa-bell');

			if(message_container.message.message_data.state == true)
			{
				security_violation_bell.removeClass('hide');
			}
			else
			{
				security_violation_bell.addClass('hide');
			}
		}
	}
}
conn.onclose = function (e)
{
	// το εκανα comment γιατι στον firefox αν ανοιξεις socket δεν μπορεις να κανεις navigate αλου γιατι ερχετε πρωτα εδω
	//location.reload();
	console.log('Connection to websocket closed');
}