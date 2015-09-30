<?php $paginator->options(array('url' => $this->passedArgs)); ?>
<?php $lp = $paginator->counter('%start%'); ?>

<h1>Galerie</h1>

<div class="nice">
	<table class="table">
		<tr>
			<th></th>
			<th><?php echo $paginator->sort('nazwa', 'name'); ?></th>
			<th><?php echo $paginator->sort('link', 'link'); ?></th>
			<th><?php echo $paginator->sort('status', 'active'); ?></th>
			<th><?php echo $paginator->sort('data wydarzenia', 'event_start'); ?></th>
			<th><?php echo $paginator->sort('data umieszczenia', 'created'); ?></th>
			<th>opcje</th>
		</tr>
		<?php foreach($galleries as $gallery): ?>
		<tr>
			<td class="lp"><?php echo $lp++; ?></td>
			<td><?php echo $gallery['Gallery']['name']; ?></td>
            <td><?php echo $html->link('link', $gallery['Gallery']['link']); ?></td>
			<td class="center"><?php echo ($gallery['Gallery']['active'] > 0) ? $html->image('icons/yes_small.png') : $html->image('icons/no_small.png'); ?></td>
			<td><?php echo $calendar->show_from_to($gallery['Gallery']['event_start'], $gallery['Gallery']['event_end']); ?></td>
			<td><?php echo $gallery['Gallery']['created']; ?></td>
			<td>
				<?php echo $html->link('edytuj', '/admin/galleries/edit/'.$gallery['Gallery']['id']); ?>
				<?php echo $html->link('usuń', '/admin/galleries/delete/'.$gallery['Gallery']['id'], null, 'Na pewno chcesz usunąć galerię?'); ?>
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