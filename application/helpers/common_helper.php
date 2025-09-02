<?php
function sendemail($to = '', $subject, $message, $attach = '') {
    $CI = & get_instance();
    
    $CI->load->library('email');
    $config = array();
    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'mail.supremecluster.com';
    $config['smtp_user'] = 'webmail@rrtravels.co.uk';
    $config['smtp_pass'] = 'c3or17QGV&';
    $config['smtp_port'] = 465;
    $config['smtp_crypto'] = 'ssl';
    $CI->email->initialize($config);
    $config['mailtype'] = 'html';
    $CI->email->initialize($config);
    $cc = "";
    $bcc = "";
    $CI->email->from('webmail@rrtravels.co.uk', 'Flight RR Inquiry');
    if (!empty($to)) {
        $CI->email->to($to);
    }
    $CI->email->reply_to('info@rrtravels.co.uk', 'Flight RR Inquiry');
    if (!empty($cc)) {
        $CI->email->cc($cc);
    }
    if (!empty($bcc)) {
        $CI->email->bcc($bcc);
    }
    $CI->email->subject($subject);
    $CI->email->message($message);
    if ($attach != '') {
        $CI->email->attach($attach);
    }    
    return $CI->email->send();
}
function contidestcount($conti = null)
{
    $CI = & get_instance();
    $CI->db->where('airport_continent',$conti);
    return  $CI->db->count_all_results('airports');
}
function getdestbycountry($country = NULL){
    $CI = & get_instance();
    $CI->db->select('airport_name');
    $CI->db->from('airports a');
    $CI->db->where('a.airport_country', $country);
    $data = $CI->db->get()->row_array();
    return $data['airport_name'] ;
}
function custom_substr($x, $length) {
    if (strlen($x) <= $length) {
        return $x;
    } else {
        $y = substr($x, 0, $length) . '...';
        return $y;
    }
}
function DistContinents(){
    $CI = & get_instance();
    $CI->db->select('airport_continent');
    $CI->db->where('airport_continent !=', '');		
    $CI->db->group_by('airport_continent');		
    return $CI->db->get('airports')->result_array();		
}
function ContsCountry($cont){
    $country = array(
        'Europe' => array(
            array( 'airport_country' => 'France'),
            array( 'airport_country' => 'Germany'),
            array( 'airport_country' => 'Netherlands'),
            array( 'airport_country' => 'Belgium'),
        ),
        'Asia' => array(
            array( 'airport_country' => 'Malaysia'),
            array( 'airport_country' => 'UAE'),
            array( 'airport_country' => 'Thailand'),
            array( 'airport_country' => 'Hong Kong'),
        ),
        'North America' => array(
            array( 'airport_country' => 'Bahamas'),
            array( 'airport_country' => 'Cuba'),
            array( 'airport_country' => 'Jamaica'),
            array( 'airport_country' => 'United States'),
        ),
        'Africa' => array(
            array( 'airport_country' => 'Algeria'),
            array( 'airport_country' => 'Cameroon'),
            array( 'airport_country' => 'Ghana'),
            array( 'airport_country' => 'Gambia'),
        ),
        'Oceania' => array(
            array( 'airport_country' => 'Australia'),
            array( 'airport_country' => 'New Zealand'),
            array( 'airport_country' => 'American Samoa'),
            array( 'airport_country' => 'Tonga'),
        ),
        'South America' => array(
            array( 'airport_country' => 'Brazil'),
            array( 'airport_country' => 'Colombia'),
            array( 'airport_country' => 'Ecuador'),
            array( 'airport_country' => 'Peru'),
        ),
    );
    return $country[$cont];		
}
?>