<?php

/* Controlleur de la première news du VirtUAPI-DZ */

class News1 extends Controller {

    function News1() {
        parent::Controller();	
        $this->load->library('oms');
    }
        
    function index() {
        $this->load->view("news1");             	
    }
}

?>
