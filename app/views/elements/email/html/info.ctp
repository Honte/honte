<?php
    $cancel = $this->Html->url($data['cancelUrl'], true);
    $info = $this->Html->url($data['tournamentUrl'], true);

    echo $data['message'];
?>
<small>Ta wiadomość dotarła do Ciebie dlatego, że widniejesz na liście graczy zapisanych na turniej Go - <a href="<?php echo $info; ?>"><?php echo $data['title']; ?></a>. Możesz zmienić swój status pod adresem: <a href="<?php echo $cancel; ?>"><?php echo $cancel; ?></a></small>