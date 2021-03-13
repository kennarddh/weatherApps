<?php
    require_once("component/db.php");

    date_default_timezone_set('Asia/Jakarta');

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

    $success = false;
    
    if (!isset($_GET["search"]))
    {
        $search = "uk";

        $_GET["submit"] = true;
    }

    if (isset($_GET["submit"]))
    {
        if (!isset($_GET["search"]))
        {
            $search = "uk";
        }
        else
        {
            $search = $_GET["search"];
        }

        $apiKey = "e1bc79cd4e6b64cc8d2ba46bec983b61";
        
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://api.weatherstack.com/current?access_key=' . $apiKey . '&query=' . $search,
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

        $response = json_decode(curl_exec($curl), true);
        
        curl_close($curl);

        if (isset($response["success"]))
        {
            $success = false;

            $errorType = implode(" ", explode("_", $response["error"]["type"]));
            $errorInfo = $response["error"]["info"];
        }
        else
        {
            $success = true;

            $city = $response["location"]["name"];
            $location = $response["request"]["query"];
            $image = $response["current"]["weather_icons"][0];
            $imageAlt = $response["current"]["weather_descriptions"][0];
            $humidity = $response["current"]["humidity"];
            $temperature = $response["current"]["temperature"];
            $observationTime = $response["current"]["observation_time"];
            $localTime = $response["location"]["localtime"];
        }
        
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
    <script>
        var localTimeGet, localTime;
        var t, d;

        window.onload = (function(){start()});

        function start()
        {
            localTimeGet = document.getElementById("localTime");
            localTime = localTimeGet.innerHTML + ":00";

            t = localTime.split(/[- :]/);
            
            t.shift();
            t.shift();
            t.shift();
            t.shift();

            d = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
            
            changeLocalTime();
        }

        function changeLocalTime()
        {
            d.setSeconds(d.getSeconds() + 1);

            localTimeGet.innerHTML = "Local Time : " + d.getFullYear() + "-" + d.getMonth() + "-" + d.getDate() + " " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();

            setTimeout(changeLocalTime, 1000);
        }

        function changeTemperatureFormat()
        {
            var switches = document.getElementById("TemperatureCheck");

            var temperature = document.getElementById("temperature");
            
            var celcius, farentheith;

            if (switches.checked == true)
            {
                farentheith = temperature.innerHTML;

                farentheith = farentheith.slice(2, -1);
                
                celcius = (farentheith - 32) * 5/9;

                celcius = celcius.toFixed(2);

                temperature.innerHTML = "C " + celcius + "&deg;";
            }
            else
            {
                celcius = temperature.innerHTML;

                celcius = celcius.slice(2, -1);

                farentheith = (celcius * 9/5) + 32;

                farentheith = farentheith.toFixed(2);

                temperature.innerHTML = "F " + farentheith + "&deg;";
            }
        }
    </script>
    <title>weather</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <div class="nav-item" id="navbarSupportedContent">
                <form class="d-flex">
                    <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-primary" name="submit" type="submit">Search</button>
                </form>
            </div>
            <?php if ($success) { ?>
                <div class="nav item">
                    <p id="localTime">Local Time : <?= $localTime; ?></p>
                </div>
                <div class="nav item">
                    <p>Observation Time : <?= $observationTime; ?></p>
                </div>
                <div class="nav-item">
                    <form action="" method="get">
                        <div class="form-check form-switch">
                            <label for="TemperatureCheck">C</label>
                            <input class="form-check-input" onclick="changeTemperatureFormat()" type="checkbox" id="TemperatureCheck" style="width: 100px; height: 50px;" checked>
                        </div>
                    </form>
                </div>
            <?php } ?>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="Absolute-Center is-Responsive">
                <div class="col-sm-12 col-md-10 col-md-offset-1 icon">
                    <?php if ($success) { ?>
                        <p class="location">Location : <?= $location; ?></p>
                        <img class="weather-icon" src="<?= $image; ?>" alt="<?= $imageAlt; ?>">       
                        <div id="temperature">C <?= $temperature; ?>.00&deg;</div>

                        <p class="humidity">humidity <?= $humidity; ?>%</p>
                    <?php } else { ?>
                        <h2><?= $errorType; ?></h2>
                        <h2><br></h2>
                        <h2><?= $errorInfo; ?></h2>
                    <?php } ?>
                </div>  
            </div>    
        </div>
    </div>
</body>
</html>