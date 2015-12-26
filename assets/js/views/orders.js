$(document).ready(function() {

	/* set timer on each order */
	Date.prototype.addSeconds= function(h){
	    this.setSeconds(this.getSeconds()+h);
	    return this;
	}

	$('.order-timer').each(function(){

		var date = new Date().addSeconds(-$(this).text()) / 1000;

		$(this).countid({
			clock: true,
			dateTime: date,
			dateTplRemaining: "%H:%M:%S",
			dateTplElapsed: "%H:%M:%S",
			complete: function( el ){
				el.animate({ 'font-size': '50px'})
			}
		});

	});
	
})