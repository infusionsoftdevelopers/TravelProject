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
            $head_data['page'] = 'umrah'; 
            $this->load->view('common/header',$head_data); 
        ?>
        <div id="content">
			<div class="so-page-builder">
				<div class="row bg-umrah">
					<div class="col-lg-12 bg-secondary">
						<section class="flight-search ptb-50 pl-50 pr-20">
							<h4 class="mt-0 search-heading-2 text-center">لبيك اللهم لبيك</h4>
							<h1 class="mt-0 mb-30 search-heading-2 text-center">Umrah Packages</h1>							
							<div class="container">							
								<form class="searchform umrah-form" action="<?php echo base_url('thank-you') ;?>" method="post">
									<input type="hidden" name="mail" value="umrah">
									<input type="hidden" name="direct_flights" value="No">
									<div class="row">
										<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
											<div class="form-group">
												<div class="input-group">
													<input type="text" name="dept_arpt" class="form-control arpt" placeholder="Enter Departure Airport..." required value="London - LON">
													<div class="input-group-addon"><i class="fa fa-plane"></i></div>
												</div>
											</div>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
											<div class="form-group">
												<div class="input-group">
													<input type="text" name="dest_arpt" class="form-control arpt" placeholder="Enter Destination Airport..." required value="Jeddah - JED">
													<div class="input-group-addon"><i class="fa fa-plane fa-rotate-90"></i></div>
												</div>
											</div>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
											<div class="form-group">
												<div class="input-group">
													<input type="text" name="departure_date" class="form-control departure_date" placeholder="Enter Departure Date..." required value="<?php echo date('d-M-Y') ; ?>">
													<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
												</div>
											</div>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
											<div class="form-group">
												<div class="input-group">
													<select class="form-control" name="mecca_nights" data-parsley-error-message="required" data-parsley-trigger="focusin focusout" required>
														<option value="">Nights In Mecca</option>
														<?php
															for ($i=1; $i < 20 ; $i++) { 
																if($i==1){
														?>
															<option value="<?php echo $i ; ?>" selected><?php echo $i ; ?> Night</option>
															<?php }else{ ?>
															<option value="<?php echo $i ; ?>"><?php echo $i ; ?> Nights</option>
														<?php	
																}
															}
														?>																
													</select>
													<div class="input-group-addon"><i class="fa fa-moon-o"></i></div>
												</div>
											</div>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
											<div class="form-group">
												<div class="input-group">
													<select class="form-control" name="madina_nights" data-parsley-error-message="required" data-parsley-trigger="focusin focusout" required>
														<option value="">Nights In Medina</option>
														<?php
															for ($i=1; $i < 10 ; $i++) { 
																if($i==1){
														?>
															<option value="<?php echo $i ; ?>" selected><?php echo $i ; ?> Night</option>
															<?php }else{ ?>
															<option value="<?php echo $i ; ?>"><?php echo $i ; ?> Nights</option>
														<?php	
																}
															}
														?>																
													</select>
													<div class="input-group-addon"><i class="fa fa-moon-o"></i></div>
												</div>
											</div>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
											<div class="form-group">
												<div class="input-group">
													<select class="form-control" name="room" data-parsley-error-message="required" data-parsley-trigger="focusin focusout" required>
														<option value="">Rooms</option>
														<?php
															for ($i=1; $i < 10 ; $i++) { 
																if($i==1){
														?>
															<option value="<?php echo $i ; ?>" selected><?php echo $i ; ?> Room</option>
															<?php }else{ ?>
															<option value="<?php echo $i ; ?>"><?php echo $i ; ?> Rooms</option>
														<?php	
																}
															}
														?>																
													</select>
													<div class="input-group-addon"><i class="fa fa-bed"></i></div>
												</div>
											</div>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
											<div class="form-group">
												<div class="input-group">
													<select class="form-control" name="accommodation" data-parsley-error-message="required" data-parsley-trigger="focusin focusout" required>
														<option value="">Accommodation</option>
														<option value="5" selected>5 Star</option>
														<option value="4">4 Star</option>
														<option value="3">3 Star</option>
													</select>
													<div class="input-group-addon"><i class="fa fa-building-o"></i></div>
												</div>
											</div>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
											<div class="row">
												<div class="col-xs-4">
													<div class="form-group">
														<div class="input-group">
															<select class="form-control" name="padults" required>
																<option value="" selected>Adults</option>
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
																<option value="" selected>Children</option>
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
																<option value="" selected>Infants</option>
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
										<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
											<div class="form-group">
												<div class="input-group">
													<input type="text" name="cust_name" class="form-control" placeholder="Enter Your Name" required>
													<div class="input-group-addon"><i class="fa fa-user"></i></div>
												</div>
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
											<div class="form-group">
												<div class="input-group">
													<input type="email" name="cust_email" class="form-control" placeholder="Enter Your Active Email" required>
													<div class="input-group-addon"><i class="fa fa-envelope"></i></div>
												</div>
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
											<div class="form-group">
												<div class="input-group">
													<input type="number" name="cust_mob" class="form-control" placeholder="Enter Your Valid Mobile" required>
													<div class="input-group-addon"><i class="fa fa-mobile"></i></div>
												</div>
											</div>
										</div>
										<div class="col-lg-12 text-center">
											<button type="submit" class="btn btn-primary btn-search"><i class="fa fa-check-circle"></i>Enquire Now</button>
										</div>
									</div>
								</form>
							</div>
						</section>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<section class="bg-white">
							<div class="container">
								<div class="page-header">
								  <h1 class="text-center text-black">Cheap Umrah Packages</h1>
								  <p class="text-center">We feels proud to serve the Muslims in United Kingdom. We offers a wide range of reliable Umrah packages to make sure our beloved customers get the best deals to fulfill their requirements. We have years of experience in providing the possible Umrah package deals with affordable prices to our valued customers.</p>
								</div>
								<div class="section-style4 mb-0">
									<div class="row row-style row_a1">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col_a1c">
											<div class="module so-deals-1tr home1_deals so-deals">
												<div class="head-title clearfix">
													<div class="block-title pull-left">
														<h3><span>5 Star Umrah Packages</span></h3>
													</div>
												</div>
												<div class="modcontent">
													<div class="so-deal modcontent products-list grid clearfix clearfix preset00-3 preset01-3 preset02-2 preset03-2 preset04-1  button-type1  style2">
														<div class="category-slider-inner products-list yt-content-slider" data-rtl="yes" data-autoplay="yes" data-autoheight="no" data-delay="4" data-speed="0.6" data-margin="30" data-items_column00="3" data-items_column0="3" data-items_column1="3" data-items_column2="3"  data-items_column3="3" data-items_column4="1" data-arrows="no" data-pagination="no" data-lazyload="yes" data-loop="yes" data-hoverpause="yes">
															<div class="item">
																<div class="item-inner">
																	<div class="transition product-layout">
																		<div class="product-item-container mb-0" >
																			<div class="item-block so-quickview">
																				<div class="image">
																					<a href="tel:<?php echo $this->web_tel ; ?>" target="_self">
																						<img src="<?php echo base_url('assets/image/umrah/5m1.jpg') ; ?>" alt="asdfasdf" class="img-responsive">
																					</a>
																				</div>
																				<div class="item-content clearfix">
																					<h3><a href="tel:<?php echo $this->web_tel ; ?>">5 Star – 7 Nights Package</a></h3>
																					<ul>
																						<li><i class="fa fa-plane"></i> Flight</li>
																						<li><i class="fa fa-bus"></i> Transportation</li>
																						<li><i class="fa fa-id-card-o"></i> Visa</li>
																					</ul>
																					<div class="row">
																						<div class="col-xs-6 text-center">
																							<h5 class="text-center">Makkah Hotel<br><small>Anjum Hotel</small></h5>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																						</div>
																						<div class="col-xs-6 text-center">
																							<h5 class="text-center">Madina Hotel<br><small>Millennium Al Aqeeq</small></h5>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																						</div>
																					</div>
																					<h1 class="text-center"><small>From</small> &pound; 750/-</h1>
																					<hr>
																					<div class="item-bot text-center">
																						<a href="tel:<?php echo $this->web_tel ; ?>" class="book-now pt-10 pb-10 pl-20 pr-20" title="Book Now"><h4 class="mb-0 mt-0"><i class="fa fa-phone-square"></i> <?php echo $this->web_phn ; ?></h4></a>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="item">
																<div class="item-inner">
																	<div class="transition product-layout">
																		<div class="product-item-container mb-0" >
																			<div class="item-block so-quickview">
																				<div class="image">
																					<a href="tel:<?php echo $this->web_tel ; ?>" target="_self">
																						<img src="<?php echo base_url('assets/image/umrah/5m2.jpg') ; ?>" alt="asdfasdf" class="img-responsive">
																					</a>
																				</div>
																				<div class="item-content clearfix">
																					<h3><a href="tel:<?php echo $this->web_tel ; ?>">5 Star – 10 Nights Package</a></h3>
																					<ul>
																						<li><i class="fa fa-plane"></i> Flight</li>
																						<li><i class="fa fa-bus"></i> Transportation</li>
																						<li><i class="fa fa-id-card-o"></i> Visa</li>
																					</ul>
																					<div class="row">
																						<div class="col-xs-6 text-center">
																							<h5 class="text-center">Makkah Hotel<br><small>Pullman Zamzam</small></h5>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																						</div>
																						<div class="col-xs-6 text-center">
																							<h5 class="text-center">Madina Hotel<br><small>Millennium Al Taiba</small></h5>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																						</div>
																					</div>
																					<h1 class="text-center"><small>From</small> &pound; 850/-</h1>
																					<hr>
																					<div class="item-bot text-center">
																						<a href="tel:<?php echo $this->web_tel ; ?>" class="book-now pt-10 pb-10 pl-20 pr-20" title="Book Now"><h4 class="mb-0 mt-0"><i class="fa fa-phone-square"></i> <?php echo $this->web_phn ; ?></h4></a>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="item">
																<div class="item-inner">
																	<div class="transition product-layout">
																		<div class="product-item-container mb-0" >
																			<div class="item-block so-quickview">
																				<div class="image">
																					<a href="tel:<?php echo $this->web_tel ; ?>" target="_self">
																						<img src="<?php echo base_url('assets/image/umrah/5m1.jpg') ; ?>" alt="asdfasdf" class="img-responsive">
																					</a>
																				</div>
																				<div class="item-content clearfix">
																					<h3><a href="tel:<?php echo $this->web_tel ; ?>">5 Star – 14 Nights Package</a></h3>
																					<ul>
																						<li><i class="fa fa-plane"></i> Flight</li>
																						<li><i class="fa fa-bus"></i> Transportation</li>
																						<li><i class="fa fa-id-card-o"></i> Visa</li>
																					</ul>
																					<div class="row">
																						<div class="col-xs-6 text-center">
																							<h5 class="text-center">Makkah Hotel<br><small>Swissotel Makkah</small></h5>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																						</div>
																						<div class="col-xs-6 text-center">
																							<h5 class="text-center">Madina Hotel<br><small>Madinah Movenpick</small></h5>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																						</div>
																					</div>
																					<h1 class="text-center"><small>From</small> &pound; 895/-</h1>
																					<hr>
																					<div class="item-bot text-center">
																						<a href="tel:<?php echo $this->web_tel ; ?>" class="book-now pt-10 pb-10 pl-20 pr-20" title="Book Now"><h4 class="mb-0 mt-0"><i class="fa fa-phone-square"></i> <?php echo $this->web_phn ; ?></h4></a>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="section-style4 mb-0">
									<div class="row row-style row_a1">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col_a1c">
											<div class="module so-deals-1tr home1_deals so-deals">
												<div class="head-title clearfix">
													<div class="block-title pull-left">
														<h3><span>4 Star Umrah Packages</span></h3>
													</div>
												</div>
												<div class="modcontent">
													<div class="so-deal modcontent products-list grid clearfix clearfix preset00-3 preset01-3 preset02-2 preset03-2 preset04-1  button-type1  style2">
														<div class="category-slider-inner products-list yt-content-slider" data-rtl="yes" data-autoplay="yes" data-autoheight="no" data-delay="4" data-speed="0.6" data-margin="30" data-items_column00="3" data-items_column0="3" data-items_column1="3" data-items_column2="3"  data-items_column3="3" data-items_column4="1" data-arrows="no" data-pagination="no" data-lazyload="yes" data-loop="yes" data-hoverpause="yes">
															<div class="item">
																<div class="item-inner">
																	<div class="transition product-layout">
																		<div class="product-item-container mb-0" >
																			<div class="item-block so-quickview">
																				<div class="image">
																					<a href="tel:<?php echo $this->web_tel ; ?>" target="_self">
																						<img src="<?php echo base_url('assets/image/umrah/4m1.jpg') ; ?>" alt="asdfasdf" class="img-responsive">
																					</a>
																				</div>
																				<div class="item-content clearfix">
																					<h3><a href="tel:<?php echo $this->web_tel ; ?>">4 Star – 7 Nights Package</a></h3>
																					<ul>
																						<li><i class="fa fa-plane"></i> Flight</li>
																						<li><i class="fa fa-bus"></i> Transportation</li>
																						<li><i class="fa fa-id-card-o"></i> Visa</li>
																					</ul>
																					<div class="row">
																						<div class="col-xs-6 text-center">
																							<h5 class="text-center">Makkah Hotel<br><small>Dar Al Eiman Grand</small></h5>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																						</div>
																						<div class="col-xs-6 text-center">
																							<h5 class="text-center">Madina Hotel<br><small>Dar Al Eiman Al Manar</small></h5>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																						</div>
																					</div>
																					<h1 class="text-center"><small>From</small> &pound; 685/-</h1>
																					<hr>
																					<div class="item-bot text-center">
																						<a href="tel:<?php echo $this->web_tel ; ?>" class="book-now pt-10 pb-10 pl-20 pr-20" title="Book Now"><h4 class="mb-0 mt-0"><i class="fa fa-phone-square"></i> <?php echo $this->web_phn ; ?></h4></a>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="item">
																<div class="item-inner">
																	<div class="transition product-layout">
																		<div class="product-item-container mb-0" >
																			<div class="item-block so-quickview">
																				<div class="image">
																					<a href="tel:<?php echo $this->web_tel ; ?>" target="_self">
																						<img src="<?php echo base_url('assets/image/umrah/4m2.jpg') ; ?>" alt="asdfasdf" class="img-responsive">
																					</a>
																				</div>
																				<div class="item-content clearfix">
																					<h3><a href="tel:<?php echo $this->web_tel ; ?>">4 Star – 10 Nights Package</a></h3>
																					<ul>
																						<li><i class="fa fa-plane"></i> Flight</li>
																						<li><i class="fa fa-bus"></i> Transportation</li>
																						<li><i class="fa fa-id-card-o"></i> Visa</li>
																					</ul>
																					<div class="row">
																						<div class="col-xs-6 text-center">
																							<h5 class="text-center">Makkah Hotel<br><small>Nawazi Watheer</small></h5>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																						</div>
																						<div class="col-xs-6 text-center">
																							<h5 class="text-center">Madina Hotel<br><small>Al Eiman Taibah Madinah</small></h5>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																						</div>
																					</div>
																					<h1 class="text-center"><small>From</small> &pound; 720/-</h1>
																					<hr>
																					<div class="item-bot text-center">
																						<a href="tel:<?php echo $this->web_tel ; ?>" class="book-now pt-10 pb-10 pl-20 pr-20" title="Book Now"><h4 class="mb-0 mt-0"><i class="fa fa-phone-square"></i> <?php echo $this->web_phn ; ?></h4></a>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="item">
																<div class="item-inner">
																	<div class="transition product-layout">
																		<div class="product-item-container mb-0" >
																			<div class="item-block so-quickview">
																				<div class="image">
																					<a href="tel:<?php echo $this->web_tel ; ?>" target="_self">
																						<img src="<?php echo base_url('assets/image/umrah/4m3.jpg') ; ?>" alt="asdfasdf" class="img-responsive">
																					</a>
																				</div>
																				<div class="item-content clearfix">
																					<h3><a href="tel:<?php echo $this->web_tel ; ?>">4 Star – 14 Nights Package</a></h3>
																					<ul>
																						<li><i class="fa fa-plane"></i> Flight</li>
																						<li><i class="fa fa-bus"></i> Transportation</li>
																						<li><i class="fa fa-id-card-o"></i> Visa</li>
																					</ul>
																					<div class="row">
																						<div class="col-xs-6 text-center">
																							<h5 class="text-center">Makkah Hotel<br><small>Dar al Eiman Ajyad</small></h5>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																						</div>
																						<div class="col-xs-6 text-center">
																							<h5 class="text-center">Madina Hotel<br><small>Elaf Al Meshal</small></h5>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																						</div>
																					</div>
																					<h1 class="text-center"><small>From</small> &pound; 785/-</h1>
																					<hr>
																					<div class="item-bot text-center">
																						<a href="tel:<?php echo $this->web_tel ; ?>" class="book-now pt-10 pb-10 pl-20 pr-20" title="Book Now"><h4 class="mb-0 mt-0"><i class="fa fa-phone-square"></i> <?php echo $this->web_phn ; ?></h4></a>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="section-style4 mb-0">
									<div class="row row-style row_a1">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col_a1c">
											<div class="module so-deals-1tr home1_deals so-deals">
												<div class="head-title clearfix">
													<div class="block-title pull-left">
														<h3><span>3 Star Umrah Packages</span></h3>
													</div>
												</div>
												<div class="modcontent">
													<div class="so-deal modcontent products-list grid clearfix clearfix preset00-3 preset01-3 preset02-2 preset03-2 preset04-1  button-type1  style2">
														<div class="category-slider-inner products-list yt-content-slider" data-rtl="yes" data-autoplay="yes" data-autoheight="no" data-delay="4" data-speed="0.6" data-margin="30" data-items_column00="3" data-items_column0="3" data-items_column1="3" data-items_column2="3"  data-items_column3="3" data-items_column4="1" data-arrows="no" data-pagination="no" data-lazyload="yes" data-loop="yes" data-hoverpause="yes">
															<div class="item">
																<div class="item-inner">
																	<div class="transition product-layout">
																		<div class="product-item-container mb-0" >
																			<div class="item-block so-quickview">
																				<div class="image">
																					<a href="tel:<?php echo $this->web_tel ; ?>" target="_self">
																						<img src="<?php echo base_url('assets/image/umrah/3m1.jpg') ; ?>" alt="asdfasdf" class="img-responsive">
																					</a>
																				</div>
																				<div class="item-content clearfix">
																					<h3><a href="tel:<?php echo $this->web_tel ; ?>">3 Star – 7 Nights Package</a></h3>
																					<ul>
																						<li><i class="fa fa-plane"></i> Flight</li>
																						<li><i class="fa fa-bus"></i> Transportation</li>
																						<li><i class="fa fa-id-card-o"></i> Visa</li>
																					</ul>
																					<div class="row">
																						<div class="col-xs-6 text-center">
																							<h5 class="text-center">Makkah Hotel<br><small>Dar al Eiman Ajyad</small></h5>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																						</div>
																						<div class="col-xs-6 text-center">
																							<h5 class="text-center">Madina Hotel<br><small>Elaf Al Meshal</small></h5>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																						</div>
																					</div>
																					<h1 class="text-center"><small>From</small> &pound; 620/-</h1>
																					<hr>
																					<div class="item-bot text-center">
																						<a href="tel:<?php echo $this->web_tel ; ?>" class="book-now pt-10 pb-10 pl-20 pr-20" title="Book Now"><h4 class="mb-0 mt-0"><i class="fa fa-phone-square"></i> <?php echo $this->web_phn ; ?></h4></a>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="item">
																<div class="item-inner">
																	<div class="transition product-layout">
																		<div class="product-item-container mb-0" >
																			<div class="item-block so-quickview">
																				<div class="image">
																					<a href="tel:<?php echo $this->web_tel ; ?>" target="_self">
																						<img src="<?php echo base_url('assets/image/umrah/3m2.jpg') ; ?>" alt="asdfasdf" class="img-responsive">
																					</a>
																				</div>
																				<div class="item-content clearfix">
																					<h3><a href="tel:<?php echo $this->web_tel ; ?>">3 Star – 10 Nights Package</a></h3>
																					<ul>
																						<li><i class="fa fa-plane"></i> Flight</li>
																						<li><i class="fa fa-bus"></i> Transportation</li>
																						<li><i class="fa fa-id-card-o"></i> Visa</li>
																					</ul>
																					<div class="row">
																						<div class="col-xs-6 text-center">
																							<h5 class="text-center">Makkah Hotel<br><small>Dar Al Eiman Al Sud</small></h5>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																						</div>
																						<div class="col-xs-6 text-center">
																							<h5 class="text-center">Madina Hotel<br><small>Dar Al Eiman Ohud</small></h5>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																						</div>
																					</div>
																					<h1 class="text-center"><small>From</small> &pound; 695/-</h1>
																					<hr>
																					<div class="item-bot text-center">
																						<a href="tel:<?php echo $this->web_tel ; ?>" class="book-now pt-10 pb-10 pl-20 pr-20" title="Book Now"><h4 class="mb-0 mt-0"><i class="fa fa-phone-square"></i> <?php echo $this->web_phn ; ?></h4></a>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="item">
																<div class="item-inner">
																	<div class="transition product-layout">
																		<div class="product-item-container mb-0" >
																			<div class="item-block so-quickview">
																				<div class="image">
																					<a href="tel:<?php echo $this->web_tel ; ?>" target="_self">
																						<img src="<?php echo base_url('assets/image/umrah/3m3.jpg') ; ?>" alt="asdfasdf" class="img-responsive">
																					</a>
																				</div>
																				<div class="item-content clearfix">
																					<h3><a href="tel:<?php echo $this->web_tel ; ?>">3 Star – 14 Nights Package</a></h3>
																					<ul>
																						<li><i class="fa fa-plane"></i> Flight</li>
																						<li><i class="fa fa-bus"></i> Transportation</li>
																						<li><i class="fa fa-id-card-o"></i> Visa</li>
																					</ul>
																					<div class="row">
																						<div class="col-xs-6 text-center">
																							<h5 class="text-center">Makkah Hotel<br><small>Dar Eman Al Khalil</small></h5>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																						</div>
																						<div class="col-xs-6 text-center">
																							<h5 class="text-center">Madina Hotel<br><small>Al Eiman Al Nour</small></h5>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																							<i class="fa fa-star"></i>
																						</div>
																					</div>
																					<h1 class="text-center"><small>From</small> &pound; 755/-</h1>
																					<hr>
																					<div class="item-bot text-center">
																						<a href="tel:<?php echo $this->web_tel ; ?>" class="book-now pt-10 pb-10 pl-20 pr-20" title="Book Now"><h4 class="mb-0 mt-0"><i class="fa fa-phone-square"></i> <?php echo $this->web_phn ; ?></h4></a>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
																
							</div>							
						</section>
					</div>
				</div>
				<?php $this->load->view('common/whychooseus'); ?>
			</div>
		</div>
        <?php $this->load->view('common/footer'); ?>
    </div>
    <?php $this->load->view('common/js'); ?>
</body>
</html>