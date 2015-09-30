<?php $paginator->options(array('url' => $this->passedArgs)); ?>

<h1>Miejsca spotkań</h1>

<div class="nice">
	<table class="table">
		<thead>
		<tr>
			<th><?php echo $paginator->sort('nazwa', 'name'); ?></th>
			<th><?php echo $paginator->sort('adres', 'address'); ?></th>
			<th><?php echo $paginator->sort('mapa', 'map'); ?></th>
			<th><?php echo $paginator->sort('zdjęcie', 'photo_id'); ?></th>
			<th><?php echo $paginator->sort('zmodyfikowano', 'updated'); ?></th>
			<th><?php echo $paginator->sort('utworzono', 'created'); ?></th>
			<th>opcje</th>
		</tr>
		</thead>
		<tbody>
			
			
			<?php foreach($places as $place): ?>
			<tr>
				<td><?php echo $place['Place']['name']; ?></td>
				<td><?php echo $place['Place']['address']; ?></td>
            	<td class="center"><?php echo (!empty($place['Place']['map'])) ? $html->image('icons/yes_small.png') : $html->image('icons/no_small.png'); ?></td>
    			<td class="center"><?php echo (!empty($place['Place']['photo_name'])) ? $html->image('icons/yes_small.png') : $html->image('icons/no_small.png'); ?></td>
				<td><?php echo $place['Place']['updated']; ?></td>
				<td><?php echo $place['Place']['created']; ?></td>
				<td>
					<?php echo $html->link('edytuj', '/admin/meetings/edit_place/'.$place['Place']['id']); ?>
					<?php echo $html->link('usuń', '/admin/meetings/delete_place/'.$place['Place']['id'], null, 'Na pewno chcesz skasować?'); ?>
				</td>
			</tr>
			<?php endforeach; ?>
		
		</tbody>
	</table>
</div>