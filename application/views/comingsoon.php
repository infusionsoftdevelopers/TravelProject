<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Coming Soon">
    <meta name="author" content="<?php echo $this->web_title; ?>">
    <meta name="keywords" content="Error,404">
    <link rel="icon" href="<?php echo base_url('favicon.png'); ?>" type="image/png">
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url('favicon.png'); ?>">
    <title>Coming Soon</title>
    <?php $this->load->view('common/css'); ?>
</head>

<body>
    <div class="page h-100">
        <div class="page-content zindex-10">
            <div class="container text-center">
                <div class="display-2 mb-5 font-weight-semibold2">Coming Soon</div>
                <h1 class="fs-20 mb-3 font-weight-bold">We are working really hard for you to launch it soon.</h1>
                <p class="fs-14 font-weight-normal mb-7 leading-normal">Meanwhile you can visit our website and get some amazing flight deals </p><a class="btn btn-secondary px-6" href="<?php echo base_url() ; ?>"> <i class="fe fe-arrow-left"></i> Back To Home </a> <img src="<?php echo base_url('assets/images/3.png') ; ?>" alt="error404" class="img-absolute-bottom">
            </div>
        </div>
    </div>
    <?php $this->load->view('common/js'); ?>
</body>

</html>