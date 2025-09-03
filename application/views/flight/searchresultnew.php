<?php
// dynamic flight search and booking mock application
ini_set('display_errors', 1);
error_reporting(E_ALL);
var_dump($_GET);


// Basic data about airports including coordinates for distance calculation.
// This is a small curated list of popular international airports. More can be added easily.
$AIRPORTS = [
    ['code' => 'LHE', 'city' => 'Lahore', 'country' => 'Pakistan', 'lat' => 31.5204, 'lon' => 74.3587],
    ['code' => 'BKK', 'city' => 'Bangkok', 'country' => 'Thailand', 'lat' => 13.6900, 'lon' => 100.7501],
    ['code' => 'DXB', 'city' => 'Dubai', 'country' => 'UAE', 'lat' => 25.2532, 'lon' => 55.3657],
    ['code' => 'AUH', 'city' => 'Abu Dhabi', 'country' => 'UAE', 'lat' => 24.4330, 'lon' => 54.6511],
    ['code' => 'DOH', 'city' => 'Doha', 'country' => 'Qatar', 'lat' => 25.2736, 'lon' => 51.6080],
    ['code' => 'IST', 'city' => 'Istanbul', 'country' => 'Turkey', 'lat' => 41.2753, 'lon' => 28.7519],
    ['code' => 'KUL', 'city' => 'Kuala Lumpur', 'country' => 'Malaysia', 'lat' => 2.7456, 'lon' => 101.7072],
    ['code' => 'KHI', 'city' => 'Karachi', 'country' => 'Pakistan', 'lat' => 24.9065, 'lon' => 67.1600],
    ['code' => 'JFK', 'city' => 'New York', 'country' => 'USA', 'lat' => 40.6413, 'lon' => -73.7781],
    ['code' => 'LHR', 'city' => 'London', 'country' => 'United Kingdom', 'lat' => 51.4700, 'lon' => -0.4543],
    ['code' => 'NRT', 'city' => 'Tokyo', 'country' => 'Japan', 'lat' => 35.7719, 'lon' => 140.3929],
    ['code' => 'SYD', 'city' => 'Sydney', 'country' => 'Australia', 'lat' => -33.9399, 'lon' => 151.1753],
    // --- Additional worldwide major airports by country ---
    ['code' => 'MLE', 'city' => 'Male', 'country' => 'Maldives', 'lat' => 4.1919, 'lon' => 73.5291],
    ['code' => 'KWI', 'city' => 'Kuwait City', 'country' => 'Kuwait', 'lat' => 29.2266, 'lon' => 47.9689],
    ['code' => 'BAH', 'city' => 'Manama', 'country' => 'Bahrain', 'lat' => 26.2708, 'lon' => 50.6336],
    ['code' => 'AMM', 'city' => 'Amman', 'country' => 'Jordan', 'lat' => 31.7226, 'lon' => 35.9932],
    ['code' => 'BEY', 'city' => 'Beirut', 'country' => 'Lebanon', 'lat' => 33.8208, 'lon' => 35.4884],
    ['code' => 'TLV', 'city' => 'Tel Aviv', 'country' => 'Israel', 'lat' => 32.0090, 'lon' => 34.8869],
    ['code' => 'IKA', 'city' => 'Tehran', 'country' => 'Iran', 'lat' => 35.4161, 'lon' => 51.1522],
    ['code' => 'KBL', 'city' => 'Kabul', 'country' => 'Afghanistan', 'lat' => 34.5630, 'lon' => 69.2123],
    ['code' => 'TAS', 'city' => 'Tashkent', 'country' => 'Uzbekistan', 'lat' => 41.2579, 'lon' => 69.2812],
    ['code' => 'ALA', 'city' => 'Almaty', 'country' => 'Kazakhstan', 'lat' => 43.3521, 'lon' => 77.0405],
    ['code' => 'NQZ', 'city' => 'Nur-Sultan', 'country' => 'Kazakhstan', 'lat' => 51.0222, 'lon' => 71.4669],
    ['code' => 'FRU', 'city' => 'Bishkek', 'country' => 'Kyrgyzstan', 'lat' => 43.0613, 'lon' => 74.4779],
    ['code' => 'GYD', 'city' => 'Baku', 'country' => 'Azerbaijan', 'lat' => 40.4681, 'lon' => 50.0469],
    ['code' => 'EVN', 'city' => 'Yerevan', 'country' => 'Armenia', 'lat' => 40.1473, 'lon' => 44.3959],
    ['code' => 'TBS', 'city' => 'Tbilisi', 'country' => 'Georgia', 'lat' => 41.6692, 'lon' => 44.9542],
    ['code' => 'KBP', 'city' => 'Kyiv', 'country' => 'Ukraine', 'lat' => 50.3450, 'lon' => 30.8947],
    ['code' => 'LWO', 'city' => 'Lviv', 'country' => 'Ukraine', 'lat' => 49.8125, 'lon' => 23.9561],
    ['code' => 'SVO', 'city' => 'Moscow', 'country' => 'Russia', 'lat' => 55.9726, 'lon' => 37.4146],
    ['code' => 'DME', 'city' => 'Moscow (Domodedovo)', 'country' => 'Russia', 'lat' => 55.4088, 'lon' => 37.9063],
    ['code' => 'LED', 'city' => 'Saint Petersburg', 'country' => 'Russia', 'lat' => 59.8003, 'lon' => 30.2625],
    ['code' => 'MSQ', 'city' => 'Minsk', 'country' => 'Belarus', 'lat' => 53.8825, 'lon' => 28.0300],
    ['code' => 'WAW', 'city' => 'Warsaw', 'country' => 'Poland', 'lat' => 52.1657, 'lon' => 20.9671],
    ['code' => 'PRG', 'city' => 'Prague', 'country' => 'Czech Republic', 'lat' => 50.1008, 'lon' => 14.2565],
    ['code' => 'BUD', 'city' => 'Budapest', 'country' => 'Hungary', 'lat' => 47.4399, 'lon' => 19.2611],
    ['code' => 'BTS', 'city' => 'Bratislava', 'country' => 'Slovakia', 'lat' => 48.1702, 'lon' => 17.2127],
    ['code' => 'LJU', 'city' => 'Ljubljana', 'country' => 'Slovenia', 'lat' => 46.2259, 'lon' => 14.4575],
    ['code' => 'ZAG', 'city' => 'Zagreb', 'country' => 'Croatia', 'lat' => 45.7429, 'lon' => 16.0688],
    ['code' => 'SJJ', 'city' => 'Sarajevo', 'country' => 'Bosnia and Herzegovina', 'lat' => 43.8246, 'lon' => 18.3315],
    ['code' => 'BEG', 'city' => 'Belgrade', 'country' => 'Serbia', 'lat' => 44.8184, 'lon' => 20.3094],
    ['code' => 'OTP', 'city' => 'Bucharest', 'country' => 'Romania', 'lat' => 44.5720, 'lon' => 26.1020],
    ['code' => 'SOF', 'city' => 'Sofia', 'country' => 'Bulgaria', 'lat' => 42.6977, 'lon' => 23.4011],
    ['code' => 'ATH', 'city' => 'Athens', 'country' => 'Greece', 'lat' => 37.9364, 'lon' => 23.9445],
    ['code' => 'HER', 'city' => 'Heraklion', 'country' => 'Greece', 'lat' => 35.3397, 'lon' => 25.1803],
    ['code' => 'LCA', 'city' => 'Larnaca', 'country' => 'Cyprus', 'lat' => 34.8750, 'lon' => 33.6249],
    ['code' => 'ARN', 'city' => 'Stockholm', 'country' => 'Sweden', 'lat' => 59.6519, 'lon' => 17.9186],
    ['code' => 'GOT', 'city' => 'Gothenburg', 'country' => 'Sweden', 'lat' => 57.6689, 'lon' => 12.2778],
    ['code' => 'OSL', 'city' => 'Oslo', 'country' => 'Norway', 'lat' => 60.1939, 'lon' => 11.1004],
    ['code' => 'CPH', 'city' => 'Copenhagen', 'country' => 'Denmark', 'lat' => 55.6181, 'lon' => 12.6560],
    ['code' => 'HEL', 'city' => 'Helsinki', 'country' => 'Finland', 'lat' => 60.3172, 'lon' => 24.9633],
    ['code' => 'KEF', 'city' => 'Reykjavik', 'country' => 'Iceland', 'lat' => 63.9850, 'lon' => -22.6056],
    ['code' => 'RIX', 'city' => 'Riga', 'country' => 'Latvia', 'lat' => 56.9236, 'lon' => 23.9711],
    ['code' => 'VNO', 'city' => 'Vilnius', 'country' => 'Lithuania', 'lat' => 54.6341, 'lon' => 25.2858],
    ['code' => 'TLL', 'city' => 'Tallinn', 'country' => 'Estonia', 'lat' => 59.4133, 'lon' => 24.8328],
    ['code' => 'DUB', 'city' => 'Dublin', 'country' => 'Ireland', 'lat' => 53.4213, 'lon' => -6.2701],
    ['code' => 'BRU', 'city' => 'Brussels', 'country' => 'Belgium', 'lat' => 50.9014, 'lon' => 4.4844],
    ['code' => 'LUX', 'city' => 'Luxembourg', 'country' => 'Luxembourg', 'lat' => 49.6233, 'lon' => 6.2044],
    ['code' => 'GVA', 'city' => 'Geneva', 'country' => 'Switzerland', 'lat' => 46.2381, 'lon' => 6.1090],
    ['code' => 'FCO', 'city' => 'Rome', 'country' => 'Italy', 'lat' => 41.7999, 'lon' => 12.2462],
    ['code' => 'MXP', 'city' => 'Milan', 'country' => 'Italy', 'lat' => 45.6306, 'lon' => 8.7281],
    ['code' => 'NAP', 'city' => 'Naples', 'country' => 'Italy', 'lat' => 40.8860, 'lon' => 14.2908],
    ['code' => 'AGP', 'city' => 'Malaga', 'country' => 'Spain', 'lat' => 36.6749, 'lon' => -4.4991],
    ['code' => 'PMI', 'city' => 'Palma de Mallorca', 'country' => 'Spain', 'lat' => 39.5517, 'lon' => 2.7388],
    ['code' => 'STN', 'city' => 'London (Stansted)', 'country' => 'United Kingdom', 'lat' => 51.8897, 'lon' => 0.2622],
    ['code' => 'MAN', 'city' => 'Manchester', 'country' => 'United Kingdom', 'lat' => 53.3650, 'lon' => -2.2727],
    ['code' => 'BHX', 'city' => 'Birmingham', 'country' => 'United Kingdom', 'lat' => 52.4539, 'lon' => -1.7480],
    ['code' => 'GLA', 'city' => 'Glasgow', 'country' => 'United Kingdom', 'lat' => 55.8721, 'lon' => -4.4331],
    ['code' => 'CAI', 'city' => 'Cairo', 'country' => 'Egypt', 'lat' => 30.1123, 'lon' => 31.4004],
    ['code' => 'HRG', 'city' => 'Hurghada', 'country' => 'Egypt', 'lat' => 27.1773, 'lon' => 33.8090],
    ['code' => 'CMN', 'city' => 'Casablanca', 'country' => 'Morocco', 'lat' => 33.3672, 'lon' => -7.5892],
    ['code' => 'RAK', 'city' => 'Marrakech', 'country' => 'Morocco', 'lat' => 31.6069, 'lon' => -8.0363],
    ['code' => 'TUN', 'city' => 'Tunis', 'country' => 'Tunisia', 'lat' => 36.8510, 'lon' => 10.2272],
    ['code' => 'ALG', 'city' => 'Algiers', 'country' => 'Algeria', 'lat' => 36.6930, 'lon' => 3.2155],
    ['code' => 'TIP', 'city' => 'Tripoli', 'country' => 'Libya', 'lat' => 32.8950, 'lon' => 13.2760],
    ['code' => 'NBO', 'city' => 'Nairobi', 'country' => 'Kenya', 'lat' => -1.3192, 'lon' => 36.9278],
    ['code' => 'LOS', 'city' => 'Lagos', 'country' => 'Nigeria', 'lat' => 6.5774, 'lon' => 3.3215],
    ['code' => 'ADD', 'city' => 'Addis Ababa', 'country' => 'Ethiopia', 'lat' => 8.9778, 'lon' => 38.7993],
    ['code' => 'JNB', 'city' => 'Johannesburg', 'country' => 'South Africa', 'lat' => -26.1337, 'lon' => 28.2420],
    ['code' => 'CPT', 'city' => 'Cape Town', 'country' => 'South Africa', 'lat' => -33.9695, 'lon' => 18.5972],
    ['code' => 'SEZ', 'city' => 'Mahe', 'country' => 'Seychelles', 'lat' => -4.6743, 'lon' => 55.5218],
    ['code' => 'MRU', 'city' => 'Mauritius', 'country' => 'Mauritius', 'lat' => -20.4304, 'lon' => 57.6836],
    ['code' => 'DAR', 'city' => 'Dar es Salaam', 'country' => 'Tanzania', 'lat' => -6.8781, 'lon' => 39.2026],
    ['code' => 'ZNZ', 'city' => 'Zanzibar', 'country' => 'Tanzania', 'lat' => -6.2217, 'lon' => 39.2236],
    ['code' => 'DKR', 'city' => 'Dakar', 'country' => 'Senegal', 'lat' => 14.7397, 'lon' => -17.4902],
    ['code' => 'ABJ', 'city' => 'Abidjan', 'country' => 'Côte d’Ivoire', 'lat' => 5.2614, 'lon' => -3.9263],
    ['code' => 'ACC', 'city' => 'Accra', 'country' => 'Ghana', 'lat' => 5.6052, 'lon' => -0.1860],
    ['code' => 'DLA', 'city' => 'Douala', 'country' => 'Cameroon', 'lat' => 4.0067, 'lon' => 9.7195],
    ['code' => 'BLR', 'city' => 'Bangalore', 'country' => 'India', 'lat' => 13.1979, 'lon' => 77.7063],
    ['code' => 'MAA', 'city' => 'Chennai', 'country' => 'India', 'lat' => 12.9941, 'lon' => 80.1709],
    ['code' => 'HYD', 'city' => 'Hyderabad', 'country' => 'India', 'lat' => 17.2403, 'lon' => 78.4294],
    ['code' => 'CCU', 'city' => 'Kolkata', 'country' => 'India', 'lat' => 22.6540, 'lon' => 88.4467],
    ['code' => 'PNQ', 'city' => 'Pune', 'country' => 'India', 'lat' => 18.5820, 'lon' => 73.9197],
    ['code' => 'GOI', 'city' => 'Goa', 'country' => 'India', 'lat' => 15.3800, 'lon' => 73.8329],
    ['code' => 'DAC', 'city' => 'Dhaka', 'country' => 'Bangladesh', 'lat' => 23.8433, 'lon' => 90.3978],
    ['code' => 'KTM', 'city' => 'Kathmandu', 'country' => 'Nepal', 'lat' => 27.6964, 'lon' => 85.3591],
    ['code' => 'PBH', 'city' => 'Paro', 'country' => 'Bhutan', 'lat' => 27.4032, 'lon' => 89.4244],
    ['code' => 'DPS', 'city' => 'Denpasar', 'country' => 'Indonesia', 'lat' => -8.7481, 'lon' => 115.1672],
    ['code' => 'SUB', 'city' => 'Surabaya', 'country' => 'Indonesia', 'lat' => -7.3798, 'lon' => 112.7870],
    ['code' => 'MNL', 'city' => 'Manila', 'country' => 'Philippines', 'lat' => 14.5086, 'lon' => 121.0198],
    ['code' => 'CEB', 'city' => 'Cebu', 'country' => 'Philippines', 'lat' => 10.3090, 'lon' => 123.9819],
    ['code' => 'SGN', 'city' => 'Ho Chi Minh City', 'country' => 'Vietnam', 'lat' => 10.8188, 'lon' => 106.6520],
    ['code' => 'HAN', 'city' => 'Hanoi', 'country' => 'Vietnam', 'lat' => 21.2212, 'lon' => 105.8106],
    ['code' => 'PNH', 'city' => 'Phnom Penh', 'country' => 'Cambodia', 'lat' => 11.5466, 'lon' => 104.8444],
    ['code' => 'REP', 'city' => 'Siem Reap', 'country' => 'Cambodia', 'lat' => 13.4124, 'lon' => 103.8669],
    ['code' => 'VTE', 'city' => 'Vientiane', 'country' => 'Laos', 'lat' => 17.9883, 'lon' => 102.5640],
    ['code' => 'RGN', 'city' => 'Yangon', 'country' => 'Myanmar', 'lat' => 16.9063, 'lon' => 96.1340],
    ['code' => 'SHA', 'city' => 'Shanghai (Hongqiao)', 'country' => 'China', 'lat' => 31.1979, 'lon' => 121.3370],
    ['code' => 'SZX', 'city' => 'Shenzhen', 'country' => 'China', 'lat' => 22.6393, 'lon' => 113.8107],
    ['code' => 'XMN', 'city' => 'Xiamen', 'country' => 'China', 'lat' => 24.5440, 'lon' => 118.1270],
    ['code' => 'FUK', 'city' => 'Fukuoka', 'country' => 'Japan', 'lat' => 33.5859, 'lon' => 130.4500],
    ['code' => 'NGO', 'city' => 'Nagoya', 'country' => 'Japan', 'lat' => 34.8584, 'lon' => 136.8048],
    ['code' => 'GMP', 'city' => 'Seoul (Gimpo)', 'country' => 'South Korea', 'lat' => 37.5583, 'lon' => 126.7910],
    ['code' => 'MEL', 'city' => 'Melbourne', 'country' => 'Australia', 'lat' => -37.6733, 'lon' => 144.8430],
    ['code' => 'BNE', 'city' => 'Brisbane', 'country' => 'Australia', 'lat' => -27.3833, 'lon' => 153.1175],
    ['code' => 'PER', 'city' => 'Perth', 'country' => 'Australia', 'lat' => -31.9403, 'lon' => 115.9672],
    ['code' => 'AKL', 'city' => 'Auckland', 'country' => 'New Zealand', 'lat' => -36.8485, 'lon' => 174.7633],
    ['code' => 'WLG', 'city' => 'Wellington', 'country' => 'New Zealand', 'lat' => -41.3272, 'lon' => 174.8056],
    ['code' => 'CHC', 'city' => 'Christchurch', 'country' => 'New Zealand', 'lat' => -43.4894, 'lon' => 172.5322],
    ['code' => 'NAN', 'city' => 'Nadi', 'country' => 'Fiji', 'lat' => -17.7554, 'lon' => 177.4434],
    ['code' => 'MEX', 'city' => 'Mexico City', 'country' => 'Mexico', 'lat' => 19.4361, 'lon' => -99.0719],
    ['code' => 'CUN', 'city' => 'Cancun', 'country' => 'Mexico', 'lat' => 21.0365, 'lon' => -86.8769],
    ['code' => 'ATL', 'city' => 'Atlanta', 'country' => 'USA', 'lat' => 33.6407, 'lon' => -84.4277],
    ['code' => 'DFW', 'city' => 'Dallas/Fort Worth', 'country' => 'USA', 'lat' => 32.8998, 'lon' => -97.0403],
    ['code' => 'DEN', 'city' => 'Denver', 'country' => 'USA', 'lat' => 39.8561, 'lon' => -104.6737],
    ['code' => 'BOS', 'city' => 'Boston', 'country' => 'USA', 'lat' => 42.3656, 'lon' => -71.0096],
    ['code' => 'MIA', 'city' => 'Miami', 'country' => 'USA', 'lat' => 25.7959, 'lon' => -80.2870],
    ['code' => 'LAS', 'city' => 'Las Vegas', 'country' => 'USA', 'lat' => 36.0801, 'lon' => -115.1522],
    ['code' => 'PHX', 'city' => 'Phoenix', 'country' => 'USA', 'lat' => 33.4342, 'lon' => -112.0116],
    ['code' => 'CLT', 'city' => 'Charlotte', 'country' => 'USA', 'lat' => 35.2144, 'lon' => -80.9473],
    ['code' => 'IAH', 'city' => 'Houston', 'country' => 'USA', 'lat' => 29.9902, 'lon' => -95.3368],
    ['code' => 'HNL', 'city' => 'Honolulu', 'country' => 'USA', 'lat' => 21.3187, 'lon' => -157.9227],
    ['code' => 'YYC', 'city' => 'Calgary', 'country' => 'Canada', 'lat' => 51.1139, 'lon' => -114.0200],
    ['code' => 'YUL', 'city' => 'Montreal', 'country' => 'Canada', 'lat' => 45.4577, 'lon' => -73.7499],
    ['code' => 'GRU', 'city' => 'São Paulo', 'country' => 'Brazil', 'lat' => -23.4356, 'lon' => -46.4731],
    ['code' => 'GIG', 'city' => 'Rio de Janeiro', 'country' => 'Brazil', 'lat' => -22.8089, 'lon' => -43.2436],
    ['code' => 'BSB', 'city' => 'Brasilia', 'country' => 'Brazil', 'lat' => -15.8692, 'lon' => -47.9188],
    ['code' => 'EZE', 'city' => 'Buenos Aires', 'country' => 'Argentina', 'lat' => -34.8222, 'lon' => -58.5358],
    ['code' => 'SCL', 'city' => 'Santiago', 'country' => 'Chile', 'lat' => -33.3930, 'lon' => -70.7869],
    ['code' => 'BOG', 'city' => 'Bogotá', 'country' => 'Colombia', 'lat' => 4.7016, 'lon' => -74.1469],
    ['code' => 'LIM', 'city' => 'Lima', 'country' => 'Peru', 'lat' => -12.0219, 'lon' => -77.1140],
    ['code' => 'UIO', 'city' => 'Quito', 'country' => 'Ecuador', 'lat' => -0.1292, 'lon' => -78.3576],
    ['code' => 'HAV', 'city' => 'Havana', 'country' => 'Cuba', 'lat' => 22.9892, 'lon' => -82.4091],
    ['code' => 'SJU', 'city' => 'San Juan', 'country' => 'Puerto Rico', 'lat' => 18.4394, 'lon' => -66.0018],
    ['code' => 'AUA', 'city' => 'Oranjestad', 'country' => 'Aruba', 'lat' => 12.5014, 'lon' => -70.0152],
    ['code' => 'CUR', 'city' => 'Willemstad', 'country' => 'Curaçao', 'lat' => 12.1889, 'lon' => -68.9598],
    // -----------------------------------------------------------------------------
    // The following airports have been added to ensure that every ISO‑3166 country
    // defined in $COUNTRIES has at least one representative airport.  These
    // entries use widely‑recognised IATA codes and approximate coordinates.
    // Some microstates without commercial airports are associated with their
    // closest functional fields (e.g. Andorra via La Seu d'Urgell in Spain,
    // Liechtenstein via Altenrhein) to provide a sensible search option.
    ['code' => 'TIA', 'city' => 'Tirana', 'country' => 'Albania', 'lat' => 41.4147, 'lon' => 19.7206],
    // Andorra is served via the nearby La Seu d'Urgell airfield; apostrophe removed to avoid PHP escape issues
    ['code' => 'LEU', 'city' => 'La Seu dUrgell', 'country' => 'Andorra', 'lat' => 42.3394, 'lon' => 1.4092],
    ['code' => 'LAD', 'city' => 'Luanda', 'country' => 'Angola', 'lat' => -8.8584, 'lon' => 13.2312],
    // Antigua and Barbuda uses V.C. Bird International Airport near St Johns (no apostrophe)
    ['code' => 'ANU', 'city' => 'St Johns', 'country' => 'Antigua and Barbuda', 'lat' => 17.1367, 'lon' => -61.7927],
    ['code' => 'VIE', 'city' => 'Vienna', 'country' => 'Austria', 'lat' => 48.1103, 'lon' => 16.5697],
    ['code' => 'NAS', 'city' => 'Nassau', 'country' => 'Bahamas', 'lat' => 25.0380, 'lon' => -77.4663],
    ['code' => 'BGI', 'city' => 'Bridgetown', 'country' => 'Barbados', 'lat' => 13.0746, 'lon' => -59.4925],
    ['code' => 'BZE', 'city' => 'Belize City', 'country' => 'Belize', 'lat' => 17.5392, 'lon' => -88.3082],
    ['code' => 'COO', 'city' => 'Cotonou', 'country' => 'Benin', 'lat' => 6.3576, 'lon' => 2.3844],
    ['code' => 'VVI', 'city' => 'Santa Cruz', 'country' => 'Bolivia', 'lat' => -17.6448, 'lon' => -63.1354],
    ['code' => 'GBE', 'city' => 'Gaborone', 'country' => 'Botswana', 'lat' => -24.5552, 'lon' => 25.9182],
    ['code' => 'BWN', 'city' => 'Bandar Seri Begawan', 'country' => 'Brunei', 'lat' => 4.9442, 'lon' => 114.9283],
    ['code' => 'OUA', 'city' => 'Ouagadougou', 'country' => 'Burkina Faso', 'lat' => 12.3532, 'lon' => -1.5125],
    ['code' => 'BJM', 'city' => 'Bujumbura', 'country' => 'Burundi', 'lat' => -3.3240, 'lon' => 29.3185],
    ['code' => 'RAI', 'city' => 'Praia', 'country' => 'Cabo Verde', 'lat' => 14.9246, 'lon' => -23.4935],
    ['code' => 'BGF', 'city' => 'Bangui', 'country' => 'Central African Republic', 'lat' => 4.3985, 'lon' => 18.5182],
    ['code' => 'NDJ', 'city' => 'Ndjamena', 'country' => 'Chad', 'lat' => 12.1337, 'lon' => 15.0340],
    ['code' => 'HAH', 'city' => 'Moroni', 'country' => 'Comoros', 'lat' => -11.5475, 'lon' => 43.2713],
    ['code' => 'BZV', 'city' => 'Brazzaville', 'country' => 'Congo', 'lat' => -4.2517, 'lon' => 15.2530],
    ['code' => 'FIH', 'city' => 'Kinshasa', 'country' => 'Congo (DRC)', 'lat' => -4.3850, 'lon' => 15.4446],
    ['code' => 'SJO', 'city' => 'San José', 'country' => 'Costa Rica', 'lat' => 9.9939, 'lon' => -84.2086],
    ['code' => 'PRG', 'city' => 'Prague', 'country' => 'Czechia', 'lat' => 50.1008, 'lon' => 14.2565],
    ['code' => 'JIB', 'city' => 'Djibouti', 'country' => 'Djibouti', 'lat' => 11.5475, 'lon' => 43.1595],
    ['code' => 'DOM', 'city' => 'Dominica (Douglas–Charles)', 'country' => 'Dominica', 'lat' => 15.5470, 'lon' => -61.2998],
    ['code' => 'SDQ', 'city' => 'Santo Domingo', 'country' => 'Dominican Republic', 'lat' => 18.4294, 'lon' => -69.6689],
    ['code' => 'SAL', 'city' => 'San Salvador', 'country' => 'El Salvador', 'lat' => 13.4409, 'lon' => -89.0557],
    ['code' => 'SSG', 'city' => 'Malabo', 'country' => 'Equatorial Guinea', 'lat' => 3.7553, 'lon' => 8.7084],
    ['code' => 'ASM', 'city' => 'Asmara', 'country' => 'Eritrea', 'lat' => 15.2919, 'lon' => 38.9106],
    ['code' => 'MTS', 'city' => 'Manzini', 'country' => 'Eswatini', 'lat' => -26.5283, 'lon' => 31.3078],
    ['code' => 'CDG', 'city' => 'Paris', 'country' => 'France', 'lat' => 49.0097, 'lon' => 2.5479],
    ['code' => 'LBV', 'city' => 'Libreville', 'country' => 'Gabon', 'lat' => 0.4586, 'lon' => 9.4123],
    ['code' => 'BJL', 'city' => 'Banjul', 'country' => 'Gambia', 'lat' => 13.3379, 'lon' => -16.6523],
    ['code' => 'FRA', 'city' => 'Frankfurt', 'country' => 'Germany', 'lat' => 50.0379, 'lon' => 8.5622],
    ['code' => 'MUC', 'city' => 'Munich', 'country' => 'Germany', 'lat' => 48.3537, 'lon' => 11.7750],
    ['code' => 'GND', 'city' => 'Grenada (Maurice Bishop)', 'country' => 'Grenada', 'lat' => 12.0042, 'lon' => -61.7863],
    ['code' => 'GUA', 'city' => 'Guatemala City', 'country' => 'Guatemala', 'lat' => 14.5833, 'lon' => -90.5270],
    ['code' => 'CKY', 'city' => 'Conakry', 'country' => 'Guinea', 'lat' => 9.5769, 'lon' => -13.6120],
    ['code' => 'OXB', 'city' => 'Bissau', 'country' => 'Guinea‑Bissau', 'lat' => 11.8947, 'lon' => -15.6538],
    ['code' => 'GEO', 'city' => 'Georgetown', 'country' => 'Guyana', 'lat' => 6.4986, 'lon' => -58.2541],
    ['code' => 'PAP', 'city' => 'Port-au-Prince', 'country' => 'Haiti', 'lat' => 18.5790, 'lon' => -72.2926],
    ['code' => 'TGU', 'city' => 'Tegucigalpa', 'country' => 'Honduras', 'lat' => 14.0608, 'lon' => -87.2172],
    ['code' => 'BGW', 'city' => 'Baghdad', 'country' => 'Iraq', 'lat' => 33.2625, 'lon' => 44.2346],
    ['code' => 'MBJ', 'city' => 'Montego Bay', 'country' => 'Jamaica', 'lat' => 18.5017, 'lon' => -77.9130],
    ['code' => 'TRW', 'city' => 'Tarawa', 'country' => 'Kiribati', 'lat' => 1.3818, 'lon' => 173.1474],
    ['code' => 'FNJ', 'city' => 'Pyongyang', 'country' => 'Korea (North)', 'lat' => 39.2241, 'lon' => 125.6705],
    ['code' => 'ICN', 'city' => 'Seoul (Incheon)', 'country' => 'Korea (South)', 'lat' => 37.4602, 'lon' => 126.4407],
    ['code' => 'MSU', 'city' => 'Maseru', 'country' => 'Lesotho', 'lat' => -29.4623, 'lon' => 27.5510],
    ['code' => 'ROB', 'city' => 'Monrovia', 'country' => 'Liberia', 'lat' => 6.2338, 'lon' => -10.3589],
    ['code' => 'ACH', 'city' => 'Altenrhein', 'country' => 'Liechtenstein', 'lat' => 47.4889, 'lon' => 9.5533],
    ['code' => 'TNR', 'city' => 'Antananarivo', 'country' => 'Madagascar', 'lat' => -18.7960, 'lon' => 47.4780],
    ['code' => 'LLW', 'city' => 'Lilongwe', 'country' => 'Malawi', 'lat' => -13.7894, 'lon' => 33.7810],
    ['code' => 'BKO', 'city' => 'Bamako', 'country' => 'Mali', 'lat' => 12.5417, 'lon' => -7.9444],
    ['code' => 'MLA', 'city' => 'Luqa', 'country' => 'Malta', 'lat' => 35.8575, 'lon' => 14.4775],
    ['code' => 'MAJ', 'city' => 'Majuro', 'country' => 'Marshall Islands', 'lat' => 7.0648, 'lon' => 171.2727],
    ['code' => 'NKC', 'city' => 'Nouakchott', 'country' => 'Mauritania', 'lat' => 18.0974, 'lon' => -15.9445],
    ['code' => 'PNI', 'city' => 'Pohnpei', 'country' => 'Micronesia', 'lat' => 6.9851, 'lon' => 158.2094],
    ['code' => 'KIV', 'city' => 'Chisinau', 'country' => 'Moldova', 'lat' => 46.9289, 'lon' => 28.9306],
    ['code' => 'MCM', 'city' => 'Monaco (Heliport)', 'country' => 'Monaco', 'lat' => 43.7277, 'lon' => 7.4187],
    ['code' => 'ULN', 'city' => 'Ulaanbaatar', 'country' => 'Mongolia', 'lat' => 47.8431, 'lon' => 106.7663],
    ['code' => 'TGD', 'city' => 'Podgorica', 'country' => 'Montenegro', 'lat' => 42.3594, 'lon' => 19.2519],
    ['code' => 'MPM', 'city' => 'Maputo', 'country' => 'Mozambique', 'lat' => -25.9208, 'lon' => 32.5725],
    ['code' => 'WDH', 'city' => 'Windhoek', 'country' => 'Namibia', 'lat' => -22.4799, 'lon' => 17.4709],
    ['code' => 'INU', 'city' => 'Yaren', 'country' => 'Nauru', 'lat' => -0.5470, 'lon' => 166.9190],
    ['code' => 'AMS', 'city' => 'Amsterdam', 'country' => 'Netherlands', 'lat' => 52.3105, 'lon' => 4.7683],
    ['code' => 'MGA', 'city' => 'Managua', 'country' => 'Nicaragua', 'lat' => 12.1415, 'lon' => -86.1693],
    ['code' => 'NIM', 'city' => 'Niamey', 'country' => 'Niger', 'lat' => 13.4823, 'lon' => 2.1836],
    ['code' => 'SKP', 'city' => 'Skopje', 'country' => 'North Macedonia', 'lat' => 41.9611, 'lon' => 21.6214],
    ['code' => 'MCT', 'city' => 'Muscat', 'country' => 'Oman', 'lat' => 23.5880, 'lon' => 58.3759],
    ['code' => 'ROR', 'city' => 'Koror', 'country' => 'Palau', 'lat' => 7.3673, 'lon' => 134.5443],
    ['code' => 'PTY', 'city' => 'Panama City', 'country' => 'Panama', 'lat' => 9.0667, 'lon' => -79.3878],
    ['code' => 'POM', 'city' => 'Port Moresby', 'country' => 'Papua New Guinea', 'lat' => -9.4438, 'lon' => 147.2200],
    ['code' => 'ASU', 'city' => 'Asunción', 'country' => 'Paraguay', 'lat' => -25.2415, 'lon' => -57.5196],
    ['code' => 'LIS', 'city' => 'Lisbon', 'country' => 'Portugal', 'lat' => 38.7742, 'lon' => -9.1364],
    ['code' => 'KGL', 'city' => 'Kigali', 'country' => 'Rwanda', 'lat' => -1.9686, 'lon' => 30.1395],
    ['code' => 'SKB', 'city' => 'Basseterre', 'country' => 'Saint Kitts and Nevis', 'lat' => 17.3095, 'lon' => -62.7184],
    ['code' => 'UVF', 'city' => 'Vieux Fort', 'country' => 'Saint Lucia', 'lat' => 13.7332, 'lon' => -60.9560],
    ['code' => 'SVD', 'city' => 'Kingstown', 'country' => 'Saint Vincent and the Grenadines', 'lat' => 13.1567, 'lon' => -61.1490],
    ['code' => 'APW', 'city' => 'Apia', 'country' => 'Samoa', 'lat' => -13.8293, 'lon' => -172.0083],
    ['code' => 'RMI', 'city' => 'Rimini (San Marino)', 'country' => 'San Marino', 'lat' => 44.0229, 'lon' => 12.6123],
    ['code' => 'TMS', 'city' => 'São Tomé', 'country' => 'Sao Tome and Principe', 'lat' => 0.3782, 'lon' => 6.7123],
    ['code' => 'JED', 'city' => 'Jeddah', 'country' => 'Saudi Arabia', 'lat' => 21.6702, 'lon' => 39.1528],
    ['code' => 'RUH', 'city' => 'Riyadh', 'country' => 'Saudi Arabia', 'lat' => 24.9576, 'lon' => 46.6988],
    ['code' => 'MED', 'city' => 'Medina', 'country' => 'Saudi Arabia', 'lat' => 24.5534, 'lon' => 39.7051],
    ['code' => 'FNA', 'city' => 'Freetown', 'country' => 'Sierra Leone', 'lat' => 8.6179, 'lon' => -13.1950],
    ['code' => 'SIN', 'city' => 'Singapore', 'country' => 'Singapore', 'lat' => 1.3644, 'lon' => 103.9915],
    ['code' => 'HIR', 'city' => 'Honiara', 'country' => 'Solomon Islands', 'lat' => -9.4280, 'lon' => 160.0541],
    ['code' => 'MGQ', 'city' => 'Mogadishu', 'country' => 'Somalia', 'lat' => 2.0144, 'lon' => 45.3048],
    ['code' => 'JUB', 'city' => 'Juba', 'country' => 'South Sudan', 'lat' => 4.8720, 'lon' => 31.6011],
    ['code' => 'CMB', 'city' => 'Colombo', 'country' => 'Sri Lanka', 'lat' => 7.1739, 'lon' => 79.8841],
    ['code' => 'KRT', 'city' => 'Khartoum', 'country' => 'Sudan', 'lat' => 15.5895, 'lon' => 32.5532],
    ['code' => 'PBM', 'city' => 'Paramaribo', 'country' => 'Suriname', 'lat' => 5.4528, 'lon' => -55.1878],
    ['code' => 'DAM', 'city' => 'Damascus', 'country' => 'Syria', 'lat' => 33.4116, 'lon' => 36.5156],
    ['code' => 'DYU', 'city' => 'Dushanbe', 'country' => 'Tajikistan', 'lat' => 38.5433, 'lon' => 68.8260],
    ['code' => 'DIL', 'city' => 'Dili', 'country' => 'Timor‑Leste', 'lat' => -8.5464, 'lon' => 125.5228],
    ['code' => 'LFW', 'city' => 'Lomé', 'country' => 'Togo', 'lat' => 6.1659, 'lon' => 1.2553],
    ['code' => 'TBU', 'city' => 'Nukualofa', 'country' => 'Tonga', 'lat' => -21.2412, 'lon' => -175.1496],
    ['code' => 'POS', 'city' => 'Port of Spain', 'country' => 'Trinidad and Tobago', 'lat' => 10.5954, 'lon' => -61.3372],
    ['code' => 'IST', 'city' => 'Istanbul', 'country' => 'Türkiye', 'lat' => 41.2753, 'lon' => 28.7519],
    ['code' => 'ASB', 'city' => 'Ashgabat', 'country' => 'Turkmenistan', 'lat' => 37.9869, 'lon' => 58.3600],
    ['code' => 'FUN', 'city' => 'Funafuti', 'country' => 'Tuvalu', 'lat' => -8.5243, 'lon' => 179.1962],
    ['code' => 'EBB', 'city' => 'Entebbe', 'country' => 'Uganda', 'lat' => 0.0423, 'lon' => 32.4435],
    ['code' => 'DXB', 'city' => 'Dubai', 'country' => 'United Arab Emirates', 'lat' => 25.2532, 'lon' => 55.3657],
    ['code' => 'JFK', 'city' => 'New York', 'country' => 'United States', 'lat' => 40.6413, 'lon' => -73.7781],
    ['code' => 'MVD', 'city' => 'Montevideo', 'country' => 'Uruguay', 'lat' => -34.8384, 'lon' => -56.0308],
    ['code' => 'VLI', 'city' => 'Port Vila', 'country' => 'Vanuatu', 'lat' => -17.6999, 'lon' => 168.3200],
    ['code' => 'VTN', 'city' => 'Vatican City', 'country' => 'Vatican City', 'lat' => 41.9029, 'lon' => 12.4534],
    ['code' => 'CCS', 'city' => 'Caracas', 'country' => 'Venezuela', 'lat' => 10.6031, 'lon' => -66.9912],
    ['code' => 'SAH', 'city' => 'Sanaa', 'country' => 'Yemen', 'lat' => 15.3694, 'lon' => 44.1944],
    ['code' => 'LUN', 'city' => 'Lusaka', 'country' => 'Zambia', 'lat' => -15.3308, 'lon' => 28.4528],
    ['code' => 'HRE', 'city' => 'Harare', 'country' => 'Zimbabwe', 'lat' => -17.9390, 'lon' => 31.0928],
];

// Ensure availability inside functions that declare `global $AIRPORTS`
$GLOBALS['AIRPORTS'] = $AIRPORTS;

// Airlines with quality factors (affects price) and hubs for connecting flights.
$AIRLINES = [
    ['name' => 'Etihad Airways',       'code' => 'EY', 'quality' => 1.25, 'hubs' => ['AUH']],
    ['name' => 'Qatar Airways',        'code' => 'QR', 'quality' => 1.30, 'hubs' => ['DOH']],
    ['name' => 'Emirates',             'code' => 'EK', 'quality' => 1.35, 'hubs' => ['DXB']],
    ['name' => 'Turkish Airlines',     'code' => 'TK', 'quality' => 1.10, 'hubs' => ['IST']],
    ['name' => 'Saudi Arabian Airlines','code' => 'SV','quality' => 1.05, 'hubs' => ['JED','RUH']],
    ['name' => 'Malaysia Airlines',    'code' => 'MH', 'quality' => 1.00, 'hubs' => ['KUL']],
];

// Ensure availability inside functions that declare `global $AIRLINES`
$GLOBALS['AIRLINES'] = $AIRLINES;

// Multipliers for different cabin classes.
$CLASSES = [
    // Updated cabin multipliers: higher premiums for upper classes
    'economy'         => 1.00,
    'premium'         => 1.60,
    'business'        => 2.75,
    'first'           => 4.20,
];

// Ensure availability inside functions that declare `global $CLASSES`
$GLOBALS['CLASSES'] = $CLASSES;

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

// Ensure availability inside functions that declare `global $MONTH_PRICE_BANDS`
$GLOBALS['MONTH_PRICE_BANDS'] = $MONTH_PRICE_BANDS;

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

    // Limit to top 12 results
    return array_slice($results, 0, 12);
}

// Extract and sanitize query parameters from the request (GET).
// Accept only 3-letter alphabetic codes for airports.
function sanitizeIata($str) {
    return strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $str), 0, 3));
}

function getParam(array $keys, $default = null) {
    foreach ($keys as $key) {
        if (isset($_GET[$key]) && $_GET[$key] !== '') {
            return $_GET[$key];
        }
    }
    return $default;
}

$_GET['mode']      = strtolower(getParam(['mode', 'flight_type'], 'round')) === 'oneway' ? 'oneway' : 'round';
$_GET['from']      = sanitizeIata(getParam(['from', 'dept_arpt'], ''));
$_GET['to']        = sanitizeIata(getParam(['to', 'dest_arpt'], ''));
$_GET['depart']    = getParam(['depart', 'departure_date'], '');
$_GET['return']    = getParam(['return', 'return_date'], '');
$_GET['class']     = strtolower(getParam(['class', 'cabin_class'], 'economy'));
$_GET['airline']   = strtoupper(preg_replace('/[^A-Za-z]/', '', getParam(['airline', 'airline'], '')));
$_GET['adults']    = max(1, intval(getParam(['adults', 'padults'], 1)));
$_GET['children']  = max(0, intval(getParam(['children', 'pchildren'], 0)));
$_GET['infants']   = max(0, intval(getParam(['infants', 'pinfants'], 0)));
$_GET['c_name']    = getParam(['c_name'], '');
$_GET['c_email']   = getParam(['c_email'], '');
$_GET['c_phone']   = getParam(['c_phone'], '');

// Read basic search parameters
$mode      = isset($_GET['mode']) && $_GET['mode'] === 'oneway' ? 'oneway' : 'round';
$fromCode  = isset($_GET['from']) ? sanitizeIata($_GET['from']) : '';
$toCode    = isset($_GET['to'])   ? sanitizeIata($_GET['to'])   : '';
$depart    = isset($_GET['depart']) ? date('Y-m-d', strtotime($_GET['depart'])) : '';
$return    = isset($_GET['return']) ? date('Y-m-d', strtotime($_GET['return'])) : '';
$classKey  = isset($_GET['class']) ? $_GET['class'] : 'economy';
// Additional fields for refined search
$airlineCode = isset($_GET['airline']) ? strtoupper(preg_replace('/[^A-Za-z]/', '', $_GET['airline'])) : '';
$adults   = isset($_GET['adults']) ? max(1, intval($_GET['adults'])) : 1;
$children = isset($_GET['children']) ? max(0, intval($_GET['children'])) : 0;
$infants  = isset($_GET['infants']) ? max(0, intval($_GET['infants'])) : 0;

$results = [];
if ($fromCode && $toCode && $depart) {
    // Only generate if departure and airports provided
    $results = generateFlightResults($fromCode, $toCode, $depart, ($mode === 'oneway' ? null : $return), $classKey, $airlineCode);

    // Apply passenger count multipliers to price: adults weigh 1.0, children 0.75, infants 0.10
    // Standard passenger multipliers: 100% adult, 75% child, 10% infant (lap).
    $passengerMultiplier = ($adults * 1.00) + ($children * 0.75) + ($infants * 0.10);
    foreach ($results as &$res) {
        // Compute the adjusted price with passenger multiplier
        $adjusted = round($res['price'] * $passengerMultiplier);
        // Determine the departure date for this result to look up min and max band
        $dateStr = '';
        if (isset($res['outbound']['segments'][0]['depart'])) {
            $dateStr = substr($res['outbound']['segments'][0]['depart'], 0, 10);
        } elseif (isset($res['segments'][0]['depart'])) {
            // Fallback for single segment arrays
            $dateStr = substr($res['segments'][0]['depart'], 0, 10);
        }
        $month = $dateStr ? (int) date('n', strtotime($dateStr)) : 0;
        // Look up monthly band; default if missing
        [$minBand, $maxBand] = $MONTH_PRICE_BANDS[$month] ?? [500, 700];
        // Scale the band by passenger multiplier
        $scaledMin = $minBand * $passengerMultiplier;
        $scaledMax = $maxBand * $passengerMultiplier;
        // Clamp the adjusted price within the scaled band to strictly follow MONTH_PRICE_BANDS
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
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7fafc;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            display: flex;
            gap: 16px;
            padding: 20px;
        }
        .sidebar {
            width: 260px;
            background: #fff;
            border: 1px solid #ddd;
            padding: 16px;
            border-radius: 4px;
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
        input[type="text"], input[type="date"], select {
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
            padding: 14px;
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
        .price {
            font-size: 22px;
            font-weight: bold;
            color: #2b6cb0;
            line-height: 1.2;
        }
    </style>
    <script>
    // Auto uppercase and filter suggestions for IATA input fields.
    function setupIataInput(id) {
        var input = document.getElementById(id);
        input.addEventListener('input', function() {
            this.value = this.value.toUpperCase().replace(/[^A-Z]/g, '').slice(0,3);
        });
    }
    document.addEventListener('DOMContentLoaded', function() {
        setupIataInput('from');
        setupIataInput('to');
        // Class tabs removed; class selection is now via dropdown.
        var classSelect = document.getElementById('class');
        if (classSelect) {
            classSelect.addEventListener('change', function() {
                document.getElementById('flightForm').submit();
            });
        }
        // Toggle return date field
        var modeRadios = document.querySelectorAll('[name="mode"]');
        modeRadios.forEach(function(radio) {
            radio.addEventListener('change', function() {
                document.getElementById('flightForm').submit();
            });
        });
    });
    </script>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>Refine Your Results</h2>
            <form id="flightForm" method="get" action="<?php echo base_url('flight/resultsnew') ;?>">
                <div class="form-group">
                    <label>Trip Type</label>
                    <label><input type="radio" name="mode" value="round" <?php echo $mode==='oneway'?'':'checked'; ?>> Round Trip</label><br>
                    <label><input type="radio" name="mode" value="oneway" <?php echo $mode==='oneway'?'checked':''; ?>> One Way</label>
                </div>
                <div class="form-group">
                    <label for="from">Flying From</label>
                    <input list="iataList" id="from" name="from" required pattern="[A-Za-z]{3}" value="<?php echo htmlspecialchars($fromCode); ?>">
                </div>
                <div class="form-group">
                    <label for="to">Flying To</label>
                    <input list="iataList" id="to" name="to" required pattern="[A-Za-z]{3}" value="<?php echo htmlspecialchars($toCode); ?>">
                </div>
                <datalist id="iataList">
                    <?php // Populate airports first. ?>
                    <?php foreach ($AIRPORTS as $apt): ?>
                        <option value="<?php echo htmlspecialchars($apt['code']); ?>">
                            <?php echo htmlspecialchars($apt['code'] . ' - ' . $apt['city'] . ', ' . $apt['country']); ?>
                        </option>
                    <?php endforeach; ?>
                    <?php // Then list all countries so users can search by country code as a hint. ?>
                    <?php foreach ($COUNTRIES as $ct): ?>
                        <option value="<?php echo htmlspecialchars($ct['code']); ?>">
                            <?php echo htmlspecialchars($ct['code'] . ' - ' . $ct['name'] . ' (country)'); ?>
                        </option>
                    <?php endforeach; ?>
                </datalist>
                <div class="form-group">
                    <label for="depart">Departure Date</label>
                    <input type="date" id="depart" name="depart" required value="<?php echo htmlspecialchars($depart); ?>">
                </div>
                <?php if ($mode !== 'oneway'): ?>
                <div class="form-group">
                    <label for="return">Return Date</label>
                    <input type="date" id="return" name="return" required value="<?php echo htmlspecialchars($return); ?>">
                </div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="airline">Preferred Airline</label>
                    <select id="airline" name="airline">
                        <option value="">All Airlines</option>
                        <?php foreach ($AIRLINES as $al): ?>
                            <option value="<?php echo htmlspecialchars($al['code']); ?>" <?php echo ($airlineCode && strcasecmp($airlineCode,$al['code'])==0) ? 'selected' : ''; ?>><?php echo htmlspecialchars($al['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="adults">Adults</label>
                    <select id="adults" name="adults">
                        <?php for ($i=1; $i<=9; $i++): ?>
                            <option value="<?php echo $i; ?>" <?php echo ($adults==$i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="children">Children</label>
                    <select id="children" name="children">
                        <?php for ($i=0; $i<=5; $i++): ?>
                            <option value="<?php echo $i; ?>" <?php echo ($children==$i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="infants">Infants</label>
                    <select id="infants" name="infants">
                        <?php for ($i=0; $i<=4; $i++): ?>
                            <option value="<?php echo $i; ?>" <?php echo ($infants==$i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="class">Class</label>
                    <select id="class" name="class">
                        <?php foreach ($CLASSES as $key => $mult): ?>
                            <option value="<?php echo htmlspecialchars($key); ?>" <?php echo ($classKey === $key) ? 'selected' : ''; ?>><?php echo htmlspecialchars(ucwords(str_replace('_',' ', $key))); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit">Search Flights</button>
                </div>
            </form>
            <div class="form-group">
                <p>Need help? Call us for unpublished fares.</p>
                <strong>+44 207 123 4567</strong>
            </div>
        </div>
        <div class="content">
            <h2>Available Flights</h2>
            <?php if ($results): ?>
                <?php foreach ($results as $res): ?>
                    <div class="flight-card">
                        <h3><?php echo htmlspecialchars($res['airline']); ?> - <?php echo htmlspecialchars($res['class']); ?></h3>
                        <div class="segments">
                            <?php
                            // Outbound segments
                            foreach ($res['outbound']['segments'] as $seg) {
                                echo '<div class="segment">';
                                echo '<div>'.htmlspecialchars($seg['from']).' → '.htmlspecialchars($seg['to']).'</div>';
                                echo '<div>'.htmlspecialchars(date('H:i', strtotime($seg['depart']))).' - '.htmlspecialchars(date('H:i', strtotime($seg['arrive']))).'</div>';
                                echo '</div>';
                            }
                            if ($res['inbound']) {
                                echo '<strong>Return:</strong>';
                                foreach ($res['inbound']['segments'] as $seg) {
                                    echo '<div class="segment">';
                                    echo '<div>'.htmlspecialchars($seg['from']).' → '.htmlspecialchars($seg['to']).'</div>';
                                    echo '<div>'.htmlspecialchars(date('H:i', strtotime($seg['depart']))).' - '.htmlspecialchars(date('H:i', strtotime($seg['arrive']))).'</div>';
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
                                <em>Total duration:</em> <?php echo htmlspecialchars(formatDuration($res['totalDuration'])); ?><br>
                                <em>Stops:</em> <?php echo htmlspecialchars($stopsInfo); ?>
                            </div>
                            <div class="price">£ <?php echo htmlspecialchars(number_format($res['price'], 0)); ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No flights found. Please adjust your search criteria.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>