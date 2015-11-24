<div class="content">
	<ul class="table-view orders">
		<li class="table-view-cell">
			<div class="pull-left">
				<span>ID</span>
			</div>
			<div style="margin-left:55%;">
				<i class="fa fa-clock-o fa-lg"></i>
			</div>
			<div class="order_cost badge badge-inverted">
				<i class="fa fa-money fa-lg"></i>
			</div>
		</li>
		<li class="table-view-cell" data-order-record-id="">
			<div class="order_num pull-left">
				<span></span>
			</div>
			<div class="order_time" style="margin-left:50%;">
				<span></span>
			</div>
			<div class="order_cost badge badge-inverted">
				<span></span>
			</div>
		</li>
	</ul>
	<div class="content-padded">
		<button class="btn btn-positive btn-block">πληρωμή συνόλου
			<div class="badge badge-positive">2</div>
		</button>
	</div>
</div>
<!-- θα αφαιρεθει και θα χρησιμοποιειτε μονο το Modal που υπαρχει στο κεντρικο layout-->
<div id="order_details_Modal" class="modal">
	<header class="bar bar-nav">
		<a class="close-order icon icon-close pull-right"></a>
		<h1 class="title">Λεπτομέρειες παραγγελίας</h1>
	</header>
	<div class="content order-details"></div>
</div>
