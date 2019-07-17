<?php
require 'Termek.php';

$myJSON = json_encode(termek_listazas(), JSON_NUMERIC_CHECK);

echo $myJSON;
?>