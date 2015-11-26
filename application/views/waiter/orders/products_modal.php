<div class="card">
	<ul class="table-view">
<?php foreach ($products as $key => $product){?>
		<li class="table-view-cell">
			<span><i class="fa fa-plus-circle" style="color:#22BAA0"></i></span>
			<span><?=$product->name?></span>
			<em class="small"> <?=$product->description?></em>
			<span class="pull-right"><?=$product->price?> €</span>
		</li>
<?php }?>
	</ul>
</div>