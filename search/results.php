<title>Flight Search</title>
<?php
// dynamic flight search and booking mock application
ini_set('display_errors', 1);
error_reporting(E_ALL);


include_once __DIR__ . '/airports_data.php';

include_once __DIR__ . '../../../wp-blog-header.php';
require_once __DIR__ . '../../../wp-load.php';



get_header();

require_once __DIR__ . '/flights_algo.php';

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