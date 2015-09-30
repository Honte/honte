<section id="gallery">

	<?php echo $this->element('pagination');?>
	
    <?php foreach($galleries as $gallery): ?>
		<article class="listed">

		<div class="article-details">
			<h3>Galeria</h4>
			<h4><?php echo $calendar->article_date($gallery['Gallery']['event_start']); ?></h4>
		</div>

		<h1><?php echo $html->link($gallery['Gallery']['name'], $gallery['Gallery']['link']); ?></h1>

		<div class="article-photo">
		<?php if (!empty($art['Photo'])): ?>
			<?php echo $image->tag('/files/gallery/'.$gallery['Gallery']['photo'], array('size' => "250x167", 'aspect' => true, 'class' => 'news_photo', 'alt' => $gallery['Gallery']['name']));?>
		<?php else: ?>
			<?php echo $image->tag('/img/default.jpg', array('size' => "250x167", 'aspect' => true, 'class' => 'news_photo', 'alt' => $gallery['Gallery']['name']));?>
		<?php endif; ?>
		</div>

		<div class="article-content">
			<?php echo $gallery['Gallery']['description']; ?>
		</div>

		<p class="article-more">
			<?php echo $html->link('zobacz galerię', $gallery['Gallery']['link'], array('title' => 'zobacz galerię','class' => 'button')); ?>
			<?php if(!empty($gallery['Gallery']['link_hq'])): ?>
			<?php echo $html->link('zobacz galerię w HQ', $gallery['Gallery']['link_hq'], array('title' => 'zobacz galerię w HQ','class' => 'button')); ?>
			<?php endif; ?>
		</p>
	</article>
	<?php endforeach; ?>

    <?php echo $this->element('pagination'); ?>

</section>