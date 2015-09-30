<?php $this->Html->script(array('board'), false); ?>
<section id="introduction">
    <div class="board">
        <?php
            $stones[1][2] = 'white';
            $stones[2][1] = 'white';
            $stones[2][2] = 'black';
            $stones[2][3] = 'white';
        ?>
        <?php echo $this->Board->show(3,3, $stones); ?>
    </div>
    <div class="learn">
        <?php echo $html->link('
            <strong>Poznaj zasady!</strong>
            <span>Przejdź do interaktywnego kursu Go</span>
        ', 'http://kursgo.pl', array('escape' => false, 'title' => 'Poznaj zasady w interaktywnym kursie Go')); ?>
    </div>
</section>