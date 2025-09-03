<?php
    $conts = DistContinents();
?>
<header id="header" class=" typeheader-1">
    <div class="header-top hidden-compact">
        <div class="w-100">
            <div class="row">
                <div class="col-lg-2 col-xs-2 header-logo pull-left">
                    <div class="navbar-logo">
                        <a href="<?php echo base_url() ; ?>">
                            <img src="<?php echo base_url('assets/image/logo/logo.jpg') ; ?>" alt="Logo" width="118" height="36" title="<?php echo $this->web_title ; ?>">
                        </a>
                    </div>
                </div>
                <div class="call-us-now pull-right hidden-xs hidden-sm hidden-md">
                    <a href="tel:<?php echo $this->web_tel ; ?>">
                        <h2><i class="fa fa-phone"></i> <?php echo $this->web_phn ; ?></h2>
                    </a>
                    <!-- <a href="javascript:void(0);" class="seebank">
                        <h5 class="text-white mb-0 text-right"><i class="fa fa-university"></i> Our Bank Details</h5>
                    </a>
                    <div class="bankdetails">
                        <h2>asdfasdfasdf</h2>
                    </div> -->
                    <div class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" id="bankdetails" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <h5 class="text-white mb-0 text-right"><i class="fa fa-university"></i> Our Bank Details <span class="caret"></span></h5>
                        </a>
                        <ul class="dropdown-menu pb-0 pt-0 w-100" aria-labelledby="bankdetails">
                            <li class="bankdetails">
                                <h5 class="text-right mb-10 color-primary">RR Travel Limited</h5>
                                <p class="text-right mb-0">
                                    <strong>Account # </strong>44210817<br>
                                    <strong>Sort Code: </strong>04-00-75
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="call-icon pull-right visible-md">
                    <a href="tel:<?php echo $this->web_tel ; ?>">
                        <h2><i class="fa fa-phone"></i></h2>
                    </a>
                </div>
                <div class="call-icon-sm visible-sm visible-xs">
                    <a href="tel:<?php echo $this->web_tel ; ?>">
                        <h2><i class="fa fa-phone"></i></h2>
                    </a>
                </div>
                <div class="pull-right hidden-xs hidden-sm hidden-md">
                    <img class="pull-right mr-20 mt-20" src="<?php echo base_url('assets/image/trustpilot.png') ;?>" alt="trustpilot" width="140px">
                </div>
                <div class="header-menu">
                    <div class="megamenu-style-dev megamenu-dev">
                        <div class="responsive">
                            <nav class="navbar-default">
                                <div class="container-megamenu horizontal">
                                    <div class="navbar-header">
                                        <button type="button" id="show-megamenu" data-toggle="collapse" class="navbar-toggle">
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                        </button>
                                    </div>
                                    <div class="megamenu-wrapper">
                                        <span id="remove-megamenu" class="fa fa-times"></span>
                                        <div class="megamenu-pattern">
                                            <div class="container">
                                                <ul class="megamenu" data-transition="slide" data-animationtime="500">
                                                    <li class="<?php echo($page=='home')?'menu-home':'style-page';?>">
                                                        <a href="<?php echo base_url() ; ?>" class="clearfix font-weight-bolder text-center"><span class="hidden-xs hidden-sm"><i class="fa fa-home color-red fa-2x pr-0 mb-10"></i><br></span>Home</a>
                                                    </li>
                                                    <li class="<?php echo($page=='cheapflights')?'menu-home':'style-page';?> with-sub-menu hover">
                                                        <a href="<?php echo base_url('cheap-flights') ; ?>" class="clearfix font-weight-bolder text-center"><span class="hidden-xs hidden-sm"><i class="fa fa-globe color-red fa-2x pr-0 mb-10"></i><br></span>Cheap Flights</a>
                                                        <div class="sub-menu">
                                                            <div class="content">
                                                                <div class="row">
                                                                    <?php
                                                                        foreach ($conts as $key => $cont) {
                                                                            $img = strtolower($cont['airport_continent']);
														                    $slug = str_replace(' ','-',$img) ;
                                                                            $cities = ContsCountry($cont['airport_continent']);
                                                                    ?>
                                                                    <div class="col-md-4">
                                                                        <h3><?php echo $cont['airport_continent'] ; ?></h3>
                                                                        <ul class="row-list">
                                                                            <?php
                                                                                foreach ($cities as $key => $ct) {
                                                                                    $country = strtolower($ct['airport_country']) ;
                                                                                    $slug = str_replace(' ','-',$country) ;
                                                                            ?>
                                                                            <li><a class="subcategory_item" href="<?php echo base_url('destinations/'.$slug) ; ?>"><?php echo $ct['airport_country'] ; ?></a></li>
                                                                            <?php
                                                                                }
                                                                            ?>
                                                                        </ul>
                                                                    </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="<?php echo($page=='umrah')?'menu-home':'style-page';?>">
                                                        <a href="<?php echo base_url('umrah-packages') ; ?>" class="clearfix font-weight-bolder text-center"><span class="hidden-xs hidden-sm"><img style="position: relative !important;margin: 0px 0px 5px 0px !important;" src="<?php echo base_url('assets/image/umrah/mosque.png') ; ?>" width="22px" class="pr-0 mb-10"></i><br></span>Umrah Packages</a>
                                                    </li>
                                                    <li class="<?php echo($page=='whychooseus')?'menu-home':'style-page';?>">
                                                        <a href="<?php echo base_url('why-us') ; ?>" class="clearfix font-weight-bolder text-center"><span class="hidden-xs hidden-sm"><i class="fa fa-question-circle color-red fa-2x pr-0 mb-10"></i><br></span>Why Us</a>
                                                    </li>
                                                    <li class="<?php echo($page=='aboutus')?'menu-home':'style-page';?>">
                                                        <a href="<?php echo base_url('about-us') ; ?>" class="clearfix font-weight-bolder text-center"><span class="hidden-xs hidden-sm"><i class="fa fa-info-circle color-red fa-2x pr-0 mb-10"></i><br></span>About Us</a>
                                                    </li>
                                                    <li class="<?php echo($page=='faqs')?'menu-home':'style-page';?>">
                                                        <a href="<?php echo base_url('faqs') ; ?>" class="clearfix font-weight-bolder text-center"><span class="hidden-xs hidden-sm"><i class="fa fa-weixin color-red fa-2x pr-0 mb-10"></i><br></span>Faq's</a>
                                                    </li>
                                                    <!-- <li class="<?php echo($page=='contactus')?'menu-home':'style-page';?>">
                                                        <a href="<?php echo base_url('contact-us') ; ?>" class="clearfix font-weight-bolder text-center"><span class="hidden-xs hidden-sm"><i class="fa fa-headphones color-red fa-2x pr-0 mb-10"></i><br></span>Contact Us</a>
                                                    </li> -->
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>