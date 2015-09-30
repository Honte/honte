<?php
class Download extends AppModel {

	// utf w/o bom trick: ą
	var $actsAs = array('Upload');

    var $useTable = 'download';
}
?>