<?php $paginator->options(array('url' => $this->passedArgs)); ?>
<?php $lp = $paginator->counter('%start%'); ?>

<h1>Turnieje</h1>

<div>
	<table class="table">
		<tr>
			<th></th>
			<th><?php echo $paginator->sort('nazwa', 'title'); ?></th>
			<th><?php echo $paginator->sort('start', 'start'); ?></th>
			<th><?php echo $paginator->sort('status', 'status'); ?></th>
			<th><?php echo $paginator->sort('l. graczy', 'player_count'); ?></th>
			<th><?php echo $paginator->sort('wyniki', 'results'); ?></th>
			<th>opcje</th>
			<th>eksport</th>
		</tr>
		<?php foreach($tournaments as $tournament): ?>
		<tr>
			<td class="lp"><?php echo $lp++; ?></td>
			<td><?php echo $html->link($tournament['Tournament']['title'], array(
                                                                                'controller' => 'players',
                                                                                'action' => 'admin_tournament_players',
                                                                                $tournament['Tournament']['id']
                                                                           )); ?></td>
			<td><?php echo $tournament['Tournament']['start']; ?></td>
            <td class="center"><?php echo ($tournament['Tournament']['status'] == 1) ? $html->image('icons/yes_small.png') : $html->image('icons/no_small.png'); ?></td>
			<td class="center"><?php echo $tournament['Tournament']['player_count']; ?></td>
            <td class="center"><?php echo (!empty($tournament['Tournament']['results'])) ? $html->image('icons/yes_small.png') : $html->image('icons/no_small.png'); ?></td>
			<td>
				<?php echo $html->link('edytuj', '/admin/tournaments/edit/'.$tournament['Tournament']['id']); ?>
                <?php echo $html->link('spamuj', '/admin/tournaments/mail/'.$tournament['Tournament']['id']); ?>
				<?php echo $html->link('usuń', '/admin/tournaments/delete/'.$tournament['Tournament']['id'], null, 'Na pewno chcesz usunąć turniej?'); ?>
			</td>
			<td>
				<?php echo $html->image('logos/macmahon.png', array(
					'title' => 'MacMahon',
					'height' => 16,
					'width' => 16,
					'url' =>  array('controller' => 'players', 'action' => 'admin_export', $tournament['Tournament']['id'], '/macmahon'))); ?>
				<?php echo $html->image('logos/gotha.jpg', array(
					'title' => 'OpenGotha',
					'height' => 16,
					'width' => 16,
					'url' =>  array('controller' => 'players', 'action' => 'admin_export', $tournament['Tournament']['id'], '/opengotha'))); ?>
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
