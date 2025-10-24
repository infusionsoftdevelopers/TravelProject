<title>Flight Search</title>
<?php
// dynamic flight search and booking mock application
ini_set('display_errors', 1);
error_reporting(E_ALL);


include_once __DIR__ . '/airports_data.php';

include_once __DIR__ . '../../../wp-blog-header.php';
require_once __DIR__ . '../../../wp-load.php';



get_header();


$AIRPORTS = $AIRPORTSORIGINAL;

// Airlines with quality factors (affects price) and hubs for connecting flights.
// Airlines with quality factors (affects price), hubs for connecting flights and
// broad region coverage. Each airline's "regions" list enumerates the
// continents or areas where the carrier operates a significant scheduled
// passenger network. This allows generateFlightResults() to filter out
// airlines that do not realistically serve the requested origin/destination.
// Coverage data is derived from publicly available route maps and network
// summaries for 2025 (e.g. Turkish Airlines serves Europe, Asia, Africa,
// the Americas and Oceania【867817718742440†L133-L144】; Emirates operates to 133
// destinations across six continents【831762841005088†L124-L132】; Delta Air Lines
// flies to over 50 countries on six continents【603331910806239†L304-L307】; Qantas
// operates international flights across Africa, North America, South America,
// Asia, Europe and Oceania【618647756162369†L123-L129】).
$AIRLINES = [
    [
        'name'    => 'Emirates',
        'code'    => 'EK',
        'quality' => 1.35,
        'hubs'    => ['DXB'],
        'regions' => ['Middle East','Asia','Europe','Africa','Americas','Oceania']
    ],
    [
        'name'    => 'Qatar Airways',
        'code'    => 'QR',
        'quality' => 1.30,
        'hubs'    => ['DOH'],
        'regions' => ['Middle East','Asia','Europe','Africa','Americas','Oceania']
    ],
    [
        'name'    => 'Etihad Airways',
        'code'    => 'EY',
        'quality' => 1.25,
        'hubs'    => ['AUH'],
        'regions' => ['Middle East','Asia','Europe','Africa','Americas','Oceania']
    ],
    [
        'name'    => 'Turkish Airlines',
        'code'    => 'TK',
        'quality' => 1.10,
        'hubs'    => ['IST'],
        'regions' => ['Europe','Asia','Africa','Americas','Oceania','Middle East']
    ],
    [
        'name'    => 'Saudi Arabian Airlines',
        'code'    => 'SV',
        'quality' => 1.05,
        'hubs'    => ['JED','RUH'],
        'regions' => ['Middle East','Asia','Europe','Africa','North America']
    ],
    [
        'name'    => 'Malaysia Airlines',
        'code'    => 'MH',
        'quality' => 1.00,
        'hubs'    => ['KUL'],
        'regions' => ['Asia','Oceania','Europe']
    ],
    [
        'name'    => 'British Airways',
        'code'    => 'BA',
        'quality' => 1.20,
        'hubs'    => ['LHR','LGW'],
        'regions' => ['Europe','Africa','Asia','Americas','Oceania','Middle East']
    ],
    [
        'name'    => 'Air France',
        'code'    => 'AF',
        'quality' => 1.18,
        'hubs'    => ['CDG','ORY'],
        'regions' => ['Europe','Africa','Asia','Americas','Middle East']
    ],
    [
        'name'    => 'KLM',
        'code'    => 'KL',
        'quality' => 1.15,
        'hubs'    => ['AMS'],
        'regions' => ['Europe','Africa','Asia','Americas','Middle East']
    ],
    [
        'name'    => 'Delta Air Lines',
        'code'    => 'DL',
        'quality' => 1.10,
        'hubs'    => ['ATL','DTW','MSP','SLC','LAX','JFK','SEA','BOS'],
        'regions' => ['North America','South America','Europe','Asia','Africa']
    ],
    [
        'name'    => 'American Airlines',
        'code'    => 'AA',
        'quality' => 1.10,
        'hubs'    => ['DFW','MIA','CLT','PHL','PHX','ORD','LAX','JFK'],
        'regions' => ['North America','South America','Europe','Asia']
    ],
    [
        'name'    => 'United Airlines',
        'code'    => 'UA',
        'quality' => 1.10,
        'hubs'    => ['ORD','IAH','DEN','EWR','SFO','LAX','IAD','GUM'],
        'regions' => ['North America','South America','Europe','Asia','Oceania']
    ],
    [
        'name'    => 'Air Canada',
        'code'    => 'AC',
        'quality' => 1.05,
        'hubs'    => ['YYZ','YVR','YUL'],
        'regions' => ['North America','Europe','Asia','South America']
    ],
    [
        'name'    => 'Singapore Airlines',
        'code'    => 'SQ',
        'quality' => 1.30,
        'hubs'    => ['SIN'],
        'regions' => ['Asia','Europe','North America','Oceania','Africa']
    ],
    [
        'name'    => 'Qantas',
        'code'    => 'QF',
        'quality' => 1.25,
        'hubs'    => ['SYD','MEL','BNE','PER'],
        'regions' => ['Oceania','Asia','Europe','Americas','Africa']
    ],
    [
        'name'    => 'Ethiopian Airlines',
        'code'    => 'ET',
        'quality' => 1.05,
        'hubs'    => ['ADD'],
        'regions' => ['Africa','Europe','Asia','Americas','Middle East']
    ],
    [
        'name'    => 'Kenya Airways',
        'code'    => 'KQ',
        'quality' => 1.00,
        'hubs'    => ['NBO'],
        'regions' => ['Africa','Europe','Asia','Middle East']
    ],
    [
        'name'    => 'Egyptair',
        'code'    => 'MS',
        'quality' => 1.00,
        'hubs'    => ['CAI'],
        'regions' => ['Africa','Middle East','Europe','North America','Asia']
    ],
    [
        'name'    => 'LATAM Airlines',
        'code'    => 'LA',
        'quality' => 1.00,
        'hubs'    => ['SCL','GRU','LIM'],
        'regions' => ['South America','North America','Europe','Oceania']
    ]
];

// Multipliers for different cabin classes.
$CLASSES = [
    // Updated cabin multipliers: higher premiums for upper classes
    'economy'         => 1.00,
    'premium economy'         => 1.60,
    'business class'        => 2.75,
    'first class'           => 4.20,
];

// Price ranges for each month (adult one-way before multipliers).
$MONTH_PRICE_BANDS = [
    1  => [550, 750],  // JAN
    2  => [430, 612],  // FEB
    3  => [420, 560],  // MAR
    4  => [580, 712],  // APR
    5  => [420, 580],  // MAY
    6  => [430, 590],  // JUN
    7  => [580, 700],  // JUL
    8  => [580, 700],  // AUG
    9  => [460, 620],  // SEP
    10 => [430, 580],  // OCT
    11 => [430, 640],  // NOV
    12 => [590, 850],  // DEC
];

// List of all ISO‑3166-1 alpha‑3 country codes and names for datalist suggestions.
// These entries allow the user to quickly find their country and then choose an airport.
$COUNTRIES = [
    ['code' => 'AFG','name' => 'Afghanistan'],['code' => 'ALB','name' => 'Albania'],['code' => 'DZA','name' => 'Algeria'],['code' => 'AND','name' => 'Andorra'],['code' => 'AGO','name' => 'Angola'],['code' => 'ATG','name' => 'Antigua and Barbuda'],['code' => 'ARG','name' => 'Argentina'],['code' => 'ARM','name' => 'Armenia'],['code' => 'AUS','name' => 'Australia'],['code' => 'AUT','name' => 'Austria'],['code' => 'AZE','name' => 'Azerbaijan'],
    ['code' => 'BHS','name' => 'Bahamas'],['code' => 'BHR','name' => 'Bahrain'],['code' => 'BGD','name' => 'Bangladesh'],['code' => 'BRB','name' => 'Barbados'],['code' => 'BLR','name' => 'Belarus'],['code' => 'BEL','name' => 'Belgium'],['code' => 'BLZ','name' => 'Belize'],['code' => 'BEN','name' => 'Benin'],['code' => 'BTN','name' => 'Bhutan'],['code' => 'BOL','name' => 'Bolivia'],['code' => 'BIH','name' => 'Bosnia and Herzegovina'],['code' => 'BWA','name' => 'Botswana'],['code' => 'BRA','name' => 'Brazil'],['code' => 'BRN','name' => 'Brunei'],['code' => 'BGR','name' => 'Bulgaria'],['code' => 'BFA','name' => 'Burkina Faso'],['code' => 'BDI','name' => 'Burundi'],['code' => 'CPV','name' => 'Cabo Verde'],['code' => 'KHM','name' => 'Cambodia'],['code' => 'CMR','name' => 'Cameroon'],['code' => 'CAN','name' => 'Canada'],['code' => 'CAF','name' => 'Central African Republic'],['code' => 'TCD','name' => 'Chad'],['code' => 'CHL','name' => 'Chile'],['code' => 'CHN','name' => 'China'],['code' => 'COL','name' => 'Colombia'],['code' => 'COM','name' => 'Comoros'],['code' => 'COG','name' => 'Congo'],['code' => 'COD','name' => 'Congo (DRC)'],['code' => 'CRI','name' => 'Costa Rica'],['code' => 'CIV','name' => 'Côte d’Ivoire'],['code' => 'HRV','name' => 'Croatia'],['code' => 'CUB','name' => 'Cuba'],['code' => 'CYP','name' => 'Cyprus'],['code' => 'CZE','name' => 'Czechia'],['code' => 'DNK','name' => 'Denmark'],['code' => 'DJI','name' => 'Djibouti'],['code' => 'DMA','name' => 'Dominica'],['code' => 'DOM','name' => 'Dominican Republic'],['code' => 'ECU','name' => 'Ecuador'],['code' => 'EGY','name' => 'Egypt'],['code' => 'SLV','name' => 'El Salvador'],['code' => 'GNQ','name' => 'Equatorial Guinea'],['code' => 'ERI','name' => 'Eritrea'],['code' => 'EST','name' => 'Estonia'],['code' => 'SWZ','name' => 'Eswatini'],['code' => 'ETH','name' => 'Ethiopia'],['code' => 'FJI','name' => 'Fiji'],['code' => 'FIN','name' => 'Finland'],['code' => 'FRA','name' => 'France'],['code' => 'GAB','name' => 'Gabon'],['code' => 'GMB','name' => 'Gambia'],['code' => 'GEO','name' => 'Georgia'],['code' => 'DEU','name' => 'Germany'],['code' => 'GHA','name' => 'Ghana'],['code' => 'GRC','name' => 'Greece'],['code' => 'GRD','name' => 'Grenada'],['code' => 'GTM','name' => 'Guatemala'],['code' => 'GIN','name' => 'Guinea'],['code' => 'GNB','name' => 'Guinea‑Bissau'],['code' => 'GUY','name' => 'Guyana'],['code' => 'HTI','name' => 'Haiti'],['code' => 'HND','name' => 'Honduras'],['code' => 'HUN','name' => 'Hungary'],['code' => 'ISL','name' => 'Iceland'],['code' => 'IND','name' => 'India'],['code' => 'IDN','name' => 'Indonesia'],['code' => 'IRN','name' => 'Iran'],['code' => 'IRQ','name' => 'Iraq'],['code' => 'IRL','name' => 'Ireland'],['code' => 'ISR','name' => 'Israel'],['code' => 'ITA','name' => 'Italy'],['code' => 'JAM','name' => 'Jamaica'],['code' => 'JPN','name' => 'Japan'],['code' => 'JOR','name' => 'Jordan'],['code' => 'KAZ','name' => 'Kazakhstan'],['code' => 'KEN','name' => 'Kenya'],['code' => 'KIR','name' => 'Kiribati'],['code' => 'PRK','name' => 'Korea (North)'],['code' => 'KOR','name' => 'Korea (South)'],['code' => 'KWT','name' => 'Kuwait'],['code' => 'KGZ','name' => 'Kyrgyzstan'],['code' => 'LAO','name' => 'Laos'],['code' => 'LVA','name' => 'Latvia'],['code' => 'LBN','name' => 'Lebanon'],['code' => 'LSO','name' => 'Lesotho'],['code' => 'LBR','name' => 'Liberia'],['code' => 'LBY','name' => 'Libya'],['code' => 'LIE','name' => 'Liechtenstein'],['code' => 'LTU','name' => 'Lithuania'],['code' => 'LUX','name' => 'Luxembourg'],['code' => 'MDG','name' => 'Madagascar'],['code' => 'MWI','name' => 'Malawi'],['code' => 'MYS','name' => 'Malaysia'],['code' => 'MDV','name' => 'Maldives'],['code' => 'MLI','name' => 'Mali'],['code' => 'MLT','name' => 'Malta'],['code' => 'MHL','name' => 'Marshall Islands'],['code' => 'MRT','name' => 'Mauritania'],['code' => 'MUS','name' => 'Mauritius'],['code' => 'MEX','name' => 'Mexico'],['code' => 'FSM','name' => 'Micronesia'],['code' => 'MDA','name' => 'Moldova'],['code' => 'MCO','name' => 'Monaco'],['code' => 'MNG','name' => 'Mongolia'],['code' => 'MNE','name' => 'Montenegro'],['code' => 'MAR','name' => 'Morocco'],['code' => 'MOZ','name' => 'Mozambique'],['code' => 'MMR','name' => 'Myanmar'],['code' => 'NAM','name' => 'Namibia'],['code' => 'NRU','name' => 'Nauru'],['code' => 'NPL','name' => 'Nepal'],['code' => 'NLD','name' => 'Netherlands'],['code' => 'NZL','name' => 'New Zealand'],['code' => 'NIC','name' => 'Nicaragua'],['code' => 'NER','name' => 'Niger'],['code' => 'NGA','name' => 'Nigeria'],['code' => 'MKD','name' => 'North Macedonia'],['code' => 'NOR','name' => 'Norway'],['code' => 'OMN','name' => 'Oman'],['code' => 'PAK','name' => 'Pakistan'],['code' => 'PLW','name' => 'Palau'],['code' => 'PAN','name' => 'Panama'],['code' => 'PNG','name' => 'Papua New Guinea'],['code' => 'PRY','name' => 'Paraguay'],['code' => 'PER','name' => 'Peru'],['code' => 'PHL','name' => 'Philippines'],['code' => 'POL','name' => 'Poland'],['code' => 'PRT','name' => 'Portugal'],['code' => 'QAT','name' => 'Qatar'],['code' => 'ROU','name' => 'Romania'],['code' => 'RUS','name' => 'Russia'],['code' => 'RWA','name' => 'Rwanda'],['code' => 'KNA','name' => 'Saint Kitts and Nevis'],['code' => 'LCA','name' => 'Saint Lucia'],['code' => 'VCT','name' => 'Saint Vincent and the Grenadines'],['code' => 'WSM','name' => 'Samoa'],['code' => 'SMR','name' => 'San Marino'],['code' => 'STP','name' => 'Sao Tome and Principe'],['code' => 'SAU','name' => 'Saudi Arabia'],['code' => 'SEN','name' => 'Senegal'],['code' => 'SRB','name' => 'Serbia'],['code' => 'SYC','name' => 'Seychelles'],['code' => 'SLE','name' => 'Sierra Leone'],['code' => 'SGP','name' => 'Singapore'],['code' => 'SVK','name' => 'Slovakia'],['code' => 'SVN','name' => 'Slovenia'],['code' => 'SLB','name' => 'Solomon Islands'],['code' => 'SOM','name' => 'Somalia'],['code' => 'ZAF','name' => 'South Africa'],['code' => 'SSD','name' => 'South Sudan'],['code' => 'ESP','name' => 'Spain'],['code' => 'LKA','name' => 'Sri Lanka'],['code' => 'SDN','name' => 'Sudan'],['code' => 'SUR','name' => 'Suriname'],['code' => 'SWE','name' => 'Sweden'],['code' => 'CHE','name' => 'Switzerland'],['code' => 'SYR','name' => 'Syria'],['code' => 'TJK','name' => 'Tajikistan'],['code' => 'TZA','name' => 'Tanzania'],['code' => 'THA','name' => 'Thailand'],['code' => 'TLS','name' => 'Timor‑Leste'],['code' => 'TGO','name' => 'Togo'],['code' => 'TON','name' => 'Tonga'],['code' => 'TTO','name' => 'Trinidad and Tobago'],['code' => 'TUN','name' => 'Tunisia'],['code' => 'TUR','name' => 'Türkiye'],['code' => 'TKM','name' => 'Turkmenistan'],['code' => 'TUV','name' => 'Tuvalu'],['code' => 'UGA','name' => 'Uganda'],['code' => 'UKR','name' => 'Ukraine'],['code' => 'ARE','name' => 'United Arab Emirates'],['code' => 'GBR','name' => 'United Kingdom'],['code' => 'USA','name' => 'United States'],['code' => 'URY','name' => 'Uruguay'],['code' => 'UZB','name' => 'Uzbekistan'],['code' => 'VUT','name' => 'Vanuatu'],['code' => 'VAT','name' => 'Vatican City'],['code' => 'VEN','name' => 'Venezuela'],['code' => 'VNM','name' => 'Vietnam'],['code' => 'YEM','name' => 'Yemen'],['code' => 'ZMB','name' => 'Zambia'],['code' => 'ZWE','name' => 'Zimbabwe'],
];

// Helper: clamp value between min and max.
function clamp($val, $min, $max) {
    return max($min, min($max, $val));
}

// Helper: returns random float between 0 and 1.
function randf() {
    return mt_rand() / mt_getrandmax();
}

// Haversine formula to compute great-circle distance between two lat/lon points (km).
function haversine($lat1, $lon1, $lat2, $lon2) {
    $R = 6371; // Earth radius in km
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    $a = sin($dLat / 2) * sin($dLat / 2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    return $R * $c;
}

// Format seconds into human-friendly "Xh Ym".
function formatDuration($seconds) {
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    return sprintf('%dh %02dm', $hours, $minutes);
}

// Determine a broad region/continent for a given country.  This helper
// categorizes countries into coarse areas to support realistic airline
// filtering.  If a country is not explicitly mapped it defaults to 'Asia'.
function getRegionByCountry(string $country): string {
    // Normalise case for matching
    $c = strtolower($country);
    $africa = [
        'egypt','kenya','ethiopia','south africa','nigeria','algeria','morocco','tunisia',
        'tanzania','ghana','senegal','cameroon','uganda','zambia','zimbabwe','mauritius','seychelles',
        'botswana','namibia','sudan','libya','somalia','angola','ivory coast','côte d’ivoire',
        'democratic republic of the congo','congo (drc)','congo','mozambique','rwanda','burkina faso',
        'niger','mali','chad','benin','togo','sierra leone','liberia','djibouti','eritrea','madagascar','mauritania','guinea','guinea-bissau','gabon','lesotho','swaziland','eswatini','south sudan'
    ];
    $northAmerica = ['united states','usa','canada','mexico','bahamas','barbados','jamaica','cuba','panama','costa rica','puerto rico','trinidad and tobago'];
    $southAmerica = ['brazil','argentina','chile','peru','colombia','venezuela','uruguay','paraguay','bolivia','ecuador','guyana','suriname'];
    $europe = [
        'united kingdom','uk','england','scotland','wales','northern ireland','ireland','france','germany','italy','spain','portugal','netherlands',
        'belgium','switzerland','austria','greece','poland','czech republic','hungary','ukraine','romania','bulgaria','serbia','croatia','slovenia',
        'slovakia','sweden','norway','finland','denmark','iceland','estonia','latvia','lithuania','luxembourg','malta','cyprus','turkey'
    ];
    $middleEast = [
        'united arab emirates','uae','qatar','saudi arabia','kuwait','bahrain','oman','jordan','israel','lebanon','iran','iraq','yemen','syria'
    ];
    $oceania = ['australia','new zealand','fiji','papua new guinea','solomon islands','vanuatu','samoa','tonga','tuvalu'];
    if (in_array($c, $africa)) return 'Africa';
    if (in_array($c, $northAmerica)) return 'North America';
    if (in_array($c, $southAmerica)) return 'South America';
    if (in_array($c, $europe)) return 'Europe';
    if (in_array($c, $middleEast)) return 'Middle East';
    if (in_array($c, $oceania)) return 'Oceania';
    // default to Asia for any unmapped country
    return 'Asia';
}

// Convert number of stops into a human-friendly label.
function stops_label($n) {
    if ($n <= 0) {
        return 'Non-stop';
    } elseif ($n == 1) {
        return '1 stop';
    } else {
        return $n . ' stops';
    }
}

// Compute flight duration given distance in km. Adds taxi/climb/descent time.
function computeDuration($distanceKm) {
    // base cruise speed ~ 800 km/h => hours = distance / 800
    $cruiseHours = $distanceKm / 800.0;
    // extra 20-45 min for taxi/climb/descent
    $extraMinutes = 20 + rand(0, 25);
    // Cast to integer seconds to avoid implicit float-to-int conversion deprecations.
    return (int) round(($cruiseHours * 3600) + ($extraMinutes * 60));
}

// Compute dynamic price given distance, airline quality, class multiplier and days ahead of departure.
function computePrice($distanceKm, $quality, $classMult, $daysAhead) {
    // Base cost per km; adjust lower to provide more sensible bracket
    $base = $distanceKm * 0.05;

    // Adjusted time factors to further compress price differences based on booking lead time.
    // The earlier you book, the cheaper the fare; late bookings still cost more but are not exorbitant.
    if ($daysAhead >= 60) {
        $timeFactor = 0.80;
    } elseif ($daysAhead >= 30) {
        $timeFactor = 0.95;
    } elseif ($daysAhead >= 14) {
        $timeFactor = 1.05;
    } elseif ($daysAhead >= 7) {
        $timeFactor = 1.20;
    } else {
        $timeFactor = 1.35;
    }

    // Increase random variation range slightly to keep fares realistic while generally lower.
    $randFactor = 0.85 + rand(0, 30) / 100.0; // ±15% variation

    // Always return an integer to avoid implicit float-to-int conversion.
    return (int) round($base * $quality * $classMult * $timeFactor * $randFactor);
}

/**
 * Compute a base price per adult one-way using month ranges and booking lead time.
 *
 * @param string $dateStr  Date in 'Y-m-d' format.
 * @param float  $quality  Airline quality factor.
 * @param float  $classMult Class multiplier from $CLASSES.
 * @param int    $daysAhead Days until departure.
 * @return int  Price in GBP.
 */
/**
 * Month-driven pricing that ALWAYS returns a per-adult one-way fare within the month's [min, max] band.
 * Quality, class, weekend and lead-time only adjust the position inside the band, they never
 * push the computed price outside of it. A small random factor provides variation.
 *
 * @param string      $dateStr    Departure date in 'Y-m-d' format.
 * @param float       $quality    Airline quality factor (e.g. 1.0 for baseline).
 * @param float       $classMult  Cabin class multiplier from $CLASSES.
 * @param int|null    $daysAhead  Optional days between today and departure. If null it will be computed.
 * @param bool        $isWeekend  Whether the departure date falls on a weekend.
 * @return int                    Price in GBP for one adult, one-way.
 */
function computeBasePriceByMonth(string $dateStr, float $quality, float $classMult, ?int $daysAhead = null, bool $isWeekend = false): int {
    global $MONTH_PRICE_BANDS;
    // Resolve the monthly band; default to a middle range if not found.
    $month = (int) date('n', strtotime($dateStr));
    [$min, $max] = $MONTH_PRICE_BANDS[$month] ?? [500, 700];
    $span = max(0, $max - $min);

    // Compute days ahead if not supplied. Use difference between today and departure date.
    if ($daysAhead === null) {
        $today   = new DateTime('today');
        $target  = new DateTime($dateStr);
        $daysAhead = max(0, (int) $today->diff($target)->days);
    }
    // Lead-time: 0 (close-in) -> high in band; 1 (far-out) -> lower in band.
    $advance = clamp(($daysAhead - 3) / 30.0, 0.0, 1.0);
    // Base position between 0.3 and 1.0 depending on advance (close-in ~1.0, far-out ~0.3).
    $pos = 1.0 - 0.7 * $advance;

    // Quality nudges position up or down slightly. Typical quality ~1.0..1.15.
    // Multiplying difference by 0.40 keeps influence modest.
    $pos += ($quality - 1.0) * 0.40;

    // Class bump: Map class multiplier (1.0..4.2) to at most +0.35 in position.
    $classBump = max(0.0, min(0.35, ($classMult - 1.0) / 3.5));
    $pos += $classBump;

    // Weekend premium: small extra push upward if flight departs on a weekend.
    if ($isWeekend) {
        $pos += 0.05;
    }

    // Small random variation ±0.05 to avoid identical fares; uses randf() defined below.
    $pos += (randf() - 0.5) * 0.10;

    // Clamp final position to [0,1].
    $pos = clamp($pos, 0.0, 1.0);

    // Compute price within band's bounds and enforce boundaries explicitly.
    $fare = $min + $pos * $span;
    $fare = max($min, min($max, $fare));
    return (int) round($fare);
}

// Look up airport data by code. Returns array or null.
function findAirport($code, $airports) {
    foreach ($airports as $apt) {
        if (strcasecmp($apt['code'], $code) === 0) {
            return $apt;
        }
    }
    return null;
}

// Generate flight options for one airline between two airports on given date.
// May generate non-stop or one-stop flights via airline hubs.
function generateFlightsForAirline($airline, $fromApt, $toApt, $departDate, $classKey, $daysAhead) {
    global $CLASSES, $AIRPORTS;
    $results = [];
    $classMult = $CLASSES[$classKey] ?? $CLASSES['economy'];
    $quality  = $airline['quality'];

    // Determine possible connection points: either direct or via any hub.
    $hubOptions = $airline['hubs'];

    // We will generate a handful of departure times (morning, midday, evening).
    $departTimes = [
        '05:00',
        '09:00',
        '13:00',
        '18:00',
        '22:00',
    ];
    shuffle($departTimes);
    $departTimes = array_slice($departTimes, 0, 3); // choose 3 random times

    foreach ($departTimes as $time) {
        // Determine if we do direct or one-stop (50% chance one-stop if there is at least one hub).
        $doConnection = (count($hubOptions) > 0 && randf() < 0.45);

        if (!$doConnection) {
            // Direct flight: compute distance and durations
            $dist = haversine($fromApt['lat'], $fromApt['lon'], $toApt['lat'], $toApt['lon']);
            $duration = computeDuration($dist);
            // Price based on month ranges rather than distance. Pass weekend flag so pricing stays within monthly bands
            $price = computeBasePriceByMonth(
                $departDate->format('Y-m-d'),
                $quality,
                $classMult,
                $daysAhead,
                ((int)$departDate->format('N') >= 6)
            );

            $results[] = [
                'airline'   => $airline['name'],
                'segments'  => [[
                    'from'   => $fromApt['code'],
                    'to'     => $toApt['code'],
                    'depart' => $departDate->format('Y-m-d') . ' ' . $time,
                    'arrive' => (clone $departDate)->setTime(intval(substr($time,0,2)), intval(substr($time,3,2)))->modify('+' . (int) round($duration/60) . ' minutes')->format('Y-m-d H:i'),
                    'duration' => $duration,
                    'stops'     => 0,
                ]],
                'totalDuration' => $duration,
                'price'    => $price,
                'class'    => ucfirst(str_replace('_',' ', $classKey)),
            ];
        } else {
            // One-stop via hub
            // pick a random hub
            $hubCode = $hubOptions[array_rand($hubOptions)];
            $hubApt  = findAirport($hubCode, $AIRPORTS);
            if (!$hubApt || $hubApt['code'] == $fromApt['code'] || $hubApt['code'] == $toApt['code']) {
                // fallback to direct if hub same as origin/destination
                $dist = haversine($fromApt['lat'], $fromApt['lon'], $toApt['lat'], $toApt['lon']);
                $duration = computeDuration($dist);
                // Price based on month ranges rather than distance
                $price = computeBasePriceByMonth(
                    $departDate->format('Y-m-d'),
                    $quality,
                    $classMult,
                    $daysAhead,
                    ((int)$departDate->format('N') >= 6)
                );
                $results[] = [
                    'airline'   => $airline['name'],
                    'segments'  => [[
                        'from'   => $fromApt['code'],
                        'to'     => $toApt['code'],
                        'depart' => $departDate->format('Y-m-d') . ' ' . $time,
                        'arrive' => (clone $departDate)->setTime(intval(substr($time,0,2)), intval(substr($time,3,2)))->modify('+' . (int) round($duration/60) . ' minutes')->format('Y-m-d H:i'),
                        'duration' => $duration,
                        'stops'     => 0,
                    ]],
                    'totalDuration' => $duration,
                    'price'    => $price,
                    'class'    => ucfirst(str_replace('_',' ', $classKey)),
                ];
            } else {
                // compute first leg and second leg
                $dist1 = haversine($fromApt['lat'], $fromApt['lon'], $hubApt['lat'], $hubApt['lon']);
                $dur1  = computeDuration($dist1);

                // choose layover time between 75 and 180 minutes
                $layover = 75 + rand(0, 105);

                $dist2 = haversine($hubApt['lat'], $hubApt['lon'], $toApt['lat'], $toApt['lon']);
                $dur2  = computeDuration($dist2);

                $totalDur = $dur1 + ($layover*60) + $dur2;
                // Price based on month ranges rather than distance (same for connecting flights)
                $price = computeBasePriceByMonth(
                    $departDate->format('Y-m-d'),
                    $quality,
                    $classMult,
                    $daysAhead,
                    ((int)$departDate->format('N') >= 6)
                );

                // compute departure and arrival times
                $depDateTime = DateTime::createFromFormat('Y-m-d H:i', $departDate->format('Y-m-d') . ' ' . $time);
                $arr1DateTime = clone $depDateTime;
                $arr1DateTime->modify('+' . (int) round($dur1/60) . ' minutes');

                $dep2DateTime = clone $arr1DateTime;
                $dep2DateTime->modify('+' . (int) $layover . ' minutes');

                $arr2DateTime = clone $dep2DateTime;
                $arr2DateTime->modify('+' . (int) round($dur2/60) . ' minutes');

                $results[] = [
                    'airline'   => $airline['name'],
                    'segments'  => [
                        [
                            'from'    => $fromApt['code'],
                            'to'      => $hubApt['code'],
                            'depart'  => $depDateTime->format('Y-m-d H:i'),
                            'arrive'  => $arr1DateTime->format('Y-m-d H:i'),
                            'duration' => $dur1,
                            'stops'    => 1,
                        ],
                        [
                            'from'    => $hubApt['code'],
                            'to'      => $toApt['code'],
                            'depart'  => $dep2DateTime->format('Y-m-d H:i'),
                            'arrive'  => $arr2DateTime->format('Y-m-d H:i'),
                            'duration' => $dur2,
                            'stops'    => 0,
                        ],
                    ],
                    'totalDuration' => $totalDur,
                    'price'    => $price,
                    'class'    => ucfirst(str_replace('_',' ', $classKey)),
                ];
            }
        }
    }
    return $results;
}

// Generate flight results given search criteria. Returns array of flights.
function generateFlightResults($fromCode, $toCode, $departDateStr, $returnDateStr, $classKey, $airlineCode = '') {
    global $AIRPORTS, $AIRLINES;

    $results = [];

    $fromApt = findAirport($fromCode, $AIRPORTS);
    $toApt   = findAirport($toCode,   $AIRPORTS);
    if (!$fromApt || !$toApt) {
        return [];
    }

    // Determine broad regions (continents) of origin and destination to enable realistic airline filtering.
    // This uses getRegionByCountry helper to map country names to coarse regions like 'Europe', 'Asia', etc.
    // If a country is not explicitly mapped it defaults to 'Asia'.
    $originRegion = getRegionByCountry($fromApt['country']);
    $destRegion   = getRegionByCountry($toApt['country']);

    // Determine days ahead for price/time factors
    $today = new DateTime('now');
    $departDate = DateTime::createFromFormat('Y-m-d', $departDateStr);
    if (!$departDate) {
        $departDate = clone $today;
    }
    $daysAheadDepart = (int)$today->diff($departDate)->format('%a');

    // For each airline generate flights
    foreach ($AIRLINES as $airline) {
        // If a preferred airline code is specified, skip others
        if ($airlineCode && strcasecmp($airline['code'], $airlineCode) !== 0) {
            continue;
        }
        // If no specific airline code is given, filter airlines to those that operate in both the origin and
        // destination regions.  Airlines include a 'regions' list specifying continents where they fly.
        // Only consider airlines covering both regions; this yields more realistic search results by avoiding
        // carriers that do not serve either the origin or destination areas.
        if (!$airlineCode) {
            $airRegions = $airline['regions'] ?? [];
            if (!in_array($originRegion, $airRegions) || !in_array($destRegion, $airRegions)) {
                continue;
            }
        }
        $outboundFlights = generateFlightsForAirline($airline, $fromApt, $toApt, $departDate, $classKey, $daysAheadDepart);
        // For one-way, inbound flights remain empty.
        $inboundFlights = [];

        // If return date provided and one-way not chosen, generate inbound results.
        if ($returnDateStr) {
            $returnDate = DateTime::createFromFormat('Y-m-d', $returnDateStr);
            $daysAheadReturn = (int)$today->diff($returnDate)->format('%a');
            $inboundFlights = generateFlightsForAirline($airline, $toApt, $fromApt, $returnDate, $classKey, $daysAheadReturn);

            // Pair each outbound with each inbound (cartesian) but limit to 2 inbound combos to avoid blow up.
            foreach ($outboundFlights as $out) {
                $count = 0;
                foreach ($inboundFlights as $in) {
                    // compute combined price and total duration; but treat separately for display.
                    $comboPrice = $out['price'] + $in['price'];
                    $comboDur   = $out['totalDuration'] + $in['totalDuration'];
                    $results[] = [
                        'airline'  => $airline['name'],
                        'airlineCode' => $airline['code'],
                        'outbound' => $out,
                        'inbound'  => $in,
                        'price'    => $comboPrice,
                        'totalDuration' => $comboDur,
                        'class'    => $out['class'],
                    ];
                    $count++;
                    if ($count >= 2) break;
                }
            }
        } else {
            // no return: just outbound flights
            foreach ($outboundFlights as $out) {
                $results[] = [
                    'airline'  => $airline['name'],
                    'airlineCode' => $airline['code'],
                    'outbound' => $out,
                    'inbound'  => null,
                    'price'    => $out['price'],
                    'totalDuration' => $out['totalDuration'],
                    'class'    => $out['class'],
                ];
            }
        }
    }

    // Sort by price ascending
    usort($results, function($a, $b) {
        return $a['price'] <=> $b['price'];
    });

    // If no airline filter is applied, deduplicate by airline name (keep cheapest per airline).
    if (!$airlineCode) {
        $seen = [];
        $unique = [];
        foreach ($results as $flight) {
            $name = $flight['airline'];
            if (!isset($seen[$name])) {
                $seen[$name] = true;
                $unique[] = $flight;
            }
        }
        $results = $unique;
    }

    // Limit to top 12 results after dedupe (if applied)
    return array_slice($results, 0, 12);
}

// Extract and sanitize query parameters from the request (GET).
// Accept only 3-letter alphabetic codes for airports.
function sanitizeIata($str) {
    return strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $str), 0, 3));
}

// Read basic search parameters
// $mode      = isset($_GET['mode']) && $_GET['mode'] === 'oneway' ? 'oneway' : 'round';
// $fromCode  = isset($_GET['from']) ? sanitizeIata($_GET['from']) : '';
// $toCode    = isset($_GET['to'])   ? sanitizeIata($_GET['to'])   : '';
// $depart    = isset($_GET['depart']) ? $_GET['depart'] : '';
// $return    = isset($_GET['return']) ? $_GET['return'] : '';
// $classKey  = isset($_GET['class']) ? $_GET['class'] : 'economy';
// // Additional fields for refined search
// $airlineCode = isset($_GET['airline']) ? strtoupper(preg_replace('/[^A-Za-z]/', '', $_GET['airline'])) : '';
// $adults   = isset($_GET['adults']) ? max(1, intval($_GET['adults'])) : 1;
// $children = isset($_GET['children']) ? max(0, intval($_GET['children'])) : 0;
// $infants  = isset($_GET['infants']) ? max(0, intval($_GET['infants'])) : 0;


function extractAirportCode($str)
{
    if (empty($str)) {
        return '';
    }
    
    // If it contains " - " (dash with spaces), extract the part after the dash
    if (strpos($str, ' - ') !== false) {
        $parts = explode(' - ', $str);
        if (count($parts) >= 2) {
            // Get the last part (should be the airport code)
            $code = trim(end($parts));
            return sanitizeIata($code);
        }
    }
    
    // If no dash format, treat as direct airport code
    return sanitizeIata($str);
}

// Convert airline name to logo filename format
function getAirlineLogoFilename($airlineName)
{
    // Convert to lowercase and replace spaces with underscores
    $filename = strtolower($airlineName);
    $filename = str_replace(' ', '_', $filename);
    $filename = str_replace('-', '_', $filename);
    $filename = str_replace('.', '', $filename);
    $filename = str_replace('&', 'and', $filename);
    
    return $filename . '.jpg';
}

function getParam(array $keys, $default = null)
{
    foreach ($keys as $key) {
        if (isset($_GET[$key]) && $_GET[$key] !== '') {
            return $_GET[$key];
        }
    }
    return $default;
}

$_GET['mode'] = strtolower(getParam(['mode', 'flight_type', 'trip_type', 'trip-type'], 'round')) === 'oneway' ? 'oneway' : 'round';
$_GET['from'] = extractAirportCode(getParam(['from', 'dept_arpt', 'departure-from'], ''));
$_GET['to'] = extractAirportCode(getParam(['to', 'dest_arpt', 'return-from'], ''));
$_GET['depart'] = getParam(['depart', 'departure_date', 'departure-date'], '');
$_GET['return'] = getParam(['return', 'return_date', 'return-date'], '');

// Class handling: prefer explicit class/cabin_class, otherwise infer from flags like economy=Economy
$__classParam = strtolower(getParam(['class', 'cabin_class'], ''));

if ($__classParam === '') {
    if (isset($_GET['economy'])) {
        $__classParam = strtolower($_GET['economy']);
    } elseif (isset($_GET['premium_economy'])) {
        $__classParam = strtolower($_GET['premium_economy']);
    } elseif (isset($_GET['premium-economy'])) {
        $__classParam = strtolower($_GET['premium-economy']);
    } elseif (isset($_GET['business'])) {
        $__classParam = strtolower($_GET['business']);
    } elseif (isset($_GET['first'])) {
        $__classParam = strtolower($_GET['first']);
    }
}

// echo $__classParam;
// die();

function extractAirlineCode($str)
{
    if (empty($str)) {
        return '';
    }

    // If it contains " - " (dash with spaces), extract the part before the dash
    if (strpos($str, ' - ') !== false) {
        $parts = explode(' - ', $str, 2); // limit to 2 parts
        $code = trim($parts[0]); // first part is the code
        return $code;
    }

    // If no dash format, treat as direct airline code
    return $str;
}


$_GET['class'] = $__classParam !== '' ? $__classParam : 'economy';
$_GET["airline"] = extractAirlineCode(isset($_GET["airline"]) ? $_GET["airline"] : '');
// $_GET['airline'] = strtoupper(preg_replace('/[^A-Za-z]/', '', getParam(['airline', 'airline'], '')));
// echo $_GET["airline"];
// die();

$_GET['adults'] = max(1, intval(getParam(['adults', 'padults'], 1)));
$_GET['children'] = max(0, intval(getParam(['children', 'pchildren'], 0)));
$_GET['infants'] = max(0, intval(getParam(['infants', 'pinfants'], 0)));
$_GET['c_name'] = getParam(['c_name', 'full-name'], '');
$_GET['c_email'] = getParam(['c_email', 'email'], '');
$_GET['c_phone'] = getParam(['c_phone', 'phone'], '');
$mode = isset($_GET['mode']) && $_GET['mode'] === 'oneway' ? 'oneway' : 'round';
$fromCode = isset($_GET['from']) ? extractAirportCode($_GET['from']) : '';
$toCode = isset($_GET['to']) ? extractAirportCode($_GET['to']) : '';
$depart = isset($_GET['depart']) ? date('Y-m-d', strtotime($_GET['depart'])) : '';
$return = isset($_GET['return']) ? date('Y-m-d', strtotime($_GET['return'])) : '';
$classKey = isset($_GET['class']) ? $_GET['class'] : 'economy';
// Additional fields for refined search
$airlineCode = isset($_GET['airline']) ? $_GET['airline'] : '';
$adults = isset($_GET['adults']) ? max(1, intval($_GET['adults'])) : 1;
$children = isset($_GET['children']) ? max(0, intval($_GET['children'])) : 0;
$infants = isset($_GET['infants']) ? max(0, intval($_GET['infants'])) : 0;

$results = [];
if ($fromCode && $toCode && $depart) {
    // Only generate if departure and airports provided
    $results = generateFlightResults($fromCode, $toCode, $depart, ($mode === 'oneway' ? null : $return), $classKey, $airlineCode);

    // Apply passenger count multipliers to price: adults weigh 1.0, children 0.75, infants 0.10
    // Standard passenger multipliers: 100% adult, 75% child, 10% infant (lap).
    $passengerMultiplier = ($adults * 1.00) + ($children * 0.75) + ($infants * 0.10);
    foreach ($results as &$res) {
        // Base price per adult (one-way or sum of two one-ways) has been computed in generateFlightResults.
        // Multiply by passenger count weights to compute total price.
        $adjusted = round($res['price'] * $passengerMultiplier);

        // Determine band limits for this itinerary based on outbound and inbound dates.
        $scaledMin = 0;
        $scaledMax = PHP_INT_MAX;
        // Extract outbound departure date
        $outDate = '';
        if (isset($res['outbound']['segments'][0]['depart'])) {
            $outDate = substr($res['outbound']['segments'][0]['depart'], 0, 10);
        } elseif (isset($res['segments'][0]['depart'])) {
            $outDate = substr($res['segments'][0]['depart'], 0, 10);
        }
        $monthOut = $outDate ? (int) date('n', strtotime($outDate)) : 0;
        // Look up outbound monthly band
        [$minOut, $maxOut] = $MONTH_PRICE_BANDS[$monthOut] ?? [500, 700];

        if (!empty($res['inbound'])) {
            // Round-trip: also determine return date month
            $inDate = '';
            if (isset($res['inbound']['segments'][0]['depart'])) {
                $inDate = substr($res['inbound']['segments'][0]['depart'], 0, 10);
            }
            $monthIn = $inDate ? (int) date('n', strtotime($inDate)) : 0;
            [$minIn, $maxIn] = $MONTH_PRICE_BANDS[$monthIn] ?? [500, 700];
            // Combined band for round-trip: sum of min and max of each leg
            $scaledMin = ($minOut + $minIn) * $passengerMultiplier;
            $scaledMax = ($maxOut + $maxIn) * $passengerMultiplier;
        } else {
            // One-way: scale the single band by passenger multiplier
            $scaledMin = $minOut * $passengerMultiplier;
            $scaledMax = $maxOut * $passengerMultiplier;
        }

        // Clamp the total price within the appropriate band times passenger weights.
        $res['price'] = (int) round(max($scaledMin, min($scaledMax, $adjusted)));
    }
    unset($res);
}

// List of IATA codes for datalist suggestions
$iataList = array_map(function($a) {
    return $a['code'] . ' - ' . $a['city'] . ', ' . $a['country'];
}, $AIRPORTS);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dynamic Flight Search</title>
	<script>
	    jQuery(document).ready(function ($) {
			$('body').removeClass('home');
		});
	</script>
     <style>
        .side_whybook_w_us{
            background: #3a1b07;
    opacity: 1;
    height: auto;
    margin: 20px 0 0 0;
    padding: 20px;
    border-radius: 0;
        }
    </style>
    <style>
    #apus-header{
        display: none !important;
    }
    .elementor-section.elementor-section-boxed > .elementor-container {
      max-width: 1320px !important;
    }
    .free-callback-popup{
        width: 350px;
    }

        .container {
            max-width: 1320px;
            margin: auto;
            display: flex;
            gap: 16px;
            padding: 20px;
        }

        .sidebar {
            width: 260px;
            background: #fff;
            border: 1px solid #ddd;
            /* padding: 16px; */
            border-radius: 4px;
            padding: 0 !important;
        }

        .content {
            flex-grow: 1;
        }

        h2 {
            margin-top: 0;
        }

        .form-group {
            margin-bottom: 10px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 4px;
        }

        input[type="text"],
        input[type="date"],
        select {
            width: 100%;
            padding: 9px;
            box-sizing: border-box;
        }

        .class-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 16px;
        }

        .class-tab {
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-bottom: none;
            cursor: pointer;
            background: #eee;
        }

        .class-tab.active {
            background: #fff;
            border-bottom: 1px solid #fff;
        }

        .flight-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
            /* padding: 14px; */
        }

        .flight-card h3 {
            margin: 0 0 6px;
            font-size: 18px;
        }

        .segments {
            margin-bottom: 6px;
        }

        .segment {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            margin-bottom: 2px;
        }

        /*.price {*/
        /*    font-size: 22px;*/
        /*    font-weight: bold;*/
        /*    color: #2b6cb0;*/
        /*    line-height: 1.2;*/
        /*}*/



        .class-tabs {
            margin-bottom: 20px;
            border-bottom: 2px solid #ddd;
        }

        .class-tabs ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .class-tabs li {
            margin: 0;
        }

        .class-tabs a {
            display: block;
            padding: 10px 18px;
            text-decoration: none;
            color: #555;
            border: 1px solid #ddd;
            border-bottom: none;
            margin-right: 5px;
            border-radius: 6px 6px 0 0;
            background: #f8f8f8;
            transition: background 0.2s, color 0.2s;
        }

        .class-tabs a:hover {
            background: #eaeaea;
            color: #000;
        }

        .class-tabs a.active {
            background: #fff;
            color: #000;
            border-bottom: 2px solid #fff;
            /* seamless with container */
            font-weight: bold;
        }

        /* Tab content style */
        .tab-content {
            display: none;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 0 6px 6px 6px;
            background: #fff;
        }

        /* Show the section if its ID matches hash in URL */
        :target.tab-content {
            display: block;
        }

        :target {
            scroll-margin-top: -100vh;
            /* pushes target out of view */
        }

        /* Default: show first tab if no hash */
        .tab-content:first-of-type {
            display: block;
        }


        /* Tabs wrapper */
        .nav-tabs {
            border-bottom: 2px solid #ddd;
            /* cleaner bottom line */
            margin-bottom: 15px;
        }

        /* Each tab item */
        .nav-tabs>li {
            float: none;
            /* center align since you use text-center */
            display: inline-block;
            margin-bottom: 0;
            /* remove bootstrap default spacing */
        }

        /* Tab link */
        .nav-tabs>li>a {
            padding: 10px 20px;
            font-weight: 700;
            /* color: #fff; */
            /* background: rgba(52, 10, 82, .85); */
            letter-spacing: 1px;
            border: 1px solid transparent;
            border-radius: 2px 2px 0 0;
            margin-right: 4px;
            position: relative;
            transition: all 0.2s ease-in-out;
        }

        /* Hover effect */
        .nav-tabs>li>a:hover {
            color: #fff;
            background: rgba(52, 10, 82, .95);
        }

        /* Active tab */
        .nav-tabs>li.active>a,
        .nav-tabs>li.active>a:focus,
        .nav-tabs>li.active>a:hover {
            /* color: #350b47; */
            /* background: #ffd71e; */
            /* border: 1px solid transparent; */
            font-weight: bold;
            cursor: default;
        }

        /* Active tab notch */
        .nav-tabs>li.active>a::after,
        .nav-tabs>li.active>a:focus::after,
        .nav-tabs>li.active>a:hover::after {
            content: "";
            position: absolute;
            left: 24px;
            bottom: -8px;
            border-width: 8px 7px 0 7px;
            border-style: solid;
            border-color: #ffd71e transparent transparent transparent;
        }

        /* Responsive small text */
        .nav-tabs>li>a small {
            display: block;
            font-size: 11px;
            color: #999;
        }
    </style>



    <style>
        .flight-card {
            display: flex;
            flex-direction: column;
            border: 2px solid #8B5CF6;
            border-radius: 6px;
            overflow: visible;
            margin: 15px 0;
            background: #fff;
            position: relative;
        }

        .flight-header {
            width: 100%;
            background: #F3F4F6;
            color: #374151;
            padding: 3px 0px;
            font-size: 16px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
        }

   

        .flight-body {
            flex: 3;
            padding: 0;
            display: flex;
            flex-direction: row;
        }

        .flight-section {
            flex: 1;
            background: white;
            border-right: 1px solid #E5E7EB;
            position: relative;
        }

        .flight-section:last-child {
            border-right: none;
        }

        .flight-section h2 {
            font-size: 13px;
    background: #015f9e;
    margin: 0;
    color: #fff;
    padding: 6px 8px;
    font-weight: 400;
    letter-spacing: 1px;
    text-align: center;
    border-right: 1px solid #fff;
        }
        .flight-section h4 {
            background: #1E40AF;
            color: #fff;
            padding: 8px 12px;
            font-size: 14px;
            font-weight: bold;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }


        .flight-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px;
            text-align: center;
        }

        .flight-info .from,
        .flight-info .to {
            width: 30%;
            font-size: 14px;
        }

        .airport-code {
            font-size: 24px;
            font-weight: bold;
            color: #2563EB;
            line-height: 1.2;
        }

        .airport-name {
            font-size: 12px;
            color: #6B7280;
            margin-bottom: 4px;
        }

        .flight-time {
            font-size: 18px;
            font-weight: bold;
            color: #374151;
            margin-bottom: 2px;
        }

        .flight-date {
            font-size: 12px;
            color: #6B7280;
        }

        .flight-info .stops {
            flex: 1;
            font-size: 13px;
            color: #374151;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }

        .stops-text {
            font-size: 13px;
            color: #374151;
        }

                 .airline-name {
             font-size: 12px;
             color: #6B7280;
         }

         .airline-logo {
             width: 24px;
             height: 16px;
             object-fit: contain;
             margin-top: 4px;
         }

        .flight-path {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 8px 0;
        }

        .flight-path-line {
            width: 60px;
            height: 2px;
            background: repeating-linear-gradient(to right,
                    #D1D5DB 0px,
                    #D1D5DB 8px,
                    transparent 8px,
                    transparent 16px);
            position: relative;
        }

        .flight-path-line::after {
            content: "✈";
            position: absolute;
            right: -8px;
            top: -6px;
            font-size: 12px;
            color: #9CA3AF;
        }

        /* Make the left column a positioning context for the details panel */
        .flight-card-inner { position: relative; }

        .flight-sidebar {
            background: #1E40AF;
            border: 3px solid #FCD34D;
            padding: 16px;
            text-align: center;
            font-size: 14px;
            color: white;
            position: relative;
            min-width: 200px;
            margin-left: auto;
        }

        .flight-sidebar::before {
            content: "";
            position: absolute;
            left: -12px;
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            height: 0;
            border-top: 12px solid transparent;
            border-bottom: 12px solid transparent;
            border-right: 12px solid #FCD34D;
        }

        .flight-sidebar .price {
            font-size: 24px;
            font-weight: bold;
            color: white;
            margin-bottom: 12px;
        }

        .flight-sidebar .call-text {
            font-size: 12px;
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .flight-sidebar .call-now {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .flight-sidebar .phone {
            font-size: 18px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .flight-details-link {
            font-size: 12px;
            color: #DC2626;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-weight: bold;
        }

        .flight-details-link::after {
            content: none;
        }

        .more-flights-link {
            font-size: 12px;
            color: #DC2626;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-weight: bold;
        }

        .flight-footer{
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            padding: 8px 12px;
            /* border-top: 1px solid #E5E7EB; */
            background: #fff;
        }

        .close_details{
            position: absolute;
    top: 0;
    right: 5px;
    font-size: 12px;
    cursor: pointer;
    z-index: 9999 !important;
}

        /* Flight details popover */
        .flight-details-panel {
            position: absolute;
            left: 0;
            right: auto;
            width: 100%;
            top: calc(100% + 8px);
            background: #fff;
            border: 2px solid #5b2a86;
            box-shadow: 0 4px 18px rgba(0,0,0,.15);
            z-index: 1000;
            display: none;
        }
        .flight-details-panel.visible { display: block; }
        .flight-details-header {
            background: #ffd71e;
            color: #000;
            padding: 10px 14px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .flight-details-body {  }
        .flight-details-section { border-top: 1px dashed #c6c6c6; padding: 12px 0; }
        .flight-details-row { display: flex; justify-content: space-between; gap: 12px; }
        .flight-details-col { width: 48%; }
        .flight-details-close { cursor: pointer; color: #5b2a86; font-size: 16px; }
        .more-flights-link::before {
            content: "ℹ";
            background: #DC2626;
            color: white;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
        }

        .more-flights-link::after {
            content: none;
        }

        /* New Price Section Styling */
        .price_details {
            /* background: #FCD34D; */
            /* border: 3px solid #FCD34D; */
            padding: 16px;
            text-align: center;
            position: relative;
            min-width: 200px;
        }

        /* .price_details::before {
        content: "";
        position: absolute;
        left: -12px;
        top: 50%;
        transform: translateY(-50%);
        width: 0;
        height: 0;
        border-top: 12px solid transparent;
        border-bottom: 12px solid transparent;
        border-right: 12px solid #FCD34D;
    } */

        .price_details .price h6 {
            font-size: 12px;
            color: #374151;
            margin: 0 0 8px 0;
            font-weight: normal;
        }

        .price_details .price h1 {
            font-size: 28px;
            font-weight: bold;
            color: #374151;
            margin: 0 0 8px 0;
            line-height: 1;
        }

        .price_details .price h1 span {
            font-size: 14px;
            font-weight: normal;
        }

        .price_details .price h6:last-child {
            font-size: 11px;
            line-height: 1.4;
            margin-bottom: 16px;
        }

        .add-to-link {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .add-to-link a {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 12px;
            font-weight: bold;
            color: white;
            transition: all 0.2s;
        }

        .call_now {
            background: #DC2626;
        }

        .call_now:hover {
            background: #B91C1C;
        }

        .book_now {
            background: #1E40AF;
        }

        .book_now:hover {
            background: #1D4ED8;
        }

        .whatsapp_now {
            background: #059669;
        }

        .whatsapp_now:hover {
            background: #047857;
        }

        .add-to-link a div {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .add-to-link a i {
            font-size: 14px;
        }

        /* Mobile responsive */
        .mob_price {
            font-size: 18px;
            font-weight: bold;
            color: #374151;
            margin: 0;
        }

        .mob_price small {
            font-size: 10px;
            font-weight: normal;
            display: block;
        }
    </style>
    <script>
        // Auto uppercase and filter suggestions for IATA input fields.
        function setupIataInput(id) {
            var input = document.getElementById(id);
            input.addEventListener('input', function () {
                this.value = this.value.toUpperCase().replace(/[^A-Z]/g, '').slice(0, 3);
            });
        }
        document.addEventListener('DOMContentLoaded', function () {
            setupIataInput('from');
            setupIataInput('to');
            // Class tabs removed; class selection is now via dropdown.
            var classSelect = document.getElementById('class');
            if (classSelect) {
                classSelect.addEventListener('change', function () {
                    document.getElementById('flightForm').submit();
                });
            }
            // Toggle return date field
            var modeRadios = document.querySelectorAll('[name="mode"]');
            modeRadios.forEach(function (radio) {
                radio.addEventListener('change', function () {
                    document.getElementById('flightForm').submit();
                });
            });
        });
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://rrtravels.co.uk/wp-content/themes/travila/assets/css/tickets.css">
    <!-- <link rel="stylesheet" href="tickets.css"> -->
</head>

<body>
    <button type="button" class="sidebar-open-btn">Filter Tickets</button>
    <div class="container results-page">
        <div class="sidebar">
            <h2 style="margin: 0 0 0 0;text-align: center;padding: 10px 0;color: #ffffff;">
                Refine Your Results
                <button type="button" class="close-sidebar"><i class="fas fa-plus"></i></button>
            </h2>
            <form id="flightForm" method="get" action="#" style="margin-bottom: 14px;">
                <div class="form-group">
                    <div class="trip-type-checkbox">
                        <label>
                            <input type="radio" name="mode" value="round" <?php echo $mode === 'oneway' ? '' : 'checked'; ?>>
                            Round Trip
                        </label>
                        <label>
                            <input type="radio" name="mode" value="oneway" <?php echo $mode === 'oneway' ? 'checked' : ''; ?>>
                            One Way
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="from">Flying From</label>
                    <select id="from" name="from">
                        <?php foreach ($AIRPORTS as $apt): ?>
                        <option value="<?php echo htmlspecialchars($apt['code']); ?>"  <?php echo ($apt['code'] === $fromCode) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($apt['code'] . ' - ' . $apt['city'] . ', ' . $apt['country']); ?>
                        </option>
                    <?php endforeach; ?>
                        <?php foreach ($COUNTRIES as $ct): ?>
                        <option value="<?php echo htmlspecialchars($ct['code']); ?>" <?php echo ($ct['code'] === $fromCode) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($ct['code'] . ' - ' . $ct['name'] . ' (country)'); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="to">Flying To</label>
                    <select id="to" name="to">
                        <?php foreach ($AIRPORTS as $apt): ?>
                        <option value="<?php echo htmlspecialchars($apt['code']); ?>" <?php echo ($apt['code'] === $toCode) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($apt['code'] . ' - ' . $apt['city'] . ', ' . $apt['country']); ?>
                        </option>
                    <?php endforeach; ?>
                        <?php foreach ($COUNTRIES as $ct): ?>
                        <option value="<?php echo htmlspecialchars($ct['code']); ?>" <?php echo ($ct['code'] === $toCode) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($ct['code'] . ' - ' . $ct['name'] . ' (country)'); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!--<div class="form-group">-->
                <!--    <label for="from">Flying From</label>-->
                <!--    <input list="iataList" id="from" name="from" required pattern="[A-Za-z]{3}"-->
                <!--        value="<?php echo htmlspecialchars($fromCode); ?>">-->
                <!--</div>-->
                <!--<div class="form-group">-->
                <!--    <label for="to">Flying To</label>-->
                <!--    <input list="iataList" id="to" name="to" required pattern="[A-Za-z]{3}"-->
                <!--        value="<?php echo htmlspecialchars($toCode); ?>">-->
                <!--</div>-->
                <!--<datalist id="iataList">-->
                    <?php // Populate airports first. ?>
                <!--    <?php foreach ($AIRPORTS as $apt): ?>-->
                <!--        <option value="<?php echo htmlspecialchars($apt['code']); ?>">-->
                <!--            <?php echo htmlspecialchars($apt['code'] . ' - ' . $apt['city'] . ', ' . $apt['country']); ?>-->
                <!--        </option>-->
                <!--    <?php endforeach; ?>-->
                    <?php // Then list all countries so users can search by country code as a hint. ?>
                <!--    <?php foreach ($COUNTRIES as $ct): ?>-->
                <!--        <option value="<?php echo htmlspecialchars($ct['code']); ?>">-->
                <!--            <?php echo htmlspecialchars($ct['code'] . ' - ' . $ct['name'] . ' (country)'); ?>-->
                <!--        </option>-->
                <!--    <?php endforeach; ?>-->
                <!--</datalist>-->
                <div class="form-group">
                    <label for="depart">Departure Date</label>
                    <input type="text" id="depart" name="depart" required
                        value="<?php echo htmlspecialchars($depart); ?>" readonly>
                </div>
                <?php if ($mode !== 'oneway'): ?>
                    <div class="form-group">
                        <label for="return">Return Date</label>
                        <input type="text" id="return" name="return" required
                            value="<?php echo htmlspecialchars($return); ?>" readonly="">
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="airline">Preferred Airline</label>
                    <select id="airline" name="airline">
                        <option value="" <?php echo empty($airlineCode) ? 'selected' : ''; ?>>All Airlines</option>
                        <?php foreach ($AIRLINES as $al): ?>
                            <option value="<?php echo htmlspecialchars($al['code']); ?>" <?php echo ($airlineCode && strcasecmp($airlineCode, $al['code']) == 0) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($al['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="select-passengers-main">
                    <div class="form-group">
                        <label for="adults">Adults</label>
                        <select id="adults" name="adults">
                            <?php for ($i = 0; $i <= 10; $i++): ?>
                                <option value="<?php echo $i; ?>" <?php echo ($adults == $i) ? 'selected' : ''; ?>>
                                    <?php echo $i; ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="children">Children</label>
                        <select id="children" name="children">
                            <?php for ($i = 0; $i <= 10; $i++): ?>
                                <option value="<?php echo $i; ?>" <?php echo ($children == $i) ? 'selected' : ''; ?>>
                                    <?php echo $i; ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="infants">Infants</label>
                        <select id="infants" name="infants">
                            <?php for ($i = 0; $i <= 10; $i++): ?>
                                <option value="<?php echo $i; ?>" <?php echo ($infants == $i) ? 'selected' : ''; ?>>
                                    <?php echo $i; ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="class">Class</label>
                    <select id="class" name="class">
                        <?php foreach ($CLASSES as $key => $mult): ?>
                            <option value="<?php echo htmlspecialchars($key); ?>" <?php echo ($classKey === $key) ? 'selected' : ''; ?>><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $key))); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit">Search</button>
                </div>
            </form>
            <div class="why-book-main" >
       			<div class="booking_session side_whybook_w_us visible-lg visible-md">
       				<h3>Why book with us ?</h3> 
   					<ul style="text-align:left;">
                    	<li class="first"><i class="fa fa-check"></i> Best Prices - Save Money</li>
                        <li><i class="fa fa-check"></i> No Hidden Fees</li>
                        <li><i class="fa fa-check"></i> Financial Protection</li>
                        <li><i class="fa fa-check"></i> Flexible Payment Options - Book Now Pay Later</li>
                        <li><i class="fa fa-check"></i> Secure Payments &amp; Complete Privacy</li>
                        <li><i class="fa fa-check"></i> Dedicated Customer Support - Friendly Staff</li>
                        <li><i class="fa fa-check"></i> Proven Record Of Over Thousands of Satisfied Customers</li>
                        <li class="last"><i class="fa fa-check"></i> Soft Cancellation Policies and Much More</li>
                    </ul>
                </div>
            </div>
            <!-- <div class="form-group">
                <p>Need help? Call us for unpublished fares.</p>
                <strong>+44 207 123 4567</strong>
            </div> -->
        </div>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <a href="tel:02070788885">
                        <img src="search-banner.png" style="width: 100%;" alt="Flight Search">
                    </a>
                </div>
            </div>

            <!-- Flight Class Tabs -->
            <div class="class-tabs" style="margin-top:1.5rem">
                <!-- <ul>
    <?php foreach ($CLASSES as $key => $mult): ?>
      <li><a href="#<?php echo htmlspecialchars($key); ?>"><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $key))); ?></a></li>
    <?php endforeach; ?>
  </ul> -->

                <ul class="nav nav-tabs" role="tablist">
                    <?php foreach ($CLASSES as $key => $mult): ?>
                        <?php
                        // Copy current query params
                        $params = $_GET;

                        // Set/override the class param
                        $params['class'] = $key;

                        // Build the new URL (same page + updated query)
                        $url = htmlspecialchars($_SERVER['PHP_SELF'] . '?' . http_build_query($params));

                        // Check if this tab should be active
                        $active = (isset($_GET['class']) && $_GET['class'] === $key) ? 'active' : '';
                        ?>

                        <li role="presentation" class="text-center <?php echo $active; ?>">
                            <a href="<?php echo $url; ?>" aria-controls="<?php echo htmlspecialchars($key); ?>" role="tab"
                                data-toggle="tab" aria-expanded="<?php echo $active ? 'true' : 'false'; ?>">
                                <span><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $key))); ?></span>
                                
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>


            </div>

            <?php 

                // Find airport by code
                $airport = array_filter($AIRPORTS, function ($a) use ($toCode) {
                    return $a['code'] === $toCode;
                });
                
                // Get first match
                $airport = reset($airport);
            ?>


            <h2 class="mb-0 page-mian-heading"><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $classKey))); ?> Flights To
                <?php 
                   if ($airport) {
                       echo $airport['city'];
                   }
                ?>
            </h2>
            <p class="page-mian-text" style="text-transform:capitalize;">
                <?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $mode))); ?>,
                <?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $classKey))); ?>, departuring on
                <strong>
                    <?php
                    if (!empty($depart)) {
                        echo htmlspecialchars(date("d-M-Y", strtotime($depart)));
                    }
                    ?>
                </strong>
                <?php if ($mode !== 'oneway'): ?>
                    and returning on <strong>
                        <?php
                        if (!empty($depart)) {
                            echo htmlspecialchars(date("d-M-Y", strtotime($return)));
                        }
                        ?>
                    </strong>
                <?php endif; ?>
                for
                <?php echo htmlspecialchars($adults); ?> Adult
                <?php if ($children > 0): ?>
                    <?php echo ", " . htmlspecialchars($children); ?> Child
                <?php endif; ?>
                <?php if ($infants > 0): ?>
                    <?php echo "and " . htmlspecialchars($infants); ?> Infant
                <?php endif; ?>.
            </p>
            <!-- flights results here -->

            <?php if ($results): ?>
                <?php foreach ($results as $index => $res): ?>



                    <div class="flight-card<?php echo $mode === 'round' ? ' round-trip' : ''; ?>">
                        <div class="tickets-main-area">
                            <div class="flight-card-inner">
                                <div class="flight-header">
                                    <!--<div class="flight-number"><?php echo $index + 1; ?></div>-->
                                    <span class="airline"><strong><?php echo htmlspecialchars($res['airline']); ?></strong> To <?php
                                       $destinationCode = $res['outbound']['segments'][count($res['outbound']['segments']) - 1]['to'];
                                       $destinationAirport = findAirport($destinationCode, $AIRPORTS);
                                       echo $destinationAirport ? htmlspecialchars($destinationAirport['city']) : htmlspecialchars($destinationCode);
                                       ?></span>
                                </div>

                                <div class="flight-body">
                                    <div class="tickets-sub-area">
                                        <!-- Outbound -->
                                        <div class="flight-section">
                                            <h2><i class="fas fa-plane-departure"></i> Outbound</h2>
                                            <?php $outSegs = $res['outbound']['segments']; ?>
                                            <div class="flight-info">
                                                <div class="from">
                                                    <div class="airport-code"><?php echo htmlspecialchars($outSegs[0]['from']); ?>
                                                    </div>
                                                    <div class="airport-name"><?php
                                                    $fromAirport = findAirport($outSegs[0]['from'], $AIRPORTS);
                                                    echo $fromAirport ? htmlspecialchars($fromAirport['city']) : '';
                                                    ?></div>
                                                    <div class="flight-time">
                                                        <?php echo date('g:i A', strtotime($outSegs[0]['depart'])); ?></div>
                                                    <div class="flight-date">
                                                        <?php echo date('D d, M', strtotime($outSegs[0]['depart'])); ?></div>
                                                </div>
                                                <div class="stops">
                                                                                                     <div class="stops-text"><?php 
                                                         $stops = max(0, count($outSegs) - 1);
                                                         echo $stops === 0 ? 'Non-stop' : $stops . ' stop' . ($stops > 1 ? 's' : '');
                                                     ?></div>
                                                    <div class="flight-path">
                                                        <div class="flight-path-line"></div>
                                                    </div>
                                                    <div class="airline-name"><?php echo htmlspecialchars($res['airline']); ?></div>
                                                    <img src="../assets/image/airlines/<?php echo htmlspecialchars($res['airlineCode']); ?>.gif" 
                                                         alt="<?php echo htmlspecialchars($res['airline']); ?>" 
                                                         class="airline-logo"
                                                         onerror="this.style.display='none';">
                                                </div>
                                                <div class="to">
                                                    <div class="airport-code"><?php echo htmlspecialchars(end($outSegs)['to']); ?>
                                                    </div>
                                                    <div class="airport-name"><?php
                                                    $toAirport = findAirport(end($outSegs)['to'], $AIRPORTS);
                                                    echo $toAirport ? htmlspecialchars($toAirport['city']) : '';
                                                    ?></div>
                                                    <div class="flight-time">
                                                        <?php echo date('g:i A', strtotime(end($outSegs)['arrive'])); ?></div>
                                                    <div class="flight-date">
                                                        <?php echo date('D d, M', strtotime(end($outSegs)['arrive'])); ?></div>
                                                </div>
                                            </div>
                                            <!--<div class="section-footer" style="display:flex; justify-content: space-between; padding: 8px 12px; position: relative; ">-->
                                            <!--    <a href="#" class="flight-details-link" -->
                                            <!--       onmouseenter="this.closest('.flight-card').querySelector('.flight-details-panel').classList.add('visible');"-->
                                            <!--       onclick="event.preventDefault(); this.closest('.flight-card').querySelector('.flight-details-panel').classList.add('visible');">-->
                                            <!--        Flight Details <i class="fa fa-angle-double-down"></i>-->
                                            <!--    </a>-->
                                                
                                            <!--</div>-->
                                        </div>
    
                                        <!-- Inbound -->
                                        <?php if ($res['inbound']): ?>
                                            <div class="flight-section">
                                                <h2><i class="fas fa-plane-arrival"></i> Inbound</h2>
                                                <?php $inSegs = $res['inbound']['segments']; ?>
                                                <div class="flight-info">
                                                    <div class="from">
                                                        <div class="airport-code"><?php echo htmlspecialchars($inSegs[0]['from']); ?>
                                                        </div>
                                                        <div class="airport-name"><?php
                                                        $fromAirport = findAirport($inSegs[0]['from'], $AIRPORTS);
                                                        echo $fromAirport ? htmlspecialchars($fromAirport['city']) : '';
                                                        ?></div>
                                                        <div class="flight-time">
                                                            <?php echo date('g:i A', strtotime($inSegs[0]['depart'])); ?></div>
                                                        <div class="flight-date">
                                                            <?php echo date('D d, M', strtotime($inSegs[0]['depart'])); ?></div>
                                                    </div>
                                                    <div class="stops">
                                                                                                             <div class="stops-text"><?php 
                                                             $stops = max(0, count($inSegs) - 1);
                                                             echo $stops === 0 ? 'Non-stop' : $stops . ' stop' . ($stops > 1 ? 's' : '');
                                                         ?></div>
                                                        <div class="flight-path">
                                                            <div class="flight-path-line"></div>
                                                        </div>
                                                        <div class="airline-name"><?php echo htmlspecialchars($res['airline']); ?></div>
                                                        <img src="../assets/image/airlines/<?php echo htmlspecialchars($res['airlineCode']); ?>.gif" 
                                                             alt="<?php echo htmlspecialchars($res['airline']); ?>" 
                                                             class="airline-logo"
                                                             onerror="this.style.display='none';">
                                                    </div>
                                                    <div class="to">
                                                        <div class="airport-code"><?php echo htmlspecialchars(end($inSegs)['to']); ?>
                                                        </div>
                                                        <div class="airport-name"><?php
                                                        $toAirport = findAirport(end($inSegs)['to'], $AIRPORTS);
                                                        echo $toAirport ? htmlspecialchars($toAirport['city']) : '';
                                                        ?></div>
                                                        <div class="flight-time">
                                                            <?php echo date('g:i A', strtotime(end($inSegs)['arrive'])); ?></div>
                                                        <div class="flight-date">
                                                            <?php echo date('D d, M', strtotime(end($inSegs)['arrive'])); ?></div>
                                                    </div>
                                                </div>
                                                <!--<div class="section-footer" style="display:flex; justify-content: flex-end; padding: 8px 12px; position: relative; ">-->
                                                <!--    <a href="#" class="more-flights-link">-->
                                                <!--        <span class="info-dot"></span> More <?php echo htmlspecialchars($res['airline']); ?> Flights <i class="fa fa-angle-double-down"></i>-->
                                                <!--    </a>-->
                                                    
                                                <!--</div>-->
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="tickets-right-area <?php if($index > 2 ):?> <?php else:?> tickets-noprice-right-area <?php endif;?>">

                                        <div class="price_details hidden-xs hidden-sm" style="">
                                            <?php if($index > 2 ):?>
                                            <div class="price main-price">
                                                <h6 class="price-from-text">From</h6>
                                                <h1>£ <?php echo htmlspecialchars(number_format($res['price'], 0)); ?>
                                                    <!--<span>PP</span>-->
                                                </h1>
                                                <h6>
                                                    <span class="ticket-type"><?php echo $mode === 'oneway' ? 'One Way' : 'Return'; ?>, Inc. Taxes<br></span>
                                                    <?php echo $adults; ?>
                                                    Adult<?php echo $adults > 1 ? 's' : ''; ?><?php if ($children > 0): ?>,
                                                        <?php echo $children; ?>
                                                        Child<?php echo $children > 1 ? 'ren' : ''; ?><?php endif; ?><?php if ($infants > 0): ?>,
                                                        <?php echo $infants; ?>
                                                        Infant<?php echo $infants > 1 ? 's' : ''; ?><?php endif; ?><br>
                                                    <strong class="total-price" style="font-size:13px;">Total Price £
                                                        <?php echo htmlspecialchars(number_format($res['price'], 0)); ?></strong>
                                                </h6>
                                                <!-- <h6 class="phn-strok">
                                                                <a href="tel:02079938331">02079938331</a>
                                                            </h6> -->
                                            </div>
                                            <?php else:?>
                                                <div class="price no-price">
                                                    <a href="tel:02070788885" class="link-fill"></a>
                                                    <p style=""> Special rates not published online.</p>
                                                    <div class="call-group">
                                                        <h4><i aria-hidden="true" class="fas fa-phone-alt"></i> Call Now</h4>
                                                        <a href="tel:02070788885" class="dialme">0207 078 8885</a>
                                                    </div>
                                                </div>
                                            <?php endif;?>
                                             <?php if($index > 2 ):?>
                                             <div class="add-to-links-div">
                                                 <a class="whatsapp_now"
                                                    href="https://api.whatsapp.com/send?phone=02070788885&amp;text=I'm%20interested%20in%20flights%20to%20<?php
                                                        $fromAirport = findAirport($inSegs[0]['from'], $AIRPORTS);
                                                        echo $fromAirport ? htmlspecialchars($fromAirport['city']) : '';
                                                        ?>%20from%20<?php
                                                        $toAirport = findAirport(end($inSegs)['to'], $AIRPORTS);
                                                        echo $toAirport ? htmlspecialchars($toAirport['city']) : '';
                                                        ?>%20Return%20Departure Date:%20<?php
                    if (!empty($return)) {
                        echo htmlspecialchars(date("d-M-Y", strtotime($depart)));
                    }
                    ?>%20Return Date:%20<?php
                    if (!empty($return)) {
                        echo htmlspecialchars(date("d-M-Y", strtotime($depart)));
                    }
                    ?>%20Price:%20£<?php echo htmlspecialchars(number_format($res['price'], 0)); ?>%20%20%20%20"
                                                    target="_blank">
                                                    <div>
                                                        <i class="fa fa-whatsapp"></i>
                                                        <!--<span>Whatsapp</span>-->
                                                    </div>
                                                </a>
                                                <a class="call_now" href="tel:02070788885">
                                                    <div>
                                                        <i class="fa fa-phone"></i>
                                                        <!--<span>Call Now</span>-->
                                                    </div>
                                                </a>
                                                
                                            </div>
                                             <?php else:?>
                                            
                                            <?php endif;?>
                                        </div>
        
                                    </div>

                                </div>
                                <?php $fromAirport = findAirport($outSegs[0]['from'], $AIRPORTS); ?>
                                <?php $toAirport = findAirport(end($outSegs)['to'], $AIRPORTS); ?>
                                
                            </div>
                            
                        </div>
                    </div>

                    <!-- <div class="flight-card">
                        <h3><?php echo htmlspecialchars($res['airline']); ?> - <?php echo htmlspecialchars($res['class']); ?>
                        </h3>
                        <div class="segments">
                            <?php
                            // Outbound segments
                            foreach ($res['outbound']['segments'] as $seg) {
                                echo '<div class="segment">';
                                echo '<div>' . htmlspecialchars($seg['from']) . ' → ' . htmlspecialchars($seg['to']) . '</div>';
                                echo '<div>' . htmlspecialchars(date('H:i', strtotime($seg['depart']))) . ' - ' . htmlspecialchars(date('H:i', strtotime($seg['arrive']))) . '</div>';
                                echo '</div>';
                            }
                            if ($res['inbound']) {
                                echo '<strong>Return:</strong>';
                                foreach ($res['inbound']['segments'] as $seg) {
                                    echo '<div class="segment">';
                                    echo '<div>' . htmlspecialchars($seg['from']) . ' → ' . htmlspecialchars($seg['to']) . '</div>';
                                    echo '<div>' . htmlspecialchars(date('H:i', strtotime($seg['depart']))) . ' - ' . htmlspecialchars(date('H:i', strtotime($seg['arrive']))) . '</div>';
                                    echo '</div>';
                                }
                            }
                            ?>
                        </div>
                        <?php
                        // Calculate stops for outbound and inbound segments
                        $outStops = max(0, count($res['outbound']['segments']) - 1);
                        $stopsInfo = stops_label($outStops);
                        if ($res['inbound']) {
                            $inStops = max(0, count($res['inbound']['segments']) - 1);
                            $stopsInfo .= ' / ' . stops_label($inStops);
                        }
                        ?>
                        <div class="segment">
                            <div>
                                <em>Total duration:</em>
                                <?php echo htmlspecialchars(formatDuration($res['totalDuration'])); ?><br>
                                <em>Stops:</em> <?php echo htmlspecialchars($stopsInfo); ?>
                            </div>
                            <div class="price">£ <?php echo htmlspecialchars(number_format($res['price'], 0)); ?></div>
                        </div>
                    </div> -->
                <?php endforeach; ?>
            <?php else: ?>
                <p>No flights found. Please adjust your search criteria.</p>
            <?php endif; ?>








        </div>
    </div>
    <?php get_footer(); ?>
    <script>
        jQuery(document).ready(function ($) {
            $(".sidebar [name='depart']").datepicker({
                dateFormat: "yy-mm-dd",
                minDate: 0,
                onSelect: function (selectedDate) {
                  $(".sidebar [name='return']").datepicker("option", "minDate", selectedDate);
                }
              });
            
              // Return Date
              $(".sidebar [name='return']").datepicker({
                dateFormat: "yy-mm-dd",
                minDate: 0
              });
            
              // ✅ Initialize with PHP values (if already filled)
              let departVal = $(".sidebar [name='depart']").val();
              if (departVal) {
                $(".sidebar [name='depart']").datepicker("setDate", departVal);
                $(".sidebar [name='return']").datepicker("option", "minDate", departVal);
              }
            
              let returnVal = $(".sidebar [name='return']").val();
              if (returnVal) {
                $(".sidebar [name='return']").datepicker("setDate", returnVal);
              }
          
            $('#airline').select2({
                placeholder: "All Airlines",
                allowClear: true
            });
            $('#adults,#children,#infants').select2({
                placeholder: "All Airlines",
                allowClear: false,
                minimumResultsForSearch: Infinity
            });
            $('.sidebar-open-btn').on('click', function() {
        		$('.sidebar').addClass('sidebar-active');
        	});
        	// 👉 Remove class
        	$('.close-sidebar').on('click', function() {
        		$('.sidebar').removeClass('sidebar-active');
        	});
        });
    </script>
</body>

</html>