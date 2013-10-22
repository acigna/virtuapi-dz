<?php

//Helper pour charger les formulaire à travers une class librairie formulaire
function load_form( $obj, $config, $err_delim1="", $err_delim2="", $req_msg="" ) {
    $CI = $obj->CI = & get_instance();
    $CI->load->library('form_validation');
    $CI->load->helper('form');
    $CI->form = $obj;
    $obj->form_validation = $CI->form_validation;
    $obj->form_validation->set_rules($config);
    $obj->form_validation->set_error_delimiters( $err_delim1, $err_delim2 );
    $obj->form_validation->set_message( 'required', $req_msg ); 
}


?>
