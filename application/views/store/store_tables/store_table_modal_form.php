<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="myModalLabel"><?=$modal_title?></h4>
</div>
<div class="modal-body">
	<form class="store-table-form">
		<div class="form-group">
			<input type="text" class="form-control" name="caption" placeholder="Όνομα" required tabindex="1">
		</div>
		<div class="form-group">
			<input type="text" class="form-control" name="seats" placeholder="Θέσεις" required tabindex="2">
		</div>				
		<div class="form-group"> 
			<div class="ios-switch switch-md">
				Ενεργοποίηση
				<input type="checkbox" name="status" class="js-switch compact-menu-check status">
			</div>
		</div>
	</form>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Ακύρωση</button>
	<button type="submit" class="btn btn-success save-store-table">Αποθήκευση</button>
</div>

<script>

	new Switchery(document.querySelector('.status'));

	$('.save-store-table').on('click', function(){
		if (!form_empty($('.store-table-form')))
		{
			save_store_table($('.store-table-form'));
		}
	});

</script>