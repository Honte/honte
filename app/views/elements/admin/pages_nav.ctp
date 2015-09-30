<ul>
    <?php $pages = $this->requestAction(array('controller' => 'pages', 'action' => 'render_list')); ?>

    <?php foreach($pages as $page): ?>
        <li><?php echo $html->link($page['Page']['title'], array('controller' => 'pages', 'action' => 'admin_edit', $page['Page']['id'])); ?></li>
    <?php endforeach; ?>

    <hr />
    <li><?php echo $html->link('Dodaj stronę', '/admin/pages/add'); ?></li>
</ul>