<?php
header('Content-type: application/json');
session_start();
$response = array("SessionID" => $_SESSION['SessionID']);
echo json_encode($response);
?>