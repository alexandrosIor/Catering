<h5 class="content-padded">Ρυθμισεις λογαριασμου</h5>
<form class="input-group user-info">
	<input type="text" value="<?=$logged_in_member->email?>">
	<input type="password" value="<?=$logged_in_member->password?>">
	<div class="content-padded">
		<button class="save-changes btn btn-positive btn-block" type="submit" disabled>αποθηκευση</button>
	</div>
</form>

<h5 class="content-padded">App settings</h5>
<ul class="table-view">
	<li class="table-view-cell media">
		<span class="media-object pull-left icon icon-sound"></span>
		<div class="media-body">Enable sounds</div>
		<div class="toggle">
			<div class="toggle-handle"></div>
		</div>
	</li>
</ul>

<div class="content-padded">
	<a href="/logout" class="btn btn-negative btn-block sign-out" data-transition="slide-out">αποσύνδεση <i class="fa fa-sign-out fa-lg fa-fw"></i></a>
</div>