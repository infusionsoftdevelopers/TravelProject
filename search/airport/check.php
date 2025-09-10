<?php
include_once '../airports_data.php';
include_once __DIR__ . '/missing_airports.php';
$codesAirports = array_column($AIRPORTSORIGINAL, null, 'code');
$codesMissing  = array_column($MISSING_AIRPORTS, null, 'code');

// Find common codes
$commonCodes = array_intersect(array_keys($codesAirports), array_keys($codesMissing));

// Collect matching airports from both arrays
$matches = [];
foreach ($commonCodes as $code) {
    $matches[] = [
        'fromAirports' => $codesAirports[$code],
        'fromMissing'  => $codesMissing[$code],
    ];
}

// Output JSON
echo json_encode(['matches' => $matches], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>