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
            // Normalize incoming params so the view (which reads $_GET) can work unchanged
            // $normalized = $this->normalizeSearchParams($data);
            // Overwrite superglobal for the view's direct access
            // $data = $normalized;
            // $p["data"]=$normalized;
            $this->load->view('flight/searchresultnew');//, $data);
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

	/**
	 * Normalize query parameters from various form field names to
	 * the keys expected by searchresultnew.php without changing the view.
	 */
	private function normalizeSearchParams($data){
		$expected = [
			'direct_flights' => ['direct_flights','nonstop','direct','is_direct'],
			'flight_type' => ['flight_type','trip_type','journey_type','type'],
			'dept_arpt' => ['dept_arpt','from','origin','departure_airport','o_deptairport','depart_airport'],
			'dest_arpt' => ['dest_arpt','to','destination','arrival_airport','o_arvlairport','arrive_airport'],
			'departure_date' => ['departure_date','depart_date','departure','outbound_date','from_date','dep_date'],
			'return_date' => ['return_date','return','inbound_date','to_date','ret_date'],
			'page' => ['page'],
			'cabin_class' => ['cabin_class','cabin','class','ticketclass'],
			'airline' => ['airline','carrier'],
			'padults' => ['padults','adults','adult_count','m_adults'],
			'pchildren' => ['pchildren','children','child_count','m_children'],
			'pinfants' => ['pinfants','infants','infant_count','m_infants'],
			'c_name' => ['c_name','name','fullname','cname'],
			'c_email' => ['c_email','email','mail','cemail'],
			'c_phone' => ['c_phone','phone','telephone','mobile','cphone']
		];

		$normalized = [];
		foreach($expected as $targetKey => $candidates){
			foreach($candidates as $key){
				if(isset($data[$key]) && $data[$key] !== ''){
					$normalized[$targetKey] = $data[$key];
					break;
				}
			}
		}

		// Sensible defaults if not provided
		if(!isset($normalized['direct_flights'])){ $normalized['direct_flights'] = 'No'; }
		if(!isset($normalized['flight_type'])){ $normalized['flight_type'] = 'Return'; }
		if(!isset($normalized['cabin_class'])){ $normalized['cabin_class'] = 'Economy'; }
		if(!isset($normalized['airline'])){ $normalized['airline'] = 'All Airlines'; }
		if(!isset($normalized['padults'])){ $normalized['padults'] = 1; }
		if(!isset($normalized['pchildren'])){ $normalized['pchildren'] = 0; }
		if(!isset($normalized['pinfants'])){ $normalized['pinfants'] = 0; }
		if(!isset($normalized['page'])){ $normalized['page'] = 'landing'; }

		// If airports provided as separate code/name parts, synthesize label format "City - CODE"
		if(!isset($normalized['dept_arpt'])){
			$fromCity = isset($data['from_city']) ? $data['from_city'] : (isset($data['origin_city']) ? $data['origin_city'] : 'London');
			$fromCode = isset($data['from_code']) ? $data['from_code'] : (isset($data['origin_code']) ? $data['origin_code'] : 'LON');
			$normalized['dept_arpt'] = $fromCity.' - '.$fromCode;
		}
		if(!isset($normalized['dest_arpt'])){
			$toCity = isset($data['to_city']) ? $data['to_city'] : (isset($data['destination_city']) ? $data['destination_city'] : 'Dubai');
			$toCode = isset($data['to_code']) ? $data['to_code'] : (isset($data['destination_code']) ? $data['destination_code'] : 'DXB');
			$normalized['dest_arpt'] = $toCity.' - '.$toCode;
		}

		return array_merge($data, $normalized);
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
