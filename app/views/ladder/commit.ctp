<?php echo $this->Html->script(array('ladder_commit', 'jquery/i18n/ui.datepicker-pl'), false); ?>
<?php echo $this->Html->css(array('ui.core', 'ui.base', 'ui.theme', 'ui.datepicker'), 'stylesheet', array('inline' => false)); ?>

<?php $session->flash(); ?>

<div id="ladder">

    <h1>Formularz zgłaszania wyniku</h1>

    <div id="ladder_select">
        <ul>
            <li><?php echo $html->link($html->image('icons/ladder_big.png').' Drabinka zwykła', array('controller' => 'ladder', 'action' => 'commit', 'normal'), array('escape' => false) ); ?></li>
            <li><?php echo $html->link($html->image('icons/blitz_big.png').' Drabinka blitzowa', array('controller' => 'ladder', 'action' => 'commit', 'blitz'), array('escape' => false) ); ?></li>
        </ul>
        <div class="clear"></div>
    </div>

    <div id="ladder_commit">
        <?php echo $this->element('ladder', array('players' => $players, 'ladder' => $ladder_type)); ?>
    </div>



</div>