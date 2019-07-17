<?php
require '../Kosar.php';

session_start();
$payload = json_decode(file_get_contents('php://input'), true);
$aru_id ="#".$payload['aru_id'];
$kosar = new Kosar();
$kosar->add_item($aru_id);
echo json_encode( $kosar->kosar_szamit(), JSON_NUMERIC_CHECK);