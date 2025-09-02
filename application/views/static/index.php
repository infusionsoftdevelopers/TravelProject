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
            $head_data['page'] = 'home'; 
            $this->load->view('common/header',$head_data); 
        ?>
        <div id="content">
			<div class="so-page-builder">
				<div class="row bg-home">
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
												<input type="text" name="dest_arpt" class="form-control arpt" placeholder="Enter Destination Airport..." required>
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
				<?php $this->load->view('common/whychooseus'); ?>
				<?php if(count($bestfares) > 0){ ?>
				<section class="section-style4">
					<div class="container page-builder-ltr">
						<div class="row row-style row_a1">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col_a1c">
								<div class="module so-deals-1tr home1_deals so-deals">
									<div class="head-title clearfix">
										<div class="block-title pull-left">
											<h3><span>Cheap Flight Deals</span></h3>
										</div>
									</div>
									<div class="modcontent">
										<div class="so-deal modcontent products-list grid clearfix clearfix preset00-3 preset01-3 preset02-2 preset03-2 preset04-1  button-type1  style2">
											<div class="category-slider-inner products-list yt-content-slider" data-rtl="yes" data-autoplay="yes" data-autoheight="no" data-delay="4" data-speed="0.6" data-margin="30" data-items_column00="4" data-items_column0="4" data-items_column1="4" data-items_column2="2"  data-items_column3="2" data-items_column4="2" data-arrows="no" data-pagination="no" data-lazyload="yes" data-loop="yes" data-hoverpause="yes">
												<?php
													foreach ($bestfares as $key => $row) {
												?>
												<div class="item">
													<div class="item-inner">
														<div class="transition product-layout">
															<div class="product-item-container ">
																<div class="item-block so-quickview">
																	<div class="image">
																		<a href="<?php echo base_url('/fly-to-'.str_replace(' ','-',$row['f_to'])) ; ?>" target="_self">
																			<img src="<?php echo base_url('assets/image/dest/'.$row['f_tocode'].'.jpg') ; ?>" alt="<?php echo $row['f_to'] ; ?>" class="img-responsive">
																		</a>
																		<span class="label-hot">
																			<i class="fa fa-fire"></i>Hot tour
																		</span>
																	</div>
																	<div class="item-content clearfix">
																		<h3><a href="<?php echo base_url('/fly-to-'.str_replace(' ','-',$row['f_to'])) ; ?>">Travel To <?php echo $row['f_to'] ; ?></a></h3>
																		<ul>
																			<li><i class="fa fa-map-marker"></i> <?php echo $row['f_airline'] ; ?></li>
																			<li><i class="fa fa-refresh"></i> Return</li>
																		</ul>
																		<div class="item-bot clearfix">
																			<div class="price pull-left">
																				from <label>&pound;<?php echo $row['price'] ; ?></label>
																			</div>
																			<a href="<?php echo base_url('/fly-to-'.str_replace(' ','-',$row['f_to'])) ; ?>" class="book-now pull-right p-5" title="Book Now"><small>Book now</small></a>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
				<?php } ?>
				<section class="section-style5">
					<div class="container page-builder-ltr">
						<div class="row row-style row_a1">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col_a1c">
								<div class="module so-deals-1tr home1_deals so-deals">
									<div class="head-title clearfix">
										<div class="block-title pull-left">
											<h3><span>Choose your destinations</span></h3>
										</div>
									</div>
									<div class="modcontent">
										<div class="so-deal modcontent products-list grid clearfix clearfix preset00-3 preset01-3 preset02-2 preset03-2 preset04-1  button-type1  style2">
											<div class="category-slider-inner products-list yt-content-slider" data-rtl="yes" data-autoplay="yes" data-autoheight="no" data-delay="4" data-speed="0.6" data-margin="30" data-items_column00="5" data-items_column0="5" data-items_column1="5" data-items_column2="2"  data-items_column3="2" data-items_column4="5" data-arrows="no" data-pagination="no" data-lazyload="yes" data-loop="yes" data-hoverpause="yes">
												<?php 
													foreach ($continents as $key => $conti) {
														$img = strtolower($conti['airport_continent']);
														$slug = str_replace(' ','-',$img) ;													
												?>
												<div class="item">
													<div class="transition product-layout">
														<div class="product-item-container ">
															<div class="item-block so-quickview">
																<div class="image">
																	<a href="<?php echo base_url('continent/'.$slug) ?>" target="_self">
																		<img src="<?php echo base_url('assets/image/continent/'.$slug.'.jpg') ; ?>" alt="<?php echo $conti['airport_continent'] ; ?>" class="img-responsive">
																	</a>
																</div>
																<div class="item-content">
																	<div class="item-title clearfix">
																		<h3 class="pull-left mb-0"><a href="<?php echo base_url('continent/'.$slug) ?>"><i class="fa fa-map-marker"></i> <?php echo $conti['airport_continent'] ; ?></a></h3><br>
																		<span><?php echo  contidestcount($conti['airport_continent']) ; ?> Destinations</span>
																	</div>			
																	<div class="view-all"><a href="<?php echo base_url('continent/'.$slug) ?>">View all tour <i class="fa fa-angle-double-right"></i></a></div>
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
						</div>
					</div>
				</section>
			</div>
		</div>
        <?php $this->load->view('common/footer'); ?>
    </div>
    <?php $this->load->view('common/js'); ?>
</body>
</html>