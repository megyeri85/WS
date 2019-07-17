<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
?>
<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<html lang="hu">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="js/app.js"></script>
    <meta charset="UTF-8">
    <title>Shop</title>
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css">
</head>
<body>

<header class="container-fluid">
    <div class="row">
        <div class="container">
            <div class="row">
                <h1 class="col-sm-4">Shop</h1>
                <div class="d-block d-sm-none">XS</div>
                <div class="d-none d-sm-block d-md-none">SM</div>
                <div class="d-none d-md-block d-lg-none">MD</div>
                <div class="d-none d-lg-block d-xl-none">LG</div>
                <div class="d-none d-xl-block">XL</div>
            </div>
        </div>
    </div>
</header>

<div class="container-fluid">
    <div class="row ">
        <div class="col-xl-10 col-lg-9 col-md-8 col-sm-6 col-6"></div>
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 ">
            <div id="kosar" class="box">
                <img src="img/kosar.jpg" style="height: 50px; width: auto; border-radius: 4px; float: left;">
                <h2>Kosár</h2>
                <p>Végösszeg: <span class="vegosszeg"></span></p>
                <p><button id="reset" onclick="reset()">Kosár ürítése</button><button id="listagomb" onclick="listazas()">Listázás</button></p>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div id="buttonrow" class=" row">
        <div class="col-sm-6" style=text-align:center;">
            <BUTTON onclick="cim_szerint()">Rendezés cím szerint</BUTTON>
        </div>
        <div class="col-sm-6" style=text-align:center;">
            <BUTTON onclick="ar_szerint()">Rendezés ár szerint</BUTTON>
        </div>
    </div>
</div>


    <div class="container-fluid">
        <div class="row termek ">

        </div>
    </div>

<div class="container-fluid">
    <div class="row" id="kosar_row">


    </div>
</div>

<div class="container-fluid">
    <div class= "kosartermek container col-sm-6"   >
        <p>Összeg kedvezmények nélkül: <span class="osszeg"></span></p>
        <p>Kedvezmények összege: <span class="kedvezmenyek"></span></p>
        <p>Végösszeg: <span class="vegosszeg"></span></p>
    </div>
</div>






</body>
</html>