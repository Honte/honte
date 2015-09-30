<?php $paginator->options(array('url' => $this->passedArgs)); ?>
<?php $lp = $paginator->counter('%start%'); ?>

<h1>Drabinka - gry</h1>

<div class="nice">
	<table class="table">
		<tr>
			<th></th>
			<th><?php echo $paginator->sort('data gry', 'date_played'); ?></th>
			<th><?php echo $paginator->sort('czarny', 'LadderPlayersAsBlack.surname'); ?></th>
			<th><?php echo $paginator->sort('biały', 'LadderPlayersAsWhite.surname'); ?></th>
			<th><?php echo $paginator->sort('wynik', 'winner'); ?></th>
			<th><?php echo $paginator->sort('status', 'visible'); ?></th>
			<th><?php echo $paginator->sort('baduk id', 'baduk_id'); ?></th>
			<th>opcje</th>
		</tr>
		<?php foreach($games as $game): ?>
		<tr>
			<td class="lp"><?php echo $lp++; ?></td>
			<td><?php echo $calendar->show_date($game['LadderGames']['date_played']); ?></td>
			<td><?php echo $ladderGame->shortName($game['LadderGamesAsBlack']); ?></td>
			<td><?php echo $ladderGame->shortName($game['LadderGamesAsWhite']); ?></td>
			<td><?php echo $ladderGame->showResult($game['LadderGames']) ?></td>
            <td>
            <?php if($game['LadderGames']['visible'] > 0): ?>
                <?php echo $html->image('icons/yes_small.png'); ?>
            <?php else: ?>
                <?php echo $html->link('zatwierdź', array('controller' => 'ladder', 'action' => 'admin_confirm', $game['LadderGames']['id']), null, 'Na pewno zatwierdzić grę?'); ?>
            <?php endif; ?>
            </td>
			<td><?php echo $ladderGame->getUrl($game['LadderGames']); ?></td>
			<td>
				<?php echo $html->link('edytuj', '/admin/ladder/edit_game/'.$game['LadderGames']['id']); ?>&nbsp;|&nbsp;
				<?php echo $html->link('usuń', '/admin/ladder/delete_game/'.$game['LadderGames']['id'],null, 'Na pewno chcesz usunąć?'); ?>
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