<?php $paginator->options(array('url' => $this->passedArgs)); ?>
<?php $lp = $paginator->counter('%start%'); ?>

<h1>Klubowicze</h1>

<div class="nice">
	<table class="table">
		<tr>
			<th></th>
			<th><?php echo $paginator->sort('login', 'login'); ?></th>
			<th><?php echo $paginator->sort('email', 'email'); ?></th>
			<th><?php echo $paginator->sort('status', 'active'); ?></th>
			<th><?php echo $paginator->sort('utworzono', 'utworzono'); ?></th>
			<th>opcje</th>
		</tr>
		<?php foreach($users as $user): ?>
		<tr>
			<td class="lp"><?php echo $lp++; ?></td>
			<td><?php echo $user['User']['login']; ?></td>
			<td><?php echo $user['User']['email']; ?></td>
			<td>
				<?php if ($user['User']['active']): ?>
					<strong>aktywny</strong> <?php echo $html->link('zablokuj', '/admin/users/block/'.$user['User']['id']); ?>
				<?php else: ?>
					<strong>nieaktywny</strong> <?php echo $html->link('odblokuj', '/admin/users/unblock/'.$user['User']['id']); ?>
				<?php endif; ?>
			</td>
			<td><?php echo $user['User']['created']; ?></td>
			<td>
				<?php echo $html->link('usuń', '/admin/users/delete/'.$user['User']['id'], null, 'Na pewno chcesz usunąć użytkownika?'); ?>
			</td>
		</tr>
		<?php endforeach; ?>
		<tr>
			<td colspan="7" class="nav">
				<?php echo $paginator->counter('strona %page% z %pages%');  ?>
				<?php echo $paginator->prev('«', null, null); ?>
				<?php echo $paginator->numbers(array('separator' => '&nbsp;&nbsp;', '3')); ?>
				<?php echo $paginator->next('»', null, null); ?> 
			</td>
		</tr>
	
	</table>
</div>