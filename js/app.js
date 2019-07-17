var d = [];

function create_item(item) {
    return '<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6"><div class=\"box\"><BUTTON class="kosarbutton" onclick="kosarhoz_ad(' + item.aru_id + ')" id=\"' + item.aru_id + '\">KOSÁRBA</BUTTON><h2>' + item.cim + '</h2><p>' + item.ar + ' <span style="display: ' + (item.kedvezmenyes ? 'inline' : 'none') + '">' + item.kedvezmenyes_ar + ' HUF</span> HUF</p>  <p>' + item.aru_id + '</p><p>' + item.szerzo + '</p></div></div>';
}

function listaz(item) {
    return '<div class="col-12 col-sm-6"><p class="kosartermek">Cím: ' + item.aru_nev + ' DB: ' + item.aru_db + '</p></div>';
}

$(document).ready(function () {
    $.get("content/termekek.php", function (data) {
        d = JSON.parse(data);
        d.forEach(function (item) {
            $(".termek").append(create_item(item));
        });
    });
});


function ar_szerint() {

    d.sort(function (a, b) {
        return a.ar < b.ar ? -1 : 1;
    });
    $(".termek").html("");
    d.forEach(function (item) {
        $(".termek").append(create_item(item));
    });
}

function cim_szerint() {
    d.sort(function (a, b) {
        return a.cim < b.cim ? -1 : 1;
    });
    $(".termek").html("");
    d.forEach(function (item) {
        $(".termek").append(create_item(item));
    });
}

function kosarhoz_ad(item) {
    $.post("content/kosar/hozzaad.php", JSON.stringify({"aru_id": item}), function (data) {
        const resp = JSON.parse(data);
        $(".osszeg").html(resp["osszeg"]);
        $(".kedvezmenyek").html(resp["kedvezmenyek"]);
        $(".vegosszeg").html(resp["kedvezmenyes_osszeg"]);
    });
}

function reset() {
    $.post("content/kosar/reset.php", function () {
        $(".osszeg").html(0);
        $(".kedvezmenyek").html(0);
        $(".vegosszeg").html(0);
    });
}

function listazas() {
    $.post("content/kosar/list.php", function (data) {
        var json = JSON.parse(data);
        $("#kosar_row").html("");
        json.forEach(function ($item) {
            $("#kosar_row").append(listaz($item));
        })


    });

}

