<?php
public function kosar_szamit()
{
    $tartalom = array_map(function ($item) {
        return str_replace("#", "", $item);
    }, array_keys($_SESSION));
    $termekek = termek_listazas($tartalom);

    foreach ($termekek as &$termek) {
        $termek ['db'] = $_SESSION['#' . $termek['aru_id']];
    }
    $osszeg = 0;
    $kedv_osszeg = 0;
    foreach ($termekek as $row) {
        $osszeg += $row['ar'] * $row['db'];
        $kedv_osszeg += $row['kedvezmenyes_ar'] * $row['db'];
    }


    $mennyisegi_kedvezmenyek = $this->ossz_menny_kedv();
    foreach ($mennyisegi_kedvezmenyek as $row) {
        $kiado_konyvei = [];
        foreach ($termekek as $termek) {
            if ($termek['kiado_id'] == $row['kiado_id']) {
                array_push($kiado_konyvei, $termek);
            }
        }

        $array_sum = array_map(function ($item) {
            return $item['db'];
        }, $kiado_konyvei);
        var_dump($array_sum);


        if ($array_sum > 2) {
            $kedv_darab = intdiv($array_sum, 3);
            usort($kiado_konyvei, function ($a, $b) {
                if ($a == $b)
                    return 0;
                return $a['ar'] < $b['ar'] ? -1 : 1;
            });

            foreach ($kiado_konyvei as $konyv) {
                if ($kedv_darab <= $konyv['db']) {
                    $kedv_osszeg -= $kedv_darab * $konyv['ar'];
                    break;
                } else {
                }
            }
        }
    }
    return ['osszeg' => $osszeg, 'kedvezmenyek' => $osszeg - $kedv_osszeg, 'kedvezmenyes_osszeg' => $kedv_osszeg];
}