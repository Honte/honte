<?php echo $javascript->link(array('tiny_mce/tiny_mce'), false); ?>
<?php echo $this->element('tiny_mce'); ?>

<h1>Wiadomość do zapisanych graczy</h1>

<div class="nice">
    <?php echo $session->flash(); ?>

    <?php if (count($players)): ?>
        <p class="hint">
            <strong>Wiadmość zostanie wysłana do nast. graczy:</strong>
        <ul>
            <?php foreach($players as $player):?>
                <li><?php echo "{$player['name']} {$player['surname']}"; ?></li>
            <?php endforeach; ?>
        </ul>
        </p>


        <?php
            echo $form->create('Tournament', array('url' => array('action' => 'mail'), 'class' => 'form'));

            echo $form->input('id', array('type' => 'hidden', 'value' => $tournament['Tournament']['id']));

            echo $form->input('message', array(
                                              'type'  => 'textarea',
                                              'label' => 'Opis turnieju',
                                              'value' => $tournament['Tournament']['description']
                                         ));

            echo $form->submit('Wyślij wiadomość');
            echo $form->end();
        ?>

    <?php else: ?>
        <p class="hint">
            <strong>Brak graczy do których wysłana zostanie wiadomość</strong>
        </p>
    <?php endif; ?>
</div>