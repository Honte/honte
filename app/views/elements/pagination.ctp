<?php if($paginator->counter("%pages%") > 1): ?>

<ul class="paginate_navigation">
	<?php if ($paginator->hasPrev()) echo $paginator->prev('«', array('tag' => 'li')); ?>
    <?php echo $paginator->numbers(array('separator' => false, 'modulus' => 3, 'tag' => 'li')); ?>
	<?php if ($paginator->hasNext()) echo $paginator->next('»', array('tag' => 'li')); ?>
</ul>

<?php endif; ?>