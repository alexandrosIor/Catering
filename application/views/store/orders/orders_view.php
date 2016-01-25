<div class="panel panel-white">
	<div class="panel-body">
		<div role="tabpanel">
			<!-- Nav tabs -->
			<ul class="nav nav-tabs nav-justified" role="tablist">
				<li role="presentation" class="active"><a href="#incomplete-orders" role="tab" data-toggle="tab"><i class="fa fa-hourglass-half m-r-xs"></i>Τρέχουσες</a></li>
				<li role="presentation"><a href="#unpaid-orders" role="tab" data-toggle="tab"><i class="fa fa-money m-r-xs fa-lg"></i>Απλήρωτες</a></li>
				<li role="presentation"><a href="#completed-orders" role="tab" data-toggle="tab"><i class="fa fa-check-circle-o m-r-xs fa-lg"></i>Ολοκληρωμένες</a></li>
			</ul>
			<!-- Tab panes -->
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active fade in" id="incomplete-orders">
 					<div class="row">
						<div class="orders">
<?php foreach ($orders as $order){?>
								<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
									<div class="panel panel-purple order-panel" data-order_record_id="<?=$order->record_id?>">
										<div class="panel-heading">
											<h3 class="panel-title">
												<span><i class="fa fa-th-large fa-lg m-r-xs"></i><span class="text-md"><?=$order->store_table_info->caption?></span></span>
											</h3>
											<div class="panel-control pull-right">
												<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Expand/Collapse" class="panel-collapse"><i class="fa fa-expand fa-fw"></i></a>
												<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Remove" class="panel-remove"><i class="fa fa-times fa-lg"></i></a>
											</div>
											<span class="order-timer pull-right m-r-sm"><?=$order->elapsed_time?></span>
										</div>
										<div class="panel-body order-summary">
											<div class="waiter-name pull-left"><i class="fa fa-user fa-fw"></i><?=$order->user_info->lastname . ' ' .  $order->user_info->firstname?></div>
											<div class="order-total-cost pull-right"><?=$order->total_price?> €</i></div>
											
										</div>
										<a href="/orders/order_modal_form/<?=$order->record_id?>" class="view-order btn btn-success btn-block" data-toggle="modal" data-target="#myModal"><i class="fa fa-search fa-lg fa-fw"></i>προβολή</a>
									</div>
								</div>
<?php }?>
						</div><!-- Sortable -->
					</div>
				</div>
				<div role="tabpanel" class="tab-pane fade" id="unpaid-orders">
					<div class="table-responsive">
						<table class="display table">
							<thead>
								<tr>
									<th>ID</th>
									<th>Τραπέζι</th>
									<th>Σερβιτόρος</th>
									<th>Ώρα έναρξης</th>
									<th>Ώρα ολοκλήρωσης</th>
									<th>Χρόνος ολοκλήρωσης</th>
									<th>Συνολικό ποσό</th>
									<th>Ενέργειες</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>ID</th>
									<th>Τραπέζι</th>
									<th>Σερβιτόρος</th>
									<th>Ώρα έναρξης</th>
									<th>Ώρα ολοκλήρωσης</th>
									<th>Χρόνος ολοκλήρωσης</th>
									<th>Συνολικό ποσό</th>
									<th>Ενέργειες</th>
								</tr>
							</tfoot>
							<tbody></tbody>
						</table>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane fade" id="completed-orders">
					<div class="table-responsive">
						<table class="display table">
							<thead>
								<tr>
									<th>ID</th>
									<th>Τραπέζι</th>
									<th>Σερβιτόρος</th>
									<th>Ώρα έναρξης</th>
									<th>Ώρα ολοκλήρωσης</th>
									<th>Χρόνος ολοκλήρωσης</th>
									<th>Συνολικό ποσό</th>
									<th>Ενέργειες</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>ID</th>
									<th>Τραπέζι</th>
									<th>Σερβιτόρος</th>
									<th>Ώρα έναρξης</th>
									<th>Ώρα ολοκλήρωσης</th>
									<th>Χρόνος ολοκλήρωσης</th>
									<th>Συνολικό ποσό</th>
									<th>Ενέργειες</th>
								</tr>
							</tfoot>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
