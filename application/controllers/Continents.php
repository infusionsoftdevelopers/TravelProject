<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Continents extends RR_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('flights_model','flights');
        
    }
    public function index($continents=null)
    {
        if($continents==null){
            $data = $this->flights->DistContinents();
        }else{
            $continents = str_replace('-',' ',$continents);
            $data['continent'] = $continents ;
            $data['countries'] = $this->flights->GetContCountries($continents);
            $data['meta_title'] = ucfirst($continents)." Flights ".$this->web_title;
            $data['meta_desc'] = "RR Travels, the UK's largest independent travel agent, specializes in providing good value, quality holidays alongside excellent customer service. ";
            $data['meta_key'] = "cheap flights,flights,cheap flights from UK,cheap flights from london";
            $this->load->view('flight/contdest', $data, FALSE);
            
        }
    }
}
/* End of file Continents.php */