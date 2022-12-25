<?php


// error_reporting(0);
include "cleanup.php";
require  __DIR__ .'/vendor/autoload.php';
$pdf = new \Clegginabox\PDFMerger\PDFMerger;
header('Content-type: application/json');
try{
$countfiles = count($_FILES['files']['name']);
// Upload Location
$filearr=[];
$dirname = uniqid();

    mkdir("temp/$dirname");
    mkdir("exports/$dirname");
    for ($i = 0; $i < $countfiles; $i++) {
        
        //setting the allowed file format
        $allowed = array("pdf" => "application/pdf");
        //getting the files name,size and type using the $_FILES //superglobal
        $filename = $_FILES['files']['name'][$i];
        array_push($filearr,$filename);
        $filesize = $_FILES['files']['size'][$i];
        $filetype = $_FILES['files']['type'][$i];
        //verifying the extention of the file
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!array_key_exists($ext, $allowed)) throw new Exception("Error: the file format is not acceptable");
        //verifying the file size
    $maxsize = 5 * 1024 * 1024;
    if ($filesize > $maxsize) throw new Exception("Error: file size too large!!");
    if (in_array($filetype, $allowed)) {
        if (file_exists("temp/".$dirname."/". $filename)) {
            throw new Exception("File already exists");
        } else {
            move_uploaded_file($_FILES['files']['tmp_name'][$i], "temp/".$dirname."/". $filename);
        }
    } else {
        throw new Exception("Invalid filetype");
    }
}

// add as many pdfs as you want
for ($i = 0; $i < $countfiles; $i++) {
    $pdf->addPDF("temp/$dirname/$filearr[$i]");
}
$merged="exports/$dirname/merged.pdf";
$pdf->merge('file',$merged);
echo json_encode("/$merged");
}
catch(Exception $e) {
    $response['success'] = false;
    $response['error'] = $e->getMessage();
    echo json_encode($response);

}

