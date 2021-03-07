<?php

use function PHPSTORM_META\type;

require_once("component/db.php");

    date_default_timezone_set('Asia/Jakarta');

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://api.weatherstack.com/current?access_key=8d31a59241d10e47a054c39562bf0329&query=Zimbabwe',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Cookie: __cfduid=df3376d14ce595c39624634958ad203b21615087088'
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;

    echo "<br><br>";

    function get_time($add) {
        $m = date('m');
        $d = date('d');
        $y = date('Y');
        $h = date('H');
        $i = date('i');
        $s = date('s');
        $time = mktime($h + $add,$i,$s,$m,$d,$y);
        return $time;
    }
    $time = get_time(6);
    $city = explode(",", json_decode($response, true)["request"]["query"])[0];
    $sql = "INSERT INTO weather VALUES ('', '$city', '$response', '$time')";
    $query = $conn->query($sql);
    if ($query)
    {
        echo "<br>Berhasil";
    }
    else
    {
        echo "<br>Gagal";
        print_r([$city, type($response), $time]);
    }

?>