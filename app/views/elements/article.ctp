<article class="listed">
	
	<div class="article-details">
		<hgroup>
			<h3 class="article-category"><?php echo $art['Category']['title']; ?></h3>
			<h4 class="article-date"><?php echo $calendar->article_date($art['Article']['created']); ?></h4>
		</hgroup>
	</div>
	
	<h1><?php echo $html->link($art['Article']['title'], array('controller' => 'articles', 'action' => 'view', $art['Article']['label'])); ?></h1>
	
	<div class="article-photo">
    <?php
        if (!empty($art['Photo'])) {
            $articleImage = $image->tag(
                '/files/photo/'.$art['Photo'][0]['filename'],
                array(
                    'size' => "250x167",
                    'aspect' => true
                ),
                array(
                    'class' => 'news_photo',
                    'alt' => $art['Photo'][0]['description'])
            );
        } else {
            $articleImage = $image->tag(
                '/img/default.jpg',
                array(
                    'size' => "250x167",
                    'aspect' => true
                ),
                array(
                    'class' => 'news_photo',
                    'alt' => $art['Category']['title'])
            );
        }
        echo $html->link(
            $articleImage,
            array(
                'controller' => 'articles',
                'action' => 'view',
                $art['Article']['label']
            ),
            array(
                'escape' => false
            )
        );
    ?>
	</div>
	
	<div class="article-content">
		<?php echo $art['Article']['short_content']; ?>
	</div>
	
	<p class="article-more"><?php echo $html->link('czytaj całość', array('controller' => 'articles', 'action' => 'view', $art['Article']['label']), array('class' => 'button')); ?></p>
	
</article>