<?php

function db_csatlakozas()
{
    $con = mysqli_connect("localhost:3306", "root", "");
    $con->set_charset("utf8");
    if (!$con) {
        die('Nem sikerult kapcsolatot kiepiteni: ' . mysqli_error());
    }
    mysqli_select_db($con, "shop");

    return $con;
}