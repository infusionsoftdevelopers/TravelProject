
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
            $head_data['page'] = 'faqs'; 
            $this->load->view('common/header',$head_data); 
        ?>
        <div class="breadcrumbs mb-0">
            <div class="container">
                <div class="title-breadcrumb">FAQs</div>
                <ul class="breadcrumb-cate">
                    <li><a href="<?php echo base_url() ; ?>">Home</a></li>
                    <li><a href="javascript:void(0);"><strong>FAQs</strong></a></li>
                </ul>
            </div>
        </div>
        <div class="main-faq container mt-50">
			<div class="row">
				<div class="faq-left col-xs-12">
					<div class="block-title">
						<h3>Frequently Asked Questions</h3>
						<p>Hope you will find most of the answers here otherwise you can call any time to talk to our experts regarding your queries.</p>
					</div>
					<ul class="yt-accordion">
						<li class="accordion-group">
							<h3 class="accordion-heading active"><i class="fa fa-plus-square"></i><span>Why Book With Us?</span></h3>
							<div class="accordion-inner">
								<p>One benefit of making your air reservations with us is that we are able to understand your needs whilst arranging your travel itinerary. Our travel consultants will be able to suggest the best airlines with the most flexible conditions for your travel. We also monitor the travel itinerary and are able to advise of any changes that the airline may make. Finally, we know which airlines are the most reliable, have good on-time records and are more passenger oriented.</p>
							</div>
						</li>
						<li class="accordion-group">
							<h3 class="accordion-heading"><i class="fa fa-plus-square"></i><span>How to get cheapest prices?</span></h3>
							<div class="accordion-inner" style="display: none;">
								<p>The best way to book with us is to call our travel experts on <?php echo $this->web_phn?> or use the call back feature <a href="<?php echo base_url() ; ?>" target="_blank" rel="noopener noreferrer">(send us inquiry)</a> or even you can chat us online.</p>
							</div>
						</li>
						<li class="accordion-group">
							<h3 class="accordion-heading"><i class="fa fa-plus-square"></i><span>How are these tickets different than buying a ticket from the airline directly?</span></h3>
							<div class="accordion-inner" style="display: none;">
								<p>These tickets are for the most part very similar to tickets you would buy directly from the airlines. An advantage is that you can request special meals, get advanced seat assignments and always accurate flyer mileage.</p>
							</div>
						</li>
						<li class="accordion-group">
							<h3 class="accordion-heading"><i class="fa fa-plus-square"></i><span>How can I pay for my ticket?</span></h3>
							<div class="accordion-inner" style="display: none;">
								<p>The easiest way to make the payment is to transfer the money online in our company bank account. If you don't have the online banking then you can pay the cash in the branch. You can also visit our office to make the payment and collect your tickets. You can also pay through the Credit Card / Debit Card.</p>
							</div>
						</li>
						<li class="accordion-group">
							<h3 class="accordion-heading"><i class="fa fa-plus-square"></i><span>How and when will I receive my ticket? (Delivery Policy)</span></h3>
							<div class="accordion-inner" style="display: none;">
								<p>It's quite simple. As soon as you send us the full payment and singed invoice (booking terms and conditions), we will instantly send the Electronic Tickets on your given email address. All you need to take the printout and use these tickets. As this is the modern era of E-Tickets unlikely to the Paper Tickets (which were used in past) so we do not need to send you anything by post.</p>
							</div>
						</li>
						<li class="accordion-group">
							<h3 class="accordion-heading"><i class="fa fa-plus-square"></i><span>What if I need to cancel or change my ticket? (Cancellation / Refund Policy)</span></h3>
							<div class="accordion-inner" style="display: none;">
								<p>Different Airlines have different cancellation and refund policies depending on the type of ticket, season and price etc. So, in certain cases tickets are refundable / changeable but in other cases tickets are non-refundable / non-changeable. It's always mentioned on your booking terms and conditions when you are making the purchase of that. It means we always intimate you about the Cancellation / Refund policy before you make a purchase. If Tickets are refundable and there is cancellation fee involved then you will get your net refund amount within 4 to 5 weeks from the date of refund made by you. If Airline permits the changes in tickets and there is change fee involved then you can get your new ticket by paying the change fee and / or difference of fare (if any).</p>
							</div>
						</li>
						<li class="accordion-group">
							<h3 class="accordion-heading"><i class="fa fa-plus-square"></i><span>How do I contact you?</span></h3>
							<div class="accordion-inner" style="display: none;">
								<p>You can check the contact us button at the top of the page. This will have all the information you will need to get in touch with us. We are open Mon - Fri : 9:00AM - 6:00PM | Sat : 10:00AM - 4:00PM</p>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
        <?php $this->load->view('common/footer'); ?>
    </div>
    <?php $this->load->view('common/js'); ?>
</body>
</html>