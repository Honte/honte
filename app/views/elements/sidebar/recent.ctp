<?php $articles = $this->requestAction(array('controller' => 'articles', 'action' => 'recent')); ?>

<section id="sidebarRecentArticles">
<p class="sidebar-rss"><?php echo $html->link($html->image('icons/feed_small.png', array('alt' => 'RSS')), array('controller' => 'articles', 'action' => 'rss'), array('escape' => false, 'title' => 'Najnowsze wydarzenia przez RSS') ); ?></p>

	<h2>Ostatnie artykuły</h2>
    <ul>
	<?php foreach($articles as $art): ?>
		<li class="link">
            <span><?php echo date("d.m.Y", strtotime($art['Article']['created'])); ?></span>
            <?php echo $html->link($art['Article']['title'], '/artykuly/'.$art['Article']['label']); ?>
        </li>
	<?php endforeach; ?>
	</ul>
</section>