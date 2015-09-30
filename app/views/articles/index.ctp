<?php $paginator->options(array('url' => $this->passedArgs)); ?>
<?php if (!empty($articles)): ?>

	<?php echo $this->element('pagination'); ?>

    <div id="articles">
    <?php
        foreach($articles as $art) {
            if ($art['Category']['title'] === "Turniej") { // artykul - turniej

                // id turnieju powinno byc zawarte w *content*
                $tournament = $this->requestAction(array(
                    'controller' => 'tournaments',
                    'action' => 'get',
                ), array(
                    'pass' => array(strip_tags($art['Article']['content']))
                ));

                // jesli nie znaleziono turnieju to nic nie renderujemy
                if ($tournament != null) {

                    // nadpisanie informacji turniejowych przez dane z artykulu
                    $tournament['Tournament']['title'] = $art['Article']['title'];
                    $tournament['Tournament']['short'] = $art['Article']['short_content'];
                    $tournament['Photo'] = $art['Photo'];

                    echo $this->element('tournament', array('tournament' => $tournament));
                }

            } else { // pozostale arykuly
                echo $this->element('article', array('art' => $art));
            }
        }
    ?>
    </div>

    <?php echo $this->element('pagination'); ?>

<?php else: ?>
	
	<h3>Aktualnie nie ma jeszcze artykułów w tym dziale.</h3>

<?php endif; ?>