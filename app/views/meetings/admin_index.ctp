<?php $paginator->options(array('url' => $this->passedArgs)); ?>

<h1>Spotkania</h1>

<div class="nice">
	<table class="table">
		<thead>
		<tr>
			<th><?php echo $paginator->sort('miejsce spotkań', 'Place.name'); ?></th>
			<th><?php echo $paginator->sort('dzień tygodnia', 'day_of_week'); ?></th>
			<th><?php echo $paginator->sort('od', 'starts'); ?></th>
			<th><?php echo $paginator->sort('do', 'ends'); ?></th>
			<th><?php echo $paginator->sort('godziny', 'from'); ?></th>
			<th><?php echo $paginator->sort('status', 'active'); ?></th>
			<th><?php echo $paginator->sort('uwagi', 'info'); ?></th>
			<th>opcje</th>
		</tr>
		</thead>
		<tbody>
			
			
			<?php foreach($meetings as $m): ?>
			<tr>
				<td><b><?php echo $m['Place']['name']; ?></b></td>
				<td><?php echo $calendar->week_name($m['Meeting']['starts']); ?></td>
				<td><?php echo date("d.m.Y", strtotime($m['Meeting']['starts'])); ?></td>
				<td><?php echo date("d.m.Y", strtotime($m['Meeting']['ends'])); ?></td>
				<td><?php echo substr($m['Meeting']['from'],0,5); ?>-<?php echo substr($m['Meeting']['to'],0,5); ?></td>
				<td class="center"><?php echo ($m['Meeting']['active'] > 0 ) ? $html->image('icons/yes_small.png') : $html->image('icons/no_small.png'); ?></td>
				<td><?php echo $m['Meeting']['info']; ?></td>
				<td>
					<?php echo $html->link('edytuj', '/admin/meetings/edit_meeting/'.$m['Meeting']['id']); ?>
					<?php echo $html->link('usuń', '/admin/meetings/delete_meeting/'.$m['Meeting']['id'], null, 'Na pewno chcesz skasować?'); ?>
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
		
		</tbody>
	</table>
</div>