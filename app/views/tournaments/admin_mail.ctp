<?php echo $javascript->link(array('tiny_mce/tiny_mce', 'admin/mailing'), false); ?>
<?php echo $this->element('tiny_mce'); ?>

<h1>Wiadomość do zapisanych graczy</h1>

<div class="nice">
<?php echo $session->flash(); ?>

<?php if (count($registeredPlayers) < 1): ?>
    <p class="hint">
        <strong>Nikt się jeszcze nie zapisał - nie ma do kogo wysłać wiadomość</strong>
    </p>

<?php else: ?>
    <?php echo $form->create('Tournament', array('url' => array('action' => 'mail'), 'class' => 'form')); ?>

    <table class="table">
        <tr>
            <th><a href="#select-all">zaznacz</a></th>
            <th>imię</th>
            <th>nazwisko</th>
            <th>potwierdzony</th>
            <th>email</th>
        </tr>
        <?php foreach($registeredPlayers as $player): $id = $player['id'] ?>
            <tr>
                <td class="lp"><?php echo $form->input("Tournament.players.$id", array('type' => 'checkbox', 'label' => false, 'div' => false, 'checked' => isset($selectedPlayers) ? !!$selectedPlayers[$player['id']] : !empty($player['email']))); ?></td>
                <td><?php echo $player['name']; ?></td>
                <td><?php echo $player['surname']; ?></td>
                <td class="center"><?php echo $player['confirmation'] ? $html->image('icons/yes_small.png') : $html->image('icons/no_small.png'); ?></td>
                <td><?php echo $player['email']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php
        echo $form->input('id', array('type' => 'hidden'));
        echo $form->input('template', array(
            'type'  => 'select',
            'label' => 'Szablon',
            'options' => array(
                'reminder' => 'Przypomnienie',
                'info' => 'Informacja'
            )
        ));
        echo $form->input('subject', array(
            'type'  => 'text',
            'label' => 'Tytuł'
        ));
        echo $form->input('message', array(
                                          'type'  => 'textarea',
                                          'label' => 'Treść wiadomości'
                                     ));

        echo $form->submit('Wyślij wiadomość');
        echo $form->end();
    ?>

    <?php echo $form->end(); ?>
<?php endif; ?>
