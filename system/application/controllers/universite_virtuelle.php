<?php

/* Controlleur de contactez-nous du Open Mind Students */

class Universite_virtuelle extends Controller {

	function Universite_virtuelle()
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
                
               $this->oms->partie_haute('./../','L\'université virtuelle',$this);
                      
  	       //Contenu principal ici   
		
               $contenu=$this->load->view("universite_virtuelle",'',true);             	
               echo $contenu ;
               $this->oms->partie_basse($this);
 
       }
}

?>
