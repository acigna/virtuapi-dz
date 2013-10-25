<?php

/* Controlleur de la partie membre de VirtUAPI-DZ */
class Membre extends Controller {
    function Membre() {
        parent::Controller();    
    }
    
    function deconnexion() {
        $this->load->helper('url');
        $this->load->library('session');
        $this->session->sess_destroy();
        redirect(base_url(), 'location');
        die();
    }
}
?>
