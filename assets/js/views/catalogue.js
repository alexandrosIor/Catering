$( document ).ready(function() {
	
	// Nestable
	$('.dd').nestable();

	$(".dd-nodrag").on("mousedown", function(e){
		e.preventDefault();
		return false;
	});

	$('#nestable-menu').on('click', function(e)  {
		var target = $(e.target),
			action = target.data('action');
		if (action === 'expand-all') {
			$('.dd').nestable('expandAll');
		}
		if (action === 'collapse-all') {
			$('.dd').nestable('collapseAll');
		}
	});
	$('.dd').nestable('collapseAll');
	
});