<h3>Zapisy na Mistrzostwa Polski Par 2010</h3>

<p>Zapisy na turniej towarzyszący znajdziesz <?php echo $html->link('pod tym adresem', array('controller' => 'players', 'action' => 'register', $mpp_addon_id), array('title' => 'Turniej towarzyszący MPP - rejestracja')); ?>.</p>

<p>Przypominamy, że aby zagrać o tytuł najlepszej pary w Polsce gracze muszą być <strong>członkami PSG</strong>.</p>

<p><?php echo $html->link('Zobacz pary zarejestrowane na MPP 2010', array('controller' => 'mpp', 'action' => 'pary'), array('title' => 'Zobacz pary zarejestrowane na MPP 2010')); ?></p>

<?php echo $form->create('Player', array('url' => array('controller' => 'mpp','action' => 'zapisy'))); ?>
<?php for ($i = 0; $i < 2; $i++): ?>
<?php $gender = array('Kobieta', 'Mężczyzna'); ?>

<fieldset>
	<legend><?php echo $gender[$i]; ?></legend>

	<?php echo $form->hidden("Pair.$i.tournament_id", array('value' => $mpp_id)); ?>

    <?php echo $form->input("Pair.$i.name", array('type' => 'text', 'label' => 'Imię')); ?>
    <?php echo $form->input("Pair.$i.surname", array('type' => 'text', 'label' => 'Nazwisko')); ?>
    <?php echo $form->input("Pair.$i.rank", array('type' => 'select', 'label' => 'Siła', 'options' => array_reverse($rank, true))); ?>
	<?php echo $form->input("Pair.$i.city", array('type' => 'text', 'label' => 'Miasto')); ?>
    <?php //echo $registering->nightsSelect("$i.nights", $tournament['Tournament']['nights']); ?>


</fieldset>

<?php endfor; ?>

<?php echo $form->input('email', array('type' => 'text', 'label' => 'Adres e-mail (do ew. kontaktu)')); ?>

<?php echo $form->submit('Zapisz parę'); ?>

<?php echo $form->end(); ?>

<p><?php echo $html->link('Zobacz pary zarejestrowane na MPP 2010', array('controller' => 'mpp', 'action' => 'pary'), array('title' => 'Zobacz pary zarejestrowane na MPP 2010')); ?></p>
