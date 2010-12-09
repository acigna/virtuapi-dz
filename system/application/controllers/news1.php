<?php

/* Controlleur de la première news du Open Mind Students */

class News1 extends Controller {

	function News1()
	{
		parent::Controller();	
		$this->load->library('oms');
	}
        
        
        function Deconnection()
        {
          	$this->oms->Deconnection($this);
        }
        
        
       	function index()
	{
                
               $this->oms->partie_haute('./../','L\'équipe de Open Mind Students',$this);
                      
  	       //Contenu principal ici   
		
               $contenu=$this->load->view("news1",'',true);             	
               echo $contenu ;
               $this->oms->partie_basse($this);
 
       }
}

?>
