<?php

/* Controlleur de contactez-nous du Open Mind Students */

class Contact extends Controller {

	function Contact()
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
                
               $this->oms->partie_haute('./../','Contactez-nous',$this);
                      
  	       //Contenu principal ici   
		
                $contenu=$this->load->view("contact",'',true);             	
                echo $contenu ;
               $this->oms->partie_basse($this);
 
       }
}

?>
