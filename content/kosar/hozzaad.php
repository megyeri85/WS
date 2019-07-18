<?php
require '../Kosar.php';

session_start();
$adat = json_decode(file_get_contents('php://input'), true);
$aru_id ="#".$adat['aru_id'];
$kosar = new Kosar();
$kosar->add_aru($aru_id);
echo json_encode( $kosar->kosar_szamit(), JSON_NUMERIC_CHECK);