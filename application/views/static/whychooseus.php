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
            $head_data['page'] = 'whychooseus'; 
            $this->load->view('common/header',$head_data); 
        ?>
        <div class="breadcrumbs mb-0">
            <div class="container">
                <div class="title-breadcrumb">Why Book With Us</div>
                <ul class="breadcrumb-cate">
                    <li><a href="<?php echo base_url() ; ?>">Home</a></li>
                    <li><a href="javascript:void(0);"><strong>Why Us</strong></a></li>
                </ul>
            </div>
        </div>
        <div id="content">
			<div class="so-page-builder">
				<?php $this->load->view('common/whychooseus'); ?>
			</div>
		</div>
        <?php $this->load->view('common/footer'); ?>
    </div>
    <?php $this->load->view('common/js'); ?>
</body>
</html>