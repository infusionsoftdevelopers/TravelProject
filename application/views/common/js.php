<div class="back-to-top"><i class="fa fa-angle-up"></i></div>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-2.2.4.min.js') ; ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js') ; ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/themejs/so_megamenu.js') ; ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/owl-carousel/owl.carousel.js') ; ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/slick-slider/slick.js') ; ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/themejs/libs.js') ; ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/unveil/jquery.unveil.js') ; ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/countdown/jquery.countdown.min.js') ; ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/dcjqaccordion/jquery.dcjqaccordion.2.8.min.js') ; ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/moment.js') ; ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/bootstrap-datetimepicker.min.js') ; ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-ui/jquery-ui.min.js') ; ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/modernizr/modernizr-2.6.2.min.js') ; ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/minicolors/jquery.miniColors.min.js') ; ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.nav.js') ; ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/quickview/jquery.magnific-popup.min.js') ; ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/themejs/application.js') ; ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/themejs/homepage.js') ; ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/themejs/custom_h1.js') ; ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/themejs/nouislider.js') ; ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/parsley.js') ; ?>"></script>
<!--Cookie Consent-->
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
<script>
	window.addEventListener("load", function() {
		window.cookieconsent.initialise({
			"palette": {
				"popup": {
					"background": "#000"
				},
				"button": {
					"background": "#f1d600"
				},
				"cookie": {
					expiryDays: 2
				}
			}
		})
	});
</script>
<!--Cookie Consent End-->
<form action="<?php echo base_url('flight/enquire') ; ?>" method="get" name="frmrequest" id="frmrequest">
    <input type="hidden" name="o_deptdate" 	id="o_deptdate" 	value="" />
    <input type="hidden" name="o_depttime" 	id="o_depttime" 	value="" />
    <input type="hidden" name="o_deptairport" id="o_deptairport" value="" />
    <input type="hidden" name="o_arvldate" 	id="o_arvldate" 	value="" />
    <input type="hidden" name="o_arvltime" 	id="o_arvltime" 	value="" />
    <input type="hidden" name="o_arvlairport" id="o_arvlairport" value="" />
    <input type="hidden" name="o_duration" 	id="o_duration" 	value="" />
    <input type="hidden" name="o_stops" 	   id="o_stops" 	   value="" />
    <input type="hidden" name="i_deptdate" 	id="i_deptdate" 	value="" />
    <input type="hidden" name="i_depttime" 	id="i_depttime" 	value="" />
    <input type="hidden" name="i_deptairport" id="i_deptairport" value="" />
    <input type="hidden" name="i_arvldate" 	id="i_arvldate" 	value="" />
    <input type="hidden" name="i_arvltime" 	id="i_arvltime" 	value="" />
    <input type="hidden" name="i_arvlairport" id="i_arvlairport" value="" />
    <input type="hidden" name="i_duration" 	id="i_duration" 	value="" />
    <input type="hidden" name="i_stops" 	   id="i_stops" 	   value="" />
    <input type="hidden" name="m_dept" 		 id="m_dept" 	    value="" />
    <input type="hidden" name="m_dest" 		 id="m_dest" 	 	value="" />
    <input type="hidden" name="m_airlinecode"  id="m_airlinecode" value="" />
    <input type="hidden" name="m_airline" 	  id="m_airline" 	 value="" />
    <input type="hidden" name="m_adults" 	   id="m_adults" 	  value="" />
    <input type="hidden" name="m_children" 	 id="m_children" 	value="" />
    <input type="hidden" name="m_infants" 	  id="m_infants" 	 value="" />
    <input type="hidden" name="m_priceperp"    id="m_priceperp"   value="" />
    <input type="hidden" name="m_totalprice"   id="m_totalprice"  value="" />
    <input type="hidden" name="m_flight_type"    id="m_flight_type"   value="Return" />
    <input type="hidden" name="m_cabin_class"   id="m_cabin_class"  value="Economy" />
</form>
<script>
    function bookingRequest(data){
        var formElements = new Array(
            "o_deptdate", 
            "o_depttime", 
            "o_deptairport", 
            "o_arvldate", 
            "o_arvltime", 
            "o_arvlairport", 
            "o_duration", 
            "o_stops", 
            "i_deptdate", 
            "i_depttime", 
            "i_deptairport", 
            "i_arvldate", 
            "i_arvltime", 
            "i_arvlairport", 
            "i_duration", 
            "i_stops" ,
            "m_dept", 
            "m_dest", 
            "m_airlinecode", 
            "m_airline", 
            "m_adults", 
            "m_children", 
            "m_infants", 
            "m_priceperp", 
            "m_totalprice"
            );
        var fbr = document.forms.frmrequest;
        for(var i = 0; i < 25; i++){
            fbr.elements[i].value = data[i];
        }
        document.getElementById("frmrequest").submit();
    }
    $('form').parsley();
    $('.arpt').autocomplete({
        'source': "<?php echo base_url('searchCountry'); ?>",
        minChars: 3,
        position: {
            my: "left top",
            at: "left bottom"
        }
    });
    $(".departure_date").datepicker({
        minDate: -0,
        maxDate: "+12M",
        dateFormat: "dd-M-yy",
        onClose: function () {
            var t = $(".departure_date").datepicker("getDate");
            null != t && t.setDate(t.getDate() + 1), $(".return_date").datepicker("option", "minDate", t)
        }
    }).on("change", function (t) {
        $(this).parsley().validate()
    });
    $(".return_date").datepicker({
        minDate: -0,
        maxDate: "+12M",
        dateFormat: "dd-M-yy"
    }).on("change", function (t) {
        $(this).parsley().validate()
    });
    $(".flighttype").on('click',function () {
        if("Return" === $(this).val()){
            $(".return-date-selection").css({
                opacity: "1",
                "pointer-events": "inherit"
            });
            $(".return_date").prop("required", !0).parsley().validate();
        }else{
            $(".return-date-selection").css({
                opacity: "0.2",
                "pointer-events": "none"
            }); 
            $(".return_date").removeAttr("required").parsley().validate();
        }
    });
    $(".seebank").on('click', function(){
        if($(this).is(":visible")){
            $(".bankdetails").hide();
        }else{
            $(".bankdetails").show()
        }
    });
</script>