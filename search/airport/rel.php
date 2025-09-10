<?php
header('Content-Type: application/json');

function fetchAirports($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    // Browser-like headers
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Accept: application/json, text/javascript, */*; q=0.01",
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0 Safari/537.36",
        "Referer: $url"
    ]);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        throw new Exception("Curl error: " . curl_error($ch));
    }
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($status !== 200) {
        throw new Exception("HTTP $status from $url");
    }

    $data = json_decode($result, true);
    if (!is_array($data)) {
        throw new Exception("Invalid JSON from $url");
    }
    return $data;
}

function parseAirports($list) {
    $airports = [];
    foreach ($list as $entry) {
        if (preg_match('/^(.*) - ([A-Z0-9]{2,3})$/', $entry, $m)) {
            $city = trim($m[1]);
            $code = trim($m[2]);
            $airports[$code] = [
                'code' => $code,
                'city' => $city
            ];
        }
    }
    return $airports;
}

try {
    $relianceData = fetchAirports("https://www.reliancetravels.co.uk/home/searchCountry");
    $rrData       = fetchAirports("https://www.rrtravels.co.uk/searchCountry");

    $relianceAirports = parseAirports($relianceData);
    $rrAirports       = parseAirports($rrData);

    // Compare
    $missingInRR = [];
    foreach ($relianceAirports as $code => $airport) {
        if (!isset($rrAirports[$code])) {
            $missingInRR[] = $airport;
        }
    }

    $missingInReliance = [];
    foreach ($rrAirports as $code => $airport) {
        if (!isset($relianceAirports[$code])) {
            $missingInReliance[] = $airport;
        }
    }

    echo json_encode([
        'missingInRR'       => $missingInRR,
        'missingInReliance' => $missingInReliance,
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>