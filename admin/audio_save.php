<?php
// via: https://github.com/muaz-khan/RecordRTC/blob/master/RecordRTC-to-PHP/save.php
include_once("../config.php");
header("Access-Control-Allow-Origin: *");

    if (!isset($_POST['audio-filename'])) {
        echo 'PermissionDeniedError';
        return;
    }

    $fileName = '';
    $tempName = '';

    if (isset($_POST['audio-filename'])) {
        $fileName = $_POST['audio-filename'];
        $tempName = $_FILES['audio-blob']['tmp_name'];
    } 
	
    if (isset($_POST['audio-class'])) $fileClass = $_POST['audio-class'];
	if (isset($_POST['audio-id'])) $fileID = $_POST['audio-id'];
	if (isset($_POST['audio-field_name'])) $fileField = $_POST['audio-field_name'];

	if ($fileID==-1)
	{	
		$klasa=ucfirst($fileClass); 
		$obj = $ObjectFactory->createObject($klasa);
		$colid=$DBBR->vratiPoslednjiID($obj);
		$fileID=$colid[1]+1;
	}
	$sql ="DELETE FROM  `audio` WHERE class = '".$fileClass."' AND id = '".$fileID."' AND field = '".$fileField."'" ;
	$DBBR->con->query($sql);
	
	$sql="INSERT INTO `audio`(`class`, `id`,`field`,`filename` ) VALUES ('".$fileClass."','".$fileID."','".$fileField."','".$fileName."')";
	$results = $DBBR->con->query($sql);	
	
	
    if (empty($fileName) || empty($tempName)) {
        echo 'PermissionDeniedError';
        return;
    }
    $filePath = '../audio_content/' . $fileName;

    // make sure that one can upload only allowed audio/video files
    $allowed = array(
        'webm',
        'wav',
        'mp4',
        'mp3',
        'ogg'
    );
    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
    if (!$extension || empty($extension) || !in_array($extension, $allowed)) {
        echo 'PermissionDeniedError';
        continue;
    }

    if (!move_uploaded_file($tempName, $filePath)) {
        echo ('Problem saving file.');
        return;
    }

    echo ($filePath);


?>