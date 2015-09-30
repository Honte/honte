<?php $session->flash(); ?>
<section id="tournaments">

    <?php if(!empty($tournaments)): ?>
    <?php foreach($tournaments as $tournament): ?>
        <?php echo $this->element('tournament', array('tournament' => $tournament)); ?>
    <?php endforeach; ?> 
    <?php else: ?>
        <p><strong>Brak turniejów w bazie</strong></p>
    <?php endif; ?>

    <?php echo $this->element('pagination'); ?>

</section>