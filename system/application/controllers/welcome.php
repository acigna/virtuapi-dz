<?php

/* Controlleur de la page d'accueil du Open Mind Students */

class Welcome extends Controller {

	function Welcome()
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
                
               $this->oms->partie_haute('','Page d\'acceuil',$this);
                      
  	       //Contenu principal ici   
		
                $contenu=$this->load->view("acceuil",'',true);             	
                echo $contenu ;
               $this->oms->partie_basse($this);
 
       }
}


