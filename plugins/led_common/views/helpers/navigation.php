<?php
/**
 * @version 1.0
 * @author Artur Barcicki
 * @property HtmlHelper $Html
 */
class NavigationHelper extends Helper
{
	var $helpers = array('Html');

	function render($navigation, $level = 0, $options = array()) {
		
		$class = "n-level-$level" . (isset($options['class']) ? " ".$options['class'] : "");
		
		$id = isset($options['id']) ? $options['id'] : "";
		$idString = (!empty($id)) ? " id=\"$id\"" : "";
		
		$current = isset($options['current']) ? $options['current'] : false;
		$currentClass = isset($options['currentClass']) ? $options['currentClass'] : "current";
		$noChildrenClass = isset($options['noChildrenClass']) ? $options['noChildrenClass'] : "n-no-children";
		$withChildrenClass = isset($options['withChildrenClass']) ? $options['withChildrenClass'] : "n-with-children";
		$output = "<ul$idString class=\"$class\">";
		
		foreach($navigation as $i => $n) {
			
			$classes = array( empty($n['children']) ? $noChildrenClass : $withChildrenClass );
			if ($current && $current == $n['Navigation']['name']) $classes []= $currentClass;
			$classes []= $n['Navigation']['class']."-box";
			$classes []= "n-li-level-$level";
			
			$output .= "<li class=\"" . join(" ", $classes) . "\">";
			$output .= $this->Html->link(
						$n['Navigation']['anchor'], 
						$n['Navigation']['link'], 
						array('title' => $n['Navigation']['title'], 'class' => $n['Navigation']['class']." n-a-level-$level", 'escape' => false)
					);
			if (!empty($n['children'])) {
				$output .= $this->render($n['children'], $level+1, array(
					'current' => $current
				));
			}
			$output .= "</li>";
		}
		
		$output .= "</ul>";
		return $output;
	}
  
}
?>