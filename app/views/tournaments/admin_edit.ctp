<?php echo $javascript->link( array('jscalendar/calendar', 'jscalendar/lang/calendar-pl-utf8', 'date_picker' ), false); ?>
<?php echo $javascript->link(array('tiny_mce/tiny_mce'), false); ?>
<?php echo $this->element('tiny_mce'); ?>
<?php echo $html->css('../js/jscalendar/skins/minium/theme', false); ?>

<h1>Nowy turniej</h1>

<div class="nice">

    <?php
    echo $form->create('Tournament', array('url' => array('action' => 'edit'), 'class' => 'form'));

    echo $form->input('id', array('type' => 'hidden'));

    echo $form->input('title', array('type' => 'text', 'label' => 'Nazwa'));

    echo $datePicker->picker('start', array('label' => 'Start turnieju'));

    echo $form->input('status', array('type' => 'select', 'label' => 'Rejestracja', 'options' => array(1 => 'włączona', 0 => 'wyłączona')));
    echo $form->input('nights', array('type' => 'text', 'label' => 'Noclegi', 'default' => 0));
    echo $form->input('max_players', array('type' => 'text', 'label' => 'Max l. graczy'));

    echo $form->input('short', array('type' => 'textarea', 'label' => 'Streszczenie', 'class' => 'short'));
    echo $form->input('description', array('type' => 'textarea', 'label' => 'Opis turnieju'));

    echo $form->input('results', array('type' => 'textarea', 'label' => 'Wyniki'));


    echo $form->submit('Zapisz zmiany');
    echo $form->end();


    ?>

</div>