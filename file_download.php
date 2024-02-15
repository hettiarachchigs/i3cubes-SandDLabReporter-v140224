<?php

include_once 'class/file.php';

$file_id = $_REQUEST['file_id'];

if ($file_id != "") {
    $file = new file($file_id);
    $row_file = $file->getData();
    $file_path = $file->path;
    $file_name = $file->name;
    
    if ($file_path != "") {
        $exist = true;
    } else {
        $exist = false;
    }
    $file_path = substr($file_path, 3);
    if ($exist) {
        $file_name = urlencode($file_name);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $file_name);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));
        ob_clean();
        flush();
        readfile($file_path);
        exit();
    } else {
        print "File Not Found";
    }
} else {
    print "File ID Not Defined";
}
?>