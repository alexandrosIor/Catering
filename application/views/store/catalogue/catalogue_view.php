<div class="row">
	<div class="col-md-12">
		<div class="panel panel-white">
			<div class="panel-body">
				<menu id="nestable-menu" class="no-m no-p m-b-sm">
					<button type="button" class="btn btn-primary" data-action="expand-all">Expand All</button>
					<button type="button" class="btn btn-primary" data-action="collapse-all">Collapse All</button>
				</menu>
				<div class="row">
<?php foreach ($product_categories as $key => $product_category){?>

					<div class="col-md-4">
						<div class="dd" id="nestable">
							<ol class="dd-list">
								<li class="dd-item">
									<div class="dd-handle dd-nodrag"><?=$product_category->name?></div>
									<ol class="dd-list">
	<?php foreach ($product_category->products() as $key => $product){?>
										<li class="dd-item"><div class="dd-handle dd-nodrag"><?=$product->name?></div></li>
	<?php } 
	if ($product_category->children()){
		foreach ($product_category->children() as $key => $children){?>
										<li class="dd-item">
											<div class="dd-handle"><?=$children->name?></div>
											<ol class="dd-list">
			<?php foreach ($children->products() as $key => $product){?>
												<li class="dd-item"><div class="dd-handle dd-nodrag"><?=$product->name?></div></li>
			<?php }?>
											</ol>
										</li>
		<?php }?>
	<?php }?>
									</ol>
								</li>
							</ol>
						</div>
					</div>
				<div class="clearfix"></div>
<?php }?>
</div>
			</div>
		</div>
	</div>
</div><!-- Row -->