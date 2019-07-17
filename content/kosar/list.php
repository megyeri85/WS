<?php

require '../Kosar.php';
session_start();

$con = mysqli_connect("localhost:3306", "root", "");
$con->set_charset("utf8");
if (!$con) {
    die('Nem sikerult kapcsolatot kiepiteni: ' . mysqli_error());
}
mysqli_select_db($con, "shop");





$a=array();
foreach ($_SESSION as $k => $v){

    $aru_id=str_replace("#","",$k);
    $sql = "SELECT * FROM `aru` INNER JOIN kiado on aru.kiado_id=kiado.kiado_id WHERE aru_id=".$aru_id.";";
    $result = mysqli_query($con, $sql) or die("Error: " . mysqli_error($con));
    $row=mysqli_fetch_array($result,MYSQLI_BOTH);

    array_push($a, array("aru_id" => $aru_id,"aru_nev"=>$row['cim'] ,"aru_db"=> $v, "aru_ar"=>$row['ar']));

}
$myJSON = json_encode($a,JSON_NUMERIC_CHECK );
echo  $myJSON;

