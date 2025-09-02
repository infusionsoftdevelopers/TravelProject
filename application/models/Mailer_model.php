<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mailer_model extends CI_Model {
    public function send_inq($form_val)
    {
		$this->load->library('Mobile_Detect');
		$detect = new Mobile_Detect;
		$ddevice = "Desktop";
		$ddeviceos = "";
		if ($detect->isMobile()) {
			$ddevice = "Mobile";
		}
		if ($detect->isTablet()) {
			$ddevice = "Tablet";
		}
		if ($detect->isMobile() && !$detect->isTablet()) {
			$ddevice = "Mobile";
		}
		if ($detect->isiOS()) {
			$ddeviceos = "iOS";
		}
		if ($detect->isAndroidOS()) {
			$ddeviceos = "Android";
		}
		$dept_withcode = $form_val["deptairport"];
		$dept_code = substr($dept_withcode, -3);
		$dept_name = substr($dept_withcode, 0, -5);
		$dest_withcode = $form_val["destairport"];
		$dest_code = substr($dest_withcode, -3);
		$dest_name = substr($dest_withcode, 0, -5);

		$dept_date = $form_val["departure_date"];
		$rtn_date = $form_val["return_date"];

		$airline_withcode = $form_val["airline"];
		$flight_type = $form_val["flighttype"];
		$cabin_class = $form_val["ticketclass"];
		$selected_price = $form_val["ftotal"];

		$no_adt = $form_val["padults"];
		$no_chd = $form_val["pchildren"];
		$no_inf = $form_val["pinfants"];

		$customer_name = $form_val["name"];
		$customer_email = $form_val["cemail"];
		$customer_phone = $form_val["cphone"];
		$customer_inst = $form_val["inst"];

		$req = $form_val["requesttitle"];

		$subject = 	"$req For $dest_name By $customer_name - $ddevice $ddeviceos";
		$message = '
		<table cellspacing="10" cellpadding="10" width="100%" bgcolor="#f1fcfc">
			<tr>
				<td style="border-bottom: solid thin #b9b9b9;padding-left: 10px;"><h3>' . $req . ' For ' . $dest_name . ' By ' . $customer_name . ' - ' . $ddevice . ' ' . $ddeviceos . '</h3></td>
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
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>' . $dept_withcode . '</strong></td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Destination Airport</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>' . $dest_withcode . '</strong></td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Departure Date</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>' . $dept_date . '</strong></td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Return Date</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>' . $rtn_date . '</strong></td>									
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
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>' . $customer_name . '</strong></td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Contact #</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>' . $customer_phone . '</strong></td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Email Address</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>' . $customer_email . '</strong></td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Comments</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>' . $customer_inst . '</strong></td>
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
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>' . $airline_withcode . '</strong></td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Ticket Type</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>' . $flight_type . '</strong></td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Ticket Class</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>' . $cabin_class . '</strong></td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Selected Fare</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>' . $selected_price . '</strong></td>									
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
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>' . $no_adt . '</strong></td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Children</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>' . $no_chd . '</strong></td>
									</tr>
									<tr>
										<td width="30%" style="padding: 5px;" bgcolor="" align="left">Infants</td>
										<td width="70%" style="padding: 5px;" bgcolor="" align="left"><strong>' . $no_inf . '</strong></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		';
		$new_panel_db = $this->load->database('new_panel_db', TRUE);
		$customer_enq = "INSERT INTO `customer_enq`(`enq_date`,`enq_status`, `enq_type`, `enq_page`, `enq_device`, `enq_dept`, `enq_dest`, `enq_dept_date`, `enq_rtrn_date`, `enq_cust_name`, `enq_cust_phone`, `enq_cust_email`, `enq_cust_cmnt`, `enq_airline`, `enq_tkt_type`, `enq_tkt_class`, `enq_tkt_price`, `enq_adt`, `enq_chd`, `enq_inf`, `enq_brand`,`enq_receive_time`) VALUES (CURDATE(),'Open','Mail','$req','$ddevice $ddeviceos','$dept_withcode','$dest_withcode','" . date('Y-m-d', strtotime($dept_date)) . "','" . date('Y-m-d', strtotime($rtn_date)) . "','$customer_name','$customer_phone','$customer_email','$customer_inst','$airline_withcode','$flight_type','$cabin_class','$selected_price','$no_adt','$no_chd','$no_inf','RR Travels',NOW())";
		$new_panel_db->query($customer_enq);
		$query_status =  $new_panel_db->affected_rows();
		$new_panel_db->close();
		$sent = sendemail($this->inq_mail, $subject, $message);
		if ($query_status == 1 && $sent == 1) {
			return True;
		} else {
			return False;
		}
    }

}
/* End of file Mailer_model.php */