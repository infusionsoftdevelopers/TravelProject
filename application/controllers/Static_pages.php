<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Static_pages extends RR_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('flights_model','flights');
        
    }
    
    public function searchCountry(){
		$conditions['searchTerm'] = $this->input->get('term');
        $conditions['conditions']['status'] = '1';
        $skillData = $this->flights->getCountry($conditions);
        if(!empty($skillData)){
            foreach ($skillData as $row){
                $data[] = $row['airport_name']." - ".$row['airport_code'];               
            }
        }
        echo json_encode($data);die;   
	}
    public function index()
    {
        $data['meta_title'] = $this->web_title;
        $data['meta_desc'] = "RR Travels, the UK's largest independent travel agent, specializes in providing good value, quality holidays alongside excellent customer service. ";
        $data['meta_key'] = "cheap flights,flights,cheap flights from UK,cheap flights from london";
        $data['airlines'] = $this->flights->allAirlinesform();
        $data['bestfares'] = $this->flights->bestfares();
        $data['continents'] = $this->flights->DistContinents();
        $this->load->view('static/index', $data);                
    }
    public function aboutus()
    {
        $data['meta_title'] = "About Us - ".$this->web_title ;
        $data['meta_desc'] = "RR Travels, the UK's largest independent travel agent, specializes in providing good value, quality holidays alongside excellent customer service. ";
        $data['meta_key'] = "cheap flights,flights,cheap flights from UK,cheap flights from london";
        $this->load->view('static/aboutus', $data);                
    }
    public function contactus()
    {
        if($this->input->post()){
            $this->flights->contactus($this->input->post());
            redirect("thank-you",'refresh');
        }else{
            $data['meta_title'] = "Contact Us - ".$this->web_title ;
            $data['meta_desc'] = "RR Travels, the UK's largest independent travel agent, specializes in providing good value, quality holidays alongside excellent customer service. ";
            $data['meta_key'] = "cheap flights,flights,cheap flights from UK,cheap flights from london";
            $this->load->view('static/contactus', $data);
        }
    }
    public function faqs()
    {
        $data['meta_title'] = "FAQ's - ".$this->web_title ;
        $data['meta_desc'] = "RR Travels, the UK's largest independent travel agent, specializes in providing good value, quality holidays alongside excellent customer service. ";
        $data['meta_key'] = "cheap flights,flights,cheap flights from UK,cheap flights from london";
        $this->load->view('static/faqs', $data);
    }
    public function terms()
    {
        $data['meta_title'] = "Terms and Conditions - ".$this->web_title ;
        $data['meta_desc'] = "RR Travels, the UK's largest independent travel agent, specializes in providing good value, quality holidays alongside excellent customer service. ";
        $data['meta_key'] = "cheap flights,flights,cheap flights from UK,cheap flights from london";
        $this->load->view('static/terms', $data);
    }
    public function ppolicy()
    {
        $data['meta_title'] = "Privacy Policy - ".$this->web_title ;
        $data['meta_desc'] = "RR Travels, the UK's largest independent travel agent, specializes in providing good value, quality holidays alongside excellent customer service. ";
        $data['meta_key'] = "cheap flights,flights,cheap flights from UK,cheap flights from london";
        $this->load->view('static/pp', $data);
    }
    public function disclaimer()
    {
        $data['meta_title'] = "Disclaimer - ".$this->web_title ;
        $data['meta_desc'] = "RR Travels, the UK's largest independent travel agent, specializes in providing good value, quality holidays alongside excellent customer service. ";
        $data['meta_key'] = "cheap flights,flights,cheap flights from UK,cheap flights from london";
        $this->load->view('static/disclaimer', $data);
    }
    public function whyus()
    {
        $data['meta_title'] = "Why Book With Us? - ".$this->web_title ;
        $data['meta_desc'] = "RR Travels, the UK's largest independent travel agent, specializes in providing good value, quality holidays alongside excellent customer service. ";
        $data['meta_key'] = "cheap flights,flights,cheap flights from UK,cheap flights from london";
        $this->load->view('static/whychooseus', $data);
    }
    public function umrahpackages()
    {
        $data['meta_title'] = "Umrah Packages - ".$this->web_title ;
        $data['meta_desc'] = "RR Travels, the UK's largest independent travel agent, specializes in providing good value, quality holidays alongside excellent customer service. ";
        $data['meta_key'] = "cheap flights,flights,cheap flights from UK,cheap flights from london";
        $this->load->view('static/umrah', $data);
    }
    public function cheapflights($dest='')
    {
        $data['meta_title'] = "Cheap Flights - ".$this->web_title ;
        $data['meta_desc'] = "RR Travels, the UK's largest independent travel agent, specializes in providing good value, quality holidays alongside excellent customer service. ";
        $data['meta_key'] = "cheap flights,flights,cheap flights from UK,cheap flights from london";
        $data['airlines'] = $this->flights->allAirlinesform();
        // $AIRLINES = "[";
        // foreach ($data["airlines"] as $air){
        //     $AIRLINES .=
        //         "['name' => '".$air["airline"]."',       'code' => '".$air["airline_code"]."', 'quality' => 1.25, 'hubs' => ['AUH']],<br>";
        //         // break;
        //     }
            
        //     $AIRLINES .="]";
        //     echo $AIRLINES;
        //     die();
        if($dest != ''){
            $dest = str_replace('-',' ',$dest);
            $query = "SELECT `airport_code`,`airport_name` from `airports` where `airport_name` like '%{$dest}%';";
            $result = $this->db->query($query)->row_array();
            $airport_code = $result['airport_code'] ;
            $airport_name = $result['airport_name'] ;
            $data["destination_airport"] = $airport_name." - ". $airport_code;
            $data["departure_airport"] = "London - LON";
			$data["dpt_c"] = "LON";
			$data["dpt"] = "London";
			$data["dst_c"] = $airport_code;
			$data["dst"] = $airport_name;
			$data["direct_flights"] = "No";
			$data["airline"] = "All Airlines";
			$data["flight_type"] = "Return";
			$data["cabin_class"] = "Economy";
			$date = strtotime("+10 day");
			$data["departure_date"] = date('d-M-Y', $date);;
			$date2 = strtotime("+30 day");
			$data["return_date"] = date('d-M-Y', $date2);
			$data["padults"] = 1;
			$data["pchildren"] = 0;
			$data["pinfants"] = 0;
			$data['results'] = $this->flights->boxFare($data, false);
			$data['arrairline'] = $this->flights->allAirlines();
			$data['arrport'] = $this->flights->allAirports();
			$data['otherairports'] = $this->flights->fareOtherairports($data);
			$data['popairports'] = $this->flights->farePopularairports($data);
        }
        $this->load->view('static/cheapflights', $data);
    }
    public function page_404()
    {
        $this->load->view('error404');        
    }
}

/* End of file Static_pages.php */
