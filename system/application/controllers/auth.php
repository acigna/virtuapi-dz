<?php

/* Controlleur de la partie authentification de VirtUAPI-DZ */
class Auth extends Controller {
    function Membre() {
        parent::Controller();    
    }
    
    //Inscription sur le site
    function inscription() {
        $this->load->library("oms");
        $this->load->view("auth/inscription");
    }
    
    //Déconnexion du site
    function deconnexion() {
        $this->load->helper('url');
        $this->load->library('session');
        $this->session->sess_destroy();
        //TODO:correct a bug here
        redirect(base_url(), 'location');
        die();
    }
}
?>
