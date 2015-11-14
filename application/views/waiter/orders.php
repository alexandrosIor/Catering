<div class="content">
	<ul class="table-view">
		<li class="table-view-cell">
			<a href="#order_details_Modal">
				<div class="order_num pull-left">
					<span><?=$table_record_id?></span>
				</div>
				<div class="order_time" style="margin-left:50%;">
					<i class="fa fa-clock-o fa-lg"></i>
					<span>13:30</span>
				</div>
				<div class="order_cost badge badge-inverted">
					<i class="fa fa-money"></i> 53€
				</div>
			</a>
		</li>
	</ul>
	<div class="content-padded">
		<button class="btn btn-positive btn-block">πληρωμή συνόλου
		<div class="badge badge-positive">76€</div>
		</button>
	</div>
</div>

<div id="order_details_Modal" class="modal">
	<header class="bar bar-nav">
		<a class="icon icon-close pull-right" href="#order_details_Modal"></a>
		<h1 class="title">Λεπτομέρειες παραγγελίας</h1>
	</header>
	<div class="content">
		<div class="card">
			<ul class="table-view">
				<li class="table-view-cell table-view-divider">Φαγητά</li>
				<li class="table-view-cell">
					Item 1 

					<span class="badge badge-inverted"><i class="fa fa-money"></i> 10€</span>
				</li>
				<li class="table-view-cell">Item 2</li>
				<li class="table-view-cell table-view-divider">Αναψυκτικά</li>
				<li class="table-view-cell">Item 3</li>
				<li class="table-view-cell">Item 4</li>
				<li class="table-view-cell table-view-divider">Ποτά</li>
				<li class="table-view-cell">Item 3</li>
				<li class="table-view-cell">Item 4</li>
			</ul>
		</div>
	</div>
</div>