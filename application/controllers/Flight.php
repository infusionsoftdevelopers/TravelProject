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
	 * the exact keys expected by searchresultnew.php: mode, from, to, depart, return, class,
	 * airline, adults, children, infants. Leaves other incoming keys intact.
	 */
	private function normalizeSearchParams($data){
		$out = $data; // start with incoming

		// 1) From/To airport codes (IATA)
		$fromLabel = $data['dept_arpt'] ?? ($data['departure_airport'] ?? ($data['from'] ?? ($data['origin'] ?? 'London - LON')));
		$toLabel   = $data['dest_arpt'] ?? ($data['destination_airport'] ?? ($data['to'] ?? ($data['destination'] ?? 'Dubai - DXB')));
		// Extract codes if labels like "City - CODE"
		$fromCode = isset($data['from']) ? $data['from'] : substr(trim($fromLabel), -3);
		$toCode   = isset($data['to'])   ? $data['to']   : substr(trim($toLabel), -3);
		$out['from'] = strtoupper(preg_replace('/[^A-Z]/i','', $fromCode));
		$out['to']   = strtoupper(preg_replace('/[^A-Z]/i','', $toCode));

		// 2) Dates -> Y-m-d
		$depart = $data['depart'] ?? ($data['departure_date'] ?? ($data['outbound_date'] ?? ''));
		$return = $data['return'] ?? ($data['return_date'] ?? ($data['inbound_date'] ?? ''));
		$out['depart'] = $this->normalizeDateToYmd($depart);
		$out['return'] = $this->normalizeDateToYmd($return);

		// 3) Class -> expected keys: economy, premium_economy, business, first
		$classRaw = $data['class'] ?? ($data['cabin_class'] ?? ($data['ticketclass'] ?? 'economy'));
		$classMap = [
			'economy' => 'economy',
			'premium economy' => 'premium_economy',
			'premium_economy' => 'premium_economy',
			'business' => 'business',
			'first' => 'first'
		];
		$key = strtolower(trim($classRaw));
		$out['class'] = $classMap[$key] ?? 'economy';

		// 4) Trip mode
		$ftype = strtolower(trim($data['flight_type'] ?? ($data['trip_type'] ?? 'round')));
		$out['mode'] = ($ftype === 'oneway' || $ftype === 'one-way' || $ftype === 'one way') ? 'oneway' : 'round';

		// 5) Airline code (optional)
		$airline = $data['airline'] ?? '';
		if ($airline && strlen($airline) > 3) {
			// If in format "XX - Airline Name"
			$code = substr($airline, 0, 2);
			$out['airline'] = strtoupper(preg_replace('/[^A-Za-z]/','', $code));
		} else {
			$out['airline'] = strtoupper(preg_replace('/[^A-Za-z]/','', $airline));
		}

		// 6) Pax
		$out['adults']   = isset($data['adults'])   ? (int)$data['adults']   : (int)($data['padults']   ?? ($data['m_adults']   ?? 1));
		$out['children'] = isset($data['children']) ? (int)$data['children'] : (int)($data['pchildren'] ?? ($data['m_children'] ?? 0));
		$out['infants']  = isset($data['infants'])  ? (int)$data['infants']  : (int)($data['pinfants']  ?? ($data['m_infants']  ?? 0));

		return $out;
	}

	private function normalizeDateToYmd($dateStr){
		$dateStr = trim((string)$dateStr);
		if ($dateStr === '') { return ''; }
		// Try Y-m-d first
		$d = DateTime::createFromFormat('Y-m-d', $dateStr);
		if ($d) { return $d->format('Y-m-d'); }
		// Try d-M-Y (e.g., 22-Jun-2020)
		$d = DateTime::createFromFormat('d-M-Y', $dateStr);
		if ($d) { return $d->format('Y-m-d'); }
		// Try d/m/Y, m/d/Y, d-m-Y
		$formats = ['d/m/Y','m/d/Y','d-m-Y','m-d-Y','d.m.Y'];
		foreach($formats as $fmt){
			$d = DateTime::createFromFormat($fmt, $dateStr);
			if ($d) { return $d->format('Y-m-d'); }
		}
		// Fallback: return as-is
		return $dateStr;
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
