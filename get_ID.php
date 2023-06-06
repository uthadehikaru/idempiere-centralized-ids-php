<?php
if(!isset($_GET['USER'])){
    die("No User Defined");
}
if(!isset($_GET['PASSWORD'])){
    die("No Pass Defined");
}
if(!isset($_GET['PROJECT'])){
    die("No Project Defined");
}
if(!isset($_GET['TABLE'])){
    die("No Table Defined");
}
$user = $_GET['USER'];
$password = $_GET['PASSWORD'];
$project = strtoupper($_GET['PROJECT']);
$table = $_GET['TABLE'];
$comment = isset($_GET['COMMENT'])?$_GET['COMMENT']:"";

$projectPath = "projects/".$project."/";
// CHECK USERNAME
$userFile = $projectPath."RegisteredUser";
$access = file_get_contents($userFile);
$check = $user.'|'.$password;
if($check!=$access)
    die('No Registered User');

$initializedIdFile = $projectPath."initializedId";
$initialized = file_get_contents($initializedIdFile);
if(!$initialized)
    $initialized = 1000;

$tablePath = $projectPath.$table.".seq";
$last = file_get_contents($tablePath);
$id = $initialized;
if($last)
    $id = $last+1;
else
    $id = $initialized;
$date = date('y-m-d h:i:s');
$log = "$id|$user|$date|$comment.\n";

// Save Next ID
$tableFile = fopen($tablePath, "w");
fwrite($tableFile, $id);
fclose($tableFile);

// Append Log
$logPath = $projectPath.$table.'.log';
$logFile = fopen($logPath, "a");
fwrite($logFile, $log);
fclose($logFile);

echo $id;
?>