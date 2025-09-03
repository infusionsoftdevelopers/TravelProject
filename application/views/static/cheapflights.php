<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $meta_title; ?></title>
	<meta charset="utf-8">
	<meta name="keywords" content="<?php echo $meta_key; ?>" />
	<meta name="description" content="<?php echo $meta_desc; ?>" />
	<meta name="author" content="<?php echo $this->web_title; ?>">
	<meta name="robots" content="index, follow" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?php $this->load->view('common/css'); ?>
</head>
<body class="common-home res layout-1">
	<div id="wrapper" class="wrapper-fluid banners-effect-10">
		<?php
            $head_data['page'] = 'cheapflights'; 
            $this->load->view('common/header',$head_data); 
        ?>
        <div id="content" class="mb-0">
			<div class="so-page-builder">
				<div class="row bg-home" style="background-image: url(<?php echo base_url('assets/image/cheap-flight.jpg?v0.1') ; ?>) !important;">
					<div class="col-lg-6 bg-secondary">
						<section class="flight-search ptb-50 pl-50 pr-20">
							<p class="mb-0 search-heading-1">Book Your Journey With Us</p>
							<h1 class="mt-0 mb-30 search-heading-2">Find Perfect Trip</h1>
							<form class="searchform" action="<?php echo site_url(); ?>search/flights.php" <?php //echo base_url('flight/resultsnew') ;?>" method="get">
                                <input type="hidden" name="direct_flights" value="No">
								<div class="row">
									<div class="col-lg-12 mb-10">
										<label class="text-white fs-16" for="flight_type1"><input class="flighttype" value="Return" type="radio" name="flight_type" id="flight_type1" checked> Return</label>
										<label class="text-white fs-16" for="flight_type2"><input class="flighttype" value="Oneway" type="radio" name="flight_type" id="flight_type2"> One-way</label>
									</div>
									<div class="col-xs-6">
										<div class="form-group">
											<div class="input-group">
												<input type="text" name="dept_arpt" class="form-control arpt" placeholder="Enter Departure Airport..." required value="London - LON">
												<div class="input-group-addon"><i class="fa fa-plane"></i></div>
											</div>
										</div>
									</div>
									<div class="col-xs-6">
										<div class="form-group">
											<div class="input-group">
												<input type="text" name="dest_arpt" class="form-control arpt" placeholder="Enter Destination Airport..." value="<?php echo @$destination_airport ; ?>" required>
												<div class="input-group-addon"><i class="fa fa-plane fa-rotate-90"></i></div>
											</div>
										</div>
									</div>
									<div class="col-lg-4 col-xs-6">
										<div class="form-group">
											<div class="input-group">
												<input type="text" name="departure_date" class="form-control departure_date" placeholder="Enter Departure Date..." required value="<?php echo date('d-M-Y') ; ?>">
												<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
											</div>
										</div>
									</div>
									<div class="col-lg-4 col-xs-6 return-date-selection">
										<div class="form-group">
											<div class="input-group">
												<input type="text" name="return_date" class="form-control return_date" placeholder="Enter Return Date..." required>
												<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
											</div>
										</div>
									</div>
                                    <input type="hidden" name="page" value="landing">
									<div class="col-lg-4 col-xs-6">
										<div class="form-group">
											<div class="input-group">
												<select class="form-control" name="cabin_class" data-parsley-error-message="required" data-parsley-trigger="focusin focusout" required>
													<option value="Economy" selected>Economy</option>
													<option value="Premium Economy">Premium</option>
													<option value="Business Class">Business</option>
													<option value="First Class">First Class</option>
												</select>
												<div class="input-group-addon"><i class="fa fa-suitcase"></i></div>
											</div>
										</div>
									</div>
									<div class="col-lg-6 col-xs-6">
										<div class="form-group">
											<div class="input-group">
												<select class="form-control" name="airline" required>
													<option value="All Airlines">All Airlines</option>
													<?php foreach ($airlines as $key => $row) { ?>
														<option value="<?php echo $row['airline']; ?>"><?php echo $row['airline']; ?></option>
													<?php } ?>
												</select>
												<div class="input-group-addon"><i class="fa fa-paper-plane"></i></div>
											</div>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="row">
											<div class="col-xs-4">
												<div class="form-group">
													<div class="input-group">
														<select class="form-control" name="padults" required>
															<?php
                                                            $opt =  10;
                                                            for ($i = 1; $i <= $opt; $i++) {
                                                            ?>
                                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                            <?php
                                                            }
                                                            ?>
														</select>
														<div class="input-group-addon"><i class="fa fa-user"></i></div>
													</div>
												</div>
											</div>
											<div class="col-xs-4">
												<div class="form-group">
													<div class="input-group">
														<select class="form-control" name="pchildren">
															<?php
                                                            $opt =  10;
                                                            for ($i = 0; $i <= $opt; $i++) {
                                                            ?>
                                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                            <?php
                                                            }
                                                            ?>
														</select>
														<div class="input-group-addon"><i class="fa fa-user"></i></div>
													</div>
												</div>
											</div>
											<div class="col-xs-4">
												<div class="form-group">
													<div class="input-group">
														<select class="form-control" name="pinfants">
															<?php
                                                            $opt =  10;
                                                            for ($i = 0; $i <= $opt; $i++) {
                                                            ?>
                                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                            <?php
                                                            }
                                                            ?>
														</select>
														<div class="input-group-addon"><i class="fa fa-user"></i></div>
													</div>
												</div>
											</div>
										</div>
									</div>
                                    <div class="col-lg-4 col-xs-6">
										<div class="form-group">
                                            <div class="input-group">
											    <input type="text" name="c_name" class="form-control" placeholder="Enter Your Name..." required>
                                                <div class="input-group-addon"><i class="fa fa-id-card"></i></div>
                                            </div>
										</div>
									</div>
                                    <div class="col-lg-4 col-xs-6">
										<div class="form-group">
                                            <div class="input-group">
											    <input type="email" name="c_email" class="form-control" placeholder="Enter Your email..." required>
                                                <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                                            </div>
										</div>
									</div>
                                    <div class="col-lg-4 col-xs-6">
										<div class="form-group">
                                            <div class="input-group">
											    <input type="tel" name="c_phone" class="form-control" placeholder="Enter Your Phone#..." required>
                                                <div class="input-group-addon"><i class="fa fa-mobile"></i></div>
                                            </div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<button type="submit" class="btn btn-primary btn-search"><i class="fa fa-search"></i>Search Now</button>
									</div>
								</div>
							</form>
						</section>
					</div>
					<div class="col-lg-6 text-center hidden-xs hidden-sm hidden-md">
						<section class="ptb-80 module sohomepage-slider">
							<div class="slider-home1">
								<div class="item">
									<div class="info">
										<div class="top">discover</div>
										<h3>The World</h3>
										<p>A land of staggering natural beauty and cultural complexities, <br>of dynamic megacities and hill-tribe villages.</p>											
									</div>
								</div>
							</div>
						</section>
					</div>
				</div>
			</div>
		</div>
		<?php if(isset($destination_airport)){?>
		<div class="container product-detail mt-50">
            <div class="row">
                <aside class="col-md-3 col-sm-4 col-xs-12 content-aside left_column sidebar-offcanvas">
                    <div class="module-ques clearfix">
                        <h3>get a questions</h3>
                        <p>Call or Email us and get all the answers from expersts.</p>
                        <ul>
                            <li><i class="fa fa-phone" aria-hidden="true"></i><?php echo $this->web_phn ; ?></li>
                            <li><i class="fa fa-envelope" aria-hidden="true"></i><?php echo $this->web_email ; ?></li>
                        </ul>
                    </div>
                    <?php if(count($otherairports) > 0){ ?>
                    <div class="module-travel clearfix">
                        <h3>Other UK Airports</h3>
                        <ul>
                            <?php
                                foreach ($otherairports as $key => $deptrow) {
                                    $s_date = date("d-m-Y", strtotime($deptrow['s_date']));
                                    $e_date = date("d-m-Y", strtotime($deptrow['e_date']));
                            ?>
                            <li><a href="tel:<?php echo $this->web_tel ; ?>"><span>Fly From <?php echo $deptrow['f_from']; ?></span><label>fr £ <?php echo $deptrow['price']; ?></label></a></li>
                            <?php } ?>
                        </ul>
                    </div>
					<?php }if(count($popairports) > 0){ ?>
                    <div class="module-travel clearfix">
                        <h3>Popular Destinations</h3>
                        <ul>
                            <?php
                                foreach ($popairports as $key => $otherrow) {
                            ?>
                            <li><a href="tel:<?php echo $this->web_tel ; ?>"><span>Flights To <?php echo $otherrow['f_to']; ?></span><label>fr £ <?php echo $otherrow['price']; ?></label></a></li>
						    <?php } ?>
                        </ul>
                    </div>
                    <?php } ?>
                </aside>
                <div id="content" class="col-md-9 col-sm-12 col-xs-12 mb-0">
                    <a href="javascript:void(0)" class="open-sidebar hidden-lg hidden-md"><i class="fa fa-bars"></i>Sidebar</a>
                    <div class="products-category">
                        <div class="section-style4 products-list list row number-col-3 so-filter-gird mb-0">
                            <h2 style="font-size:27px;font-weight:bold;letter-spacing:1px;text-transform: capitalize;"><?php echo($cabin_class == "Economy")?"Cheap":$cabin_class ; ?> Flights To <?php echo $destination_airport; ?></h2>
                            <?php 
                                unset($repeatcheckarray);
                                $repeatcheckarray = array();
                                $farecnt = 1;
                                if($results && $results != 'No Flights Found'){
                                    $seatsleft = $fltdeparture = $fltdestination = $fltairline = $fltcabin = $outdeptdateDB = $outarvdateDB = $outdatediff = $outdatediff = $outdeptdate = $outdeptdate = $outdepttime = $outdepttime = $outarvdate = $outarvtime = $outarvtime = $indeptdateDB = $inarvdateDB = $indatediff = $indatediff = $indeptdate = $indeptdate = $indepttime = $indepttime = $inarvdate = $inarrvtime = $inarrvtime = $outtime = $odur = $intime = $idur = '';
                                    foreach ($results as $key => $boxfarerow) {
                                        //calculating total price for all passengers
                                        $adultprice = (int)$boxfarerow["f_adultbasic"] + (int)$boxfarerow["f_adulttax"];
                                        $adult_total_price = 0;
                                        $child_total_price = 0;
                                        $infant_total_price = 0;
                                        $adult_total_price = (int)$padults * ((int)$boxfarerow["f_adultbasic"] + (int)$boxfarerow["f_adulttax"] );
                                        if((int)$pchildren > 0){ 
                                            $child_total_price = (int)$pchildren * ((int)$boxfarerow["f_childbasic"] + (int)$boxfarerow["f_childtax"]);
                                        }
                                        if((int)$pinfants > 0){
                                            $infant_total_price = (int)$pinfants * ((int)$boxfarerow["f_infantbasic"] + (int)$boxfarerow["f_infanttax"]);
                                        }
                                        if($boxfarerow['f_seasonstartdate']=="2019-12-11" || $boxfarerow['f_seasonstartdate']=="2020-07-16"){
                                            $adultprice = round(($adultprice - ((int)$adultprice * 15)/100));
                                            $adult_total_price = round(($adult_total_price - ((int)$adult_total_price * 15)/100));
                                            $child_total_price = round(($child_total_price - ((int)$child_total_price * 15)/100));

                                        }elseif($boxfarerow['f_seasonstartdate']=="2019-12-26" || $boxfarerow['f_seasonstartdate']=="2020-03-21"){
                                            $adultprice = round(($adultprice - ((int)$adultprice * 10)/100));
                                            $adult_total_price = round(($adult_total_price - ((int)$adult_total_price * 10)/100));
                                            $child_total_price = round(($child_total_price - ((int)$child_total_price * 10)/100));
                                        }
                                        $ttlprice = (int)$adult_total_price + (int)$child_total_price + (int)$infant_total_price;
                                        ////////////////////////////////////////////

                                        $seatsleft = $boxfarerow["seatsleft"];
                                        $fltdeparture =  $boxfarerow["f_fromcode"];
                                        $fltdestination =  $boxfarerow["f_tocode"];
                                        $fltairline =  $boxfarerow["f_airlinecode"];
                                        $fltcabin = $boxfarerow["f_cabin"];
                                        $outdeptdateDB = strtotime(substr($boxfarerow['outdeptdatetime'],0,10));
                                        $outarvdateDB = strtotime(substr($boxfarerow['outarvdatetime'],0,10));
                                        $outdatediff = $outarvdateDB - $outdeptdateDB;
                                        $outdatediff = (int)$outdatediff / 86400;
                                        $outdeptdate = $departure_date;
                                        $outdeptdate = date("D, M d", strtotime("$outdeptdate"));
                                        $outdepttime = $boxfarerow["outdeptdatetime"];
                                        $outdepttime = strtoupper(date("g:i a", strtotime("$outdepttime")));
                                        $outarvdate = date("D, M d", strtotime("$departure_date +$outdatediff Day"));
                                        $outarvtime = $boxfarerow["outarvdatetime"];
                                        $outarvtime = strtoupper(date("g:i a", strtotime("$outarvtime")));
                                        $indeptdateDB = strtotime(substr($boxfarerow['indeptdatetime'],0,10));
                                        $inarvdateDB = strtotime(substr($boxfarerow['inarvdatetime'],0,10));
                                        $indatediff = $inarvdateDB - $indeptdateDB;
                                        $indatediff = (int)$indatediff / 86400;
                                        $indeptdate = $return_date;
                                        $indeptdate = date("D, M d", strtotime("$indeptdate"));
                                        $indepttime = $boxfarerow["indeptdatetime"];
                                        $indepttime = strtoupper(date("g:i a", strtotime("$indepttime")));
                                        $inarvdate = date("D, M d", strtotime("$return_date +$indatediff Day"));
                                        $inarrvtime = $boxfarerow["inarvdatetime"];
                                        $inarrvtime = strtoupper(date("g:i a", strtotime("$inarrvtime")));
                                        $outtime = $boxfarerow["outduration"];
                                        $odur = (intval($outtime/60)) . "h " . ($outtime -(intval($outtime/60) * 60)) . "m";
                                        $intime = $boxfarerow["induration"];
                                        $idur = (intval($intime/60)) . "h " . ($intime -(intval($intime/60) * 60)) . "m";
                                        if($boxfarerow["outlegscount"] <  2 ){$onostops = 'non-stop'; } 
                                        elseif($boxfarerow["outlegscount"] == 2 ){$onostops = '1 stop'; } 
                                        elseif($boxfarerow["outlegscount"] == 3 ){$onostops = '2 stops'; }
                                        elseif($boxfarerow["outlegscount"] >  3 ){$onostops = '2+ stops'; }
                                        if    ($boxfarerow["inlegscount"] <  2 ){$inostops = 'non-stop'; }
                                        elseif($boxfarerow["inlegscount"] == 2 ){$inostops = '1 stop'; }
                                        elseif($boxfarerow["inlegscount"] == 3 ){$inostops = '2 stops'; }
                                        elseif($boxfarerow["inlegscount"] >  3 ){$inostops = '2+ stops'; }
                                        if(!in_array("$fltairline",$repeatcheckarray)){
											if($farecnt < 4){											
                            ?>
                            <div class="flightdeal p-10">
                                <div class="row">
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 flightdetail">
                                        <div class="row">
                                            <?php 
                                                if($flight_type == "Return"){
                                                    $col = "col-lg-6 col-md-6 col-sm-6 col-xs-12";
                                                }else{
                                                    $col = "col-lg-12 col-md-12 col-sm-12 col-xs-12";
                                                }
                                            ?>
                                            <div class="<?php echo $col ; ?>">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <p class="text-center mar-bottom-5">
                                                            <small>Departure From: <?php echo $boxfarerow["f_from"]; ?></small>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <div class="content flight-details">
                                                            <h2 class="text-right"><?php echo $boxfarerow["f_fromcode"]; ?></h2>
                                                            <h5 class="text-right"><?php echo $outdepttime;?></h5>
                                                            <p class="text-right"><small><?php echo date("D d, M",strtotime($outdeptdate)) ;?></small></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <div class="content flight-details">
                                                            <h6 class="text-center"><small><?php echo $onostops;?><br></small><i class="fa fa-plane"></i><small><br>Fly with:</small><br><img src="<?php echo base_url('assets/image/airlines/'.$boxfarerow["f_airlinecode"].'.gif') ; ?>" alt="<?php echo ($boxfarerow["f_airline"]);?>"><br><small><?php echo ($boxfarerow["f_airline"]);;?></small></h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <div class="content flight-details">
                                                            <h2 class="text-left"><?php echo $boxfarerow["f_tocode"]; ?></h2>
                                                            <h5 class="text-left"><?php echo $outarvtime;?></h5>
                                                            <p class="text-left"><small><?php echo date("D d, M",strtotime($outarvdate));?></small></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php 
                                                if($flight_type == "Return"){
                                            ?>
                                            <div class="<?php echo $col ; ?> bleft">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <p class="text-center mar-bottom-5">
                                                            <small>Departure From: <?php echo $boxfarerow["f_to"]; ?></small>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <div class="content flight-details">
                                                            <h2 class="text-right"><?php echo $boxfarerow["f_tocode"]; ?></h2>
                                                            <h5 class="text-right"><?php echo $indepttime;?></h5>
                                                            <p class="text-right"><small><?php echo date("D d, M",strtotime($indeptdate)) ;?></small></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <div class="content flight-details">
                                                            <h6 class="text-center"><small><?php echo $inostops;?><br></small><i class="fa fa-plane"></i><small><br>Fly with:</small><br><img src="<?php echo base_url('assets/image/airlines/'.$boxfarerow["f_airlinecode"].'.gif') ; ?>" alt="<?php echo $boxfarerow["f_airline"] ?>"><br><small><?php echo $boxfarerow["f_airline"] ?></small></h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <div class="content flight-details">
                                                            <h2 class="text-left"><?php echo $boxfarerow["f_fromcode"]; ?></h2>
                                                            <h5 class="text-left"><?php echo $inarrvtime;?></h5>
                                                            <p class="text-left"><small><?php echo date("D d, M", strtotime($inarvdate)) ;?></small></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 pricedetail">
                                        <div class="item-inner text-center">
                                            <h4 style="line-height: 1;margin-bottom: 0px;"><small>Starting From</small><br><strong style="font-size:40px;">£ <?php echo $adultprice; ?></strong><small> PP</small></h4>
                                            <p class="mb-0"><small>Book it with as low as &pound; 50</small><br><strong><a href="tel:<?php echo $this->web_tel; ?>"><?php echo $this->web_phn; ?></a></strong></p>
                                            <a class="btn btn-primary btn-sm btn-danger" href="tel:<?php echo $this->web_tel; ?>"><i class="fa fa-phone"></i><strong>Call Now</strong></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
											}
											$farecnt++;
                                            if($airline == '' || $airline == 'All Airlines'){
                                                $repeatcheckarray[] = $fltairline;	
                                            }
                                        }
                                    }
                                }else{
                                    echo "<div style='font-size:14px; color:#333'>";
                                    echo 'No Fare Found for your search criteria. Please try again by changing your travelling dates or airports.<br />';
                                    echo "or Call on <span style='color:#C00; font-weight:bold;'>" .$this->web_phn. "</span> for best available option.<br />";
                                    echo '</div>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<?php 
            }  
            $this->load->view('common/whychooseus');
            $this->load->view('common/footer');
        ?>
    </div>
    <?php $this->load->view('common/js'); ?>
</body>
</html>