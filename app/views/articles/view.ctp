<?php echo $this->Html->script(array('jquery/jquery.lightbox', 'article'), false);  ?>
<?php echo $this->Html->css(array('jquery.lightbox'), 'stylesheet', array('inline' => false)); ?>

<article class="main">
	<h1><?php echo $article['Article']['title'] ?></h1>
	<div class="article-main-details"><?php echo $article['User']['login']; ?>, <?php echo $calendar->show_date($article['Article']['created']); ?></div>

    <div class="article-content">
        <?php echo $article['Article']['content']; ?>
	</div>

	<p class="article-back"><?php echo $html->link('powrót', $referer, array('class' => 'button')); ?></p>
</article>

<aside>
	<h2>Zdjęcia</h2>
	<ul class="article-gallery">	
	<?php if (!empty($article['Photo'])): ?>
		<?php foreach($article['Photo'] as $photo): ?>
			<li><?php echo $html->link($image->tag('/files/photo/'.$photo['filename'], array('size' => '160x160', 'aspect' => true, 'alt' => $photo['description'])), '/files/photo/'.$photo['filename'], array('escape' => false, 'title' => $photo['description'])); ?></li>
		<?php endforeach; ?>
	<?php else: ?>
        <?php $photos = $this->requestAction(array('controller' => 'photos', 'action' => 'getRandom'), array('pass' => array(5))); ?>
		<?php foreach($photos as $photo): ?>
			<li><?php echo $html->link($image->tag('/files/photo/'.$photo['Photo']['filename'], array('size' => '160x160', 'aspect' => true, 'alt' => $photo['Photo']['description'])), '/files/photo/'.$photo['Photo']['filename'], array('escape' => false, 'title' => $photo['Photo']['description'])); ?></li>
		<?php endforeach; ?>
	<?php endif; ?>
	</ul>
</aside>