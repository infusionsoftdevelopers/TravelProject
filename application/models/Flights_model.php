<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Flights_model extends RR_Model {
	public function DistContinents()
	{
		$this->db->select('airport_continent');
		$this->db->where('airport_continent !=', '');		
		$this->db->group_by('airport_continent');		
		return $this->db->get('airports')->result_array();		
	}
	public function GetContCountries($cont)
	{
		$this->db->select('airport_country,airport_continent,airport_country_code');
		$this->db->from('airports a');
		$this->db->where('a.airport_continent', $cont);
		$this->db->group_by('a.airport_country');
		return $this->db->get()->result_array();
	}
	public function GetDistContDest($cont)
	{
		$this->db->select('airport_code,airport_name,airport_country,airport_continent,airport_country_code');
		$this->db->from('airports a');
		$this->db->where('a.airport_continent', $cont);
		$this->db->group_by('a.airport_code');
		return $this->db->get()->result_array();		
	}
	public function bestfares()
	{
		$date = date('Y-m-d');
		// Simple approach: get all fares and then find the best one for each destination
		$this->db->select("f_tocode, f_to, f_seasonstartdate, f_seasonenddate, f_from, f_fromcode, f_cabin, f_type, f_airlinecode, f_airline, f_adultbasic, f_adulttax, (f_adultbasic + f_adulttax) as price");
		$this->db->from('fares');
		$this->db->where("f_cabin = 'Economy' AND f_type = 'Return' AND f_seasonstartdate <= '$date' AND f_seasonenddate >= '$date' AND  f_tocode IN('BJL','DXB','ALG','NBO','SIN','IST','ADD','AUH','AMS','CDG') AND f_fromcode = 'LHR'");
		$this->db->order_by("(f_adultbasic + f_adulttax)", "ASC");
		$query = $this->db->get();
		$result = ($query->num_rows() > 0) ? $query->result_array() : FALSE;
		
		if ($result) {
			// Group by destination and keep only the cheapest fare for each
			$grouped = array();
			foreach ($result as $row) {
				$key = $row['f_tocode'] . '_' . $row['f_to'];
				if (!isset($grouped[$key]) || $row['price'] < $grouped[$key]['price']) {
					$grouped[$key] = $row;
				}
			}
			// Convert back to array and limit to 8
			$result = array_values($grouped);
			$result = array_slice($result, 0, 8);
			// Shuffle the results
			shuffle($result);
		}
		
		return $result;
	}
    public function getCountry($params = array())
	{
		$this->db->select("airport_code,airport_name,airport_airport");
		$this->db->from('airports');
		if (!empty($params['searchTerm'])) {
			$q = $params['searchTerm'];
			if (strlen($q) == 3) {
				$this->db->where('airport_code', $q);
			} else {
				$this->db->where('airport_name SOUNDS LIKE', $q);
				$this->db->or_like('airport_airport', $q);
				$this->db->or_like('airport_name', $q);
				$this->db->or_like('airport_code', $q);
			}
		}
		$this->db->order_by('airport_name', 'asc');
		$query = $this->db->get();
		$result = ($query->num_rows() > 0) ? $query->result_array() : FALSE;
		return $result;
	}
    public function allAirlinesform()
	{
		$this->db->select("CONCAT(airline_code,' - ',airline_name) as airline,airline_code");
		$this->db->order_by('airline_code', 'asc');
		$query = $this->db->get('airlines');
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			return $result;
		}
	}
	public function allAirports()
	{
		//fetcheing all airports for display
		$arrport = array();

		$this->db->select("`airport_code`,CONCAT(`airport_name`, ' - ', `airport_code`) as airport");
		$this->db->from('`airports`');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			foreach ($result as $key => $rowairport) {
				$acode = $rowairport['airport_code'];
				$aname = $rowairport['airport'];
				$arrport["$acode"] = str_replace("'", " ", $aname);
			}
			return $arrport;
		}
	}
	public function allAirlines()
	{
		//fetcheing all airlines for display
		$arrairline = array();
		$this->db->select("`airline_code`,`airline_name`");
		$this->db->from('`airlines`');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			foreach ($result as $key => $rowairline) {
				$arcode = $rowairline['airline_code'];
				$arname = $rowairline['airline_name'];
				$arrairline["$arcode"] = str_replace("'", " ", $arname);
			}
			return $arrairline;
		}
	}
	public function boxFare($data, $count = false)
	{
		$dept = $data['departure_airport'];
		$dpt = $data['dpt'];
		$dpt_c = $data['dpt_c'];

		$dest = $data['destination_airport'];
		$dst = $data['dst'];
		$dst_c = $data['dst_c'];

		$dpt_date = $data['departure_date'];
		$rtn_date = $data['return_date'];

		$airline = $data['airline'];
		if ($airline != 'All Airlines') {
			$airline_c = $data['airline_code'];
			$airline_n = $data['airline_name'];
		}

		$flight_type = $data['flight_type'];
		$cabin_class = $data['cabin_class'];

		$adt = $data['padults'];
		$chd = $data['pchildren'];
		$inf = $data['pinfants'];
		if ($dpt_c == "LON") {
			$dpt_c = array('LON', 'LHR', 'LGW', 'LCY', 'STN');
		}
		$this->db->select("*");
		$this->db->from('`fares`');
		$this->db->where('`f_tocode`', $dst_c);
		$this->db->where_in('`f_fromcode`', $dpt_c);
		$this->db->where('`f_cabin`', $cabin_class);
		$this->db->where('`f_type`', $flight_type);
		$this->db->where('`f_seasonstartdate` <=', date('Y-m-d', strtotime($dpt_date)));
		$this->db->where('`f_seasonenddate` >=', date('Y-m-d', strtotime($dpt_date)));
		$this->db->ORDER_BY('(`f_adultbasic` + `f_adulttax`)');
		if ($airline != '' && $airline != 'All Airlines') {
			$this->db->where('`f_airlinecode`', $airline_c);
		}
		if (isset($dat['direct_flights']) && $data['direct_flights'] == 'Yes') {
			$this->db->where('outlegscount', 1);
			$this->db->where('inlegscount', 1);
		}
		if ($count) {
			return $this->db->count_all_results();
		} else {
			$query = $this->db->get();
			$farefound =  $query->num_rows();
			if ($farefound > 0) {
				return $query->result_array();
			} else {
				return FALSE;
			}
		}
	}
	public function fareOtherairports($dat)
	{
		$this->db->select("`f_to`, `f_tocode`, `f_from`, `f_fromcode`, min(`f_seasonstartdate`) as s_date, min(`f_seasonenddate`) as e_date, min(`f_adultbasic`+`f_adulttax`) as price");
		$this->db->from('`fares`');
		$this->db->where('`f_tocode`', $dat['dst_c']);
		$this->db->LIKE('`f_cabin`', $dat['cabin_class']);
		$this->db->where('`f_type`', $dat['flight_type']);
		$this->db->where('`f_seasonstartdate` <=', date('Y-m-d', strtotime($dat['departure_date'])));
		$this->db->where('`f_seasonenddate` >=', date('Y-m-d', strtotime($dat['departure_date'])));
		$this->db->GROUP_BY('`f_to`, `f_tocode`, `f_from`, `f_fromcode`');
		$this->db->ORDER_BY('`f_seasonstartdate`');
		return $this->db->get()->result_array();
	}
	public function farePopularairports($dat = array())
	{
		$departure_airport = $dat['departure_airport'];
		$departure_airport_code = substr($departure_airport, -3); // <-- getting departure airport code

		$destination_airport = $dat['destination_airport'];
		$destination_airport_code = substr($destination_airport, -3); // <-- getting destination airport code\

		$departure_date = $dat['departure_date'];
		$return_date = $dat['return_date'];

		$airline = $dat['airline'];
		$airline_code = substr($dat['airline'], -2);

		$flight_type = $dat['flight_type'];
		$cabin_class = $dat['cabin_class'];
		$adults = $dat['padults'];
		$children = $dat['pchildren'];
		$infants = $dat['pinfants'];
		if ($departure_airport_code == "LON") {
			$departure_airport_code = array('LON', 'LHR', 'LGW', 'LCY', 'STN');
		}
		$air_name = substr($destination_airport, 0, -6);
		$destinrow = array();
		$this->db->select("*");
		$this->db->from('`airports`');
		$this->db->where('`airport_name`', $air_name);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			foreach ($result as $row) {
				$destinrow = $row;
			}
		}
		$country = @$destinrow['airport_country'];
		$this->db->SELECT("f.f_to ,min(f.f_adultbasic+f.f_adulttax) as price, min(f.f_seasonstartdate) as sd, min(f.f_seasonenddate) as ed");
		$this->db->FROM('fares f');
		$this->db->JOIN('airports a', 'f.f_tocode = a.airport_code', 'left');
		$this->db->WHERE_IN('f.f_fromcode', $departure_airport_code);
		$this->db->WHERE('f.f_cabin', $cabin_class);
		$this->db->WHERE('f.f_type', $flight_type);
		$this->db->WHERE('a.airport_country', $country);
		$this->db->WHERE('f.f_seasonstartdate <=', date('Y-m-d', strtotime($departure_date)));
		$this->db->WHERE('f.f_seasonenddate >=', date('Y-m-d', strtotime($departure_date)));
		$this->db->GROUP_BY('f.f_to');
		$this->db->ORDER_BY('min(f.f_adultbasic+f.f_adulttax)');
		$this->db->LIMIT('10');
		return $this->db->get()->result_array();
	}
	public function inqumrahmail($form_val = array()){
		$site_address = $to = 'info@rrtravels.co.uk';
		$this->load->library('Mobile_Detect');
		$detect = new Mobile_Detect;
		$ddevice = "Desktop";
		$ddeviceos = "";         
		// Any mobile device (phones or tablets).
		if ( $detect->isMobile() ) {
			$ddevice = "Mobile";
		}         
		// Any tablet device.
		if( $detect->isTablet() ){
			$ddevice = "Tablet";
		}         
		// Exclude tablets.
		if( $detect->isMobile() && !$detect->isTablet() ){
			$ddevice = "Mobile";
		}         
		// Check for a specific platform with the help of the magic methods:
		if( $detect->isiOS() ){
			$ddeviceos = "iOS";
		}
			
		if( $detect->isAndroidOS() ){
			$ddeviceos = "Android"; 
		}
		$direct_flights = (@$form_val["direct_flights"] == 'Yes')? 'Yes' : 'No' ;
		$dept_withcode = $form_val["dept_arpt"];
		$dept_code = substr($dept_withcode,-3);
		$dept_name = substr($dept_withcode,0,-5);
		$dest_withcode = $form_val["dest_arpt"];
		$dest_code = substr($dest_withcode,-3);
		$dest_name = substr($dest_withcode,0,-5);
		
		$dept_date = $form_val["departure_date"];

		$no_adt = $form_val["padults"];
		$no_chd = $form_val["pchildren"];
		$no_inf = $form_val["pinfants"];

		$customer_name = $form_val["cust_name"];
		$customer_email = $form_val["cust_email"];
		$customer_phone = $form_val["cust_mob"];
		$mec_stay = $form_val['mecca_nights'] ;
		$med_stay = $form_val['madina_nights'] ;
		$no_rooms = $form_val['room'] ;
		$no_stars = $form_val['accommodation'] ;

		$form_val["requesttitle"] = "Umrah Package Request";
		$req = $form_val["requesttitle"];

		$subject = 	"$req For $dest_name By $customer_name - $ddevice $ddeviceos";
		$message = '
		<table cellspacing="10" cellpadding="10" width="100%" bgcolor="#f1fcfc">
			<tr>
				<td style="border-bottom: solid thin #b9b9b9;padding-left: 10px;"><h3>'.$req.' For '.$dest_name.' By '.$customer_name.' - '.$ddevice.' '.$ddeviceos.'</h3></td>
			</tr>
			<tr>
				<td>
					<table cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td width="50%">
								<table cellspacing="0" cellpadding="0" width="100%">
									<tr>
										<td colspan="2">
											<h4>Flight Details</h4>
										</td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Departure Airport</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>'.$dept_withcode.'</strong></td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Destination Airport</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>'.$dest_withcode.'</strong></td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Departure Date</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>'.$dept_date.'</strong></td>
									</tr>
								</table>
							</td>
							<td width="50%">
								<table cellspacing="0" cellpadding="0" width="100%">
									<tr>
										<td colspan="2">
											<h4>Contact Details</h4>
										</td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Customer Name</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>'.$customer_name.'</strong></td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Contact #</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>'.$customer_phone.'</strong></td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Email Address</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>'.$customer_email.'</strong></td>
									</tr>
								</table>
							</td>
							
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td style="border-top: thin dotted #000000">
					<table cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td width="50%">
								<table cellspacing="0" cellpadding="0" width="100%">
									<tr>
										<td colspan="2">
											<h4>Preference</h4>
										</td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Stay in Mecca</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>'.$mec_stay.'</strong></td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Stay in Madina</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>'.$med_stay.'</strong></td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">No. Of Rooms</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>'.$no_rooms.'</strong></td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">No. Of Stars</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>'.$no_stars.'</strong></td>
									</tr>
								</table>
							</td>
							<td width="50%">
								<table cellspacing="0" cellpadding="0" width="100%">
									<tr>
										<td colspan="2">
											<h4>Total No. Of Passengers</h4>
										</td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Adults</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>'.$no_adt.'</strong></td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Children</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>'.$no_chd.'</strong></td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Infants</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>'.$no_inf.'</strong></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		';
		$umrahdetails = '<br>Rooms: '.$no_rooms.', Stars: '.$no_stars.'<br>Makkah: '.$mec_stay.' Nights, Madina: '.$med_stay.' Nights' ; 
		$panel_db = $this->load->database('panel_db', TRUE);
		$query_customer = "INSERT INTO customer_enquiry VALUES (NULL, CURDATE(),'$subject','$message','','RR Travels', NOW(), '','','1')";
		$panel_db->query($query_customer);
		$new_panel_db = $this->load->database('new_panel_db', TRUE);
		$customer_enq = "INSERT INTO `customer_enq`(`enq_date`,`enq_status`, `enq_type`, `enq_page`, `enq_device`, `enq_dept`, `enq_dest`, `enq_dept_date`, `enq_rtrn_date`, `enq_cust_name`, `enq_cust_phone`, `enq_cust_email`, `enq_cust_cmnt`, `enq_airline`, `enq_tkt_type`, `enq_tkt_class`, `enq_tkt_price`, `enq_adt`, `enq_chd`, `enq_inf`, `enq_brand`,`enq_receive_time`) VALUES (CURDATE(),'Open','Mail','$req','$ddevice $ddeviceos','$dept_withcode','$dest_withcode','" . date('Y-m-d', strtotime($dept_date)) . "','','$customer_name','$customer_phone','$customer_email','$umrahdetails','','','','','$no_adt','$no_chd','$no_inf','RR Travels',NOW())";
		$new_panel_db->query($customer_enq);
		$query_status =  $new_panel_db->affected_rows();
		$new_panel_db->close();
		$sent = sendemail($to, $subject, $message);
		if($sent == 1){
			return True;
		}else{
			return False;
		}
	}
	public function inqmail($form_val = array()){
		$site_address = $to = 'info@rrtravels.co.uk';
		$this->load->library('Mobile_Detect');
		$detect = new Mobile_Detect;
		$ddevice = "Desktop";
		$ddeviceos = "";         
		// Any mobile device (phones or tablets).
		if ( $detect->isMobile() ) {
			$ddevice = "Mobile";
		}         
		// Any tablet device.
		if( $detect->isTablet() ){
			$ddevice = "Tablet";
		}         
		// Exclude tablets.
		if( $detect->isMobile() && !$detect->isTablet() ){
			$ddevice = "Mobile";
		}         
		// Check for a specific platform with the help of the magic methods:
		if( $detect->isiOS() ){
			$ddeviceos = "iOS";
		}
			
		if( $detect->isAndroidOS() ){
			$ddeviceos = "Android"; 
		}
		$direct_flights = (@$form_val["direct_flights"] == 'Yes')? 'Yes' : 'No' ;
		$dept_withcode = $form_val["deptairport"];
		$dept_code = substr($dept_withcode,-3);
		$dept_name = substr($dept_withcode,0,-5);
		$dest_withcode = $form_val["destairport"];
		$dest_code = substr($dest_withcode,-3);
		$dest_name = substr($dest_withcode,0,-5);
		
		$dept_date = $form_val["departure_date"];
		$rtn_date = $form_val["return_date"];

		$airline_withcode = $form_val["airline"];
		$flight_type = $form_val["flighttype"];
		$cabin_class = $form_val["ticketclass"];
		$selected_price = $form_val["ftotal"];

		$no_adt = $form_val["padults"];
		$no_chd = $form_val["pchildren"];
		$no_inf = $form_val["pinfants"];

		$customer_name = $form_val["cname"];
		$customer_email = $form_val["cemail"];
		$customer_phone = $form_val["cphone"];
		$customer_inst = $form_val["inst"];

		$req = $form_val["requesttitle"];

		$subject = 	"$req For $dest_name By $customer_name - $ddevice $ddeviceos";
		$message = '
		<table cellspacing="10" cellpadding="10" width="100%" bgcolor="#f1fcfc">
			<tr>
				<td style="border-bottom: solid thin #b9b9b9;padding-left: 10px;"><h3>'.$req.' For '.$dest_name.' By '.$customer_name.' - '.$ddevice.' '.$ddeviceos.'</h3></td>
			</tr>
			<tr>
				<td>
					<table cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td width="50%">
								<table cellspacing="0" cellpadding="0" width="100%">
									<tr>
										<td colspan="2">
											<h4>Flight Details</h4>
										</td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Departure Airport</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>'.$dept_withcode.'</strong></td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Destination Airport</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>'.$dest_withcode.'</strong></td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Departure Date</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>'.$dept_date.'</strong></td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Return Date</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>'.$rtn_date.'</strong></td>									
									</tr>
								</table>
							</td>
							<td width="50%">
								<table cellspacing="0" cellpadding="0" width="100%">
									<tr>
										<td colspan="2">
											<h4>Contact Details</h4>
										</td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Customer Name</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>'.$customer_name.'</strong></td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Contact #</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>'.$customer_phone.'</strong></td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Email Address</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>'.$customer_email.'</strong></td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Comments</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>'.$customer_inst.'</strong></td>
									</tr>
								</table>
							</td>
							
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td style="border-top: thin dotted #000000">
					<table cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td width="50%">
								<table cellspacing="0" cellpadding="0" width="100%">
									<tr>
										<td colspan="2">
											<h4>Preference</h4>
										</td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Preffered Airline</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>'.$airline_withcode.'</strong></td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Ticket Type</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>'.$flight_type.'</strong></td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Ticket Class</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>'.$cabin_class.'</strong></td>
									</tr>
									';
		if($selected_price != 0){ 
			$message.='				<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Selected Fare</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>'.$selected_price.'</strong></td>									
									</tr>
									';
		}
		$message.='
								</table>
							</td>
							<td width="50%">
								<table cellspacing="0" cellpadding="0" width="100%">
									<tr>
										<td colspan="2">
											<h4>Total No. Of Passengers</h4>
										</td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Adults</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>'.$no_adt.'</strong></td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Children</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>'.$no_chd.'</strong></td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Infants</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>'.$no_inf.'</strong></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		';
		$panel_db = $this->load->database('panel_db', TRUE);
		$query_customer = "INSERT INTO customer_enquiry VALUES (NULL, CURDATE(),'$subject','$message','','RR Travels', NOW(), '','','1')";
		$panel_db->query($query_customer);
		$new_panel_db = $this->load->database('new_panel_db', TRUE);
		$customer_enq = "INSERT INTO `customer_enq`(`enq_date`,`enq_status`, `enq_type`, `enq_page`, `enq_device`, `enq_dept`, `enq_dest`, `enq_dept_date`, `enq_rtrn_date`, `enq_cust_name`, `enq_cust_phone`, `enq_cust_email`, `enq_cust_cmnt`, `enq_airline`, `enq_tkt_type`, `enq_tkt_class`, `enq_tkt_price`, `enq_adt`, `enq_chd`, `enq_inf`, `enq_brand`,`enq_receive_time`) VALUES (CURDATE(),'Open','Mail','$req','$ddevice $ddeviceos','$dept_withcode','$dest_withcode','" . date('Y-m-d', strtotime($dept_date)) . "','" . date('Y-m-d', strtotime($rtn_date)) . "','$customer_name','$customer_phone','$customer_email','$customer_inst','$airline_withcode','$flight_type','$cabin_class','$selected_price','$no_adt','$no_chd','$no_inf','RR Travels',NOW())";
		$new_panel_db->query($customer_enq);
		$query_status =  $new_panel_db->affected_rows();
		$new_panel_db->close();
		$sent = sendemail($to, $subject, $message);
		if($sent == 1){
			return True;
		}else{
			return False;
		}
	}
	public function contactus($form_val=''){
		$site_address = $to = 'info@rrtravels.co.uk';
		$this->load->library('Mobile_Detect');
        $detect = new Mobile_Detect;
        $ddevice = "Desktop";
        $ddeviceos = "";         
        // Any mobile device (phones or tablets).
        if ( $detect->isMobile() ) {
            $ddevice = "Mobile";
        }         
        // Any tablet device.
        if( $detect->isTablet() ){
            $ddevice = "Tablet";
        }         
        // Exclude tablets.
        if( $detect->isMobile() && !$detect->isTablet() ){
            $ddevice = "Mobile";
        }         
        // Check for a specific platform with the help of the magic methods:
        if( $detect->isiOS() ){
            $ddeviceos = "iOS";
        }
         
        if( $detect->isAndroidOS() ){
            $ddeviceos = "Android"; 
        }
        $customer_name = $form_val["name"];
		$customer_email = $form_val["email"];
		$customer_phone = $form_val["phone"];
		$customer_inst = $form_val["enquiry"];

		$req = "Contact us";

		$subject = 	"$req - $customer_name - $ddevice $ddeviceos";
		$message = '
		<table cellspacing="10" cellpadding="10" width="100%" bgcolor="#f1fcfc">
			<tr>
				<td style="border-bottom: solid thin #b9b9b9;padding-left: 10px;"><h3>'.$req.' - '.$customer_name.' - '.$ddevice.' '.$ddeviceos.'</h3></td>
			</tr>
			<tr>
				<td>
					<table cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td>
								<table cellspacing="0" cellpadding="0" width="100%">
									<tr>
										<td colspan="2">
											<h4>Contact Details</h4>
										</td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Customer Name</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>'.$customer_name.'</strong></td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Contact #</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>'.$customer_phone.'</strong></td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Email Address</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>'.$customer_email.'</strong></td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Comments</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>'.$customer_inst.'</strong></td>
									</tr>
								</table>
							</td>							
						</tr>
					</table>
				</td>
			</tr>
		</table>
		';
		$panel_db = $this->load->database('panel_db', TRUE);
		$query_customer = "INSERT INTO customer_enquiry VALUES (NULL, CURDATE(),'$subject','$message','','RR Travels', NOW(), '','','1')";
		$panel_db->query($query_customer);
		$new_panel_db = $this->load->database('new_panel_db', TRUE);
		$customer_enq = "INSERT INTO `customer_enq`(`enq_date`,`enq_status`, `enq_type`, `enq_page`, `enq_device`, `enq_dept`, `enq_dest`, `enq_dept_date`, `enq_rtrn_date`, `enq_cust_name`, `enq_cust_phone`, `enq_cust_email`, `enq_cust_cmnt`, `enq_airline`, `enq_tkt_type`, `enq_tkt_class`, `enq_tkt_price`, `enq_adt`, `enq_chd`, `enq_inf`, `enq_brand`,`enq_receive_time`) VALUES (CURDATE(),'Open','Mail','$req','$ddevice $ddeviceos','','','','','$customer_name','$customer_phone','$customer_email','$customer_inst','','','','','','','','RR Travels',NOW())";
		$new_panel_db->query($customer_enq);
		$query_status =  $new_panel_db->affected_rows();
		$new_panel_db->close();
		$sent = sendemail($to, $subject, $message);
		if($sent == 1){
			return True;
		}else{
			return False;
		}
	}
}
/* End of file Flights_model.php */