<?php 
function cleaner($dir) {
    if(file_exists($dir)){
        $di = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
        $ri = new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ( $ri as $file ) {
            $file->isDir() ?  rmdir($file) : unlink($file);
        }
}}
cleaner(dirname(__FILE__).'/temp');
cleaner(dirname(__FILE__).'/exports');
  
?>