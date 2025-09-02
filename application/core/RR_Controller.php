<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class RR_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->web = "www.rrtravels.co.uk";
        $this->web_title = "RR Travels";
        $this->phn = "0207 078 8885";
        $this->web_phn = "0207 078 8885";
        $this->web_tel = "+442070788885";
        $this->whatsapp = "+442000000000";
        $this->whatsapp_dis = "020 0000 0000";
        $this->infomail = "info@rrtravels.co.uk";
        $this->web_email = "info@rrtravels.co.uk";
        $this->inq_mail = "inquiry@rrtravels.co.uk";
    }
    

}

/* End of file AR_Controller.php */
