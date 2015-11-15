$(function(){

//===================== Modals START=====================
	$('.open-settings').on('touchend', function(){
		$('#settings_modal').addClass('active');
	});

	$('.close-settings').on('touchend', function(){
		$('#settings_modal').removeClass('active');
	});

	$('.orders li').each(function(i){
		if (i > 0)
		{
			$(this).on('touchend', function(){
				$('#order_details_Modal').addClass('active').css('z-index','1040');
			});
		}
	});

	$('.close-order').on('touchend', function(){
		$('#order_details_Modal').removeClass('active').css('z-index','0');
	});
//===================== Modals END=====================
	
	$('form.user-info input').each(function(){
		$(this).on('change', function(){
			$('button.save-changes').removeAttr('disabled'); 
		})
	})
})