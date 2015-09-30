<?php
foreach ($players as $p) {
    echo $p['Player']['surname']?>|<?php 
    echo $p['Player']['name']?>|<?php 
    echo $rank[$p['Player']['rank']]?>|<?php
    ?>PL|<?php 
    echo $p['Player']['city']?>|<?php
    ?>|p
<?php 
}
