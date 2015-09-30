<?php $paginator->options(array('url' => $this->passedArgs)); ?>
<?php $lp = $paginator->counter('%start%'); ?>

<h1>Klubowicze</h1>

<div>
	<table class="table">
		<tr>
			<th></th>
			<th><?php echo $paginator->sort('imię', 'name'); ?></th>
			<th><?php echo $paginator->sort('nazwisko', 'surname'); ?></th>
			<th><?php echo $paginator->sort('miasto', 'city'); ?></th>
			<th><?php echo $paginator->sort('aktywność', 'active'); ?></th>
			<th><?php echo $paginator->sort('zdjęcie', 'photo'); ?></th>
			<th><?php echo $paginator->sort('siła', 'rank'); ?></th>
			<th>opcje</th>
		</tr>
		<?php foreach($members as $member): ?>
		<tr>
			<td class="lp"><?php echo $lp++; ?></td>
			<td><?php echo $member['Member']['name']; ?></td>
			<td><?php echo $member['Member']['surname']; ?></td>
			<td><?php echo $member['Member']['city']; ?></td>
            <td class="center"><?php echo ($member['Member']['active'] > 0) ? $html->image('icons/yes_small.png') : $html->image('icons/no_small.png'); ?></td>
            <td class="center"><?php echo (!empty($member['Member']['photo'])) ? $html->image('icons/yes_small.png') : $html->image('icons/no_small.png'); ?></td>
			<td><?php echo $rank[$member['Member']['rank']]; ?></td>
			<td>
				<?php echo $html->link('edytuj', '/admin/members/edit/'.$member['Member']['id']); ?>
				<?php echo $html->link('usuń', '/admin/members/delete/'.$member['Member']['id'], null, 'Na pewno chcesz usunąć członka?'); ?>
			</td>
		</tr>
		<?php endforeach; ?>
		<tr>
			<td colspan="8" class="nav">
				<?php echo $paginator->counter('strona %page% z %pages%');  ?>
				<?php echo $paginator->prev('«', null, null); ?>
				<?php echo $paginator->numbers(array('separator' => '&nbsp;&nbsp;', '3')); ?>
				<?php echo $paginator->next('»', null, null); ?> 
			</td>
		</tr>
	
	</table>
</div>