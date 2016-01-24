<div class="row shift-details">
	<div class="col-md-3">
		<div class="panel info-box panel-white">
			<div class="panel-body">
				<div class="info-box-stats">
					<p class="user" data-user_record_id="<?=$shift->user_record_id?>" data-notification_sender="<?=$logged_in_user->lastname .' ' .$logged_in_user->firstname?>"><?=$shift->user('name')?>
					</p>
					<span class="info-box-title">Παρέδωσε: <span class="pull-right text-primary"><?=($shift->turnover_delivered) ? $shift->turnover_delivered . ' €' : '0 €' ;?></span></span>
					<span class="info-box-title">Σύνολο πωλήσεων: <span class="pull-right text-success"><?=($shift->turnover_calculated) ? $shift->turnover_calculated . ' €' : '0 €' ;?></span></span>
					<span class="info-box-title">Διαφορά: <span class="time-worked-timer pull-right text-danger"><?=($shift->turnover_diff) ? $shift->turnover_diff . ' €' : '0 €' ;?></span></span>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-9">
		<div class="panel panel-white">
			<div class="panel-body">
				<div class="table-responsive">
					<table id="shift-orders" class="display table" style="width: 100%; cellspacing: 0;" data-shift_record_id="<?=$shift->record_id?>">
						<thead>						
							<tr>
								<th>#</th>
								<th>Τραπέζι</th>
								<th>Έναρξη</th>
								<th>Λήξη</th>
								<th>Συνολικό κόστος</th>
								<th>Λεπτομέρειες</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>#</th>
								<th>Τραπέζι</th>
								<th>Έναρξη</th>
								<th>Λήξη</th>
								<th>Συνολικό κόστος</th>
								<th>Λεπτομέρειες</th>
							</tr>
						</tfoot>
						<tbody></tbody>
					</table>  
				</div>
			</div>
		</div>
	</div>
</div><!-- Row -->