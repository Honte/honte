<?php
class DownloadHelper extends Helper
{
  function filesize($filename) {
  
    $size = filesize(WWW_ROOT.$filename);
    
    if ($size > 1024*1024*1024) return round($size/(1024*1024*1024), 2).' GB';
    if ($size > 1024*1024) return round($size/(1024*1024), 2).' MB';
    if ($size > 1024) return round($size/1024, 2).' KB';
    return $size.' B';

  }

  function extension($filename) {

    $filename = WWW_ROOT.$filename;
    $ext = end(explode('.', $filename));

    if (empty($ext)) {
        return '?';
    } else {
        return up($ext);
    }

  }

}
?>