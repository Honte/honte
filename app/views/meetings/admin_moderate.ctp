<h1>Spotkania</h1>

<div class="nice">
    <h2>Najbliższe spotkania</h2>
    <ul id="meeting">
        <?php foreach($meetings as $i => $m): ?>
        <li>
            <div>
                <strong><?php echo $html->link('Ukatualnij', array('controller' => 'meetings', 'action' => 'admin_add_exception', $m['Meeting']['id'], $m['Meeting']['date'])); ?></strong>
                <strong><?php echo $html->link('Odwołaj', array('controller' => 'meetings', 'action' => 'admin_cancel_meeting', $m['Meeting']['id'], $m['Meeting']['date']), null, 'Na pewno chcesz odwołać spotkanie?'); ?></strong>
            </div>
            <h3><?php echo $m['Meeting']['date']; ?></h3>
            <h4><?php echo $places[$m['Meeting']['place_id']]; ?> </h4>
            <p><?php echo $m['Meeting']['info']; ?></p>
        </li>
        <?php endforeach; ?>
    </ul>
</div>