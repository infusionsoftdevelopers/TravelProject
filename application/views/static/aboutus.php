
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
            $head_data['page'] = 'aboutus'; 
            $this->load->view('common/header',$head_data); 
        ?>
        <div class="breadcrumbs mb-0">
            <div class="container">
                <div class="title-breadcrumb">About Us</div>
                <ul class="breadcrumb-cate">
                    <li><a href="<?php echo base_url() ; ?>">Home</a></li>
                    <li><a href="javascript:void(0);"><strong>About Us</strong></a></li>
                </ul>
            </div>
        </div>
        <div id="content">
			<div class="so-page-builder">
                <section class="section-style1 mt-20">
                    <div class="container page-builder-ltr">
                        <div class="row row-style row_a1">
                            <div class="col-lg-7 col-md-7 col-sm-6 col-xs-12 col_a1c about-text">
                                <h3><span>About us</span></h3>
                                <p class="text-justify">RR Travels, the UK's largest independent travel agency, specializes in providing good value and quality holidays, alongside excellent customer service. The company has come a long way since its humble beginnings. Today, we are proud to be the UK's largest independent travel agent.</p>
                                <ul>
                                    <li><i class="fa fa-check-circle-o" aria-hidden="true"></i>Hundreds of Airlines</li>
                                    <li><i class="fa fa-check-circle-o" aria-hidden="true"></i>More than 2000 Deals</li>
                                    <li><i class="fa fa-check-circle-o" aria-hidden="true"></i>First Class Flights</li>
                                    <li><i class="fa fa-check-circle-o" aria-hidden="true"></i>Inclusive Packages</li>
                                </ul>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12 col_a1c about-video">
                                <img src="<?php echo base_url("assets/image/about-us.jpg")?>" alt="about us" class="img-responsive">
                            </div>
                            <div class="col-xs-12 mt-30">
                                <p class="text-justify">Our well-travelled and trained staff pride themselves in providing excellent customer service to every client who trusts us with their holiday arrangements. Our independence means we have access to a wide choice of tour operators and airlines, and we always endeavor to find the perfect holiday for the best possible price.<br>As we're constantly expanding, we're always looking for people to join the team. ToPeople who are like us and are passionate about this industry. People who want to enjoy the rewards of their work. People who want to share in the success of this company which continues to go from strength to strength are always welcomed.</p>
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