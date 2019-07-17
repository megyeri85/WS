<?php
require 'Termek.php';


/**
 * Class Kosar
 */
class Kosar
{
    /**
     * @param $item
     */
    public function add_item($item)
    {
        if (!key_exists($item, $_SESSION)) {
            $_SESSION[$item] = 0;

        }
        $_SESSION[$item]++;


    }


    /**
     * @return float|int
     */
    public function aru_db()
    {
        return array_sum($_SESSION);

    }

    /**
     *
     */
    public function kosar_urites()
    {
        $_SESSION = [];
    }

    /**
     * @return array
     */
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

            foreach ($termekek as $t) {
                if ($t['kiado_id'] == $row['kiado_id']) {
                    array_push($kiado_konyvei, $t);
                }
            }

            $array_sum = array_sum(array_map(function ($item) {
                return $item['db'];
            }, $kiado_konyvei));


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
                        $kedv_osszeg -=  $konyv['db'] * $konyv['ar'];
                        $kedv_darab -=  $konyv['db'];
                    }
                }
            }
        }
        return ['osszeg' => $osszeg, 'kedvezmenyek' => $osszeg - $kedv_osszeg, 'kedvezmenyes_osszeg' => $kedv_osszeg];
    }

    /**
     * @return array
     */
    public function ossz_menny_kedv()
    {
        $con = db_csatlakozas();

        $sql = "SELECT * FROM `termek_kedvezmeny` WHERE kedv_tip_id=3;";
        $result = mysqli_query($con, $sql, MYSQLI_ASSOC);
        $ret = [];
        while ($row2 = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            array_push($ret, $row2);
        }
        return $ret;


    }
}


