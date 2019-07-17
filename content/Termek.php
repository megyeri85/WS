<?php
require 'db_csatlakozas.php';

/**
 * @param array $row
 * @param mysqli $con
 * @param $ar
 * @param $ujara
 */
function kedvezmeny_szamolas(array $row, mysqli $con, $ar)
{
    $sql3 = "Select * from termek_kedvezmeny where aru_id=" . $row['aru_id'] . ";";
    $kedvezmenyek = mysqli_query($con, $sql3) or die("Error: " . mysqli_error($con));
    $ujara = [$ar];
    while ($kedvezmeny = mysqli_fetch_array($kedvezmenyek, MYSQLI_ASSOC)) {
        if ($kedvezmeny['kedv_tip_id'] == 1) {
            array_push($ujara, $ar * (100 - $kedvezmeny['kedvezmeny_menny']) / 100);
        } else if ($kedvezmeny['kedv_tip_id'] == 2) {
            array_push($ujara, $ar - $kedvezmeny['kedvezmeny_menny']);
        }
    }
    return min($ujara);
}


/**
 * @param array $aru_idk
 * @return array
 */
function termek_listazas(array $aru_idk = [])
{
    $con = db_csatlakozas();
    if (empty($aru_idk)) {
        $sql = "SELECT * FROM `aru` INNER JOIN kiado on aru.kiado_id=kiado.kiado_id WHERE 1;";
    } else {
        $sql = "SELECT * FROM `aru` INNER JOIN kiado on aru.kiado_id=kiado.kiado_id WHERE aru_id in (" . implode(",", $aru_idk) . ");";
    }
    $result = mysqli_query($con, $sql) or die("Error: " . mysqli_error($con));


    $a = array();


    while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
        $ar = $row["ar"];

        $sql2 = 'Select szerzo_nev from (szerzok inner join konyv_szerzoi on szerzok.szerzo_id=konyv_szerzoi.szerzo_id)inner join aru on konyv_szerzoi.aru_id=aru.aru_id WHERE aru.aru_id=' . $row["aru_id"] . ';';
        $result2 = mysqli_query($con, $sql2) or die("Error: " . mysqli_error($con));
        $szerzok = "";
        while ($row2 = mysqli_fetch_array($result2, MYSQLI_BOTH)) {
            $szerzok .= $row2["szerzo_nev"] . " ";
        }

        $kedvezmenyes_ar = kedvezmeny_szamolas($row, $con, $ar);
        array_push($a, (array("aru_id" => $row["aru_id"], "cim" => $row["cim"], "szerzo" => $szerzok, "kiado_id" => $row['kiado_id'], "ar" => $ar, "kedvezmenyes_ar" => $kedvezmenyes_ar, 'kedvezmenyes' => $ar != $kedvezmenyes_ar)));
    }
    return $a;
}

