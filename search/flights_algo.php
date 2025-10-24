<?php
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
    // Each airline now includes a home_country field. When searching for domestic flights,
    // only carriers whose home_country matches the country of origin/destination will be shown.
    // Regions remain unchanged and reflect broad network coverage as cited above.
    [
        'name'        => 'Emirates',
        'code'        => 'EK',
        'quality'     => 1.35,
        'hubs'        => ['DXB'],
        'regions'     => ['Middle East','Asia','Europe','Africa','Americas','Oceania'],
        'home_country'=> 'UAE'
    ],
    [
        'name'        => 'Qatar Airways',
        'code'        => 'QR',
        'quality'     => 1.30,
        'hubs'        => ['DOH'],
        'regions'     => ['Middle East','Asia','Europe','Africa','Americas','Oceania'],
        'home_country'=> 'Qatar'
    ],
    [
        'name'        => 'Etihad Airways',
        'code'        => 'EY',
        'quality'     => 1.25,
        'hubs'        => ['AUH'],
        'regions'     => ['Middle East','Asia','Europe','Africa','Americas','Oceania'],
        'home_country'=> 'UAE'
    ],
    [
        'name'        => 'Turkish Airlines',
        'code'        => 'TK',
        'quality'     => 1.10,
        'hubs'        => ['IST'],
        'regions'     => ['Europe','Asia','Africa','Americas','Oceania','Middle East'],
        'home_country'=> 'Turkey'
    ],
    [
        'name'        => 'Saudi Arabian Airlines',
        'code'        => 'SV',
        'quality'     => 1.05,
        'hubs'        => ['JED','RUH'],
        'regions'     => ['Middle East','Asia','Europe','Africa','North America'],
        'home_country'=> 'Saudi Arabia'
    ],
    [
        'name'        => 'Malaysia Airlines',
        'code'        => 'MH',
        'quality'     => 1.00,
        'hubs'        => ['KUL'],
        'regions'     => ['Asia','Oceania','Europe'],
        'home_country'=> 'Malaysia'
    ],
    [
        'name'        => 'British Airways',
        'code'        => 'BA',
        'quality'     => 1.20,
        'hubs'        => ['LHR','LGW'],
        'regions'     => ['Europe','Africa','Asia','Americas','Oceania','Middle East'],
        'home_country'=> 'United Kingdom'
    ],
    [
        'name'        => 'Air France',
        'code'        => 'AF',
        'quality'     => 1.18,
        'hubs'        => ['CDG','ORY'],
        'regions'     => ['Europe','Africa','Asia','Americas','Middle East'],
        'home_country'=> 'France'
    ],
    [
        'name'        => 'KLM',
        'code'        => 'KL',
        'quality'     => 1.15,
        'hubs'        => ['AMS'],
        'regions'     => ['Europe','Africa','Asia','Americas','Middle East'],
        'home_country'=> 'Netherlands'
    ],
    [
        'name'        => 'Delta Air Lines',
        'code'        => 'DL',
        'quality'     => 1.10,
        'hubs'        => ['ATL','DTW','MSP','SLC','LAX','JFK','SEA','BOS'],
        'regions'     => ['North America','South America','Europe','Asia','Africa'],
        'home_country'=> 'United States'
    ],
    [
        'name'        => 'American Airlines',
        'code'        => 'AA',
        'quality'     => 1.10,
        'hubs'        => ['DFW','MIA','CLT','PHL','PHX','ORD','LAX','JFK'],
        'regions'     => ['North America','South America','Europe','Asia'],
        'home_country'=> 'United States'
    ],
    [
        'name'        => 'United Airlines',
        'code'        => 'UA',
        'quality'     => 1.10,
        'hubs'        => ['ORD','IAH','DEN','EWR','SFO','LAX','IAD','GUM'],
        'regions'     => ['North America','South America','Europe','Asia','Oceania'],
        'home_country'=> 'United States'
    ],
    [
        'name'        => 'Air Canada',
        'code'        => 'AC',
        'quality'     => 1.05,
        'hubs'        => ['YYZ','YVR','YUL'],
        'regions'     => ['North America','Europe','Asia','South America'],
        'home_country'=> 'Canada'
    ],
    [
        'name'        => 'Singapore Airlines',
        'code'        => 'SQ',
        'quality'     => 1.30,
        'hubs'        => ['SIN'],
        'regions'     => ['Asia','Europe','North America','Oceania','Africa'],
        'home_country'=> 'Singapore'
    ],
    [
        'name'        => 'Qantas',
        'code'        => 'QF',
        'quality'     => 1.25,
        'hubs'        => ['SYD','MEL','BNE','PER'],
        'regions'     => ['Oceania','Asia','Europe','Americas','Africa'],
        'home_country'=> 'Australia'
    ],
    [
        'name'        => 'Ethiopian Airlines',
        'code'        => 'ET',
        'quality'     => 1.05,
        'hubs'        => ['ADD'],
        'regions'     => ['Africa','Europe','Asia','Americas','Middle East'],
        'home_country'=> 'Ethiopia'
    ],
    [
        'name'        => 'Kenya Airways',
        'code'        => 'KQ',
        'quality'     => 1.00,
        'hubs'        => ['NBO'],
        'regions'     => ['Africa','Europe','Asia','Middle East'],
        'home_country'=> 'Kenya'
    ],
    [
        'name'        => 'Egyptair',
        'code'        => 'MS',
        'quality'     => 1.00,
        'hubs'        => ['CAI'],
        'regions'     => ['Africa','Middle East','Europe','North America','Asia'],
        'home_country'=> 'Egypt'
    ],
    [
        'name'        => 'LATAM Airlines',
        'code'        => 'LA',
        'quality'     => 1.00,
        'hubs'        => ['SCL','GRU','LIM'],
        'regions'     => ['South America','North America','Europe','Oceania'],
        'home_country'=> 'Chile'
    ],
    // 🔸 Pakistan local carriers: PIA, Airblue and SereneAir.  These airlines operate
    // domestic flights within Pakistan and select international routes.  Their
    // inclusion enables domestic flight searches to return realistic local airlines.
    // PIA serves domestic routes plus international destinations across Asia,
    // Europe, the Middle East and North America【838397963142053†L272-L276】.
    // Airblue operates scheduled domestic flights in Pakistan and to Saudi Arabia and
    // the UAE【50911131343809†L224-L229】【50911131343809†L233-L254】.
    // SereneAir primarily operates domestically and launched its first international
    // service to Sharjah in March 2021【247028291621764†L181-L184】.
    [
        'name'        => 'Pakistan International Airlines',
        'code'        => 'PK',
        'quality'     => 0.98,
        'hubs'        => ['KHI','LHE','ISB'],
        // PIA's network covers Pakistan domestic routes and select international
        // destinations across Asia, the Middle East and Europe.  While the
        // carrier has historically served North America, those services were
        // suspended and the airline currently operates only one long-haul
        // flight to Toronto via Pakistan【111938027958090†L309-L315】.  To avoid
        // unrealistic suggestions for North America (e.g. LHR→GON), the
        // 'North America' region has been removed from this list.
        'regions'     => ['Asia','Middle East','Europe'],
        'home_country'=> 'Pakistan'
    ],
    [
        'name'        => 'Airblue',
        'code'        => 'PA',
        'quality'     => 0.95,
        'hubs'        => ['ISB','KHI','LHE'],
        'regions'     => ['Asia','Middle East'],
        'home_country'=> 'Pakistan'
    ],
    [
        'name'        => 'SereneAir',
        'code'        => 'ER',
        'quality'     => 0.90,
        'hubs'        => ['ISB','KHI','LHE'],
        'regions'     => ['Asia','Middle East'],
        'home_country'=> 'Pakistan'
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
            // Only use hubs located in either the origin or destination country to avoid third-country transits.
            $candidateHubs = [];
            foreach ($hubOptions as $hubCandidate) {
                $aptCandidate = findAirport($hubCandidate, $AIRPORTS);
                if ($aptCandidate && (
                    strcasecmp($aptCandidate['country'], $fromApt['country']) === 0 ||
                    strcasecmp($aptCandidate['country'], $toApt['country']) === 0
                )) {
                    $candidateHubs[] = $hubCandidate;
                }
            }
            // If no candidate hubs in the origin or destination country, fallback to direct.
            if (count($candidateHubs) === 0) {
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
                // pick a random hub from candidate hubs
                $hubCode = $candidateHubs[array_rand($candidateHubs)];
                $hubApt  = findAirport($hubCode, $AIRPORTS);
                // If the chosen hub is identical to the origin or destination airport,
                // treat this as a direct service instead of creating a zero-length segment.
                if ($hubApt && (
                    strcasecmp($hubApt['code'], $fromApt['code']) === 0 ||
                    strcasecmp($hubApt['code'], $toApt['code']) === 0
                )) {
                    // Direct flight fallback when hub equals origin or destination
                    $dist = haversine($fromApt['lat'], $fromApt['lon'], $toApt['lat'], $toApt['lon']);
                    $dur  = computeDuration($dist);
                    $price = computeBasePriceByMonth(
                        $departDate->format('Y-m-d'),
                        $quality,
                        $classMult,
                        $daysAhead,
                        ((int)$departDate->format('N') >= 6)
                    );
                    $depDateTime = DateTime::createFromFormat('Y-m-d H:i', $departDate->format('Y-m-d') . ' ' . $time);
                    $arrDateTime = clone $depDateTime;
                    $arrDateTime->modify('+' . (int) round($dur/60) . ' minutes');
                    $results[] = [
                        'airline'   => $airline['name'],
                        'segments'  => [[
                            'from'    => $fromApt['code'],
                            'to'      => $toApt['code'],
                            'depart'  => $depDateTime->format('Y-m-d H:i'),
                            'arrive'  => $arrDateTime->format('Y-m-d H:i'),
                            'duration' => $dur,
                            'stops'    => 0,
                        ]],
                        'totalDuration' => $dur,
                        'price'    => $price,
                        'class'    => ucfirst(str_replace('_',' ', $classKey)),
                    ];
                } else {
                    // compute first leg and second leg distances
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
        // If no specific airline code is given, apply additional filters:
        // 1) When travelling domestically (origin and destination share the same country), only show airlines
        // whose home_country matches that country.  This ensures local carriers appear for internal routes.
        // 2) When travelling internationally, restrict to airlines that serve both origin and destination
        // regions.  An airline's 'regions' list enumerates the continents it serves.
        if (!$airlineCode) {
            // Domestic flight: restrict to carriers with matching home_country.
            if (strcasecmp($fromApt['country'], $toApt['country']) === 0) {
                $home = $airline['home_country'] ?? null;
                if (!$home || strcasecmp($home, $fromApt['country']) !== 0) {
                    continue;
                }
            } else {
                // International: restrict to airlines from either the origin or destination country.
                // Skip carriers whose home_country is neither the origin nor the destination country.
                $home = $airline['home_country'] ?? '';
                if (!$home || (
                    strcasecmp($home, $fromApt['country']) !== 0 &&
                    strcasecmp($home, $toApt['country']) !== 0
                )) {
                    continue;
                }
                // Removed region filter: when the airline originates from either the origin or destination
                // country, we no longer verify that its regions list includes both the origin and destination
                // continents.  This allows flights operated by carriers from the departure or arrival
                // country to appear even if they do not serve the other region directly.  Other airlines
                // (whose home_country does not match either endpoint) continue to be excluded above.
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

$_GET['mode'] = strtolower(getParam(['mode', 'flight_type', 'trip_type', 'trip-type'], 'round'));
$_GET['mode'] =  ($_GET['mode'] === 'oneway' || $_GET['mode'] === 'one way') ? 'oneway' : 'round';
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