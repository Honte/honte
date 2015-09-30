<div id="dialog">
<form class="dialog-form" title="Dodaj zdjęcie">
<fieldset>
<?php

echo $form->input('Photo.article_id', array('type' => 'hidden', 'value' => $id));
echo $form->input('Photo.filename', array('type' => 'file', 'label' => 'Plik'));
echo $form->input('Photo.description', array('type' => 'text', 'label' => 'Opis'));

?>
</fieldset>
</form>
</div>