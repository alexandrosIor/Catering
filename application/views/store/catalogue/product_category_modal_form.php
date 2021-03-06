<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="myModalLabel"><?=$modal_title?></h4>
</div>
<div class="modal-body">
	<form class="product-category-form">
		<div class="form-group">
			<input type="text" id="name-input" class="form-control" name="name" placeholder="Όνομα" required tabindex="1">
		</div>
		<div class="form-group">
			<input type="text" id="position-input" class="form-control" name="description" placeholder="Περιγραφή" required tabindex="2">
		</div>
		<div class="form-group">
		<select class="form-control" name="parent_record_id" tabindex="3">
			<option value="0">γονική κατηγορία</option>
<?php foreach ($product_categories as $key => $product_category) {?>
			<option value="<?=$product_category->record_id?>"><?=$product_category->name?></option>
<?php }?>
		</select>
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
	<button type="submit" class="btn btn-success save-product-category">Αποθήκευση</button>
</div>

<script>

	new Switchery(document.querySelector('.status'));

	$('.save-product-category').on('click', function(){
		if (!form_empty($('.product-category-form')))
		{
			save_category($('.product-category-form'));
		}
	});

</script>