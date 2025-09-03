<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Flight extends RR_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('flights_model','flights');
        
    }
    public function index($destination=''){
        if(!$destination){
            header("Location: ./home");
        }else{
            $data = array();
            $query = "SELECT `airport_code`,`airport_name` from `airports` where `airport_name` like '%{$destination}%';";
            $result = $this->db->query($query)->row_array();
            $airport_code = $result['airport_code'] ;
            $airport_name = $result['airport_name'] ;
            $data["departure_airport"] = "London - LON" ;
            $data["destination_airport"] = $airport_name." - ". $airport_code;
            $data["dpt_c"] = "LON" ;
            $data["dpt"] = "London" ;
            $data["dst_c"] = $airport_code;
            $data["dst"] = $airport_name;
            $data["direct_flights"] = "No" ;
            $data["airline"] = "All Airlines" ;
            $data["flight_type"] = "Return" ;
            $data["cabin_class"] = "Economy" ;
            $date = strtotime("+10 day");
            $data["departure_date"] = date('d-M-Y', $date);;
            $date2 = strtotime("+30 day");
            $data["return_date"] = date('d-M-Y', $date2);
            $data["padults"] = 1 ;
            $data["pchildren"] = 0 ;
            $data["pinfants"] = 0 ;
            $data['results'] = $this->flights->boxFare($data,false) ;
            $data['arrairline'] = $this->flights->allAirlines();
            $data['arrport'] = $this->flights->allAirports();
            $data['otherairports'] = $this->flights->fareOtherairports($data);
            $data['popairports'] = $this->flights->farePopularairports($data);
            $data['search_page'] = false ; 
            $data['title'] = "Flight Search to ".$data['dst'];
            $data['meta_title'] = "Flight Search to ".$data['dst']." | ".$this->web_title;
            $data['meta_desc'] = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dignissimos earum eaque ducimus, esse incidunt eum odit totam ratione quidem culpa, inventore laborum. Ducimus sed esse sint quo, error magni laborum.';
            $data['meta_key'] = "cheap flights,flights,cheap flights from UK,cheap flights from london";
            $this->load->view('flight/searchresult', $data);
        }
    }
    public function resultsnew(){
		$data = $this->input->get(); 
		if(!$this->input->get()){
            header("Location: ./index.php");
        }else{
            $this->load->view('flight/searchresultnew');
        }
    }
    public function results(){
		$data = $this->input->get(); 
		if(!$this->input->get()){
            header("Location: ./index.php");
        }else{
            if(isset($data['page']) && $data['page'] == 'landing'){
                $form_val["direct_flights"] = $data['direct_flights'];
                $form_val["deptairport"] = $data['dept_arpt'];
                $form_val["destairport"] = $data['dest_arpt'];
                $form_val["departure_date"] = $data['departure_date'];
                $form_val["return_date"] = $data['return_date'];
                $form_val["airline"] = $data['airline'];
                $form_val["flighttype"] = $data['flight_type'];
                $form_val["ticketclass"] = $data['cabin_class'];
                $form_val["ftotal"] = '';
                $form_val["padults"] = $data['padults'];
                $form_val["pchildren"] = $data['pchildren'];
                $form_val["pinfants"] = $data['pinfants'];
                $form_val["cname"] = $data['c_name'];
                $form_val["cemail"] = $data['c_email'];
                $form_val["cphone"] = $data['c_phone'];
                $form_val["inst"] = '';
                $form_val["requesttitle"] = "Cheap Flight Search";
                // $this->flights->inqmail($form_val);
            }
            $data['departure_airport'] = $data['dept_arpt'];
            $data['destination_airport'] = $data['dest_arpt'];
            $data['dpt_c'] = substr($data['dept_arpt'], -3) ;
            $data['dst_c'] = substr($data['dest_arpt'], -3) ;
            $data['dpt'] = substr($data['dept_arpt'], 0, -6) ;
            $data['dst'] = substr($data['dest_arpt'], 0, -6) ;
            if($data['airline'] != 'All Airlines'){
                $data['airline_code'] = substr($data['airline'],-2);
                $data['airline_name'] = substr($data['airline'],0,-5);
            }else{
                $data['airline_code'] = '';
                $data['airline_name'] = '';
            }
	        $data['results'] = $this->flights->boxFare($data,false) ;
	        $data['arrairline'] = $this->flights->allAirlines();
	        $data['arrport'] = $this->flights->allAirports();
	        $data['otherairports'] = $this->flights->fareOtherairports($data);
	        $data['popairports'] = $this->flights->farePopularairports($data);
            $data['title'] = "Flight Search to ".$data['dst'];
            $data['meta_title'] = "Flight Search to ".$data['dst']." | ".$this->web_title;
            $data['meta_desc'] = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dignissimos earum eaque ducimus, esse incidunt eum odit totam ratione quidem culpa, inventore laborum. Ducimus sed esse sint quo, error magni laborum.';
            $data['meta_key'] = "cheap flights,flights,cheap flights from UK,cheap flights from london";
	        // $this->load->view('flight/searchresult', $data);
	        $this->load->view('flight/searchresultnew', $data);
        }
    }
    public function enquire()
    {
        if($this->input->get()){
            $data = $this->input->get() ;
            $this->load->library('Mobile_Detect');
            $detect = new Mobile_Detect;
            $data["ddevice"] = "Desktop";
            $data["ddeviceos"] = "";         
            // Any mobile device (phones or tablets).
            if ( $detect->isMobile() ) {
                $data["ddevice"] = "Mobile";
            }         
            // Any tablet device.
            if( $detect->isTablet() ){
                $data["ddevice"] = "Tablet";
            }         
            // Exclude tablets.
            if( $detect->isMobile() && !$detect->isTablet() ){
                $data["ddevice"] = "Mobile";
            }         
            // Check for a specific platform with the help of the magic methods:
            if( $detect->isiOS() ){
                $data["ddeviceos"] = "iOS";
            }
            
            if( $detect->isAndroidOS() ){
                $data["ddeviceos"] = "Android"; 
            }
            $data['ttlpasngr'] = (int)$data['m_adults']  + (int)$data['m_children']  + (int)$data['m_infants'] ;
            $data['title'] = "Flight Search to ".$data['o_arvlairport'];
            $data['meta_title'] = "Flight Search to ".$data['o_arvlairport']." | ".$this->web_title;
            $data['meta_desc'] = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dignissimos earum eaque ducimus, esse incidunt eum odit totam ratione quidem culpa, inventore laborum. Ducimus sed esse sint quo, error magni laborum.';
            $data['meta_key'] = "cheap flights,flights,cheap flights from UK,cheap flights from london";
            $this->load->view('flight/enquire', $data);    
        }else{
            redirect('','refresh') ;
        }
    }
    public function mail()
    {
        if($this->input->post()){
            $data = $this->input->post() ;
            if(isset($data['mail']) && $data['mail'] == 'umrah'){
                $this->flights->inqumrahmail($data);
            }else{
                $this->flights->inqmail($data);
            }
        }
        $this->load->view('flight/thankyou');
        
    }
}

/* End of file Flight.php */
