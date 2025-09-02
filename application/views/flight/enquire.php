
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
<body class=" res layout-1">
    <div id="wrapper" class="wrapper-fluid banners-effect-10">
        <?php
            $head_data['page'] = 'home'; 
            $this->load->view('common/header',$head_data); 
        ?>
        <div class="image-top"><img src="<?php echo base_url('assets/image/details.jpg') ; ?>" alt="tour" class="img-responsive"></div>
		<div class="container product-detail tour-single">
			<div class="row">
				<div id="content" class="col-md-9 col-sm-12 col-xs-12">
					<a href="javascript:void(0)" class="open-sidebar hidden-lg hidden-md"><i class="fa fa-bars"></i>Sidebar</a>
					<div class="detail-content">
						<div class="sticky-content">
							<h1><i class="fa fa-map-marker"></i> Travel to <?php echo $m_dest ; ?> <br><small class="text-white"><i class="fa fa-plane"></i> Fly with <?php echo $m_airline ; ?></small></h1>
							<ul class="box-meta">
								<li><i class="fa fa-clock-o"></i><?php echo $o_stops ; ?></li>
								<li><i class="fa fa-calendar"></i> <?php echo $o_deptdate; ?> <?php if($m_flight_type == "Return"){ ?>&nbsp;&nbsp;&nbsp;<i class="fa fa-long-arrow-right"></i>&nbsp;&nbsp;&nbsp;<i class="fa fa-calendar"></i> <?php echo $i_deptdate; ?><?php } ?></li>
								<li><i class="fa fa-male"></i>Traveller(s) - <?php echo $m_adults; ?> Adult<?php if($m_adults>1){ ?>s<?php } ?><?php if($m_children>0){ ?><?php if($m_infants>0){ echo ","; } else{echo " &";} ?> <?php echo $m_children; ?> Child<?php if($m_children>1){ ?>ren<?php } ?><?php } ?><?php if($m_infants>0){ ?> & <?php echo $m_infants; ?> Infant<?php if($m_infants>1){ ?>s<?php } ?><?php } ?></li>
							</ul>
							<div class="top-tab" id="nav">
								<ul class="nav nav-tabs">
									<li><a href="#home">Enquire Your Flight</a></li>
								</ul>
							</div>
						</div>
						<div class="content-tabs">
							<div class="tab-content p-20">
								<div id="home" class="row">
                                    <form action="<?php echo base_url('thank-you') ; ?>" method="post" id="frm" name="frm" autocomplete="off">
                                    <input type="hidden" name="requesttitle" id="requesttitle" value="Inquiry"  />
                                    <input type="hidden" name="h_submit" value="1">
                                    <input type="hidden" name="page_id" value="inquiry_submit"  />
                                    <input type="hidden" name="deptairport" id="deptairport" value="<?php echo $o_deptairport; ?>" />
                                    <input type="hidden" name="destairport" id="destairport" value="<?php echo $o_arvlairport; ?>" />
                                    <input type="hidden" name="airline" id="airline" value="<?php echo $m_airline; ?>" />
                                    <input type="hidden" name="flighttype" id="flighttype" value="<?php echo $m_flight_type; ?>" />
                                    <input type="hidden" name="ticketclass" id="ticketclass" value="<?php echo $m_cabin_class; ?>" />
                                    <input type="hidden" name="ftotal" id="ftotal" value="<?php echo $m_totalprice; ?>" />
                                    <input name="ddevice" id="ddevice" type="hidden" value="<?php echo $ddevice . " " . $ddeviceos; ?>" />
                                    <div class="col-md-4 ol-sm-6">
                                    <div class="form-group">
                                    <label>Full Name</label>
                                    <input type="text" name="cname" required class="form-control" placeholder="Enter your name..." />
                                    </div>
                                    </div>
                                    <div class="col-md-4 ol-sm-6">
                                    <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" name="cphone" required class="form-control" placeholder="Enter your phone..." />
                                    </div>
                                    </div>
                                    <div class="col-md-4 ol-sm-6">
                                    <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="cemail" required class="form-control" placeholder="Enter your email...">
                                    </div>
                                    </div>
                                    <div class="<?php if($m_flight_type == "Return"){ ?>col-md-6 col-sm-6<?php } else {?>col-md-12 col-sm-12 <?php } ?> ">
                                    <div class="form-group">
                                    <label>Departure</label>
                                    <input value="<?php echo date('d-M-Y', strtotime($o_deptdate)); ?>" type="text" id="departure_date" required name="departure_date" class="form-control" placeholder="DD/MM/YYYY">
                                    </div>
                                    </div>
                                    <?php if($m_flight_type == "Return"){ ?>
                                    <div class="col-md-6 col-sm-6  return-date-selection">
                                    <div class="form-group">
                                    <label>Return</label>
                                    <input value="<?php echo date('d-M-Y', strtotime($i_deptdate)); ?>" type="text" id="return_date" required class="form-control" name="return_date" placeholder="DD/MM/YYYY">
                                    </div>
                                    </div>
                                    <?php } ?>
                                    <div class="col-md-4 col-sm-4 ">
                                    <div class="form-group">
                                    <label>Adult(s)</label>
                                    <input id="adult_count" name="padults" value="<?php echo  $m_adults; ?>" class="form-control quantity-padding">
                                    </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 ">
                                    <div class="form-group">
                                    <label>Child(ren)</label>
                                    <input type="text" id="child_count" name="pchildren" value="<?php echo  $m_children; ?>" class="form-control quantity-padding">
                                    </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 ">
                                    <div class="form-group">
                                    <label>Infant(s)</label>
                                    <input type="text" id="hotel_child_count" name="pinfants" value="<?php echo  $m_infants; ?>" class="form-control quantity-padding">
                                    </div>
                                    </div>
                                    <div class="col-xs-12">
                                    <div class="form-group">
                                    <label>Special Instructions</label>
                                    <textarea name="inst" id="inst" rows="5" cols="5" class="form-control" placeholder="Type here..."></textarea>
                                    </div>
                                    </div>
                                    <div class="col-md-12 ">
                                    <label>
                                    <input type="checkbox" name="newsletter_check" value="1" >&nbsp;<strong style="color: #000000!important;">Click To subscribe to our newsletter and get promotion deals.</strong>
                                    </label>
                                    </div>
                                    <div class="col-xs-12 text-center">
                                        <div class="alert alert-info mtb-20"  role="alert">
                                            <p class="mb-0 text-left"><strong>Please Note:</strong> Fares and seats are not guaranteed and subject to availability. If the requested fare will not be available then we will offer you the best available alternate.</p>
                                        </div>
                                        <button type="submit" class="btn btn-book">SUBMIT <i class="fa fa-chevron-right"></i></button>
                                    </div>
                                    </form>
                                </div>
							</div>
						</div>
					</div>
				</div>
				<aside class="col-md-3 col-sm-4 col-xs-12 content-aside right_column sidebar-offcanvas">
					<span id="close-sidebar" class="fa fa-times"></span>
					<div class="module-search2 clearfix">
						<h3 class="modtitle"><label>Total Price: £<?php echo $m_totalprice; ?></label></h3>				
					</div>
					<div class="module-why clearfix">
						<h3>Why should travel with us?</h3>
						<ul>
							<li><i class="fa fa-usd"></i>No-hassle best price guarantee</li>
							<li><i class="fa fa-star"></i>Hand-picked Tours & Activities</li>
							<li><i class="fa fa-volume-control-phone"></i>Excellent Passenger Service</li>
							<li><i class="fa fa-user"></i>Book Now Pay Later</li>
						</ul>
					</div>
					<div class="module-ques clearfix">
                        <h3>get a questions</h3>
                        <p>Call or Email us and get all the answers from expersts.</p>
                        <ul>
                            <li><i class="fa fa-phone"></i><?php echo $this->web_phn ; ?></li>
                            <li><i class="fa fa-envelope"></i><?php echo $this->web_email ; ?></li>
                        </ul>
                    </div>
				</aside>
			</div>
		</div>
        <?php $this->load->view('common/footer'); ?>
    </div>
    <?php $this->load->view('common/js'); ?>
</body>
</html>