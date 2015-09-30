<li>
    <?php echo $form->input('Photos.'.$photo['id'].'.Photo.id', array('type' => 'hidden', 'value' => $photo['id'])); ?>
    <?php echo $form->input('Photos.'.$photo['id'].'.Photo.order', array('type' => 'hidden', 'value' => $photo['order'])); ?>
    <?php echo $image->tag('/files/photo/'.$photo['filename'], array('size' => '150x100', 'aspect' => true), array('alt' => $photo['description'])); ?>
    <span><?php echo (empty($photo['description'])) ? "brak opisu" : $photo['description']; ?></span>
    <small>
        <?php echo $html->link('usuń', array('controller' => 'photos', 'action' => 'admin_delete', $photo['id']), array('class' => 'delete'), 'Na pewno chcesz usunąć zdjęcie?'); ?>
    </small>
</li>