
<div data-page="catalogue" class="page tabbar-labels-fixed">
	<div class="navbar">
		<div class="navbar-inner">
			<div class="left"><a href="index-2.html" class="back link icon-only"><i class="icon icon-back"></i></a></div>
			<div class="center">Νέα πραγγελία</div>
			<div class="right"><a href="#" class="link open-panel icon-only"><i class="icon icon-bars"></i></a></div>
		</div>
	</div>
	<div class="toolbar tabbar">
		<div class="toolbar-inner">
			<a href="#catalogue-tab" class="tab-link active"><i class="fa fa-list fa-lg"></i><span class="tabbar-label">Καταλογος</span></a>
			<a href="#order-tab" class="tab-link"><i class="fa fa-edit fa-lg"></i><span class="tabbar-label">Παραγγελια</span></a>
		</div>
	</div>

	<div class="page-content">
		<div class="tabs">
			<div id="catalogue-tab" class="tab active">
				<div class="content-block">
					<div class="list-block accordion-list">
						<ul>
<?php foreach ($product_categories as $key => $product_category){?>
							<li class="accordion-item">
								<a href="#" class="item-link item-content">
									<div class="item-inner">
										<div class="item-title"><?=$product_category->name?></div>
									</div>
								</a>
								<div class="accordion-item-content">
									<div class="list-block">
										<ul class="products-list" data-order_record_id="">
	<?php foreach ($product_category->products() as $key => $product){?>
											<li class="swipeout product">
												<div class="swipeout-content item-content">
													<div class="item-inner">
														<div class="item-title">
															<?=$product->name?>
															<em><?=substr($product->short_description, 0, 10)?></em>
														</div>
		<?php if ($product->description){?>
														<div class="right description">
															<a href="#" data-popover=".my-popover" class="link open-popover"><i class="fa fa-info-circle fa-lg"></i></a>
															<span class="hidden"><?=$product->description?></span>
														</div>
		<?php }?>
														<div class="right product-price"><?=$product->price?> €</div>
													</div>
												</div>
												<div class="swipeout-actions-left">
													<a href="#" class="action1 bg-gray">
														<i class="fa fa-minus"></i>
														<div class="product-quantity"> 1 </div>
														<i class="fa fa-plus"></i>
													</a>	
													<a href="#" class="action2 bg-orange">
														<div href="#" class="add-comment">Σχόλια</div>
													</a>
													<a href="#" class="action3 bg-green add-product" data-product_record_id="<?=$product->record_id?>" data-comments="" data-quantity="1" data-order_record_id="">
														<i class="fa fa-check fa-lg"></i>
													</a>
												</div>
											</li>
	<?php }?>
										</ul>
									</div>
								</div>
							</li>
<?php }?>
						</ul>
					</div>
				</div>
			</div>
			<div id="order-tab" class="tab">
				<div class="content-block">
					
					<div class="row current-order">
						<div class="col-50">
							<div class="list-block">
								<ul>
									<li>
										<div class="item-content">
											<div class="item-inner">
												<div class="item-input">
													<input type="text" placeholder="Επιλέξτε τραπέζι" readonly id="picker-device">
												</div>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
						<div class="col-50">
							<a href="#" class="button button-fill complete-order" disabled="true"> 0 <i class="fa fa-eur"></i></a>
						</div>
					</div>

					<div class="list-block accordion-list">
						<form>
							<ul class="order-product">
								
							</ul>
						</form>
					</div>

				</div>
			</div>
		</div>
	</div>


</div>