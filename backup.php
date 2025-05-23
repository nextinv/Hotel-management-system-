<?php
// backup.php

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'hotel_db'; // replace with your DB name

$filename = "backup_" . date("Y-m-d_H-i-s") . ".sql";

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$filename");

$command = "mysqldump --user=$user --password=$pass --host=$host $dbname";
passthru($command);
exit;
