<!DOCTYPE html>
<html lang="en">
<head>
	<title>Thank you - <?php echo $this->web_title ; ?></title>
	<meta charset="utf-8">
	<meta name="keywords" content="<?php echo @$meta_key; ?>" />
	<meta name="description" content="<?php echo @$meta_desc; ?>" />
	<meta name="author" content="<?php echo $this->web_title; ?>">
	<meta name="robots" content="index, follow" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?php $this->load->view('common/css'); ?>
</head>
<body class="common-home res layout-1">
	<div id="wrapper" class="wrapper-fluid banners-effect-10">
        <?php
            $head_data['page'] = ''; 
            $this->load->view('common/header',$head_data); 
        ?>
        <div class="main-404 container">   
            <div class="content">
                <h2 style="font-size: 82px !important;">Thank You</h2>
                <p>We will be right with you<br>For more details you can call us on <?php echo $this->web_phn ; ?></p>
                <a href="<?php echo base_url() ; ?>" class="go-home">back to home</a>
            </div>
        </div>
        <?php $this->load->view('common/footer'); ?>
    </div>
    <?php $this->load->view('common/js'); ?>
</body>
</html>