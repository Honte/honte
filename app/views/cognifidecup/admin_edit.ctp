<h1><?php echo $this->data['CognifidecupResult']['name'] ?></h1>

<div>
  <?php
    echo $form->create('CognifidecupResult', array('url' => array('controller' => 'cognifidecup', 'action' => 'edit'), 'class' => 'form'));
    echo $form->input('id', array('type' => 'hidden'));
    echo $form->input('results', array('type' => 'textarea', 'label' => 'Wyniki'));
    echo $form->submit('Zapisz zmiany');
    echo $form->end();
  ?>
</div>
