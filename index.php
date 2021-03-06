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
        $time = mktime($h,$i + $add,$s,$m,$d,$y);
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
            $search = "jakarta";
        }
        else
        {
            $search = $_GET["search"];
        }

        $search = strtolower($search);

        $apiKey = "e1bc79cd4e6b64cc8d2ba46bec983b61";
        
        $rangeTime = get_time(-10);

        $nowTime = get_time(0);

        $sql = "SELECT * FROM `weather` WHERE expire BETWEEN $rangeTime AND $nowTime AND city='$search'";

        $query = $conn->query($sql);

        if ($query->num_rows == 0)
        {
            $curl = curl_init();
            
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://api.weatherstack.com/current?access_key=' . $apiKey . '&query=' . urlencode($search),
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

            $json = curl_exec($curl);

            $response = json_decode($json, true);
            
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
                $country = $response["location"]["country"];
                $location = $response["request"]["query"];
                $image = $response["current"]["weather_icons"][0];
                $imageAlt = $response["current"]["weather_descriptions"][0];
                $humidity = $response["current"]["humidity"];
                $temperature = $response["current"]["temperature"];
                $localTime = $response["location"]["localtime"];
                $observationTime = $localTime;
                $locationLat = $response["location"]["lat"];
                $locationLon = $response["location"]["lon"];

                $expire = get_time(0);

                $city = strtolower($city);
                $country = strtolower($country);

                $sql = "INSERT INTO weather VALUES ('', '$city', '$country', '$json', '$expire')";

                $query = $conn->query($sql);
            }
        }
        else
        {
            $result = $query->fetch_object();
            $json = $result->data;
            $response = json_decode($json, true);

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
                $country = $response["location"]["country"];
                $location = $response["request"]["query"];
                $image = $response["current"]["weather_icons"][0];
                $imageAlt = $response["current"]["weather_descriptions"][0];
                $humidity = $response["current"]["humidity"];
                $temperature = $response["current"]["temperature"];
                $localTime = $response["location"]["localtime"];
                $observationTime = $localTime;
                $locationLat = $response["location"]["lat"];
                $locationLon = $response["location"]["lon"];
            }
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
    <script src="asset/js/map.js"></script>
    <script src='https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css' rel='stylesheet'>
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
    <title>Weather</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <div class="nav-item" id="navbarSupportedContent">
                <form class="d-flex">
                    <input class="form-control me-2" id="search" type="search" name="search" placeholder="Search" aria-label="Search">
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
                        <p class="location">Location : <?= $city . ", " . $country; ?></p>
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
    <?php if ($success) { ?>
        <input type="hidden" id="lat" value="<?= $locationLat; ?>">
        <input type="hidden" id="lon" value="<?= $locationLon; ?>">
    <?php } else { ?>
        <input type="hidden" id="lat" value="0">
        <input type="hidden" id="lon" value="0">
    <?php } ?>
    
    <div class="container">
        <div id="map"></div>
        <pre id="info"></pre>
        <script>
            var lat = parseInt(document.getElementById("lon").value)
            var lon = parseInt(document.getElementById("lat").value)

            console.log([lon, lat])

            mapboxgl.accessToken = 'pk.eyJ1IjoidXNlcmdrbmFtZSIsImEiOiJja204bXQyeHcxOWNxMnBxc3J5ZjJuNzRkIn0.eDRDOTM6hVQDgMdxK2UEbg';
            var map = new mapboxgl.Map({
            container: 'map', // container id
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [lat, lon], // starting position
            zoom: 9 // starting zoom
            });
            
            map.on('click', function (e) {
                document.getElementById('info').innerHTML =
                // e.point is the x, y coordinates of the mousemove event relative
                // to the top-left corner of the map
                JSON.stringify(e.point) +
                '<br />' +
                // e.lngLat is the longitude, latitude geographical position of the event
                JSON.stringify(e.lngLat.wrap());
                // console.log(JSON.stringify(e.point) + '<br />' + JSON.stringify(e.lngLat.wrap()));

                document.getElementById('search').value = e.lngLat.wrap()["lat"] + "," + e.lngLat.wrap()["lng"];
                console.log(e.lngLat.wrap()["lat"] + "," + e.lngLat.wrap()["lng"]);
            });
        </script>
    </div>
</body>
</html>