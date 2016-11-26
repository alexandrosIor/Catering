<div class="list-block">
	<ul>
<?php if ($active_waiters) {
	foreach ($active_waiters as $key => $waiter){?>
		<li class="item-content">
			<div class="item-media"><i class="f7-icons md">person</i></div>
			<div class="item-inner">
				<div class="item-title"><?=$waiter->lastname . ' ' . $waiter->firstname?></div>
				<div class="item-after transfer" data-user_record_id="<?=$waiter->record_id?>"><i class="f7-icons md">download</i></div>
			</div>
		</li>
<?php }
	}
	else {?>
		<li class="item-content">Δεν βρέθηκαν ενεργές βάρδιες</li>
<?php	}?>
	</ul>
</div>