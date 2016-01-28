<div class="list-block">
	<ul>
<?php foreach ($active_waiters as $key => $waiter){?>
		<li class="item-content">
			<div class="item-media"><i class="fa fa-user"></i></div>
			<div class="item-inner">
				<div class="item-title"><?=$waiter->lastname . ' ' . $waiter->firstname?></div>
				<div class="item-after transfer" data-user_record_id="<?=$waiter->record_id?>"><i class="fa fa-arrows-h fa-lg"></i></div>
			</div>
		</li>
<?php }?>
	</ul>
</div>