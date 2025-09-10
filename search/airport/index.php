<?php
// 
function getRemoteData($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    // Fake browser headers
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Accept: application/json, text/javascript, */*; q=0.01",
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0 Safari/537.36",
        "Referer: https://www.reliancetravels.co.uk/",
    ]);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        throw new Exception(curl_error($ch));
    }
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($statusCode !== 200) {
        throw new Exception("HTTP request failed with status $statusCode");
    }

    return $result;
}

// Usage
include_once '../airports_data.php';
include_once __DIR__ . '/missing_airports.php';


$AIRPORTS = array_merge( $AIRPORTSORIGINAL, $MISSING_AIRPORTS);

// $AIRPORTS = array_merge( $AIRPORTS, $missed);

$airportMap = [];
foreach ($AIRPORTS as $a) {
    $airportMap[$a['code']] = $a;
}

// Load IATA-ICAO CSV data
function loadIataCsv($filePath) {
    $csvData = [];
    if (($handle = fopen($filePath, "r")) !== FALSE) {
        $header = fgetcsv($handle); // Skip header
        while (($data = fgetcsv($handle)) !== FALSE) {
            if (count($data) >= 7) {
                $csvData[$data[2]] = [ // IATA code as key
                    'country_code' => $data[0],
                    'region_name' => $data[1],
                    'iata' => $data[2],
                    'icao' => $data[3],
                    'airport' => $data[4],
                    'latitude' => floatval($data[5]),
                    'longitude' => floatval($data[6])
                ];
            }
        }
        fclose($handle);
    }
    return $csvData;
}

// Database connection function
function getDbConnection() {
    $config = [
        'hostname' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'travel_db',
        'dbdriver' => 'mysqli',
        'char_set' => 'utf8',
        'dbcollat' => 'utf8_general_ci'
    ];
    
    $mysqli = new mysqli($config['hostname'], $config['username'], $config['password'], $config['database']);
    
    if ($mysqli->connect_error) {
        throw new Exception('Database connection failed: ' . $mysqli->connect_error);
    }
    
    $mysqli->set_charset($config['char_set']);
    return $mysqli;
}

// Load countries mapping from database
function getCoord($ode) {
    $url = "http://iatageo.com/getLatLng/".$ode;    
    $json = getRemoteData($url);
    $data = json_decode($json, true);
    return $data;
}
function getCountryName($ode) {
    $countryName = 'Unknown';
    try {
        $mysqli = getDbConnection();
        $stmt = $mysqli->prepare("SELECT DISTINCT airport_country FROM airports WHERE airport_code = ? LIMIT 1");
        $stmt->bind_param("s", $ode);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $countryName = $row['airport_country'];
            $stmt->close();
            $mysqli->close();
            return $countryName;
        }
        
        $stmt->close();
        $mysqli->close();
        return $countryName;
        
    } catch (Exception $e) {
        // If database fails, return the country code
        return $countryName;
    }
}

// Load IATA CSV data
$iataData = loadIataCsv('iata-icao.csv');

// Fetch remote data
// $url = "https://www.reliancetravels.co.uk/home/searchCountry";
try {
    // $url = "https://www.reliancetravels.co.uk/home/searchCountry";
    $url = "http://localhost/travel/flights/searchCountry";
    
    $json = getRemoteData($url);
    $data = json_decode($json, true);
    
    if (!$data) {
        throw new Exception("Failed to decode JSON data");
    }


// $json = file_get_contents($url);
// $data = json_decode($json, true);

// Arrays to hold results
$alreadyHave = [];
$dontHave = [];
$ff = [];

foreach ($data as $entry) {
    // "City - CODE"
    if (preg_match('/^(.*) - ([A-Z0-9]{2,3})$/', $entry, $m)) {
        $city = trim($m[1]);
        $code = trim($m[2]);

        if (isset($airportMap[$code])) {
            // We already have it, push the full existing data
            $alreadyHave[] = $airportMap[$code];
        } else {
            // We don't have it, try to get real data from CSV
            // if (isset($iataData[$code])) {
            //     $csvData = $iataData[$code];
                $countryName = getCountryName($code);
                $coord = getCoord($code);
                if(isset($coord["error"])){
                    $coord = [
                        'lat' => 0.0,
                        'lon' => 0.0,
                    ];
                }else{
                    $coord = [
                        'lat' => $coord["latitude"],
                        'lon' => $coord["longitude"],
                    ];
                }
                if($coord["lat"] == 0.0 && $coord["lon"] == 0.0){
                    $ff[] = [
                        'code'    => $code,
                        'city'    => $city,
                        'country' => $countryName,
                        'lat'     => $coord["lat"],
                        'lon'     => $coord["lon"],
                    ];
                }else{
                    $dontHave[] = [
                        'code'    => $code,
                        'city'    => $city,
                        'country' => $countryName,
                        'lat'     => $coord["lat"],
                        'lon'     => $coord["lon"],
                    ];
                }
            // } else {
            //     // Still not found in CSV, use dummy data
            //     $dontHave[] = [
            //         'code'    => $code,
            //         'city'    => $city,
            //         'country' => 'Unknown',
            //         'lat'     => 0.0,
            //         'lon'     => 0.0,
            //     ];
            // }
        }
    }
}

// Debug print
// header('Content-Type: application/json');

// Prepare response
$response = 
[
    "Array"=>count($AIRPORTS),
    "RRLive"=>count($data),
    'alreadyHave' => count($alreadyHave),
    'dontHaveCount'    => count($dontHave),
    'dontHave'    => $dontHave,
    'ff'    => $ff
];

// Pretty print JSON
echo "<pre>";
echo var_export($response, true);
echo "</pre>";
// echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>