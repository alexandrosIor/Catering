<div class="row active-shifts">
	<div class="col-md-12"><h2>Ενεργές βάρδιες</h2></div>
<?php if ($active_shifts){
	foreach ($active_shifts as $key => $shift){?>
	<div class="col-lg-3 col-md-6">
		<div class="panel info-box panel-white">
			<div class="panel-body">
				<div class="info-box-stats">
					<p class="user" data-user_record_id="<?=$shift->user_record_id?>" data-notification_sender="<?=$logged_in_user->lastname .' ' .$logged_in_user->firstname?>"><?=$shift->user('name')?>
						<i class="fa pull-right <?=($shift->user('role') == 'waiter') ? 'notify-user fa-bell ' : 'fa-user'; ?>"></i>
					</p>
					<span class="info-box-title">Πόστο: <span class="pull-right text-primary"><?=($shift->user('role') == 'waiter') ? 'Service' : 'Κατάστημα'; ?></span></span>
					<span class="info-box-title">Ωρα έναρξης: <span class="pull-right"><?=$shift->start_date?></span></span>
					<span class="info-box-title">Χρόνος εργασίας: <span class="time-worked-timer pull-right"><?=$shift->time_worked?></span></span>
					<span class="info-box-title">Συνολο παραγγελιών: <span class="pull-right"><?=$shift->total_orders?></span></span>
					<span class="info-box-title">Απλήρωτες παραγγελίες: <span class="pull-right"><?=$shift->unpaid_orders?></span></span>
					<span class="info-box-title">Ολοκληρωμένες παραγγελίες: <span class="pull-right"><?=$shift->completed_orders?></span></span>
				</div>
				<div class="info-box-progress">
					<div class="progress progress-xs progress-squared bs-n">
						<div class="progress-bar progress-bar-warning" role="progressbar" style="width: 100%">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php }}else{?>
	<div class="col-lg-3 col-md-6">
		<h3>Δεν βρέθηκαν ενεργές βάρδιες.</h3>
	</div>
<?php }?>
</div>

<?php if ($logged_in_user->role == 'admin'){?>
<div class="row">
	<div class="col-lg-3 col-md-6">
		<div class="panel info-box panel-white">
			<div class="panel-body">
				<div class="info-box-stats">
					<p class="counter"><?=$current_paid?> €</p>
					<span class="info-box-title">Τρέχον ταμείο</span>
				</div>
				<div class="info-box-icon">
					<i class="fa fa-money"></i>
				</div>
				<div class="info-box-progress">
					<div class="progress progress-xs progress-squared bs-n">
						<div class="progress-bar progress-bar-info" role="progressbar" style="width: 100%">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-3 col-md-6">
		<div class="panel info-box panel-white">
			<div class="panel-body">
				<div class="info-box-stats">
					<p class="counter"><?=$current_unpaid?> €</p>
					<span class="info-box-title">Ποσό από απλήρωτες παραγγελίες</span>
				</div>
				<div class="info-box-icon">
					<i class="fa fa-money"></i>
				</div>
				<div class="info-box-progress">
					<div class="progress progress-xs progress-squared bs-n">
						<div class="progress-bar progress-bar-danger" role="progressbar" style="width: 100%">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
	<div class="col-lg-3 col-md-6">
		<div class="panel info-box panel-white">
			<div class="panel-body">
				<div class="info-box-stats">
					<p class="counter"><?=$current_total?> €</p>
					<span class="info-box-title">Συνολικό ποσό</span>
				</div>
				<div class="info-box-icon">
					<i class="fa fa-money"></i>
				</div>
				<div class="info-box-progress">
					<div class="progress progress-xs progress-squared bs-n">
						<div class="progress-bar progress-bar-success" role="progressbar" style="width: 100%">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php }?>