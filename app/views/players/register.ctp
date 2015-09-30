<div id="tournaments">

    <h1><?php echo $tournament['Tournament']['title'] ?> - rejestracja</h1>

    <div class="registration">
        <?php echo $form->create('Player', array('url' => array('action' => 'register', $tournament['Tournament']['id']))); ?>

        <?php echo $form->hidden('tournament_id', array('value' => $tournament['Tournament']['id'])); ?>

        <?php echo $form->input('name', array('type' => 'text', 'label' => 'Imię')); ?>
        <?php echo $form->input('surname', array('type' => 'text', 'label' => 'Nazwisko')); ?>
        <?php echo $form->input('city', array('type' => 'text', 'label' => 'Klub / miasto')); ?>
        <?php echo $form->input('rank', array('type' => 'select', 'label' => 'Siła', 'options' => array_reverse($rank, true))); ?>
        <?php echo $registering->nightsSelect('nights', $tournament['Tournament']['nights']); ?>

        <p>Zalecane jest podanie adresu e-mail &ndash; będzie na niego wysłana prośba o potwierdzenie.</p>
        <?php echo $form->input('email', array('type' => 'text', 'label' => 'Adres e-mail')); ?>

        <p>Podanie numeru telefonu ułatwi nawiązanie kontaktu w nadzwyczajnych sytuacjach.</p>
        <?php echo $form->input('phone', array('type' => 'text', 'label' => 'Numer telefonu')); ?>

        <?php echo $form->input('notes', array('type' => 'textarea', 'label' => 'Dodatkowe uwagi')); ?>

        <p>
            <?php echo $form->submit('Zapisz się!', array('class' => 'button', 'div' => false)); ?>
            <?php echo $html->link('Powrót', array('controller' => 'tournaments', 'action' => 'view', $tournament['Tournament']['id'])); ?>
        </p>

        <?php echo $form->end(); ?>
    </div>

</div>