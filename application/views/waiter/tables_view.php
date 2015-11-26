<div class="content">
	<div class="content-padded">
		<ul class="table-view">
<?php foreach ($tables as $key => $table){?>
			<li class="table-view-cell">
				<a href="/tables/table_orders/<?=$table->record_id?>" class="navigate-right">
					<?=($table->in_use) ? '<span class="badge badge-inverted"><i class="fa fa-users fa-lg"></i></span>' : ''?>
					<span><i class="fa fa-th-large fa-fw"></i><?=$table->caption?></span>
				</a>
			</li>
<?php }?>
		</ul>
	</div>
</div>