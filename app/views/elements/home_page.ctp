<?php $session->flash(); ?>

<?php $articles = $this->requestAction( array('controller' => 'articles', 'action' => 'home')); ?>

<?php foreach($articles as $art): ?>
	<?php echo $this->element('article', array('art' => $art)); ?>
<?php endforeach; ?>