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
				<div class="row bg-home" style="background-image: url(<?php echo base_url('assets/image/continent/'.strtolower(str_replace(' ','-',$continent)).'-lg.jpg?v0.1') ; ?>) !important;">
					<div class="col-lg-6 bg-secondary">
						<section class="flight-search ptb-50 pl-50 pr-20">
							<p class="mb-0 search-heading-1">Book Your Journey With Us</p>
							<h1 class="mt-0 mb-30 search-heading-2">Find Perfect Trip</h1>
							<form class="searchform" action="<?php echo base_url('flight/results') ;?>" method="get">
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
										<h3>The <?php echo ucfirst($continent);?></h3>
										<p>A land of staggering natural beauty and cultural complexities, <br>of dynamic megacities and hill-tribe villages.</p>											
									</div>
								</div>
							</div>
						</section>
					</div>
				</div>
			</div>
		</div>
		<?php if(isset($countries) && count($countries) > 0){?>
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
                </aside>
                <div id="content" class="col-md-9 col-sm-4 col-xs-12 mb-0">
                    <h2 style="font-size:27px;font-weight:bold;letter-spacing:1px;text-transform: capitalize;">Cheap Flights To <?php echo $continent; ?></h2>
                    <div class="products-category">
                        <div class="section-style4 products-list grid row number-col-3 so-filter-gird">
                            <?php
                                foreach ($countries as $key => $country) {
                                    $dest = getdestbycountry($country['airport_country']);
                                    $dest_slug = str_replace(' ','-',$dest);
                            ?>
                            <div class="product-layout col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="product-item-container item">
                                    <div class="item-block so-quickview">
                                        <div class="image">
                                            <img src="<?php echo base_url('assets/image/flags/'.strtolower($country['airport_country_code']).'.svg') ;?>" alt="<?php echo $country['airport_country'] ; ?>" title="<?php echo $country['airport_country'] ; ?>" class="img-responsive">
                                        </div>
                                        <div class="item-content clearfix" style="padding: 10px 20px;">
                                            <h5 title="<?php echo $country['airport_country'] ; ?>" ><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo custom_substr($country['airport_country'],13) ; ?></h5>
                                            <div class="item-bot clearfix">
                                                <div class="price pull-left">
                                                    <a href="<?php echo base_url('fly-to-'.$dest_slug) ;?>" ><strong class="text-danger"><?php echo 'Fly To '.$dest ;?></strong></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
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