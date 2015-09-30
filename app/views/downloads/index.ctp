<div id="download">
	<h2>Dział Download</h2>

    <?php if(!empty($files)): ?>
        <table class="no-result-table">
        <?php foreach($files as $file): ?>
            <tr>
                <td class="name link"><?php echo $html->link($file['Download']['name'], '/files/download/'.$file['Download']['filename']); ?></td>
                <td class="desc"><?php echo $file['Download']['description']; ?></td>
                <td class="icon"><?php echo $html->link($html->image('icons/download.png', array('alt' => 'Ściągnij')), '/files/download/'.$file['Download']['filename'], array('escape' => false) ); ?></td>
                <td class="filesize">(<?php echo $download->extension('/files/download/'.$file['Download']['filename']); ?>, <?php echo $download->filesize('/files/download/'.$file['Download']['filename']); ?>)</td>
            </tr>
        <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p><strong>Dotychczas nie dodano żadnych plików</strong></p>
    <?php endif; ?>
</div>