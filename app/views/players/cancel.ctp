<div id="tournaments" class="cancel">

    <h1><?php echo $player['Tournament']['title'] ?> - anulowanie obecności</h1>

    <p>Jeśli na pewno chcesz odwołać swoją obecność kliknij przycisk "Na pewno nie przyjadę na turniej", jeśli nie jesteś pewny/-a swojej obecności wybierz "Nie wiem czy przyjadę". Jeśli trafiłeś/-aś tu przez przypadek wybierz "Nic nie robię". <em>W przypadku pierwszej opcji wpis zostanie usunięty bezpowrotnie.</em></p>

    <p>Aktualny status: <strong><?php echo ($player['Player']['confirmation'] > 0) ? "potwierdzono" : "niepotwierdzono" ?></strong></p>

    <?php echo $form->create('Player', array('url' => array('action' => 'cancel'))); ?>

    <?php echo $form->input('id', array('type' => 'hidden', 'value' => $player['Player']['id'])); ?>
    <?php echo $form->submit('Na pewno nie przyjadę na turniej.', array('name' => 'data[cancel]')); ?>
    <?php echo $form->submit('Nie wiem czy przyjadę.', array('name' => 'data[maybe]')); ?>
    <?php echo $form->submit('Nic nie rób.', array('name' => 'data[nothing]')); ?>

    <?php echo $form->end(); ?>

</div>