<?php
include "../backend.php";
extract($_POST);
$server = new Backend();

$server->deleteDocDash($delid);
?>