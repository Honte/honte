<h2>
    <?php echo ($ladder_type == 0) ? 'Drabinka zwykła' : 'Drabinka blitzowa'; ?>
</h2>
<?php echo $form->create('LadderGames', array('url' => array('controller' => 'ladder', 'action' => 'commit'))); ?>

<?php echo $form->input('ladder', array('type' => 'hidden', 'value' => $ladder_type)); ?>

<h4>Gracze</h4>
<div class="players">
<?php echo $form->input('white_id', array('type' => 'select', 'label' => $html->image('white.png', array('alt' => 'Biały')), 'options' => $players), array('escape' => false)); ?>
<?php echo $form->input('black_id', array('type' => 'select', 'label' => $html->image('black.png', array('alt' => 'Czarny')), 'options' => $players), array('escape' => false)); ?>
</div>

<h4>Data gry</h4>
<div class="date">
<?php echo $form->input('date_played', array('type' => 'text', 'label' => false)); ?>
</div>

<h4>Wynik</h4>
<div class="result">
<?php echo $form->input('winner', array('type' => 'select', 'label' => false, 'div' => false, 'options' => Configure::read('Result.Winner'))); ?>
<span>przez</span>
<?php echo $form->input('type', array('type' => 'select', 'label' => false, 'div' => false, 'options' => Configure::read('Result.Type'))); ?>
<?php echo $form->input('result', array('type' => 'text', 'label' => false, 'div' => false)); ?>
<small class="grey">(Np. 10.5; 10,5; 10; ?)</small>
</div>

<h4>Zapis</h4>
<div class="sgf">
<?php echo $form->input('baduk', array('type' => 'checkbox', 'label' => 'Gra na baduk.pl', 'checked' => true)); ?>
<?php echo $form->input('baduk_id', array('type' => 'text', 'label' => 'ID')); ?>
<?php echo $form->input('url', array('type' => 'text', 'label' => 'Adres pliku SGF')); ?>
</div>

<?php echo $form->submit('Zgłoś wynik'); ?>
<?php echo $form->end(); ?>

