<?php
class RegisteringHelper extends Helper
{
    
    var $helpers = array('Html', 'Form', 'Calendar');

    function nightsSelect($name, $nights, $settings = array()) {

		$return = "";
		if ($nights >= 1) {

			$options = array();
			for ($i = 0; $i <= $nights; $i++) {
				$options[$i] = $this->Calendar->smooth($i, 'we własnym zakresie', array('nocleg', 'noclegi', 'noclegów'), true);
			}

			$return = $this->Form->input($name, am(array('type' => 'select', 'label' => 'Nocleg', 'class' => 'nights'), $settings, array('options' => $options)));

		}

		return $return;

	}

	function showNights($nights, $show = true) {
		if ($show) {
			return $this->Calendar->smooth($nights, 'nie', array('noc', 'noce', 'nocy'), true);
		} else {
			return null;
		}
	}

}
?>