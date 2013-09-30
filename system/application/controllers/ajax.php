<?php

/* Controlleur pour les requêtes AJAX  */
class Ajax extends Controller {
  
    function Ajax() {
        parent::Controller();
        $this->load->database();
        $this->load->model('catalogue/annee','annee');
        $this->load->model('catalogue/module','module');
        $this->load->model('catalogue/chapitre','chapitre');
        $this->load->model('membre');
    }
        
    function annees($idspecialite=0) {
        $this->load->view( "ajax/ajax_annee", array( 'annees' => $this->annee->listerAnnees($idspecialite) ) );         
    }
     
    function existpseudo($pseudo="") {
        $this->load->view( "ajax/ajax_pseudo", array('reponse' => $this->membre->existepseudo($pseudo) ) );    
    }
        
        
        function module($idannee=0) {
           $this->load->database();
           $result=mysql_query("select id,nommodule from module where idannee='$idannee' order by nommodule");
           $modules=array();
           
           while(list($id,$nom)=mysql_fetch_array($result))
           {
             $modules[]=array("id"=>$id,"nom"=>$nom);
           } 

           
           $this->load->view("ajax/ajax_module",array('modules'=>$modules));
        }
        
        function chapitre($idmodule=0) {
           $this->load->database();
           $result=mysql_query("select id,numchapitre,nomchapitre from chapitre where idmodule='$idmodule' order by numchapitre");
           $chapitres=array();
           
           while(list($id,$num,$nom)=mysql_fetch_array($result))
           {
             $chapitres[]=array("id"=>$id, "num"=>$num, "nom"=>$nom);
           } 

           
           $this->load->view("ajax/ajax_chapitre",array('chapitres'=>$chapitres));      
        }
  
  
  }


?>
