$(document).ready(function() {

	/* set timer on each order */
	Date.prototype.addSeconds= function(h){
	    this.setSeconds(this.getSeconds()+h);
	    return this;
	}

	/* Set the timer on all orders */
	$('.order-timer').each(function(){
		set_timer($(this));
	});

})

/* Set order product status completed */ 
function change_order_product_status(order_product_record_id)
{
	$.ajax({
		type: 'POST',
		url: '/orders/ajax_change_order_product_status',
		async: false,
		data: {'order_product_record_id' : order_product_record_id},
		success: function(data) {		
			//TODO: inform user that a product in his order is ready to serve via websocket message 
		},
		error: function() {
			alert('failure');
		}
	});
}

/* Programatically change switchery status */
function setSwitchery(switchElement, checkedBool)
{
	if((checkedBool && !switchElement.isChecked()) || (!checkedBool && switchElement.isChecked())) {
		switchElement.setPosition(true);
		//switchElement.handleOnchange(true);
	}
}

/* Set the timer at order panels */
function set_timer(timer)
{
	var date = new Date().addSeconds(-$(timer).text()) / 1000;

	$(timer).countid({
		clock: true,
		dateTime: date,
		dateTplRemaining: "%H:%M:%S",
		dateTplElapsed: "%H:%M:%S",
		complete: function( el ){
			
		}
	});
}