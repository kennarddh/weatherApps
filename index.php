<?php

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
    }
    else
    {
        print_r([$city, $response, $time]);
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="asset/bootstrap-5/css/bootstrap.min.css">
    <link rel="stylesheet" href="asset/css/style.css">
    <script src="asset/bootstrap-5/js/bootstrap.min.js"></script>
    <title>weather</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <div class="nav-item" id="navbarSupportedContent">
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-primary" type="submit">Search</button>
                </form>
            </div>
            <div class="nav item">
                <p>20/20/2020</p>
            </div>
            <div class="nav-item">
                <form action="" method="get">
                    <div class="form-check form-switch">
                        <label for="flexSwitchCheckDefault">C</label>
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" style="width: 100px; height: 50px;" checked>
                    </div>
                </form>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="Absolute-Center is-Responsive">
                <div class="col-sm-12 col-md-10 col-md-offset-1 icon">
                    <img class="weather-icon" src="https://assets.weatherstack.com/images/wsymbols01_png_64/wsymbol_0004_black_low_cloud.png" alt="">       
                    30&deg;

                    <p class="humidity">humidty 10%</p>
                </div>  
            </div>    
        </div>
    </div>
</body>
</html>