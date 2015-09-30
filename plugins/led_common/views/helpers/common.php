<?php
/**
 * @version 1.0
 * @author Artur Barcicki
 * @property HtmlHelper $Html
 * @property NumberHelper $Number
 */
class CommonHelper extends Helper
{
	var $helpers = array('Html', 'Number');

	/**
	 * Initalising phase for helper. Adding polish currency to NumberHelper
	 */
	public function  beforeRender() {
		$this->Number->addFormat('zł', array(
			'before' => '',
			'after' => ' zł',
			'thousands' => ' ', 
			'decimals' => ',',
			'negative' => '-'			
		));
	}
	
	/**
	 * Parses string into valid URL
	 *
	 * @param string $url A string to remove link-unfriendly characters
	 * @return string Slugged string
	 */
	public function slug($url) {
		return low(Inflector::slug($url, '-'));
	}

	/**
	 * Returns number with propers noun depending on the count and applying polish grammar rules
	 *
	 * @param integer $count A number to which assigne proper variation
	 * @param array $variations A list of variations
	 * @param string $null If number equals to zero than is transformed into null, eg. "brak zdjęć" instead of "0 zdjęć"
	 * @return string An readable and valid format of "x items" in polish language
	 */
	public function countVariations($count, $variations = array(), $null = 'Brak') {

		// if varations are empty use default - Zdjęcia
		if (empty($variations)) {
			$variations = array(
				'zdjęcie',			// 1 zdjęcie
				'zdjęcia',			// 2 zdjęcia, 3, 4, 22, 23, 24 ...
				'zdjęć'				// 5 zdjęć, 6, 7 ...
			);
		}

		if ($count == 0) {
			return $null.' '.$variations[2];
		} elseif ($count == 1) {
			return $count.' '.$variations[0];
		} elseif (($count >= 2 && $count <= 4) || ($count % 10 >= 2 && $count % 10 <= 4 && $count > 20)) {
			return $count.' '.$variations[1];
		} else {
			return $count.' '.$variations[2];
		}

	}
	
	/**
	 * Returns date in xx month year format
	 *
	 * @param string $string String with date eg. "2010-01-01" or "now"
	 * @return string Formatted date 
	 */
	public function date($string) {
		return strftime('%#d %B %Y', strtotime($string));
	}
	
	/**
	 * Return copyright year in fromat YearCreated - CurrentYear (eg. 2008 - 2010)
	 *
	 * @param string $from Year of creation
	 * @return string Formatted year 
	 */
	public function copyright($from) {

	  $now = date("Y");
	  $now_time = mktime(0, 0, 0, 1, 1, date("Y"));
	  $from_time = mktime(0, 0, 0, 1, 1, $from);

	  return ($from_time < $now_time) ? $from.' - '.$now : $from;

	}
	
	/**
	 * Returns formatted price. If old price is passed then it will be
	 * outputed after current within "del" tag.
	 *
	 * @param double $price Double value to be formatted as polish price
	 * @param double $old Old price, default is empty
	 * @return string Formatted price
	 */
	public function price($price, $old = null) {
	    $output = $this->Number->currency($price, 'zł');
	
	    // adding old price (using recurrency)
	    if ($old !== null) {
		$output = "<del>".$this->Number->currency($old, 'zł', array('after' => ''))."</del> ".$output;
	    } 
	    
	    return $output;
	}	
	
	/**
	 * Returns formatted fileszie
	 *
	 * @param double $filesize
	 * @return string 
	 */
	public function filesize($filesize) {
		return $this->Number->toReadableSize($filesize);
	}

	/**
	 * Returns time in user-friendly form
	 *
	 * @param int $duration Duration in seconds
	 * @return string Formatted duration 
	 */
	public function duration($duration) {
		
		$h = floor($duration / 3600);
		$m = floor($duration % 3600 / 60);
		$s = floor($duration % 3600 % 60);
		
		return $this->leadingZero($h) . ":" . $this->leadingZero($m). ":" . $this->leadingZero($s);
	}
	
	/**
	 * Returns number with leading zero if is smaller than 10 - for time purposes
	 *
	 * @param int $number Number to format
	 * @return string Formatted number
	 */
	public function leadingZero($number) {
		return ($number < 10) ? "0".$number : $number;
	}
	  
}
?>