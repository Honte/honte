<?php $paginator->options(array('url' => $this->passedArgs)); ?>
<?php $lp = $paginator->counter('%start%'); ?>

<h1>Artykuły</h1>

<div class="nice">
	<table class="table">
		<tr>
			<th></th>
			<th><?php echo $paginator->sort('tytuł', 'title'); ?></th>
			<th><?php echo $paginator->sort('kategoria', 'Category.name'); ?></th>
			<th><?php echo $paginator->sort('autor', 'User.login'); ?></th>
			<th><?php echo $paginator->sort('s.g.', 'main_page'); ?></th>
			<th><?php echo $paginator->sort('data utworzenia', 'created'); ?></th>
			<th>opcje</th>
		</tr>
		<?php foreach($articles as $article): ?>
		<tr>
			<td class="lp"><?php echo $lp++; ?></td>
			<td><?php echo $html->link($article['Article']['title'], '/artykuly/'.$article['Article']['label'], null, 'Przenieść na stronę artykułu?'); ?></td>
			<td><?php echo $article['Category']['name']; ?></td>
			<td><?php echo $article['User']['login']; ?></td>
			<td>
                <?php if($article['Article']['main_page'] > 0): ?>
                    <strong><?php echo $article['Article']['main_page']; ?></strong>
                <?php else: ?>
                    nd
                <?php endif; ?>
            </td>
			<td><?php echo $article['Article']['created']; ?></td>
			<td>
				<?php echo $html->link('edytuj', '/admin/articles/edit/'.$article['Article']['id']); ?>&nbsp;&nbsp;
				<?php echo $html->link('usuń', '/admin/articles/delete/'.$article['Article']['id'], null, 'Na pewno chcesz skasować?'); ?>
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
	
	<div id="hints">
        <strong>Wskazówki</strong>
        <ul>
            <li>kliknięcie na tytuł przeniesie Cię na stronę z artykułem</li>
            <li>s.g. - pozycja na stronie głównej</li>
        </ul>
    </div>

</div>