
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
            $head_data['page'] = 'contactus'; 
            $this->load->view('common/header',$head_data); 
        ?>
        <div class="contact_us_v2">   
			<div class="map">
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2480.7946044368946!2d0.07631351520229702!3d51.55366521514124!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47d8a663baec7517%3A0x90845f851edad767!2s132a%20Woodlands%20Rd%2C%20Ilford%20IG1%201JP%2C%20UK!5e0!3m2!1sen!2s!4v1623404140324!5m2!1sen!2s" width="1920" height="600" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
			</div>
			<div class="contact-bot clearfix">
				<form action="" method="post" enctype="multipart/form-data" class="form-contact pull-left">
					<input type="text" name="main" value="" style="display: none !important;">
					<h3>Drop us a line</h3>
					<p>Contact us now and let your journey begin.</p>
					<div class="form-group required">
						<input type="text" name="name" required id="input-name" class="form-control" placeholder="Your Name">
					</div>
					<div class="form-group group2 required">
						<input type="email" name="email" required id="input-email" class="form-control" placeholder="Your Email">
					</div>
					<div class="form-group group3 required">
						<input type="text" name="phone" required id="input-phone" class="form-control" placeholder="Your Phone">
					</div>
					<div class="form-group required">
						<textarea required name="enquiry" rows="6" id="input-enquiry" placeholder="Your Message" class="form-control"></textarea>
					</div>
					<div class="buttons">
						<button class="btn btn-info" type="submit">Send Message</button>
					</div>
				</form>
				<div class="contact-right pull-left">
					<h3>Contact infomation</h3>
					<p>Please free to call us or you can fill form and send us your query</p>
					<ul class="add">
						<li>
							<span>Address</span>
							<label>132-A Woodland Rd, Ilford IG1 1JP</label>
						</li>
						<li>
							<span>Phone</span>
							<label><?php echo $this->web_phn ; ?></label>
						</li>
						<li>
							<span>Email</span>
							<label><?php echo $this->infomail ; ?></label>
						</li>
					</ul>
					<ul class="social">
						<li><a href="#"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
						<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
						<li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
						<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
					</ul>
				</div>
			</div>
        </div>
        <?php $this->load->view('common/footer'); ?>
    </div>
    <?php $this->load->view('common/js'); ?>
</body>
</html>