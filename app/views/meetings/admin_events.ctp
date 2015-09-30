<?php $paginator->options(array('url' => $this->passedArgs)); ?>

<h1>Wydarzenia</h1>

<div class="nice">
	<table class="table">
		<thead>
		<tr>
			<th><?php echo $paginator->sort('nazwa', 'name'); ?></th>
			<th><?php echo $paginator->sort('miasto', 'city'); ?></th>
			<th><?php echo $paginator->sort('od', 'starts'); ?></th>
			<th><?php echo $paginator->sort('do', 'ends'); ?></th>
			<th><?php echo $paginator->sort('url', 'link'); ?></th>
			<th><?php echo $paginator->sort('opis', 'description'); ?></th>
			<th>opcje</th>
		</tr>
		</thead>
		<tbody>


			<?php foreach($events as $e): ?>
			<tr>
				<td><b><?php echo $e['Event']['name']; ?></b></td>
				<td><?php echo $e['Event']['city']; ?></td>
				<td><?php echo date("d.m.Y", strtotime($e['Event']['starts'])); ?></td>
				<td><?php echo date("d.m.Y", strtotime($e['Event']['ends'])); ?></td>
				<td class="center"><?php echo (strlen($e['Event']['link']) > 0 ) ? $html->link($e['Event']['link']) : $html->image('icons/no_small.png'); ?></td>
				<td class="center"><?php echo (strlen($e['Event']['description']) > 0 ) ? $html->image('icons/yes_small.png') : $html->image('icons/no_small.png'); ?></td>
				<td>
					<?php echo $html->link('edytuj', '/admin/meetings/edit_event/'.$e['Event']['id']); ?>
					<?php echo $html->link('usuń', '/admin/meetings/delete_event/'.$e['Event']['id'], null, 'Na pewno chcesz skasować?'); ?>
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