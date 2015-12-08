<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="myModalLabel"><?=$modal_title?></h4>
</div>
<div class="modal-body">
	<form class="user-form">
		<div class="form-group">
			<input type="text" id="name-input" class="form-control" name="firstname" placeholder="Όνομα" required tabindex="1">
		</div>
		<div class="form-group">
			<input type="text" id="position-input" class="form-control" name="lastname" placeholder="Επίθετο" required tabindex="2">
		</div>		
		<div class="form-group">
			<input type="text" id="position-input" class="form-control" name="email" placeholder="Email" required tabindex="3">
		</div>		
		<div class="form-group">
			<input type="password" id="position-input" class="form-control" name="password" placeholder="Κωδικός" required tabindex="4">
		</div>
		<div class="form-group">
		<select class="form-control" name="role" tabindex="5">
			<option value="0">Ρόλος</option>
<?php foreach ($user_roles as $key => $user_role) {?>
			<option value="<?=$user_role?>"><?=$user_role?></option>
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
	<button type="submit" class="btn btn-success save-user">Αποθήκευση</button>
</div>

<script>

	new Switchery(document.querySelector('.status'));

	$('.save-user').on('click', function(){
		save_user($('.user-form'));
	});

</script>