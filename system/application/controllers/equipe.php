<?php

/* Controlleur de l'équipe du Open Mind Students */

class Equipe extends Controller {

	function Equipe()
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
		
               $contenu=$this->load->view("equipe",'',true);             	
               echo $contenu ;
               $this->oms->partie_basse($this);
 
       }
}

?>
