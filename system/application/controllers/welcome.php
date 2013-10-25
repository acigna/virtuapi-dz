<?php

/* Controlleur de la page d'accueil de VirtUAPI-DZ */

class Welcome extends Controller {

    function Welcome() {
        parent::Controller();	
        $this->load->library('oms');
	}
        
    function index() {
        //Afficher la page d'acceuil
        $this->load->view("acceuil");             	
    }
}


