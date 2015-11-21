<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="myModalLabel"><?=$modal_title?></h4>
</div>
<div class="modal-body">
	<div class="form-group">
		<input type="text" id="name-input" class="form-control" name="name" placeholder="Όνομα" required>
	</div>
	<div class="form-group">
		<input type="text" id="position-input" class="form-control" name="description" placeholder="Περιγραφή" required>
	</div>
	<div class="form-group">
	<select class="form-control" name="category">
		<option>επιλέξτε κατηγορία</option>
	</select>
	</div>
	<div class="form-group"> 
		<div class="ios-switch switch-md">
			Ενεργοποίηση
			<input type="checkbox" name="status" class="js-switch compact-menu-check status">
		</div>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Ακύρωση</button>
	<button type="submit" id="add-row" class="btn btn-success">Αποθήκευση</button>
</div>

<script>new Switchery(document.querySelector('.status'));</script>