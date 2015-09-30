<?php 
/**
 * Model Behavior to support AydFiles from model.
 *
 * @filesource
 * @package    app
 * @subpackage    models.behaviors
 */
 
class UploadBehavior extends ModelBehavior {
     
    var $invalidFields = array();
    var $uploadFields = array();
    var $settings = array();

    /**
     * Initiate behaviour for the model using settings.
     *
     * @param object $model    Model using the behaviour
     * @param array $settings    Settings to override for model.
     *
     * @access public
     */
    function setup(&$model, $settings = array()) {
        $default = array();
        
        if (!isset($this->settings[$model->name])) {
            $this->settings[$model->name] = $default;
        }
        
        $this->settings[$model->name] = array_merge($this->settings[$model->name], ife(is_array($settings), $settings, array()));
    }


    //ta funkcja tylko sprawdza wyniki z beforeValidate (prawdziwa walidacja odbwa się tam)
    function validateUpload(&$model, $variable, $params){
        if(!is_array($variable)){
            //$variable powinna byc tablica, ale na wszelki wypadek...
            debug('UploadBehavior->validateUpload()');
            return false;
        }
            
        foreach($variable AS $variableName => $variableValue){
        //jesli w before validate wykrylismy ze pole jest nieprwidlowe, to tu tylko to oglaszamy
            if (in_array($variableName, $this->invalidFields)) {
                if(!empty($model->data[$model->name][$model->primaryKey])){
                    $data = $model->find(array($model->name.'.'.$model->primaryKey => $model->data[$model->name][$model->primaryKey]));
                    $model->data[$model->name][$variableName] = $data[$model->name][$variableName];
                } else {
                    $model->data[$model->name][$variableName] = '';
                }
                return false;
            }
        }
        return true;
    }

    function validateMime(&$model, $variable, $params){
        //sprawdz, czy to jest edycja istniejacego obiektu, 
        //jesli tak pobierz poprzednie dane
        $valid = true;
        if(!is_array($variable)){
            debug('UploadBehavior->validateMime()');
            return false;
        }
        if(is_array($params) && !empty($params['allowType'])){
            $allowType = $params['allowType'];
        } else {
            $allowType = $params;
        }
        foreach($variable AS $variableName => $variableValue){
            if(empty($variableValue['type'])){
                //can not read mime type
                //$valid = false;
            } elseif($allowType === 'image' || $allowType === 'images'){
                if(!preg_match('/^image\/(pjpeg|jpeg|jpg|png|gif)$/', $variableValue['type'])){
                    $valid = false;
                }
            } elseif(is_array($params)){
                if(!in_array($variableValue['type'], $params)){
                    $valid = false;
                }
            } else {
            	if(!preg_match($allowType, $variableValue['type'])){
                    $valid = false;
                }
            }
            if(!$valid){
                if(!empty($model->data[$model->name][$model->primaryKey])){
                    //$tempModel = new $model->name();
                    $data = $model->find(array($model->name.'.'.$model->primaryKey => $model->data[$model->name][$model->primaryKey]));
                    $model->data[$model->name][$variableName] = $data[$model->name][$variableName];
                } else {
                    $model->data[$model->name][$variableName] = '';
                }
                return false;
            }
        }
        return true;
    }

	function validateFilesize(&$model, $variable, $params){
		
		$valid = true;
		
		if(!is_array($variable)){
	
			return false;
		}

		foreach($variable as $variableName => $variableValue){
			
			if ($variableValue['size'] > $params){
				$valid = false;
			}
		}

		if(!$valid){
			if(!empty($model->data[$model->name][$model->primaryKey])){

				$data = $model->find(array($model->name.’.’.$model->primaryKey => $model->data[$model->name][$model->primaryKey]));
				$model->data[$model->name][$variableName] = $data[$model->name][$variableName];
			} else {
				$model->data[$model->name][$variableName] = ”;
			}
			return false;
		}

		return true;
}


    function beforeValidate(&$model){
        if(empty($model->validate)){
            return true;
        }
        foreach($model->validate AS $fieldName => $ruleSet){
            $singleRule = false;
            if(!is_array($ruleSet) || isset($ruleSet['rule'])) {
                $ruleSet = array($ruleSet);
                $singleRule = true;
            } 
            foreach($ruleSet AS $index => $validator){
                if (!is_array($validator)) {
                    $validator = array('rule' => $validator);
                }
                if (is_array($validator['rule'])) {
                    $rule = $validator['rule'][0];
                } else {
                    $rule = $validator['rule'];
                }
                if($rule != 'validateUpload'){
                    continue;
                }
                $this->uploadFields[] = $fieldName;

                $last = (isSet($validator['last']))?$validator['last']:false;
                $required = (isSet($validator['required']))?$validator['required']:false;
                $allowEmpty = null;
                $allowEmpty = (!empty($validator['allowEmpty']))?$validator['allowEmpty']:true;
                $fieldValue = isSet($model->data[$model->name][$fieldName])?$model->data[$model->name][$fieldName]:null;
                $error = false;
                $error = $this->areUploadErrors($fieldValue, $required, $allowEmpty);
                
                
                if(!$error){
                    /////////////////////////////////////////////////
                    // TODO:
                    //kolejne walidacje
                    //////////////////////////////////////////////////
                }
                if($error){
                    $validator['message'] = $error;
                    $this->invalidFields[] = $fieldName;
                    if($singleRule){
                        $model->validate[$fieldName] = $validator;
                    } else {
                        $model->validate[$fieldName][$index] = $validator;
                    }
                    if($last){
                        break;
                    }
                }
                continue;
            }
        }
        return true;
    }



    function beforeSave(&$model){
        //debug($model->data); 
        //sprawdz, czy to jest edycja istniejacego obiektu, 
        //jesli tak pobierz poprzednie dane
        
		if(!empty($model->data[$model->name][$model->primaryKey])){
            $primaryKey = $model->data[$model->name][$model->primaryKey];
            $tempModel = new $model->name();
            $tempModelData = $tempModel->find(array($model->name.'.'.$model->primaryKey => $primaryKey));
        }

        foreach($model->data[$model->name] AS $field => $value){
            if(!empty($this->uploadFields)){
                if(!in_array($field, $this->uploadFields)){
                    continue;
                }
            } elseif(!isSet($model->_schema[$field]['type']) || $model->_schema[$field]['type'] != 'string' || !is_array($value)){
                continue;
            }
            $uploadErrors = ($this->areUploadErrors($value, true))?true:false;
            if(!$uploadErrors){
                $model->data[$model->name][$field] = $this->_saveFile($value, $model->name);
                if($model->data[$model->name][$field] == false && !empty($tempModelData[$model->name][$field])){
                    unset($model->data[$model->name][$field]);
                }
            } else {
                    unset($model->data[$model->name][$field]);
            }
            //debug($model->data); exit;
            
            //jesli w tym polu wczesniej istnial plik i: aktualnie wysylany idzie bez bledow, albo zostalo wyznaczone pole usunięcia pliku - usun go;
            
            if(!empty($tempModelData[$model->name][$field]) && (!$uploadErrors || (!empty($model->data[$model->name][$field.'_delete']) && $model->data[$model->name][$field.'_delete'] == 1))){
                $deleted = $this->_deleteFile($tempModelData[$model->name][$field], $model->name);
                //jesli usunie
                if($deleted && (!empty($model->data[$model->name][$field.'_delete']) && $model->data[$model->name][$field.'_delete'] == 1) && $uploadErrors){
                    $model->data[$model->name][$field] = '';
                } 
            }
        }
        
        return true;
    }

    /**
     *         
     * Run before a model is deleted, used to delete files while model deleting.
     *
     * @param object $model    Model about to be deleted.
     *
     * @access public
     */
    function beforeDelete(&$model) {
        $primaryKey = $model->primaryKey;
        $model->data = $model->find(array($model->name.'.'.$primaryKey => $model->$primaryKey));

        $return = true;

        foreach($model->data[$model->name] AS $field => $value){
            if(isSet($model->_schema[$field]['type']) && $model->_schema[$field]['type']=='string'){
                $return = $return & $this->_deleteFile($value, $model->name);
            }
        }
        
        //czy powstrzymywac usuniecie rekordu, jesni nie udalo sie usunac jednego z plikow (co jesli inne udalo sie usunac)?
        return $return;
        //return true;
    }


    function _saveFile($array, $modelName){
        $destDir = WWW_ROOT.'files'.DS.strtolower($modelName);
        if(!file_exists($destDir)){
            @mkdir($destDir, 0777);
            @chmod($destDir, 0777);
        }
        if(!is_writable($destDir) || !is_dir($destDir)){
            debug("Error: $destDir is not writable or is not a dir.");
            return false;
        }
        
        $array['name'] = $this->_normalizeFileName($array['name']);

        $destPath = $this->_getUniqueFileName($destDir.DS.$array['name']);
        
        if(move_uploaded_file($array['tmp_name'], $destPath)){
            @chmod($destPath, 0666);
            $pathinfo = pathinfo($destPath);
            return $pathinfo['basename'];
        }
        return false;
    }

    function _deleteFile($name, $modelName){
        $destDir = WWW_ROOT.'files'.DS.strtolower($modelName);
        $filePath = $destDir.DS.$name;

        if (!file_exists($filePath)){ return true; }
        if (!is_file($filePath)){ return false; }
        
        // check folders with thumbs
        $myFolder = new Folder();
        $myFolder->path = $destDir;
        $readed = $myFolder->read();
        
        // delete thumbs from folders
        foreach($readed[0] as $dir) {
            $thumbPath = $destDir.DS.$dir.DS.$name;    

            @chmod ($thumbPath, 0666);
            @unlink($thumbPath);
            @passthru("del $thumbPath /q");
        }
        
        $delete = false;
        $delete = $delete | @chmod ($filePath, 0666);
        $delete = $delete | @unlink($filePath);
        $delete = $delete | @passthru("del $filePath /q");
        
        return $delete;
    }


    function error($message, $file = '' , $line = ''){
        echo "<h3>Error</h3><p>Error in file <strong>$file</strong> (line <strong>$line</strong>).\n<br />Details: $message</p>";
    }

    function _normalizeFileName($srcName) {
        $srcName = substr($srcName, 0, 250);

        $trans = array('ª'=>'a', 'º'=>'o', 'µ'=>'u', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 
                       'Ä'=>'A', 'Ą'=>'A', 'Ç'=>'C', 'Ć'=>'C', 'È'=>'E', 'É'=>'E', 
                       'Ë'=>'E', 'Ę'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'I'=>'I', 
                       'Ł'=>'L', 'Ñ'=>'N', 'Ń'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 
                       'Ö'=>'O', 'Ś'=>'S', 'Ù'=>'U', 'Ú'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 
                       'Ż'=>'Z', 'Ź'=>'Z', 'ß'=>'ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 
                       'ä'=>'a', 'ą'=>'a', 'ç'=>'c', 'ć'=>'c', 'è'=>'e', 'é'=>'e', 
                       'ë'=>'e', 'ę'=>'e', 'í'=>'i', 'î'=>'i', 'i'=>'i', 'ł'=>'l',
                       'ñ'=>'n', 'ń'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'ö'=>'o', 
                       'ś'=>'s', 'ù'=>'u', 'ú'=>'u', 'ü'=>'u', 'ý'=>'y', 'ż'=>'z', 
                       'ź'=>'z');
        /*
        $srcName=strtr( $srcName,
            "ªºµÀÁÂÄÇÈÉËÌÍÎIÑÒÓÔÖÙÚÜÝßàáâäçèéëíîiñòóôöùúüý",
            "aouAAAACEEEIIIINOOOOUUUYsàaaaceeeiiinoooouuuy"); 
        /**/
                        
        $srcName = strtr($srcName, $trans);
        //taken from moodle
        $srcName = preg_replace('/\.\.+/','.', $srcName);

        //$string = preg_replace('/[^\.a-zA-Z\d\_-]/','_', $string ); // only allowed chars
        $srcName = preg_replace('/[^[:alnum:]\.-]/','_', $srcName ); // only allowed chars **but not only english**

        //$srcName = eregi_replace(_+, _, $string);
        $srcName = strtolower($srcName);
    
        return $srcName; 
    }

    function _getUniqueFileName($destPath) {
        $pathinfo = $this->pathinfo($destPath);
        
        $i = 1;
        while(file_exists($destPath)){
            $destPath = $pathinfo['dirname'].DS.$pathinfo['filename'].'_'.($i++).'.'.$pathinfo['extension'];
        }
        return $destPath;
    }
    
    /**
     * Get full pathInfo array: dirname, basename, extension, filename
     * 
     * @param object $path    Path to extract.
     *
     * @access public
     */
    function pathinfo($path){
        $pathinfo = pathinfo($path);
        if(!isSet($pathinfo['filename'])){
            // before PHP 5.2.0
            $extLen = strlen($pathinfo['extension']);
            $pathinfo['filename'] = substr($pathinfo['basename'], 0, -($extLen+1));
        }
        return $pathinfo;
    }


    function areUploadErrors($array, $required = false, $allowEmpty = true){
        if(!$required){
            if(empty($array)){
                if($allowEmpty){
                    return false;
                }
            } elseif(empty($array['name']) && empty($array['tmp_name']) && isSet($array['error']) && $array['error'] == UPLOAD_ERR_NO_FILE){
                if($allowEmpty){
                    return false;
                }
            }
        
        }
        if($required && (empty($array['name']) || empty($array['tmp_name']) || !isSet($array['error']))){
            return __("This field is required as file", true);
        } elseif(isSet($array['size']) && $array['size'] == 0 && !$allowEmpty) {
            return __("This field must be non empty file", true);
        } else {
            switch($array['error']){
                //// TODO:
                // Uczynić informacje bardziej przyjaznymi
                case UPLOAD_ERR_OK:
                    return false;
                case UPLOAD_ERR_INI_SIZE:
                    return __("The uploaded file exceeds the upload_max_filesize directive in php.ini.", true);
                case UPLOAD_ERR_FORM_SIZE:
                    return __("The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.", true);
                case UPLOAD_ERR_PARTIAL:
                    return __("The uploaded file was only partially uploaded.", true);
                case UPLOAD_ERR_NO_FILE:
                    return __("No file was uploaded. ", true);
                case UPLOAD_ERR_NO_TMP_DIR:
                    return __("Missing a temporary folder.", true);
                case UPLOAD_ERR_CANT_WRITE:
                    return __("Failed to write file to disk.", true);
                case UPLOAD_ERR_EXTENSION:
                    return __("File upload stopped by extension.", true);
                default:
                    return __("Unknown exception while file upload", true);
            }
        }
    }
    
}
?>