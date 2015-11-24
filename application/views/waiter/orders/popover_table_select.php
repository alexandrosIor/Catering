<div id="popover" class="popover">
	<header class="bar bar-nav">
		<h1 class="title">Επιλέξτε τραπέζι</h1>
	</header>
	<ul class="table-view">
<?php foreach ($store_tables as $key => $table){?>
		<li class="table-view-cell"><?=$table->caption?><i class="fa fa-users pull-right"></i></li>
<?php }?>
	</ul>
</div>