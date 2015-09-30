<?php
class ImageHelper extends Helper {
	public $helpers = array('Html');
	const CACHE_URL = 'imagecache'; 
	const CACHE_PATH = 'img/imagecache';
	const ALT_IMAGE_URL = 'img/photo_missing.jpg';
	const CONVERT_PATH = 'convert';
//	const CONVERT_PATH = 'C:\Program Files (x86)\ImageMagick-6.6.6-Q16\convert.exe';
		
	var $_alternativeImagePath = 'img/photo_missing.jpg';

	function txt($text,$params = array()) {
		$htmlParams = array();
		if (isset($params['alt']) && $params['alt'] != false)
			$htmlParams['alt'] = $params['alt'];
		elseif (!isset($params['alt']))
			$htmlParams['alt'] = $text;
		
		$text = htmlspecialchars_decode($text);
			
		return $this->Html->image(self::CACHE_URL.'/'.$this->creatioExNihilo($text,$params),$htmlParams);
	}

	private function creatioExNihilo($text,$params) {
		$font = 'segoeui.ttf';
		$fontSize = '35';
		$color = '#273D4F';
		$density = '0';
		
		if (isset($params['font'])) $font = $params['font'];
		if (isset($params['fontSize'])) $fontSize = $params['fontSize'];
		if (isset($params['color'])) $color = $params['color'];
		if (isset($params['aliased'])) $density = '72';
		
		$returnPath = Inflector::slug($text,'-').'.png';
		$fontPath = ROOT.DS.APP_DIR.DS.WEBROOT_DIR.DS.'files'.DS.'fonts'.DS.$font;
		$finalFile = ROOT.DS.APP_DIR.DS.WEBROOT_DIR.DS.'img'.DS.self::CACHE_URL.DS.$returnPath;
		
		if (file_exists($finalFile) == true) {
			return $returnPath;
		}
		
		$convertExec = Configure::read('Images.convertPath');
		$convertExec .= ' -channel RGBA -density '.$density.' -transparent white -fill "'.$color.'" -font '.$fontPath.' -pointsize '.$fontSize.' ';
		$convertExec .= 'label:"'.$text.'" -resample 72 ';
		$convertExec .= $finalFile;
		
		exec($convertExec);
		
		return $returnPath;
	}
	
	function tag($image_file, $config, $attrib = array()) {
		$filename = $this->adjustDS($image_file);
		return $this->Html->image(self::CACHE_URL.'/'.$this->resize($filename, $config), $attrib);
	}

	function bin($image_file, $config) {
		$filename = $this->adjustDS($image_file);
		$cache_path = strtr(self::CACHE_PATH,'/',DS);
		
		if (isset($config['file-only']) == true) {
			if ($config['file-only'] == true) {
				return ROOT.DS.APP_DIR.DS.WEBROOT_DIR.DS.$cache_path.DS.$this->resize($filename, $config);
			}
		}
		
		readfile(ROOT.DS.APP_DIR.DS.WEBROOT_DIR.DS.$cache_path.DS.$this->resize($filename, $config));
	}

	function url($image_file, $config, $prefix = '') {
		$filename = $this->adjustDS($image_file);
		return $this->Html->url('/'.self::CACHE_PATH.'/'.$this->resize($filename, $config),true);
	}

	private function resize($image_file, $config) {
		$wr_path = ROOT.DS.APP_DIR.DS.WEBROOT_DIR;
		$original_path = $wr_path.DS.$image_file;
		if(!file_exists($original_path) || is_dir($original_path)) {
			$image_file = $this->_alternativeImagePath;
			$original_path = $wr_path.DS.$image_file;
		}
		$cached_file_name = $this->workoutName($image_file, $config);
		$cached_path = $wr_path.DS.self::CACHE_PATH.DS.$cached_file_name;
		$cached = file_exists($cached_path) && @filemtime($cached_path) > @filemtime($original_path);
		if (!$cached) {
//			$this->{Configure::read('Images.convertPath') && !(isset($config['forceGd']) && $config['forceGd']) ? 'imConvert' : 'gdConvert'}($original_path, $cached_path, $config);
			$this->imConvert($original_path, $cached_path, $config);
		}
		return $cached_file_name;
	}


	private function workoutName($image, $config) {
		return md5($image.print_r($config, true)).'.'.$this->getImgType($image);
	}

	private function gdConvert($from_path, $to_path, $config) {
		$img_type = $this->getImgType($from_path);
		if (!$img_type) return false;
		$load_fun = 'imagecreatefrom'.$img_type;
		$image = $load_fun($from_path);
		$orig_size = getimagesize($from_path);
		$orig_width = $orig_size[0]; $orig_height = $orig_size[1];
		$orig_aspect = $orig_width / $orig_height;
		$set_size = $this->workoutSize($config);
		$set_width = $set_size[0]; $set_height = $set_size[1];
		$no_convert = false;
		$x_offset = 0;
		$y_offset = 0;
		$crop_x = 0;
		$crop_y = 0;
		if ($set_width && $set_height) {
			if ((isset($config['aspect']) && $config['aspect']) || (isset($config['crop']) && $config['crop'])) { //Preserve aspect.
				$x_ratio = $set_width / $orig_width;
				$y_ratio = $set_height / $orig_height;
				if (isset($config['crop']) && $config['crop']) { //Crop image and fit it into set size.
					$ratio = max(array($x_ratio, $y_ratio));
					$final_uncrop_width = (int)$orig_width * $ratio;
					$final_uncrop_height = (int)$orig_height * $ratio;
					$target_width = $set_width;
					$target_height = $set_height;
					$crop_x = (int) ($x_ratio < $y_ratio ? ($orig_width - $target_width / $y_ratio) : 0);
					$crop_y = (int) ($y_ratio < $x_ratio ? ($orig_height - $target_height / $x_ratio) : 0);
					$final_width = $final_uncrop_width - $crop_x * $ratio;
					$final_height = $final_uncrop_height - $crop_y * $ratio;
				} else { //Set size is minimal size.
					$final_width = (int)$orig_width * min(array($x_ratio, $y_ratio));
					$final_height = (int)$orig_height * min(array($x_ratio, $y_ratio));
					if (isset($config['background']) && $config['background'] != false) {//Image would be put on background. Resulting size == set size. 
						$target_width = $set_width;
						$target_height = $set_height;
						$x_offset = (int)($set_width - $final_width) / 2;
						$y_offset = (int)($set_height - $final_height) / 2;
					} else { // No background. Resulting image has the same aspect as source.
						$target_width = $final_width;
						$target_height = $final_height;
					}
				}
			} 
			else { // Resize to set size. Ignore original aspect
				$target_width = $final_width = $set_width;
				$target_height = $final_height = $set_height;
			}
		} else if ($set_width) {
			$ratio = $set_width / $orig_width;
			$target_width = $final_width = $orig_width * $ratio;
			$target_height = $final_height = $orig_height * $ratio;
		} else if ($set_height) {
			$ratio = $set_height / $orig_height;
			$target_width = $final_width = $orig_width * $ratio;
			$target_height = $final_height = $orig_height * $ratio;
		} else {
			$no_convert = true;
		}
		if ($no_convert) {
			$target_image = $image;
		} else {
			$target_image = imagecreatetruecolor($target_width, $target_height);
			imagealphablending($target_image, true);
			if (isset($config['background']) && $config['background'] != false) {
				if (is_array($config['background'])) {
					$bg_color = imagecolorallocate($target_image, $config['background'][0], $config['background'][1], $config['background'][2]);
					imagefill($target_image, 0, 0, $bg_color);
				} else if (is_string($config['background'])) {
					$bg_img_type = $this->getImgType($config['background']);
					if (!$bg_img_type) return false;
					$bg_load_fun = 'imagecreatefrom'.$bg_img_type;
					$wr_path = ROOT.DS.APP_DIR.DS.WEBROOT_DIR;
					$bg_path = $wr_path.DS.$config['background'];
					$bg_image = $bg_load_fun($bg_path);
					$bg_image_size = getimagesize($bg_path);
					imagecopyresampled($target_image, $bg_image, 0, 0, 0, 0, $target_width, $target_height, $bg_image_size[0], $bg_image_size[1]);
				}
			}
			// WHY ($crop / 2) ????????
			imagecopyresampled($target_image, $image, $x_offset, $y_offset, $crop_x / 2, $crop_y / 2, $final_width, $final_height, $orig_width - $crop_x, $orig_height - $crop_y);

		}
		if (isset($config['overlay']) && $config['overlay'] != false) {
			$overlays = isset($config['overlay'][0]) ? $config['overlay'] : array($config['overlay']);
			foreach($config['overlay'] as $overlay_file => $position) {
				$overlay_path = ROOT.DS.APP_DIR.DS.WEBROOT_DIR.DS.$overlay_file;
				$load_fun = 'imagecreatefrom'.$this->getImgType($overlay_file);
				$overlay_img = $load_fun($overlay_path);
				if (isset($position[2])) {
					$overlay_img = imagerotate($overlay_img, $this->workoutValue($position[2]), imagecolorallocatealpha($image, 0, 0, 0, 127));
				}
				$overlay_img_width = imagesx($overlay_img);
				$overlay_img_height = imagesy($overlay_img);
				imagecopyresampled($target_image, $overlay_img, $this->workoutValue($position[0]), $this->workoutValue($position[1]), 0, 0, $overlay_img_width, $overlay_img_height, $overlay_img_width, $overlay_img_height);
			}
		}
		$save_fun = 'image'.$img_type;
		$save_fun($target_image, $to_path, $this->getQuality($img_type));
	}

	private function imConvert($from_path, $to_path, $config) {
		$img_type = $this->getImgType($from_path);
		$set_size = $this->workoutSize($config);
		$set_width = $set_size[0]; $set_height = $set_size[1];
		$params = array();
		if ($q  = $this->getQuality($img_type)) {
			$params['quality'] = $q;
			$quality_string = " -quality {$params['quality']} ";
		} else {
			$quality_string = '';
		}
		if ($set_width && $set_height) {
			$orig_size = getimagesize($from_path);
			$orig_width = $orig_size[0]; $orig_height = $orig_size[1];
			$x_ratio = $set_width / $orig_width;
			$y_ratio = $set_height / $orig_height;
			if (isset($config['crop']) && $config['crop']) {
				$ratio = max(array($x_ratio, $y_ratio));
				$final_uncrop_width = (int)$orig_width * $ratio;
				$final_uncrop_height = (int)$orig_height * $ratio;
				$crop_x = ($final_uncrop_width - $set_width) / 2;
				$crop_y = ($final_uncrop_height - $set_height) / 2;
				$to_execute = "\( $from_path$quality_string-resize '${set_width}x${set_height}^' \) -crop '${set_width}x${set_height}+$crop_x+$crop_y' ";
			} else if (isset($config['aspect']) && $config['aspect']) {
				if (isset($config['background']) && $config['background']) {
					$final_width = (int)$orig_width * min(array($x_ratio, $y_ratio));
					$final_height = (int)$orig_height * min(array($x_ratio, $y_ratio));
					$x_offset = (int)(($set_width - $final_width) / 2);
					$y_offset = (int)(($set_height - $final_height) / 2);
					if (is_array($config['background'])) {
						$params['resize'] = "${set_width}x${set_height}";
						$b = $config['background'];
						$params['background'] = "rgb({$b[0]},{$b[1]},{$b[2]})";
						$params['extent'] = "${set_width}x${set_height}-$x_offset-$y_offset";
					} else {
						$bg_path = ROOT.DS.APP_DIR.DS.WEBROOT_DIR.DS.$config['background'];
						$to_execute = "$quality_string\( $bg_path -resize ${set_width}x${set_height}! \) \( $from_path -resize ${set_width}x${set_height} \) -geometry '+$x_offset+$y_offset' -composite ";
					}
				}
				$params['resize'] = "${set_width}x${set_height}";
			} else {
				$params['resize'] = "${set_width}x${set_height}!";
			}
		} else if ($set_width) {
			$params['resize'] = "${set_width}";
		} else if ($set_height) {
			$params['resize'] = "x${set_height}";
		} 
		if (!isset($to_execute)) {
			$to_execute = " \"$from_path\" "; 
			foreach($params as $param => $value) { 
				$to_execute .= "-$param {$this->q($value)} ";
			}
		}
		if (isset($config['overlay']) && $config['overlay'] != false) {
			foreach($config['overlay'] as $overlay_file => $position) {
				$overlay_path = ROOT.DS.APP_DIR.DS.WEBROOT_DIR.DS.$overlay_file;
				$overlay_offset_x = $this->workoutValue($position[0]);
				$overlay_offset_y = $this->workoutValue($position[1]);
				if (isset($position[2])) {
					$overlay_file = "\( $overlay_file -background 'rgba(0,0,0,0)' -rotate ".$this->workoutValue($position[2]).' \)';
				}
				$to_execute = "\( $to_execute \) $overlay_file -geometry '+$overlay_offset_x+$overlay_offset_y' -composite ";
			}
		}
		
		
		$to_execute .= " -depth 8 ";
		$to_execute = ImageHelper::CONVERT_PATH." {$to_execute} {$to_path}";
				
		exec($this->adjustDS($to_execute));
		return null;
	}

	private function q($s) {
		return '"'.$s.'"';
	}

	private function getImgType($f) {
		$e = end(explode('.', $f));
		switch (strtolower($e)) {
		case 'jpeg':
		case 'jpg':
		case 'jpe':
		case 'jfif':
		case 'jfi':
		case 'jif':
			return 'jpeg';
		case 'png':
			return 'png';
		case 'gif':
			return 'gif';
		default:
			return false;
		}
	}

	private function workoutSize($config) {
		if (isset($config['size'])) {
			return explode('x', $config['size']);
		} else {
			return array(isset($config['width']) ? $config['width'] : false, isset($config['height']) ? $config['height'] : false);
		}
	}

	private function getQuality($img_type) {
		switch($img_type) {
			case 'jpeg': 
				$q = Configure::read('Images.jpegQuality');
				if ($q) {
					return $q; 
				} else {
					return 95;
				}
			case 'png':
				$q = Configure::read('Images.pngQuality');
				if ($q) {
					return $q;
				} else {
					return 100;
				}
			default:
				return null;
		}
	}

	private function workoutValue($value) {
		if (!is_array($value)) {
			return $value;
		} else {
			$keys = array_keys($value);
			if ($keys[0] == 'random') {
				return rand($value['random'][0], $value['random'][1]);
			}
		}
	}

	private function adjustDS($path) {
		$result = str_replace('/', DS, $path);
		return str_replace('\\', DS, $result);
	}
	
	public function setAlternativeImagePath($path) {
		$this->_alternativeImagePath = $path;
	}
	
	public function SetDefaultAlternativeImagePath() {
		$this->_alternativeImagePath = self::ALT_IMAGE_URL;
	}
}