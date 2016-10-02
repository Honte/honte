<?php $paginator->options(array('url' => $this->passedArgs)); ?>
<?php $lp = $paginator->counter('%start%'); ?>

<h1>Zarejestrowani</h1>

<div>
	<table class="table">
		<tr>
			<th></th>
			<th><?php echo $paginator->sort('imię', 'name'); ?></th>
			<th><?php echo $paginator->sort('nazwisko', 'surname'); ?></th>
			<th><?php echo $paginator->sort('status', 'confirmation'); ?></th>
			<th><?php echo $paginator->sort('klub / miasto', 'city'); ?></th>
			<th><?php echo $paginator->sort('siła', 'rank'); ?></th>
            <th><?php echo $paginator->sort('email', 'email'); ?></th>
            <th><?php echo $paginator->sort('telefon', 'phone'); ?></th>
            <th><?php echo $paginator->sort('noclegi', 'nights'); ?></th>
            <th><?php echo $paginator->sort('uwagi', 'notes'); ?></th>
			<th>opcje</th>
		</tr>
		<?php foreach($players as $p): $player = $p['Player']; ?>
		<tr>
			<td class="lp"><?php echo $lp++; ?></td>
			<td><?php echo $player['name']; ?></td>
			<td><?php echo $player['surname']; ?></td>
            <td class="center"><?php echo $player['confirmation'] ? $html->image('icons/yes_small.png') : $html->image('icons/no_small.png'); ?></td>
            <td><?php echo $player['city']; ?></td>
            <td><?php echo $rank[$player['rank']]; ?></td>
            <td><?php echo $player['email']; ?></td>
            <td><?php echo $player['phone']; ?></td>
            <td><?php echo $player['nights']; ?></td>
            <td><?php echo $player['notes']; ?></td>
			<td>
				<?php // echo $html->link('edytuj TODO', '/admin/players/edit/'.$player['id']); ?>
				<?php echo $html->link('usuń', '/admin/players/delete/'.$player['id'], null, 'Na pewno chcesz usunąć gracza?'); ?>
			</td>
		</tr>
		<?php endforeach; ?>
		<tr>
			<td colspan="11" class="nav">
				<?php echo $paginator->counter('strona %page% z %pages%');  ?>
				<?php echo $paginator->prev('«', null, null); ?>
				<?php echo $paginator->numbers(array('separator' => '&nbsp;&nbsp;', '3')); ?>
				<?php echo $paginator->next('»', null, null); ?> 
			</td>
		</tr>
	
	</table>
</div>
